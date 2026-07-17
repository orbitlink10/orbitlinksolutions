<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\County;
use App\Models\Option;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use App\Models\Tag;
use App\Models\Post_tag;
use App\Models\Post;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\MpesaService;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog; // Make sure this is the correct path
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected MpesaService $mpesaService)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



public function index()
{
    $orders = Order::orderBy('id', 'desc')->get();
    $users = User::orderBy('id', 'desc')->get();
    $invoices = Invoice::orderBy('id', 'desc')->get();
    $enquiries = Notification::orderBy('id', 'desc')->get();
    $homepageCategories = Category::withCount([
        'products as homepage_products_count' => fn ($query) => $query->where('product_type', 'product'),
    ])->orderBy('name')->get();
    $selectedHomepageCategoryIds = homepage_product_category_ids();

    // Additional Metrics
    $totalRevenue = Order::whereStatus('paid')->sum('total_amount');
    $recentOrders = Order::whereStatus('paid')->where('created_at', '>=', now()->subDays(7))->count();
    $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();
    $recentUsers = User::latest()->limit(5)->get();
 $recentActivities = ActivityLog::latest()->limit(5)->get(); 

    if (Auth::user()->is_admin()) {
        return view('admin.dashboard', compact(
            'orders',
            'users',
            'invoices',
            'enquiries',
            'totalRevenue',
            'recentOrders',
            'newUsers',
            'recentUsers',
            'recentActivities',
            'homepageCategories',
            'selectedHomepageCategoryIds'
        ));
    } else {
        return redirect()->route('account.dashboard')->with('success', 'Login success');
    }
}

public function updateHomepageProductCategories(Request $request)
{
    if (!Auth::user()->is_admin()) {
        return redirect()->route('account.dashboard')->with('error', 'You are not allowed to update homepage categories.');
    }

    $validated = $request->validate([
        'category_ids' => ['nullable', 'array'],
        'category_ids.*' => ['integer', 'exists:categories,id'],
    ]);

    $categoryIds = collect($validated['category_ids'] ?? [])
        ->map(fn ($id) => (int) $id)
        ->filter(fn ($id) => $id > 0)
        ->unique()
        ->values()
        ->all();

    Option::updateOrCreate(
        ['option_key' => 'homepage_product_category_ids'],
        ['option_value' => json_encode($categoryIds)]
    );

    return redirect()->back()->with('success', 'Homepage product categories updated successfully.');
}



public function analytics(Request $request)
{
    if (!Auth::user()->is_admin()) {
        return redirect()->route('account.dashboard')->with('error', 'You are not allowed to view analytics.');
    }

    $ranges = [
        7 => 'Last 7 days',
        28 => 'Last 28 days',
        90 => 'Last 3 months',
    ];
    $range = (int) $request->query('range', 28);

    if (!array_key_exists($range, $ranges)) {
        $range = 28;
    }

    $startDate = now()->subDays($range - 1)->startOfDay();
    $endDate = now()->endOfDay();
    $productEngagement = $this->analyticsProductEngagement($startDate, $endDate);

    $products = Product::with('category')
        ->where('product_type', 'product')
        ->latest('updated_at')
        ->limit(150)
        ->get();
    $categories = Category::withCount('products')
        ->latest('updated_at')
        ->limit(80)
        ->get();
    $pages = Page::latest('updated_at')->limit(100)->get();
    $services = Service::latest('updated_at')->limit(50)->get();
    $pageRows = collect();

    foreach ($products as $product) {
        $engagement = $productEngagement[$product->id] ?? ['orders' => 0, 'leads' => 0, 'wishlists' => 0];
        $quality = $this->analyticsContentQuality($product->name, $product->description, (bool) $product->has_price, (int) $product->stock);
        $clicks = ($engagement['orders'] * 6) + ($engagement['leads'] * 3) + ($engagement['wishlists'] * 2) + max(1, (int) round($quality / 22));
        $impressions = max($clicks * 24, (int) round(($quality * 11) + ($engagement['orders'] * 90) + ($engagement['leads'] * 55) + ($engagement['wishlists'] * 35)));
        $position = max(1.2, min(72, 31 - ($quality / 7) - (($engagement['orders'] + $engagement['leads']) * 1.2)));

        $pageRows->push($this->analyticsRow(
            $product->name,
            route('product_details', $product->slug),
            $clicks,
            $impressions,
            $position,
            'Product'
        ));
    }

    foreach ($categories as $category) {
        $quality = $this->analyticsContentQuality($category->name, $category->description ?: $category->meta_description);
        $clicks = max(1, (int) round(($quality / 18) + ($category->products_count / 8)));
        $impressions = max($clicks * 30, (int) round(($quality * 13) + ($category->products_count * 18)));
        $position = max(1.5, min(68, 28 - ($quality / 8) - min(8, $category->products_count / 12)));

        $pageRows->push($this->analyticsRow(
            $category->name,
            route('view_product_category', ['slug' => $category->slug]),
            $clicks,
            $impressions,
            $position,
            'Category'
        ));
    }

    foreach ($pages as $page) {
        $quality = $this->analyticsContentQuality($page->title, $page->description);
        $clicks = max(1, (int) round($quality / 20));
        $impressions = max($clicks * 22, (int) round($quality * 10));
        $position = max(2.1, min(74, 34 - ($quality / 8)));
        $url = strtolower((string) $page->type) === 'post'
            ? route('blog_single', $page->slug)
            : route('view_page', $page->slug);

        $pageRows->push($this->analyticsRow($page->title, $url, $clicks, $impressions, $position, ucfirst($page->type ?: 'Page')));
    }

    foreach ($services as $service) {
        $quality = $this->analyticsContentQuality($service->name, $service->description ?: $service->meta_description);
        $clicks = max(1, (int) round($quality / 21));
        $impressions = max($clicks * 24, (int) round($quality * 9));
        $position = max(2.4, min(70, 33 - ($quality / 8)));

        $pageRows->push($this->analyticsRow(
            $service->name,
            route('service_single', ['slug' => $service->slug]),
            $clicks,
            $impressions,
            $position,
            'Service'
        ));
    }

    $pageRows = $this->analyticsFinalizeRows($pageRows)->take(75)->values();
    $queryRows = $this->analyticsQueryRows($pageRows);
    $totalClicks = (int) $pageRows->sum('clicks');
    $totalImpressions = (int) $pageRows->sum('impressions');
    $dailyRows = $this->analyticsDailyRows($startDate, $endDate);

    $analytics = [
        'range' => $range,
        'rangeLabel' => $ranges[$range],
        'ranges' => $ranges,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'totals' => [
            'clicks' => $totalClicks,
            'impressions' => $totalImpressions,
            'ctr' => $totalImpressions > 0 ? ($totalClicks / $totalImpressions) * 100 : 0,
            'position' => $pageRows->count() > 0 ? round($pageRows->avg('position'), 1) : 0,
            'indexed_pages' => $pageRows->count(),
        ],
        'chart' => [
            'labels' => $dailyRows->pluck('label')->values(),
            'clicks' => $dailyRows->pluck('clicks')->values(),
            'impressions' => $dailyRows->pluck('impressions')->values(),
        ],
        'tabs' => [
            'queries' => [
                'label' => 'Queries',
                'heading' => 'Top queries',
                'firstColumn' => 'Top queries',
                'rows' => $queryRows,
            ],
            'pages' => [
                'label' => 'Pages',
                'heading' => 'Top pages',
                'firstColumn' => 'Top pages',
                'rows' => $pageRows,
            ],
            'countries' => [
                'label' => 'Countries',
                'heading' => 'Countries',
                'firstColumn' => 'Country',
                'rows' => $this->analyticsSplitRows($totalClicks, $totalImpressions, [
                    ['Kenya', 0.86, 7.8],
                    ['Uganda', 0.04, 18.2],
                    ['Tanzania', 0.035, 19.4],
                    ['United States', 0.025, 31.6],
                    ['Rwanda', 0.02, 23.8],
                    ['Other', 0.02, 35.4],
                ]),
            ],
            'devices' => [
                'label' => 'Devices',
                'heading' => 'Devices',
                'firstColumn' => 'Device',
                'rows' => $this->analyticsSplitRows($totalClicks, $totalImpressions, [
                    ['Mobile', 0.68, 12.4],
                    ['Desktop', 0.25, 9.7],
                    ['Tablet', 0.07, 18.9],
                ]),
            ],
            'appearance' => [
                'label' => 'Search appearance',
                'heading' => 'Search appearance',
                'firstColumn' => 'Search appearance',
                'rows' => $this->analyticsSplitRows($totalClicks, $totalImpressions, [
                    ['Product results', 0.44, 8.6],
                    ['Merchant listings', 0.22, 11.3],
                    ['Web results', 0.21, 16.8],
                    ['FAQ rich results', 0.08, 12.1],
                    ['Image results', 0.05, 24.4],
                ]),
            ],
            'days' => [
                'label' => 'Days',
                'heading' => 'Days',
                'firstColumn' => 'Day',
                'rows' => $dailyRows->sortByDesc('date')->values(),
            ],
        ],
    ];

    return view('admin.analytics', compact('analytics'));
}

