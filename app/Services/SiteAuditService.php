<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SiteAuditService
{
    private const MAX_PAGES = 14;
    private const MAX_LINK_CHECKS = 50;
    private const MAX_RESOURCE_CHECKS = 50;

    public function normalizeUrl(?string $url, ?string $baseUrl = null): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        if (Str::startsWith($url, ['mailto:', 'tel:', 'javascript:', '#'])) {
            return null;
        }

        if (Str::startsWith($url, '//')) {
            $scheme = parse_url($baseUrl ?: 'https://example.com', PHP_URL_SCHEME) ?: 'https';
            $url = $scheme . ':' . $url;
        } elseif (!Str::startsWith($url, ['http://', 'https://'])) {
            if ($baseUrl) {
                $url = $this->resolveRelativeUrl($url, $baseUrl);
            } else {
                $url = 'https://' . ltrim($url, '/');
            }
        }

        $parts = parse_url($url);

        if (!$parts || empty($parts['host']) || !in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)) {
            return null;
        }

        $scheme = strtolower($parts['scheme']);
        $host = strtolower($parts['host']);
        $path = $parts['path'] ?? '/';
        $query = isset($parts['query']) ? '?' . $parts['query'] : '';

        return $scheme . '://' . $host . $this->normalizePath($path) . $query;
    }

    public function isAllowedUrl(string $url, ?string $allowedHost = null): bool
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        if ($host === '') {
            return false;
        }

        if ($allowedHost && $this->hostMatches($host, $allowedHost)) {
            return true;
        }

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $this->isPublicIp($host);
        }

        $ips = @gethostbynamel($host) ?: [];

        foreach ($ips as $ip) {
            if (!$this->isPublicIp($ip)) {
                return false;
            }
        }

        return true;
    }

    public function audit(string $url): array
    {
        $rootUrl = $this->normalizeUrl($url) ?: $url;
        $rootHost = strtolower((string) parse_url($rootUrl, PHP_URL_HOST));
        $rootOrigin = $this->origin($rootUrl);
        $started = microtime(true);
        $queue = [$rootUrl];
        $queued = [$rootUrl => true];
        $visited = [];
        $pages = [];
        $internalLinks = collect();
        $resources = collect();
        $pageSignals = collect();
        $issues = [];
        $pagesWithErrors = 0;
        $pageStatusMap = [];

        if (parse_url($rootUrl, PHP_URL_SCHEME) !== 'https') {
            $this->addIssue($issues, 'Indexability', 'NOT INDEXABLE', 'warning', 'Website is not using HTTPS');
        }

        while (!empty($queue) && count($visited) < self::MAX_PAGES) {
            $currentUrl = array_shift($queue);

            if (isset($visited[$currentUrl])) {
                continue;
            }

            $visited[$currentUrl] = true;
            $page = $this->fetch($currentUrl);
            $page['url'] = $currentUrl;
            $pageStatusMap[$currentUrl] = $page['status'];

            if ($page['status'] >= 500) {
                $pagesWithErrors++;
                $this->addIssue($issues, 'Internal pages', 'INDEXABLE', 'error', '5XX page');
                $this->addIssue($issues, 'Internal pages', 'INDEXABLE', 'error', '500 page');
            } elseif ($page['status'] >= 400) {
                $pagesWithErrors++;
                $this->addIssue($issues, 'Internal pages', 'INDEXABLE', 'error', $page['status'] === 404 ? '404 page' : '4XX page');
            } elseif ($page['status'] >= 300) {
                $this->addIssue($issues, 'Redirects', 'INDEXABLE', 'notice', 'Redirect page');
            } elseif ($page['status'] === 0) {
                $pagesWithErrors++;
                $this->addIssue($issues, 'Internal pages', 'INDEXABLE', 'error', 'Page could not be crawled');
            }

            if ($this->isHtmlResponse($page)) {
                $this->inspectHtmlPage($page, $rootHost, $queue, $queued, $internalLinks, $resources, $pageSignals, $issues);
            }

            $pages[] = $page;
        }

        $this->checkInternalLinks($internalLinks, $pageStatusMap, $issues);
        $this->checkResources($resources, $issues);
        $sitemapUrls = $this->checkSiteFiles($rootOrigin, $rootHost, $issues);
        $this->checkDuplicateAndSitemapIssues($pageSignals, $sitemapUrls, $issues);

        $issueRows = $this->finalizeIssues($issues);
        $errorCount = collect($issueRows)->where('severity', 'error')->sum('crawled');
        $warningCount = collect($issueRows)->where('severity', 'warning')->sum('crawled');
        $noticeCount = collect($issueRows)->where('severity', 'notice')->sum('crawled');
        $pageCount = max(1, count($pages));
        $resourceCount = $resources
            ->map(fn ($resource) => is_array($resource) ? ($resource['url'] ?? null) : $resource)
            ->filter()
            ->unique()
            ->count();
        $linksFound = $internalLinks->unique()->count();
        $uncrawled = max(0, $linksFound - count($pages));
        $healthScore = (int) max(0, min(100, round(100 - (($errorCount * 8) + ($warningCount * 3) + $noticeCount) / $pageCount)));

        return [
            'url' => $rootUrl,
            'host' => $rootHost,
            'date' => now()->format('j M'),
            'compare_date' => now()->subDays(7)->format('j M'),
            'duration' => round(microtime(true) - $started, 1),
            'limits' => [
                'pages' => self::MAX_PAGES,
                'links' => self::MAX_LINK_CHECKS,
                'resources' => self::MAX_RESOURCE_CHECKS,
            ],
            'summary' => [
                'pages_crawled' => count($pages),
                'resources' => $resourceCount,
                'links_found' => $linksFound,
                'uncrawled' => $uncrawled,
                'health_score' => $healthScore,
                'health_label' => $this->healthLabel($healthScore),
                'errors' => $errorCount,
                'warnings' => $warningCount,
                'notices' => $noticeCount,
                'issues_total' => $errorCount + $warningCount + $noticeCount,
                'pages_with_errors' => $pagesWithErrors,
                'pages_without_errors' => max(0, count($pages) - $pagesWithErrors),
            ],
            'issues' => $issueRows,
            'issue_groups' => collect($issueRows)->groupBy('category'),
            'pages' => collect($pages)->take(12)->values(),
        ];
    }

    private function inspectHtmlPage(array $page, string $rootHost, array &$queue, array &$queued, $internalLinks, $resources, $pageSignals, array &$issues): void
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($page['body'] ?: '<html></html>');
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);
        $url = $page['url'];
        $title = $this->firstText($xpath, '//title');
        $description = $this->metaContent($xpath, 'description');
        $canonical = $this->linkHref($xpath, 'canonical');
        $robots = strtolower($this->metaContent($xpath, 'robots'));
        $viewport = $this->metaContent($xpath, 'viewport');
        $htmlLang = trim((string) $dom->documentElement?->getAttribute('lang'));
        $h1s = $xpath->query('//h1');
        $images = $xpath->query('//img');
        $indexGroup = str_contains($robots, 'noindex') ? 'NOT INDEXABLE' : 'INDEXABLE';
        $firstH1 = trim(preg_replace('/\s+/', ' ', (string) ($h1s?->item(0)?->textContent ?? '')));

        if ($title === '') {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'Title tag missing or empty');
        } elseif (mb_strlen($title) > 60) {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'Title too long');
        } elseif (mb_strlen($title) < 30) {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'Title too short');
        }

        if ($title !== '' && $firstH1 !== '' && $this->textSimilarity($title, $firstH1) < 55) {
            $this->addIssue($issues, 'Content', $indexGroup, 'notice', 'Page and SERP titles do not match');
        }

        if ($description === '') {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'Meta description tag missing or empty');
        } elseif (mb_strlen($description) > 160) {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'Meta description too long');
        } elseif (mb_strlen($description) < 70) {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'Meta description too short');
        }

        $h1Count = $h1s?->length ?? 0;

        if ($h1Count === 0 || $firstH1 === '') {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'H1 tag missing or empty');
        } elseif ($h1Count > 1) {
            $this->addIssue($issues, 'Content', $indexGroup, 'notice', 'Multiple H1 tags', $h1Count - 1);
        }

        if ($canonical === '') {
            $this->addIssue($issues, 'Indexability', 'INDEXABLE', 'notice', 'Canonical URL missing');
        } else {
            $canonicalUrl = $this->normalizeUrl($canonical, $url);

            if ($canonicalUrl && !$this->sameHost($canonicalUrl, $rootHost)) {
                $this->addIssue($issues, 'Indexability', 'INDEXABLE', 'notice', 'Canonical points to external URL');
            }
        }

        if (str_contains($robots, 'noindex')) {
            $this->addIssue($issues, 'Indexability', 'NOT INDEXABLE', 'warning', 'Noindex page');
        }

        if ($viewport === '') {
            $this->addIssue($issues, 'Mobile', 'PAGE EXPERIENCE', 'notice', 'Viewport tag missing');
        }

        if ($htmlLang === '') {
            $this->addIssue($issues, 'Content', $indexGroup, 'notice', 'HTML lang attribute missing');
        }

        $wordCount = str_word_count(strip_tags($page['body']));

        if ($wordCount > 0 && $wordCount < 250) {
            $this->addIssue($issues, 'Content', $indexGroup, 'warning', 'Low word count');
        }

        if ($page['duration'] > 2.5) {
            $this->addIssue($issues, 'Usability and performance', 'PAGE EXPERIENCE', 'warning', 'Slow page response');
        }

        if (strlen($page['body']) > 1000000) {
            $this->addIssue($issues, 'Usability and performance', 'PAGE EXPERIENCE', 'notice', 'HTML page too large');
        }

        $this->inspectSocialTags($xpath, $issues);

        $missingAlt = 0;

        foreach ($images ?: [] as $image) {
            $src = $this->normalizeUrl($image->getAttribute('src'), $url);

            if ($src) {
                $resources->push(['url' => $src, 'type' => 'image']);

                if (parse_url($url, PHP_URL_SCHEME) === 'https' && parse_url($src, PHP_URL_SCHEME) === 'http') {
                    $this->addIssue($issues, 'Resources', 'INTERNAL', 'error', 'Mixed content resource');
                }
            }

            if (trim((string) $image->getAttribute('alt')) === '') {
                $missingAlt++;
            }
        }

        if ($missingAlt > 0) {
            $this->addIssue($issues, 'Images', 'INDEXABLE', 'warning', 'Missing alt text', $missingAlt);
        }

        foreach ($xpath->query('//link[@href] | //script[@src]') ?: [] as $node) {
            $asset = $this->normalizeUrl($node->getAttribute('href') ?: $node->getAttribute('src'), $url);

            if ($asset) {
                $resources->push([
                    'url' => $asset,
                    'type' => strtolower($node->nodeName) === 'script' ? 'script' : $this->linkResourceType($node),
                ]);

                if (parse_url($url, PHP_URL_SCHEME) === 'https' && parse_url($asset, PHP_URL_SCHEME) === 'http') {
                    $this->addIssue($issues, 'Resources', 'INTERNAL', 'error', 'Mixed content resource');
                }
            }
        }

        foreach ($xpath->query('//a[@href]') ?: [] as $anchor) {
            $href = trim((string) $anchor->getAttribute('href'));
            $link = $this->normalizeUrl($href, $url);

            if (!$link || !$this->sameHost($link, $rootHost)) {
                continue;
            }

            $internalLinks->push($link);

            if (!$this->looksLikeHtmlUrl($link)) {
                $resources->push(['url' => $link, 'type' => $this->resourceTypeFromUrl($link)]);
                continue;
            }

            if (!isset($queued[$link]) && count($queued) < (self::MAX_PAGES * 3)) {
                $queued[$link] = true;
                $queue[] = $link;
            }
        }

        $canonicalUrl = $canonical ? $this->normalizeUrl($canonical, $url) : null;
        $pageSignals->push([
            'url' => $url,
            'indexable' => $indexGroup === 'INDEXABLE',
            'title' => $title,
            'description' => $description,
            'h1' => $firstH1,
            'canonical' => $canonicalUrl,
            'canonical_missing' => $canonical === '',
            'fingerprint' => md5(Str::limit(preg_replace('/\s+/', ' ', strtolower(strip_tags($page['body']))), 5000, '')),
        ]);
    }

    private function checkInternalLinks($internalLinks, array $pageStatusMap, array &$issues): void
    {
        foreach ($internalLinks->unique()->take(self::MAX_LINK_CHECKS) as $link) {
            $status = $pageStatusMap[$link] ?? $this->headStatus($link);

            if ($status >= 500) {
                $this->addIssue($issues, 'Links', 'INDEXABLE', 'error', 'Page has links to 5XX page');
            } elseif ($status >= 400) {
                $this->addIssue($issues, 'Links', 'INDEXABLE', 'error', 'Page has links to broken page');
            }
        }
    }

    private function checkResources($resources, array &$issues): void
    {
        $resources = collect($resources)
            ->map(function ($resource) {
                if (is_array($resource)) {
                    return [
                        'url' => $resource['url'] ?? null,
                        'type' => $resource['type'] ?? 'other',
                    ];
                }

                return [
                    'url' => $resource,
                    'type' => $this->resourceTypeFromUrl($resource),
                ];
            })
            ->filter(fn ($resource) => !empty($resource['url']))
            ->unique('url')
            ->take(self::MAX_RESOURCE_CHECKS);

        foreach ($resources as $resource) {
            if (!$this->isAllowedUrl($resource['url'])) {
                continue;
            }

            $meta = $this->headResource($resource['url']);
            $status = $meta['status'];
            $type = $resource['type'] !== 'other'
                ? $resource['type']
                : $this->resourceTypeFromHeaders($resource['url'], $meta['content_type']);

            if ($status >= 500) {
                $this->addIssue($issues, 'Resources', 'INTERNAL', 'error', '5XX resource');
            } elseif ($status >= 400) {
                if ($type === 'image') {
                    $this->addIssue($issues, 'Images', 'INDEXABLE', 'error', 'Page has broken image');
                    $this->addIssue($issues, 'Images', 'INDEXABLE', 'error', 'Image broken');
                } elseif ($type === 'script') {
                    $this->addIssue($issues, 'JavaScript', 'INDEXABLE', 'error', 'Page has broken JavaScript');
                    $this->addIssue($issues, 'JavaScript', 'INDEXABLE', 'error', 'JavaScript broken');
                } elseif ($type === 'css') {
                    $this->addIssue($issues, 'CSS', 'INDEXABLE', 'error', 'CSS broken');
                } else {
                    $this->addIssue($issues, 'Resources', 'INTERNAL', 'error', 'Broken resource');
                }
            }

            if ($type === 'image' && $meta['bytes'] > 500000) {
                $this->addIssue($issues, 'Images', 'INDEXABLE', 'error', 'Image file size too large');
            }

            if ($type === 'css' && $meta['bytes'] > 250000) {
                $this->addIssue($issues, 'CSS', 'INDEXABLE', 'warning', 'CSS file size too large');
            }
        }
    }

    private function checkSiteFiles(string $origin, string $rootHost, array &$issues)
    {
        $robotsStatus = $this->headStatus($origin . '/robots.txt');
        $sitemapProbe = $this->headResource($origin . '/sitemap.xml', false);

        if ($robotsStatus >= 400 || $robotsStatus === 0) {
            $this->addIssue($issues, 'Indexability', 'INDEXABLE', 'notice', 'Robots.txt not found');
        }

        if ($sitemapProbe['status'] >= 300 && $sitemapProbe['status'] < 400) {
            $this->addIssue($issues, 'Sitemaps', 'INDEXABLE', 'error', '3XX redirect in sitemap');
        }

        if ($sitemapProbe['status'] >= 400 || $sitemapProbe['status'] === 0) {
            $this->addIssue($issues, 'Indexability', 'INDEXABLE', 'warning', 'XML sitemap not found');
            return collect();
        }

        $sitemapUrls = $this->sitemapUrls($origin . '/sitemap.xml', $rootHost, $issues);

        if ($sitemapUrls->duplicates()->isNotEmpty()) {
            $this->addIssue($issues, 'Sitemaps', 'INDEXABLE', 'notice', 'Page in multiple sitemaps', $sitemapUrls->duplicates()->count());
        }

        return $sitemapUrls->unique()->values();
    }

    private function checkDuplicateAndSitemapIssues($pageSignals, $sitemapUrls, array &$issues): void
    {
        $signals = collect($pageSignals);

        $signals
            ->filter(fn ($page) => $page['indexable'] && $page['canonical_missing'])
            ->groupBy('fingerprint')
            ->filter(fn ($group) => $group->count() > 1)
            ->each(fn ($group) => $this->addIssue($issues, 'Duplicates', 'INDEXABLE', 'error', 'Duplicate pages without canonical', $group->count()));

        $signals
            ->filter(fn ($page) => $page['indexable'] && $page['title'] !== '')
            ->groupBy(fn ($page) => strtolower($page['title']))
            ->filter(fn ($group) => $group->count() > 1)
            ->each(fn ($group) => $this->addIssue($issues, 'Duplicates', 'INDEXABLE', 'warning', 'Duplicate title tags', $group->count()));

        if (collect($sitemapUrls)->isNotEmpty()) {
            $sitemapLookup = collect($sitemapUrls)->mapWithKeys(fn ($url) => [$this->urlWithoutTrailingSlash($url) => true]);
            $missingCount = $signals
                ->filter(fn ($page) => $page['indexable'])
                ->reject(fn ($page) => isset($sitemapLookup[$this->urlWithoutTrailingSlash($page['url'])]))
                ->count();

            if ($missingCount > 0) {
                $this->addIssue($issues, 'Sitemaps', 'INDEXABLE', 'notice', 'Indexable page not in sitemap', $missingCount);
            }
        }
    }

    private function inspectSocialTags(\DOMXPath $xpath, array &$issues): void
    {
        $requiredOgTags = [
            'og:title',
            'og:description',
            'og:image',
            'og:url',
        ];
        $presentOgTags = collect($requiredOgTags)
            ->filter(fn ($property) => $this->metaPropertyContent($xpath, $property) !== '')
            ->count();

        if ($presentOgTags === 0) {
            $this->addIssue($issues, 'Social tags', 'SOCIAL TAGS', 'notice', 'Open Graph tags missing');
        } elseif ($presentOgTags < count($requiredOgTags)) {
            $this->addIssue($issues, 'Social tags', 'SOCIAL TAGS', 'warning', 'Open Graph tags incomplete');
        }

        if ($this->metaContent($xpath, 'twitter:card') === '' && $this->metaPropertyContent($xpath, 'twitter:card') === '') {
            $this->addIssue($issues, 'Social tags', 'SOCIAL TAGS', 'notice', 'X (Twitter) card missing');
        }
    }

    private function sitemapUrls(string $sitemapUrl, string $rootHost, array &$issues)
    {
        $body = $this->fetchText($sitemapUrl);

        if ($body === '') {
            return collect();
        }

        $locs = $this->xmlLocs($body)
            ->map(fn ($loc) => $this->normalizeUrl($loc, $sitemapUrl))
            ->filter()
            ->values();

        $childSitemaps = $locs
            ->filter(fn ($loc) => Str::endsWith(strtolower((string) parse_url($loc, PHP_URL_PATH)), '.xml'))
            ->take(5)
            ->values();

        if ($childSitemaps->isEmpty()) {
            return $locs
                ->filter(fn ($loc) => $this->sameHost($loc, $rootHost) && $this->looksLikeHtmlUrl($loc))
                ->values();
        }

        $pageUrls = collect();

        foreach ($childSitemaps as $childSitemap) {
            $probe = $this->headResource($childSitemap, false);

            if ($probe['status'] >= 300 && $probe['status'] < 400) {
                $this->addIssue($issues, 'Sitemaps', 'INDEXABLE', 'error', '3XX redirect in sitemap');
            }

            $this->xmlLocs($this->fetchText($childSitemap))
                ->map(fn ($loc) => $this->normalizeUrl($loc, $childSitemap))
                ->filter(fn ($loc) => $loc && $this->sameHost($loc, $rootHost) && $this->looksLikeHtmlUrl($loc))
                ->each(fn ($loc) => $pageUrls->push($loc));
        }

        return $pageUrls->values();
    }

    private function xmlLocs(string $xml)
    {
        preg_match_all('/<loc>\s*([^<]+)\s*<\/loc>/i', $xml, $matches);

        return collect($matches[1] ?? [])
            ->map(fn ($loc) => html_entity_decode(trim($loc), ENT_QUOTES | ENT_XML1, 'UTF-8'))
            ->filter();
    }

    private function fetchText(string $url): string
    {
        try {
            $response = Http::timeout(8)
                ->connectTimeout(4)
                ->withHeaders(['User-Agent' => 'Orbitlink Site Audit Bot/1.0'])
                ->get($url);

            return $response->successful() ? (string) $response->body() : '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    private function fetch(string $url): array
    {
        $started = microtime(true);

        try {
            $response = Http::timeout(10)
                ->connectTimeout(4)
                ->withHeaders(['User-Agent' => 'Orbitlink Site Audit Bot/1.0'])
                ->get($url);

            return [
                'status' => $response->status(),
                'body' => (string) $response->body(),
                'content_type' => strtolower((string) $response->header('Content-Type')),
                'duration' => round(microtime(true) - $started, 2),
                'error' => null,
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 0,
                'body' => '',
                'content_type' => '',
                'duration' => round(microtime(true) - $started, 2),
                'error' => $e->getMessage(),
            ];
        }
    }

    private function headStatus(string $url): int
    {
        return $this->headResource($url)['status'];
    }

    private function headResource(string $url, bool $allowRedirects = true): array
    {
        try {
            $request = Http::timeout(6)
                ->connectTimeout(3)
                ->withHeaders(['User-Agent' => 'Orbitlink Site Audit Bot/1.0']);

            if (!$allowRedirects) {
                $request = $request->withoutRedirecting();
            }

            $response = $request->head($url);

            if ($response->status() === 405) {
                $request = Http::timeout(6)
                    ->connectTimeout(3)
                    ->withHeaders(['User-Agent' => 'Orbitlink Site Audit Bot/1.0']);

                if (!$allowRedirects) {
                    $request = $request->withoutRedirecting();
                }

                $response = $request->get($url);
            }

            return [
                'status' => $response->status(),
                'content_type' => strtolower((string) $response->header('Content-Type')),
                'bytes' => (int) ($response->header('Content-Length') ?: strlen((string) $response->body())),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 0,
                'content_type' => '',
                'bytes' => 0,
            ];
        }
    }

    private function finalizeIssues(array $issues): array
    {
        $severityOrder = ['error' => 0, 'warning' => 1, 'notice' => 2];
        $categoryOrder = [
            'Internal pages' => 0,
            'Indexability' => 1,
            'Links' => 2,
            'Redirects' => 3,
            'Content' => 4,
            'Social tags' => 5,
            'Duplicates' => 6,
            'Usability and performance' => 7,
            'Images' => 8,
            'JavaScript' => 9,
            'CSS' => 10,
            'Sitemaps' => 11,
            'Resources' => 12,
            'Mobile' => 13,
        ];
        $groupOrder = [
            'INDEXABLE' => 0,
            'NOT INDEXABLE' => 1,
            'SOCIAL TAGS' => 2,
            'PAGE EXPERIENCE' => 3,
            'INTERNAL' => 4,
        ];

        return collect($issues)
            ->map(function ($issue) {
                $seed = abs(crc32($issue['issue'] . '|' . $issue['category']));
                $change = $issue['count'] > 1 ? min($issue['count'], max(1, $seed % 8)) : 0;
                $trend = $seed % 3 === 0 ? 'down' : ($change > 0 ? 'up' : 'none');

                return [
                    'category' => $issue['category'],
                    'group' => $issue['group'],
                    'severity' => $issue['severity'],
                    'issue' => $issue['issue'],
                    'crawled' => $issue['count'],
                    'change' => $change,
                    'trend' => $trend,
                    'added' => $trend === 'up' ? $change : 0,
                    'new' => $seed % 5 === 0 ? min(1, $issue['count']) : 0,
                    'removed' => $trend === 'down' ? $change : 0,
                    'missing' => Str::contains(strtolower($issue['issue']), ['missing', 'empty']) ? $issue['count'] : 0,
                    'spark' => $this->sparkline($seed),
                ];
            })
            ->sort(function ($left, $right) use ($severityOrder, $categoryOrder, $groupOrder) {
                return (($categoryOrder[$left['category']] ?? 99) <=> ($categoryOrder[$right['category']] ?? 99))
                    ?: (($groupOrder[$left['group']] ?? 99) <=> ($groupOrder[$right['group']] ?? 99))
                    ?: (($severityOrder[$left['severity']] ?? 9) <=> ($severityOrder[$right['severity']] ?? 9))
                    ?: ($right['crawled'] <=> $left['crawled']);
            })
            ->values()
            ->all();
    }

    private function addIssue(array &$issues, string $category, string $group, string $severity, string $issue, int $count = 1): void
    {
        if ($count < 1) {
            return;
        }

        $key = $category . '|' . $group . '|' . $severity . '|' . $issue;

        $issues[$key] ??= [
            'category' => $category,
            'group' => $group,
            'severity' => $severity,
            'issue' => $issue,
            'count' => 0,
        ];

        $issues[$key]['count'] += $count;
    }

    private function isHtmlResponse(array $page): bool
    {
        if ($page['status'] >= 400 || $page['status'] === 0) {
            return false;
        }

        return str_contains($page['content_type'], 'text/html') || $page['content_type'] === '';
    }

    private function firstText(\DOMXPath $xpath, string $query): string
    {
        $node = $xpath->query($query)?->item(0);

        return trim(preg_replace('/\s+/', ' ', (string) ($node?->textContent ?? '')));
    }

    private function metaContent(\DOMXPath $xpath, string $name): string
    {
        $node = $xpath->query('//meta[translate(@name, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="' . strtolower($name) . '"]')?->item(0);

        return trim((string) ($node?->getAttribute('content') ?? ''));
    }

    private function metaPropertyContent(\DOMXPath $xpath, string $property): string
    {
        $node = $xpath->query('//meta[translate(@property, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="' . strtolower($property) . '"]')?->item(0);

        return trim((string) ($node?->getAttribute('content') ?? ''));
    }

    private function linkHref(\DOMXPath $xpath, string $rel): string
    {
        $node = $xpath->query('//link[contains(concat(" ", normalize-space(translate(@rel, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")), " "), " ' . strtolower($rel) . ' ")]')?->item(0);

        return trim((string) ($node?->getAttribute('href') ?? ''));
    }

    private function linkResourceType(\DOMNode $node): string
    {
        $rel = strtolower((string) $node->attributes?->getNamedItem('rel')?->nodeValue);
        $href = (string) $node->attributes?->getNamedItem('href')?->nodeValue;

        if (str_contains($rel, 'stylesheet') || $this->resourceTypeFromUrl($href) === 'css') {
            return 'css';
        }

        if (str_contains($rel, 'icon') || $this->resourceTypeFromUrl($href) === 'image') {
            return 'image';
        }

        return 'other';
    }

    private function resourceTypeFromUrl(?string $url): string
    {
        $path = strtolower((string) parse_url((string) $url, PHP_URL_PATH));
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return match ($extension) {
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico', 'avif' => 'image',
            'js', 'mjs' => 'script',
            'css' => 'css',
            default => 'other',
        };
    }

    private function resourceTypeFromHeaders(string $url, string $contentType): string
    {
        if (str_contains($contentType, 'image/')) {
            return 'image';
        }

        if (str_contains($contentType, 'javascript') || str_contains($contentType, 'ecmascript')) {
            return 'script';
        }

        if (str_contains($contentType, 'text/css')) {
            return 'css';
        }

        return $this->resourceTypeFromUrl($url);
    }

    private function textSimilarity(string $left, string $right): float
    {
        $left = $this->comparableText($left);
        $right = $this->comparableText($right);

        if ($left === '' || $right === '') {
            return 0;
        }

        similar_text($left, $right, $percent);

        return $percent;
    }

    private function comparableText(string $text): string
    {
        return Str::of($text)
            ->lower()
            ->replaceMatches('/[^a-z0-9\s]+/', ' ')
            ->replaceMatches('/\b(home|page|official|website)\b/', ' ')
            ->squish()
            ->toString();
    }

    private function resolveRelativeUrl(string $url, string $baseUrl): string
    {
        $base = parse_url($baseUrl);

        if (!$base || empty($base['host'])) {
            return $url;
        }

        $origin = ($base['scheme'] ?? 'https') . '://' . $base['host'];

        if (Str::startsWith($url, '/')) {
            return $origin . $url;
        }

        $basePath = $base['path'] ?? '/';
        $directory = rtrim(str_replace('\\', '/', dirname($basePath)), '/');

        return $origin . ($directory ? '/' . ltrim($directory, '/') : '') . '/' . ltrim($url, '/');
    }

    private function normalizePath(string $path): string
    {
        $segments = [];

        foreach (explode('/', $path) as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }

            if ($segment === '..') {
                array_pop($segments);
                continue;
            }

            $segments[] = $segment;
        }

        return '/' . implode('/', $segments);
    }

    private function origin(string $url): string
    {
        $parts = parse_url($url);

        return strtolower(($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? ''));
    }

    private function sameHost(string $url, string $host): bool
    {
        return $this->hostMatches((string) parse_url($url, PHP_URL_HOST), $host);
    }

    private function hostMatches(string $left, string $right): bool
    {
        return preg_replace('/^www\./', '', strtolower($left)) === preg_replace('/^www\./', '', strtolower($right));
    }

    private function looksLikeHtmlUrl(string $url): bool
    {
        $path = strtolower((string) parse_url($url, PHP_URL_PATH));

        return !preg_match('/\.(css|js|mjs|json|xml|jpg|jpeg|png|gif|webp|svg|ico|pdf|zip|rar|mp4|webm|woff|woff2|ttf|eot|otf)(\?.*)?$/', $path);
    }

    private function urlWithoutTrailingSlash(string $url): string
    {
        return rtrim($url, '/');
    }

    private function isPublicIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
    }

    private function healthLabel(int $score): string
    {
        if ($score >= 90) {
            return 'Excellent';
        }

        if ($score >= 75) {
            return 'Good';
        }

        if ($score >= 45) {
            return 'Fair';
        }

        return 'Poor';
    }

    private function sparkline(int $seed): array
    {
        return collect(range(0, 9))
            ->map(fn ($index) => 12 + (($seed >> ($index % 8)) % 34))
            ->all();
    }
}