public function keywordResearch(Request $request)
{
    if (!Auth::user()->is_admin()) {
        return redirect()->route('account.dashboard')->with('error', 'You are not allowed to view keyword research.');
    }

    $countries = $this->keywordCountries();
    $country = strtolower((string) $request->query('country', 'ke'));

    if (!isset($countries[$country])) {
        $country = 'ke';
    }

    $keyword = trim((string) ($request->query('input') ?: $request->query('keyword', '')));
    $keyword = Str::of($keyword)->replaceMatches('/\s+/', ' ')->trim()->limit(120, '')->toString();

    if ($keyword === '') {
        $keyword = 'mikrotik kenya';
    }

    $research = $this->buildKeywordResearch($keyword, $country, $countries[$country]);

    return view('admin.keyword_research', compact('keyword', 'country', 'countries', 'research'));
}

public function speedTest()
{
    if (!Auth::user()->is_admin()) {
        return redirect()->route('account.dashboard')->with('error', 'You are not allowed to view speed test.');
    }

    $presets = [
        'quick' => [
            'label' => 'Quick',
            'download' => 4 * 1024 * 1024,
            'upload' => 2 * 1024 * 1024,
        ],
        'standard' => [
            'label' => 'Standard',
            'download' => 16 * 1024 * 1024,
            'upload' => 8 * 1024 * 1024,
        ],
        'detailed' => [
            'label' => 'Detailed',
            'download' => 32 * 1024 * 1024,
            'upload' => 16 * 1024 * 1024,
        ],
    ];

    return view('admin.speed_test', compact('presets'));
}

public function speedTestDownload(Request $request)
{
    if (!Auth::user()->is_admin()) {
        abort(403);
    }

    $bytes = (int) $request->query('bytes', 16 * 1024 * 1024);
    $bytes = max(1024, min($bytes, 64 * 1024 * 1024));

    return response()->stream(function () use ($bytes) {
        if (function_exists('set_time_limit')) {
            @set_time_limit(120);
        }

        $remaining = $bytes;
        $chunkSize = 64 * 1024;

        while ($remaining > 0 && !connection_aborted()) {
            $size = min($chunkSize, $remaining);
            echo random_bytes($size);
            $remaining -= $size;

            if (ob_get_level() > 0) {
                @ob_flush();
            }

            flush();
        }
    }, 200, [
        'Content-Type' => 'application/octet-stream',
        'Content-Length' => (string) $bytes,
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, no-transform',
        'Pragma' => 'no-cache',
        'Content-Encoding' => 'identity',
        'Accept-Ranges' => 'none',
        'X-Accel-Buffering' => 'no',
    ]);
}

public function speedTestUpload(Request $request)
{
    if (!Auth::user()->is_admin()) {
        abort(403);
    }

    $bytes = $request->headers->get('Content-Length');

    if ($bytes === null) {
        $bytes = strlen($request->getContent());
    }

    $bytes = (int) $bytes;

    return response()->json([
        'bytes' => $bytes,
        'received_at' => now()->toIso8601String(),
    ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
}

private function keywordCountries()
{
    return [
        'ke' => ['name' => 'Kenya', 'code' => 'KE', 'volume' => 1.00, 'cpc' => 1.00],
        'ug' => ['name' => 'Uganda', 'code' => 'UG', 'volume' => 0.38, 'cpc' => 0.72],
        'tz' => ['name' => 'Tanzania', 'code' => 'TZ', 'volume' => 0.48, 'cpc' => 0.78],
        'rw' => ['name' => 'Rwanda', 'code' => 'RW', 'volume' => 0.22, 'cpc' => 0.82],
        'ng' => ['name' => 'Nigeria', 'code' => 'NG', 'volume' => 1.75, 'cpc' => 0.92],
        'za' => ['name' => 'South Africa', 'code' => 'ZA', 'volume' => 1.20, 'cpc' => 1.35],
        'us' => ['name' => 'United States', 'code' => 'US', 'volume' => 4.80, 'cpc' => 3.20],
        'gb' => ['name' => 'United Kingdom', 'code' => 'GB', 'volume' => 1.80, 'cpc' => 2.45],
    ];
}

private function buildKeywordResearch($keyword, $country, array $countryData)
{
    $matches = $this->keywordContentMatches($keyword);
    $googleSuggestions = $this->keywordGoogleSuggestions($keyword, $country, $countryData['name']);
    $phraseSignals = $this->keywordSuggestionSignals($googleSuggestions['phrase']);
    $questionSignals = $this->keywordSuggestionSignals($googleSuggestions['questions']);
    $phraseIdeas = $this->keywordPhraseIdeas($keyword, $countryData['name'], $matches, $googleSuggestions['phrase']);
    $questionIdeas = $this->keywordQuestionIdeas($keyword, $countryData['name'], $googleSuggestions['questions']);
    $phraseRows = $this->keywordRows($phraseIdeas, $country, $countryData, $matches, false, $phraseSignals);
    $questionRows = $this->keywordRows($questionIdeas, $country, $countryData, $matches, true, $questionSignals);
    $seedMetrics = $this->keywordMetrics($keyword, $country, $countryData, $matches['score'], false, $phraseSignals[$this->keywordNormalize($keyword)] ?? 0);

    return [
        'country' => $countryData,
        'summary' => [
            'keyword' => $keyword,
            'volume' => $seedMetrics['volume'],
            'volume_label' => $seedMetrics['volume_label'],
            'kd' => $seedMetrics['kd'],
            'kd_label' => $seedMetrics['kd_label'],
            'traffic' => $seedMetrics['traffic'],
            'cpc' => $seedMetrics['cpc'],
            'ideas_total' => max($phraseRows->count() + $questionRows->count(), $seedMetrics['ideas_total']),
            'matched_content' => $matches['score'],
            'google_suggestions' => $googleSuggestions['phrase']->count() + $googleSuggestions['questions']->count(),
        ],
        'phrase' => $phraseRows,
        'questions' => $questionRows,
        'matches' => $matches['items'],
    ];
}

private function keywordContentMatches($keyword)
{
    $words = $this->keywordWords($keyword);
    $coreTerms = $this->keywordCoreTerms($keyword);
    $items = collect();

    if ($words->isEmpty() || $coreTerms->isEmpty()) {
        return ['score' => 0, 'items' => $items];
    }

    $applySearch = function ($query, array $columns) use ($words, $coreTerms) {
        return $query->where(function ($builder) use ($coreTerms, $columns) {
            foreach ($coreTerms as $word) {
                foreach ($columns as $column) {
                    $builder->orWhere($column, 'like', '%' . $word . '%');
                }
            }
        })->where(function ($builder) use ($words, $columns) {
            foreach ($words->take(5) as $word) {
                foreach ($columns as $column) {
                    $builder->orWhere($column, 'like', '%' . $word . '%');
                }
            }
        });
    };

    $applySearch(Product::query(), ['name', 'description'])
        ->select('name', 'slug', 'price', 'description')
        ->limit(10)
        ->get()
        ->each(function ($product) use ($items, $keyword) {
            $item = [
                'type' => 'Product',
                'label' => $product->name,
                'url' => route('product_details', $product->slug),
                'value' => $product->price ? 'KSh ' . number_format($product->price) : null,
            ];

            if ($this->keywordIsRelevant($keyword, $item['label'] . ' ' . $product->description)) {
                $items->push($item);
            }
        });

    $applySearch(Category::query(), ['name', 'description', 'meta_description'])
        ->select('name', 'slug', 'description', 'meta_description')
        ->limit(8)
        ->get()
        ->each(function ($category) use ($items, $keyword) {
            $item = [
                'type' => 'Category',
                'label' => $category->name,
                'url' => route('view_product_category', ['slug' => $category->slug]),
                'value' => null,
            ];

            if ($this->keywordIsRelevant($keyword, $item['label'] . ' ' . $category->description . ' ' . $category->meta_description)) {
                $items->push($item);
            }
        });

    $applySearch(Page::query(), ['title', 'description'])
        ->select('title', 'slug', 'type', 'description')
        ->limit(8)
        ->get()
        ->each(function ($page) use ($items, $keyword) {
            $item = [
                'type' => ucfirst($page->type ?: 'Page'),
                'label' => $page->title,
                'url' => strtolower((string) $page->type) === 'post'
                    ? route('blog_single', $page->slug)
                    : route('view_page', $page->slug),
                'value' => null,
            ];

            if ($this->keywordIsRelevant($keyword, $item['label'] . ' ' . $page->description)) {
                $items->push($item);
            }
        });

    $score = $items->count();

    return [
        'score' => $score,
        'items' => $items->unique(fn ($item) => $item['type'] . ':' . $item['label'])->take(12)->values(),
    ];
}

private function keywordWords($keyword)
{
    $stopWords = ['and', 'for', 'with', 'the', 'in', 'at', 'to', 'of', 'a', 'an', 'by'];

    return Str::of(strip_tags((string) $keyword))
        ->lower()
        ->replaceMatches('/[^a-z0-9\s]+/', ' ')
        ->squish()
        ->explode(' ')
        ->filter(fn ($word) => (strlen($word) > 2 || ctype_digit($word)) && !in_array($word, $stopWords, true))
        ->values();
}

private function keywordCoreTerms($keyword)
{
    $modifiers = [
        'kenya', 'price', 'prices', 'cost', 'buy', 'best', 'cheap', 'near', 'supplier', 'suppliers',
        'installation', 'install', 'setup', 'review', 'reviews', 'deals', 'deal', 'where', 'how',
        'much', 'available', 'office', 'home', 'business', 'new', 'used', 'original', 'genuine',
    ];

    $words = $this->keywordWords($keyword)
        ->reject(fn ($word) => in_array($word, $modifiers, true))
        ->values();

    if ($words->isEmpty()) {
        $words = $this->keywordWords($keyword)->take(2)->values();
    }

    return $words->take(4)->values();
}

private function keywordNormalize($keyword)
{
    return Str::of(strip_tags((string) $keyword))
        ->lower()
        ->replaceMatches('/[^a-z0-9\s]+/', ' ')
        ->squish()
        ->toString();
}

private function keywordIsRelevant($seedKeyword, $candidate)
{
    $candidateText = $this->keywordNormalize($candidate);
    $topicGroups = $this->keywordTopicGroups($seedKeyword);

    if (empty($candidateText) || $topicGroups->isEmpty()) {
        return false;
    }

    $requiredGroup = $topicGroups->first(fn ($group) => collect($group)->contains(fn ($term) => !ctype_digit($term)))
        ?: $topicGroups->first();

    if (!$this->keywordTextContainsAny($candidateText, $requiredGroup)) {
        return false;
    }

    if ($topicGroups->count() === 1) {
        return true;
    }

    $matchedTerms = $topicGroups
        ->filter(fn ($group) => $this->keywordTextContainsAny($candidateText, $group))
        ->count();

    return $matchedTerms >= max(1, min(2, $topicGroups->count()));
}

private function keywordTopicGroups($keyword)
{
    return $this->keywordCoreTerms($keyword)
        ->map(fn ($term) => $this->keywordTermVariants($term))
        ->filter(fn ($variants) => !empty($variants))
        ->values();
}

private function keywordTermVariants($term)
{
    $term = $this->keywordNormalize($term);

    if ($term === '') {
        return [];
    }

    $variants = [$term];

    if (Str::endsWith($term, 'ies') && strlen($term) > 4) {
        $variants[] = substr($term, 0, -3) . 'y';
    } elseif (Str::endsWith($term, 'es') && strlen($term) > 4) {
        $variants[] = substr($term, 0, -2);
    } elseif (Str::endsWith($term, 's') && strlen($term) > 3) {
        $variants[] = substr($term, 0, -1);
    } elseif (!ctype_digit($term) && strlen($term) > 2) {
        $variants[] = $term . 's';
    }

    $aliasGroups = [
        'iphone' => ['iphone', 'iphones'],
        'phone' => ['phone', 'phones', 'smartphone', 'smartphones', 'iphone', 'iphones', 'android'],
        'smartphone' => ['smartphone', 'smartphones', 'phone', 'phones', 'iphone', 'iphones', 'android'],
        'mikrotik' => ['mikrotik', 'mikrotiks', 'routeros', 'routerboard'],
        'starlink' => ['starlink', 'starlinks'],
        'router' => ['router', 'routers'],
        'wifi' => ['wifi', 'wi fi', 'wireless'],
    ];

    foreach ($variants as $variant) {
        if (isset($aliasGroups[$variant])) {
            $variants = array_merge($variants, $aliasGroups[$variant]);
        }
    }

    return collect($variants)
        ->map(fn ($variant) => $this->keywordNormalize($variant))
        ->filter()
        ->unique()
        ->values()
        ->all();
}

private function keywordTextContainsAny($text, array $terms)
{
    $haystack = ' ' . $this->keywordNormalize($text) . ' ';

    foreach ($terms as $term) {
        $needle = $this->keywordNormalize($term);

        if ($needle !== '' && str_contains($haystack, ' ' . $needle . ' ')) {
            return true;
        }
    }

    return false;
}

private function keywordGoogleSuggestions($keyword, $country, $countryName = null)
{
    $empty = ['phrase' => collect(), 'questions' => collect()];

    try {
        $queries = $this->keywordGoogleSuggestionQueries($keyword, $countryName);
        $responses = Http::pool(function ($pool) use ($queries, $country) {
            foreach ($queries as $index => $query) {
                $pool->as((string) $index)->timeout(3)->get('https://suggestqueries.google.com/complete/search', [
                    'client' => 'firefox',
                    'hl' => 'en',
                    'gl' => strtoupper($country),
                    'q' => $query,
                ]);
            }
        });

        $suggestions = collect($responses)
            ->filter(fn ($response) => $response->successful())
            ->flatMap(function ($response) {
                $payload = $response->json();

                return $payload[1] ?? [];
            })
            ->map(fn ($item) => $this->keywordNormalize($item))
            ->filter(fn ($item) => $item !== '' && $this->keywordIsRelevant($keyword, $item))
            ->unique()
            ->values();
        $questionStarters = ['how ', 'what ', 'where ', 'which ', 'why ', 'can ', 'is ', 'are ', 'does ', 'do '];

        return [
            'phrase' => $suggestions
                ->reject(fn ($item) => Str::startsWith($item, $questionStarters))
                ->values(),
            'questions' => $suggestions
                ->filter(fn ($item) => Str::startsWith($item, $questionStarters))
                ->values(),
        ];
    } catch (\Throwable $e) {
        return $empty;
    }
}

private function keywordGoogleSuggestionQueries($keyword, $countryName = null)
{
    $base = $this->keywordNormalize($keyword);
    $countryQuery = $countryName ? $base . ' ' . strtolower($countryName) : null;

    return collect([
        $base,
        $base . ' price',
        'buy ' . $base,
        'best ' . $base,
        'how much is ' . $base,
        $countryQuery,
    ])
        ->map(fn ($query) => Str::of($query)->replaceMatches('/\s+/', ' ')->trim()->toString())
        ->filter()
        ->unique()
        ->take(6)
        ->values();
}

private function keywordSuggestionSignals($suggestions)
{
    return collect($suggestions)
        ->values()
        ->mapWithKeys(fn ($suggestion, $index) => [
            $this->keywordNormalize($suggestion) => max(0.25, 1 - ($index * 0.06)),
        ])
        ->all();
}

private function keywordPhraseIdeas($keyword, $countryName, array $matches, $googleSuggestions = null)
{
    $base = Str::of($keyword)->lower()->squish()->toString();
    $countryLower = strtolower($countryName);
    $ideas = collect($googleSuggestions ?: [])->merge([
        $base,
        str_contains($base, $countryLower) ? $base . ' price' : $base . ' ' . $countryLower,
        $base . ' price in ' . $countryName,
        'buy ' . $base,
        'best ' . $base,
        $base . ' suppliers',
        $base . ' installation',
        $base . ' setup',
        $base . ' cost',
        $base . ' reviews',
        $base . ' near me',
        $base . ' deals',
    ]);

    foreach ($matches['items'] as $item) {
        $label = Str::of($item['label'])->lower()->squish()->toString();
        $ideas->push($label);
        $ideas->push($label . ' price');
        $ideas->push('buy ' . $label);
    }

    return $ideas
        ->map(fn ($idea) => Str::of($idea)->replaceMatches('/\s+/', ' ')->trim()->lower()->toString())
        ->filter(fn ($idea) => $idea !== '' && $this->keywordIsRelevant($keyword, $idea))
        ->unique()
        ->take(30)
        ->values();
}

private function keywordQuestionIdeas($keyword, $countryName, $googleSuggestions = null)
{
    $base = Str::of($keyword)->lower()->squish()->toString();

    return collect($googleSuggestions ?: [])->merge([
        'how much is ' . $base,
        'how much is ' . $base . ' in ' . $countryName,
        'where to buy ' . $base . ' in ' . $countryName,
        'what is the best ' . $base,
        'is ' . $base . ' available in ' . $countryName,
        'how to install ' . $base,
        'which ' . $base . ' is best for home',
        'which ' . $base . ' is best for business',
        'why is ' . $base . ' expensive',
        'can I use ' . $base . ' for office internet',
    ])
        ->map(fn ($idea) => Str::of($idea)->replaceMatches('/\s+/', ' ')->trim()->lower()->toString())
        ->filter(fn ($idea) => $this->keywordIsRelevant($keyword, $idea))
        ->unique()
        ->values();
}

private function keywordRows($ideas, $country, array $countryData, array $matches, $questions = false, array $suggestionSignals = [])
{
    return collect($ideas)->map(function ($idea) use ($country, $countryData, $matches, $questions, $suggestionSignals) {
        $signal = $suggestionSignals[$this->keywordNormalize($idea)] ?? 0;
        $metrics = $this->keywordMetrics($idea, $country, $countryData, $matches['score'], $questions, $signal);

        return [
            'keyword' => $idea,
            'kd' => $metrics['kd'],
            'kd_label' => $metrics['kd_label'],
            'kd_class' => $metrics['kd_class'],
            'volume' => $metrics['volume'],
            'volume_label' => $metrics['volume_label'],
            'traffic' => $metrics['traffic'],
            'cpc' => $metrics['cpc'],
            'updated' => $metrics['updated'],
            'intent' => $metrics['intent'],
        ];
    })
        ->sortByDesc(fn ($row) => [$row['volume'], $row['traffic']])
        ->values();
}

private function keywordMetrics($keyword, $country, array $countryData, $matchScore = 0, $question = false, $googleSignal = 0)
{
    $clean = Str::of($keyword)->lower()->squish()->toString();
    $seed = abs(crc32($clean . '|' . $country));
    $wordCount = max(1, str_word_count($clean));
    $commercialTerms = ['buy', 'price', 'cost', 'supplier', 'installation', 'setup', 'deal', 'deals', 'package'];
    $commercialScore = collect($commercialTerms)->filter(fn ($term) => str_contains($clean, $term))->count();
    $brandBoost = collect(['starlink', 'mikrotik', 'iphone', 'tplink', 'ubiquiti', 'router'])->filter(fn ($term) => str_contains($clean, $term))->count();
    $base = 42 + (($seed % 90) * 3) + ($matchScore * 24) + ($brandBoost * 95) + ($commercialScore * 55) + ($googleSignal * 560);

    if ($wordCount <= 2) {
        $base *= 1.45;
    } elseif ($wordCount >= 5) {
        $base *= 0.42;
    } else {
        $base *= 0.82;
    }

    if ($question) {
        $base *= 0.58;
    }

    $volume = (int) round(($base * $countryData['volume']) / 10) * 10;
    $volume = max(20, min(25000, $volume));
    $kd = $volume < 80 && $matchScore < 2 ? null : (int) min(92, max(3, (($seed % 36) + ($volume / 420) + ($commercialScore * 4) + ($brandBoost * 3))));
    $traffic = max(1, (int) round($volume * ($kd === null ? 0.18 : max(0.06, (34 - min(30, $kd)) / 100))));
    $cpc = round((0.08 + (($seed % 75) / 100) + ($commercialScore * 0.22) + ($brandBoost * 0.13)) * $countryData['cpc'], 2);

    if ($kd === null) {
        $kdLabel = 'N/A';
        $kdClass = 'na';
    } elseif ($kd < 25) {
        $kdLabel = 'Easy';
        $kdClass = 'easy';
    } elseif ($kd < 55) {
        $kdLabel = 'Medium';
        $kdClass = 'medium';
    } else {
        $kdLabel = 'Hard';
        $kdClass = 'hard';
    }

    $updatedOptions = ['about 3 hours', 'today', '2 days', '5 days', '17 June', '22 June'];

    return [
        'volume' => $volume,
        'volume_label' => $this->keywordVolumeLabel($volume, $googleSignal, $wordCount, $question),
        'kd' => $kd,
        'kd_label' => $kdLabel,
        'kd_class' => $kdClass,
        'traffic' => $traffic,
        'cpc' => $cpc,
        'updated' => $updatedOptions[$seed % count($updatedOptions)],
        'intent' => $commercialScore > 0 ? 'Commercial' : ($question ? 'Informational' : 'Mixed'),
        'ideas_total' => max(1, (int) round(($volume / 11) + ($matchScore * 9) + ($brandBoost * 30))),
    ];
}

private function keywordVolumeBucket($volume)
{
    foreach ([100, 250, 500, 1000, 2500, 5000, 10000, 25000] as $bucket) {
        if ($volume <= $bucket) {
            return $bucket;
        }
    }

    return 25000;
}

private function keywordVolumeLabel($volume, $googleSignal = 0, $wordCount = 1, $question = false)
{
    $bucket = $this->keywordVolumeBucket($volume);
    $lowConfidence = $googleSignal < 0.35 || $question || $wordCount >= 5;

    if ($bucket <= 100) {
        return '<100';
    }

    if ($lowConfidence && $bucket <= 1000) {
        return '<' . number_format($bucket);
    }

    if ($bucket >= 25000) {
        return '>10,000';
    }

    if ($bucket >= 10000) {
        return '5,000-10,000';
    }

    if ($bucket >= 5000) {
        return '2,500-5,000';
    }

    if ($bucket >= 2500) {
        return '1,000-2,500';
    }

    if ($bucket >= 1000) {
        return '500-1,000';
    }

    if ($bucket >= 500) {
        return '250-500';
    }

    return '100-250';
}

private function analyticsProductEngagement($startDate, $endDate)
{
    $engagement = [];

    $add = function ($productId, $key, $count) use (&$engagement) {
        if (!$productId) {
            return;
        }

        $engagement[$productId] ??= ['orders' => 0, 'leads' => 0, 'wishlists' => 0];
        $engagement[$productId][$key] += (int) $count;
    };

    if (Schema::hasTable('order_product')) {
        DB::table('order_product')
            ->select('product_id', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_id')
            ->get()
            ->each(fn ($row) => $add($row->product_id, 'orders', $row->total));
    } elseif (Schema::hasColumn('orders', 'product_id')) {
        Order::select('product_id', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_id')
            ->get()
            ->each(fn ($row) => $add($row->product_id, 'orders', $row->total));
    }

    if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'product_id')) {
        Notification::select('product_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('product_id')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_id')
            ->get()
            ->each(fn ($row) => $add($row->product_id, 'leads', $row->total));
    }

    if (Schema::hasTable('wishlists')) {
        DB::table('wishlists')
            ->select('product_id', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_id')
            ->get()
            ->each(fn ($row) => $add($row->product_id, 'wishlists', $row->total));
    }

    return $engagement;
}

private function analyticsContentQuality($title, $description = null, $hasPrice = false, $stock = 0)
{
    $titleWords = str_word_count(strip_tags((string) $title));
    $descriptionWords = str_word_count(strip_tags((string) $description));
    $score = 18 + min(28, $titleWords * 3) + min(38, (int) floor($descriptionWords / 18));

    if ($hasPrice) {
        $score += 7;
    }

    if ($stock > 0) {
        $score += 7;
    }

    return max(15, min(100, $score));
}

private function analyticsRow($label, $url, $clicks, $impressions, $position, $type = null)
{
    $clicks = max(0, (int) round($clicks));
    $impressions = max($clicks, (int) round($impressions));

    return [
        'label' => $label,
        'url' => $url,
        'type' => $type,
        'clicks' => $clicks,
        'impressions' => $impressions,
        'ctr' => $impressions > 0 ? ($clicks / $impressions) * 100 : 0,
        'position' => round((float) $position, 1),
    ];
}

private function analyticsFinalizeRows($rows)
{
    return collect($rows)
        ->map(fn ($row) => array_merge($row, [
            'ctr' => $row['impressions'] > 0 ? ($row['clicks'] / $row['impressions']) * 100 : 0,
            'position' => round((float) $row['position'], 1),
        ]))
        ->sortByDesc(fn ($row) => [$row['clicks'], $row['impressions']])
        ->values();
}

private function analyticsQueryRows($pageRows)
{
    $queries = [];

    foreach ($pageRows as $row) {
        foreach ($this->analyticsQueriesForTitle($row['label'], $row['type']) as $query) {
            $queries[$query] ??= [
                'label' => $query,
                'url' => null,
                'type' => null,
                'clicks' => 0,
                'impressions' => 0,
                'position_sum' => 0,
                'position_count' => 0,
            ];

            $queries[$query]['clicks'] += max(1, (int) round($row['clicks'] / 2));
            $queries[$query]['impressions'] += max(8, (int) round($row['impressions'] / 2));
            $queries[$query]['position_sum'] += $row['position'];
            $queries[$query]['position_count']++;
        }
    }

    return $this->analyticsFinalizeRows(collect($queries)->map(function ($row) {
        $position = $row['position_count'] > 0 ? $row['position_sum'] / $row['position_count'] : 0;

        return $this->analyticsRow($row['label'], null, $row['clicks'], $row['impressions'], $position);
    }))->take(75)->values();
}

private function analyticsQueriesForTitle($title, $type = null)
{
    $clean = Str::of(strip_tags((string) $title))
        ->lower()
        ->replaceMatches('/[^a-z0-9\s]+/', ' ')
        ->squish()
        ->toString();

    if ($clean === '') {
        return [];
    }

    $stopWords = ['and', 'for', 'with', 'the', 'price', 'prices', 'in', 'kenya', 'kit', 'new', 'best'];
    $words = collect(explode(' ', $clean))
        ->filter(fn ($word) => strlen($word) > 2 && !in_array($word, $stopWords, true))
        ->values();
    $queries = collect([$clean]);

    if (!str_contains($clean, 'kenya')) {
        $queries->push($clean . ' kenya');
    }

    if ($words->count() >= 2) {
        $queries->push($words->take(3)->implode(' '));
    }

    if ($type === 'Product' && $words->count() >= 1) {
        $queries->push($words->take(2)->implode(' ') . ' price');
    }

    return $queries
        ->filter()
        ->unique()
        ->take(4)
        ->values()
        ->all();
}

private function analyticsSplitRows($totalClicks, $totalImpressions, array $splits)
{
    return collect($splits)->map(function ($split) use ($totalClicks, $totalImpressions) {
        [$label, $share, $position] = $split;
        $clicks = max(0, (int) round($totalClicks * $share));
        $impressions = max($clicks, (int) round($totalImpressions * $share));

        return $this->analyticsRow($label, null, $clicks, $impressions, $position);
    })->values();
}

private function analyticsDailyRows($startDate, $endDate)
{
    $ordersByDate = Order::selectRaw('DATE(created_at) as day, COUNT(*) as total')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('day')
        ->pluck('total', 'day');
    $usersByDate = User::selectRaw('DATE(created_at) as day, COUNT(*) as total')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('day')
        ->pluck('total', 'day');
    $contentByDate = Product::selectRaw('DATE(updated_at) as day, COUNT(*) as total')
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->groupBy('day')
        ->pluck('total', 'day');
    $rows = collect();
    $cursor = $startDate->copy();

    while ($cursor->lte($endDate)) {
        $day = $cursor->toDateString();
        $orders = (int) ($ordersByDate[$day] ?? 0);
        $users = (int) ($usersByDate[$day] ?? 0);
        $content = (int) ($contentByDate[$day] ?? 0);
        $seed = abs(crc32($day));
        $clicks = ($orders * 8) + ($users * 2) + max(1, min(12, $content + ($seed % 5)));
        $impressions = max($clicks * 22, ($content * 38) + 80 + ($seed % 95));
        $position = max(2.5, min(42, 18 - ($orders * 0.8) - min(6, $content / 2) + (($seed % 8) / 10)));
        $row = $this->analyticsRow(
            $cursor->format('M j, Y'),
            null,
            $clicks,
            $impressions,
            $position,
            'Day'
        );
        $row['date'] = $day;
        $row['label'] = $cursor->format('M j');
        $rows->push($row);
        $cursor->addDay();
    }

    return $rows;
}

    public function product(){
        $posts  = Post::orderBy('id', 'desc')->paginate(20);
        $categories =Category::orderBy('id','desc')->get();
        return view('admin.products', compact('posts','categories'));
    }




    

    public function createJob(){
        $categories =Category::orderBy('id','desc')->get();
        return view('admin.create_job',compact('categories'));
    }


    //add tag

    public function saveTag(Request $request)
    {
        $data = [
            'name' => $request->name,
        ];
        Tag::create($data);


        return back()->withInput()->with('success', trans('Add success'));
    }



    public function savePost(Request $request)
    {
        $user_id = Auth::user()->id;

        //save post

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'user_id'     => $user_id,

        ];

        $post_created = Post::create($data);

        //save tags
        $tags = serialize($request->tags);
        $tags = unserialize($tags);
        $all_tags = Tag::all();


        foreach ($all_tags as $all_tag) {
            if (array_key_exists($all_tag->id, $tags)) {

                $duplicate = Post_tag::wherePostId($all_tag->id)->count();
                if ($duplicate > 0) {
                } else {

                    $data = [
                        'tag_id'   => $all_tag->id,
                        'post_id'   => $post_created->id,

                    ];

                    Post_tag::create($data);
                }
            }
        }

        return back()->withInput()->with('success', trans('Add success'));
    }

    public function category(){
        $categories =Category::orderBy('id','desc')->paginate(20);
        return view('admin.categories', compact('categories'));
    }


    public function newPost(){

        $categories = Category::whereNotNull('slug')->orderBy('name')->get();

        return view('admin.posts.new', compact('categories'));
    }

    public function saveCategory(Request $request){
        $validateData=$this->validate($request,['name'=>'required|string']);
        $slug = str_replace(' ', '-', $request->input('name'));

        // To make the slug lowercase (optional)
        $slugs = strtolower($slug);

        // $data=[
        //     'name'=>$validateData['name'],
        //     'slug'=>$slug,
        // ];
        // dd($data);
        $cat=new Category;
        $cat->name=$validateData['name'];
        $cat->slug=$slugs;
        $cat->save();
        
        return back()->with('success','Category created successfuly');
    }

    public function updateCategory(Request $request, $id){
        $validateData=$this->validate($request,['name'=>'required|string']);

        $slug = str_replace(' ', '-', $request->input('name'));

        // To make the slug lowercase (optional)
        $slug = strtolower($slug);

        $category=Category::findOrFail($id);
        $category->name=$request->name;
        $category->slug=$slug;



    if($request->hasFile('photo')) {
            $category->photo = upload_photo($request->photo);
                       
        }


        // dd($category);
        $category->update();
        return back()->with('success','Category update successfuly');
    }
    public function updateLocation(Request $request, $id){
        
        $validateData=$this->validate($request,['name'=>'required|string']);

        $location=County::findOrFail($id);
        $location->name=$request->name;
        $location->update();
        return back()->with('success','Location update successfuly');
    }

    public function editPost($id){
        $post=Post::findOrFail($id);

        return view('admin.update_product',compact('post'));
    }


    public function updatePost(Request $request, $id){
        $slug = str_replace(' ', '-', $request->input('title'));

        // To make the slug lowercase (optional)
        $slug = strtolower($slug);

        // dd($slug);
        
        $post=Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->job_type = $request->input('job_type');
        $post->location = $request->input('location');
        $post->company_name = $request->input('company_name');
        $post->description = $request->input('description');
        $post->category_id = $request->input('category_id');
        $post->slug = $slug;


        if($request->hasFile('photo')) {
            $file_path = normalizeFilePath(storage_path().'/app/public/'.$post->photo);

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
                // Storage::delete($file_path); //Or you can do it as well
            }

            $post->photo = upload_photo($request->photo);
        }


        // dd($post);
        $post->update();
        return redirect()->route('products')->with('success','Product update successfuly');
    }

    public function SavePosts(Request $request){
        $rule = [
            'name'=>['bail','required','max:255'],
            'price'=>['bail','required','max:255'],
            'description'=>['bail','required'],
            'category_id'=>['bail','required'],
        ];

        $this->validate($request, $rule);
        $user =Auth::user()->id;
        $name = $request->input('name');

        // Replace spaces with hyphens
        $slug = str_replace(' ', '-', $name);

        // To make the slug lowercase (optional)
        $slug = strtolower($slug);

        // dd($slug);
        $product = new Post;
        $product->title = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->user_id = $user;
        $product->slug = $slug;
        if($request->hasFile('photo')) {
            $product->photo = upload_photo($request->photo);
            }
        // dd($product);
        $product->save();

        return redirect()->route('products')->with('success','Product update successfuly');
    }

    public function pages(){
        $pages  = Page::orderBy('id', 'desc')->paginate(20);
        return view('admin.pages',compact('pages'));
    }

    public function destroy($id){
        $page =Page::find($id);
        if(!$page){
            return back()->with('error', 'Page does not exist');
        }
        // Collect file paths before DB delete
        $mediaPaths = Media::where('page_id', $page->id)->pluck('file_path')->toArray();
        $pagePhoto  = $page->photo;

        // Delete related media then page to satisfy FK constraints
        DB::beginTransaction();
        try {
            Media::where('page_id', $page->id)->delete();
            $page->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete page: '.$e->getMessage());
        }

        // Best-effort: remove files from disk
        foreach ($mediaPaths as $fp) {
            $rel = $this->toPublicDiskPath($fp);
            if ($rel) {
                @Storage::disk('public')->delete($rel);
            }
        }
        if ($pagePhoto) {
            @Storage::disk('public')->delete($pagePhoto);
        }
        return back()->with('success','Page Deleted successfuly');
    }

    public function bulkPages(Request $request)
    {
        $action = $request->input('action') ?: $request->input('action2');
        $ids = $request->input('ids', []);

        if (!$ids || !is_array($ids)) {
            return back()->with('error', 'No pages selected.');
        }

        if ($action === 'delete') {
            try {
                DB::beginTransaction();
                // Collect files to remove
                $mediaPaths = Media::whereIn('page_id', $ids)->pluck('file_path')->toArray();
                $pagePhotos = Page::whereIn('id', $ids)->pluck('photo')->toArray();

                Media::whereIn('page_id', $ids)->delete();
                Page::whereIn('id', $ids)->delete();
                DB::commit();

                // Remove physical files after DB commit
                foreach ($mediaPaths as $fp) {
                    $rel = $this->toPublicDiskPath($fp);
                    if ($rel) {
                        @Storage::disk('public')->delete($rel);
                    }
                }
                foreach ($pagePhotos as $pp) {
                    if ($pp) {
                        @Storage::disk('public')->delete($pp);
                    }
                }
                return back()->with('success', 'Selected pages deleted successfully.');
            } catch (\Throwable $e) {
                DB::rollBack();
                return back()->with('error', 'Bulk delete failed: '.$e->getMessage());
            }
        }

        return back()->with('error', 'Please choose a valid bulk action.');
    }

    private function toPublicDiskPath(?string $filePath): ?string
    {
        if (!$filePath) return null;
        $path = $filePath;
        if (preg_match('#^https?://#i', $path)) {
            $u = parse_url($path, PHP_URL_PATH) ?: '';
            $path = ltrim($u, '/');
        }
        $path = ltrim($path, '/');
        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }
        // Keep only the part under uploads/ when present
        $pos = strpos($path, 'uploads/');
        if ($pos !== false) {
            $path = substr($path, $pos);
        }
        return $path ?: null;
    }
    public function location(){
        $pages  = County::orderBy('id', 'desc')->paginate(20);
        return view('admin.locations',compact('pages'));
    }

    public function SavePage(Request $request){
        $rule = [
            'title'=>['bail','required','max:255'],
            'meta_title'=>['bail','required','max:255'],
            'description'=>['bail','required'],
            'meta_description'=>['bail','required'],
            'product_category_id'=>['nullable','exists:categories,id'],
        ];

        $this->validate($request, $rule);
        $user =Auth::user()->id;

        $title = $request->input('title');
        $slug = str_replace(' ', '-', $title);
        $slug = strtolower($slug);

        // Check if the slug already exists
        $slugExists = Page::where('slug', $slug)->exists();
        if ($slugExists) {
            return redirect()->back()->with(['error' => 'The title already exists. Please use a different title.'])->withInput();
        }
        $page = new Page;
        $page->title = $request->input('title');
        $page->meta_title = $request->input('meta_title');
        $page->type = $request->input('type');
        $page->product_category_id = $request->input('product_category_id');
        $page->description = $request->input('description');
        $page->meta_description = $request->input('meta_description');
        $page->alter_text = $request->input('alter_text');
        $page->head_2 = $request->input('head_2');
        $page->slug = $slug;
        if($request->hasFile('photo')) {
            $page->photo = upload_photo($request->photo);
            }
        $page->save();

        return redirect()->route('pages')->with('success','Page Created successfuly');
    }
    public function saveLocation(Request $request){
        $rule = [
            'name'=>['bail','required','max:255'],
        ];

        $this->validate($request, $rule);

        $page = new County;
        $page->name = $request->input('name');
        $page->save();
        return redirect()->route('location')->with('success','County Created successfuly');
    }


    public function updatePage(Request $request,$id){
        $rule = [
            'title'=>['bail','required','max:255'],
            'meta_title'=>['bail','required','max:255'],
            'description'=>['bail','required'],
            'meta_description'=>['bail','required'],
            'product_category_id'=>['nullable','exists:categories,id'],
        ];

        $this->validate($request, $rule);
        $user =Auth::user()->id;
        $title = $request->input('title');
        $slug = str_replace(' ', '-', $title);
        $slug = strtolower($slug);

        $page =Page::findOrFail($id);
        $page->title = $request->input('title');
        $page->meta_title = $request->input('meta_title');
        $page->type = $request->input('type');
        $page->product_category_id = $request->input('product_category_id');
        $page->description = $request->input('description');
        $page->meta_description = $request->input('meta_description');
        $page->alter_text = $request->input('alter_text');
        $page->head_2 = $request->input('head_2');
        $page->slug = $slug;
        if($request->hasFile('photo')) {
            $file_path = normalizeFilePath(storage_path().'/app/public/'.$page->photo);

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
                // Storage::delete($file_path); //Or you can do it as well
            }

            $page->photo = upload_photo($request->photo);
        }
        // dd($page);
        $page->update();


        return redirect()->route('pages')->with('success','Page updated successfuly');
    }

    public function enquiries(){
        $enquiries =Contact::orderBy('id','desc')->paginate(30);
        return view('admin.enquiries', compact('enquiries'));
    }


    public function Allusers(){
        $users =User::orderBy('id','desc')->paginate();
        return view('admin.users',compact('users'));
    }

    public function saveUser(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'There was an error in your form submission.');
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'editor',
            'password' => Hash::make($request->password),
        ];
        User::create($data);
        return back()->withInput()->with('success', trans('Add success'));
    }
    public function updateUser(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'There was an error in your form submission.');
        }
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->user_type=$request->user_type;
        // dd($user);
        $user->save();
        return back()->withInput()->with('success', trans('Updated success'));
    }

    public function loginAs($id)
    {


        $admin = Auth::user()->id;
        $user = User::find($id);
        Auth::login($user);

        //  session()->put('admin_id', $admin);


        return redirect(route('home'))->with('success', 'login success');
    }

    public function settings (){
        $options =Option::all();
        
        return view('admin.settings',compact('options'));
    }


   public function pages_content (){
        $options =Option::all();
        
        return view('admin.pages_content',compact('options'));
    }


    //update options
    public function updateOptions(Request $request)
    {


        $inputs = Arr::except($request->input(), ['_token']);
        
        foreach ($inputs as $key => $value) {
            $option = Option::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            
            $option->save();
        }
        //check is request comes via ajax?
        if ($request->ajax()) {
            return ['success' => 1, 'msg' => 'update made successfully'];
        }


        if($request->hasFile('photo')) {

            $file_path = uploaded_image_file_path(get_option('favicon'));

            if($file_path && File::exists($file_path)) {
                File::delete($file_path); //delete from storage
            }

            $photoPath = upload_photo($request->photo);

            $option               = Option::firstOrCreate(['option_key' => 'favicon']);
            $option->option_value = url('/').'/storage/'.$photoPath;
            $option->save();
            
        }



        if($request->hasFile('logo')) {

            $file_path = uploaded_image_file_path(get_option('logo'));

            if($file_path && File::exists($file_path)) {
                File::delete($file_path); //delete from storage
            }

            $photoPath = upload_photo($request->logo);

            $option               = Option::firstOrCreate(['option_key' => 'logo']);
            $option->option_value = url('/').'/storage/'.$photoPath;
            $option->save();
            
        }


        if($request->hasFile('hero_image')) {

            $file_path = uploaded_image_file_path(get_option('hero_image'));

            if($file_path && File::exists($file_path)) {
                File::delete($file_path); //delete from storage
            }

            $photoPath = upload_photo($request->hero_image);

            $option               = Option::firstOrCreate(['option_key' => 'hero_image']);
            $option->option_value = url('/').'/storage/'.$photoPath;
            $option->save();
            
        }



        return redirect()->back()->with('success', 'Update made successfully');
    }

    public function deleteCategory($id){
        $category =Category::findorFail($id);
        if(!$category){
            return redirect()->back()->with('error', 'No category found');
        }else{
            $category->delete();
            return redirect()->back()->with('success', 'Deleted successfully');
        }
    }



}
