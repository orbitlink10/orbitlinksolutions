@extends('theme.orbit.layouts.main')

@section('title', 'Internet Speed Test')
@section('meta_description', 'Run a free browser internet speed test from Orbitlink Solutions and measure ping, download speed, and upload speed.')
@section('canonical', route('speed-test'))

@section('main')
<section class="public-speedtest">
    <div class="container">
        <div class="speedtest-shell">
            <div class="speedtest-heading">
                <div>
                    <span class="speedtest-eyebrow">Internet speed test</span>
                    <h1>Test your connection speed</h1>
                    <p>Measure ping, download, and upload speed between your browser and Orbitlink Solutions.</p>
                </div>
                <div class="speedtest-external-links">
                    <a href="https://fast.com/" target="_blank" rel="noopener">
                        Fast.com <i class="fas fa-external-link-alt"></i>
                    </a>
                    <a href="https://www.speedtest.net/" target="_blank" rel="noopener">
                        Speedtest.net <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>

            <div class="speedtest-grid">
                <div class="speedtest-panel speedtest-console">
                    <div class="speedtest-gauge">
                        <div class="gauge-ring" id="speedGauge">
                            <div class="gauge-inner">
                                <span id="speedValue">0.0</span>
                                <small>Mbps</small>
                            </div>
                        </div>
                        <div class="speedtest-state" id="speedState">Ready</div>
                    </div>

                    <div class="speedtest-controls">
                        <div class="speedtest-presets" role="group" aria-label="Speed test size">
                            @foreach($presets as $key => $preset)
                                <button type="button"
                                        class="speed-option {{ $key === 'standard' ? 'active' : '' }}"
                                        data-download="{{ $preset['download'] }}"
                                        data-upload="{{ $preset['upload'] }}">
                                    {{ $preset['label'] }}
                                </button>
                            @endforeach
                        </div>
                        <button type="button" class="speedtest-start" id="speedStart">
                            <i class="fas fa-play"></i>
                            <span>Start Test</span>
                        </button>
                    </div>
                </div>

                <div class="speedtest-panel speedtest-results">
                    <div class="result-row">
                        <div>
                            <span>Ping</span>
                            <strong id="pingResult">--</strong>
                        </div>
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="result-row">
                        <div>
                            <span>Download</span>
                            <strong id="downloadResult">--</strong>
                        </div>
                        <i class="fas fa-download"></i>
                    </div>
                    <div class="result-row">
                        <div>
                            <span>Upload</span>
                            <strong id="uploadResult">--</strong>
                        </div>
                        <i class="fas fa-upload"></i>
                    </div>
                    <div class="result-row">
                        <div>
                            <span>Server</span>
                            <strong>{{ request()->getHost() }}</strong>
                        </div>
                        <i class="fas fa-server"></i>
                    </div>
                </div>
            </div>

            <div class="speedtest-panel speedtest-progress-panel">
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Download progress</span>
                        <em id="downloadProgressText">0%</em>
                    </div>
                    <div class="speedtest-progress">
                        <span id="downloadProgressBar"></span>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Upload progress</span>
                        <em id="uploadProgressText">0%</em>
                    </div>
                    <div class="speedtest-progress">
                        <span id="uploadProgressBar"></span>
                    </div>
                </div>
            </div>

            <div class="speedtest-note">
                <i class="fas fa-info-circle"></i>
                <span>This test measures your connection to the Orbitlink Solutions website server. Public services such as Fast.com and Speedtest.net may show different results because they use different test servers.</span>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .public-speedtest {
        background: #f5f7fb;
        padding: 42px 0 56px;
    }

    .speedtest-shell {
        color: #102033;
    }

    .speedtest-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .speedtest-eyebrow {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        background: #fff4e7;
        color: #c45a00;
        padding: 6px 14px;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .speedtest-heading h1 {
        margin: 12px 0 6px;
        color: #0f172a;
        font-size: clamp(2rem, 5vw, 3.4rem);
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: 0;
    }

    .speedtest-heading p {
        color: #526174;
        margin: 0;
        font-size: 1.02rem;
        max-width: 720px;
    }

    .speedtest-external-links {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 8px;
    }

    .speedtest-external-links a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        padding: 0 14px;
        background: #fff;
        border: 1px solid #dbe3ee;
        color: #1e3a8a;
        font-weight: 800;
        text-decoration: none;
    }

    .speedtest-external-links a:hover {
        color: #f47a20;
        border-color: #f47a20;
        text-decoration: none;
    }

    .speedtest-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 16px;
        align-items: stretch;
    }

    .speedtest-panel {
        background: #fff;
        border: 1px solid #dbe3ee;
        border-radius: 8px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .speedtest-console {
        display: grid;
        grid-template-columns: minmax(250px, 360px) minmax(0, 1fr);
        gap: 24px;
        align-items: center;
        padding: 28px;
    }

    .speedtest-gauge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
    }

    .gauge-ring {
        width: 260px;
        aspect-ratio: 1;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: conic-gradient(#1d4ed8 0deg, #e6edf6 0deg);
        transition: background 0.2s ease;
    }

    .gauge-inner {
        width: 196px;
        aspect-ratio: 1;
        border-radius: 50%;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 0 1px #e6edf6;
    }

    .gauge-inner span {
        color: #0f172a;
        font-size: 3.4rem;
        line-height: 1;
        font-weight: 800;
    }

    .gauge-inner small {
        color: #526174;
        font-size: 1rem;
        font-weight: 800;
    }

    .speedtest-state {
        color: #26364c;
        font-size: 1rem;
        font-weight: 800;
    }

    .speedtest-controls {
        display: flex;
        flex-direction: column;
        gap: 18px;
        min-width: 0;
    }

    .speedtest-presets {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }

    .speed-option {
        border: 1px solid #cbd6e2;
        background: #f8fafc;
        color: #26364c;
        border-radius: 8px;
        min-height: 46px;
        font-weight: 800;
    }

    .speed-option.active {
        border-color: #f47a20;
        background: #fff4e7;
        color: #b74f00;
        box-shadow: 0 0 0 3px rgba(244, 122, 32, 0.14);
    }

    .speedtest-start {
        border: 0;
        border-radius: 8px;
        min-height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #15803d;
        color: #fff;
        font-size: 1.05rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .speedtest-start.testing {
        background: #dc2626;
    }

    .speedtest-results {
        display: grid;
        padding: 8px 18px;
    }

    .result-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 17px 0;
        border-bottom: 1px solid #edf2f7;
    }

    .result-row:last-child {
        border-bottom: 0;
    }

    .result-row span {
        display: block;
        color: #65758a;
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .result-row strong {
        display: block;
        color: #0f172a;
        font-size: 1.28rem;
        line-height: 1.2;
        word-break: break-word;
    }

    .result-row i {
        width: 42px;
        aspect-ratio: 1;
        border-radius: 8px;
        display: grid;
        place-items: center;
        background: #eef5ff;
        color: #1d4ed8;
        flex: 0 0 auto;
    }

    .speedtest-progress-panel {
        margin-top: 16px;
        padding: 22px;
        display: grid;
        gap: 18px;
    }

    .progress-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        color: #26364c;
        font-size: 0.92rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .progress-label em {
        color: #65758a;
        font-style: normal;
    }

    .speedtest-progress {
        height: 12px;
        overflow: hidden;
        border-radius: 999px;
        background: #e6edf6;
    }

    .speedtest-progress span {
        display: block;
        width: 0;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #1d4ed8, #15803d);
        transition: width 0.18s ease;
    }

    .speedtest-note {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 14px;
        color: #526174;
        font-size: 0.92rem;
        background: #fff;
        border: 1px solid #dbe3ee;
        border-radius: 8px;
        padding: 12px 14px;
    }

    .speedtest-note i {
        color: #1d4ed8;
    }

    @media (max-width: 1100px) {
        .speedtest-grid,
        .speedtest-console {
            grid-template-columns: 1fr;
        }

        .speedtest-results {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 24px;
        }
    }

    @media (max-width: 640px) {
        .public-speedtest {
            padding-top: 28px;
        }

        .speedtest-console {
            padding: 20px;
        }

        .gauge-ring {
            width: min(240px, 78vw);
        }

        .gauge-inner {
            width: min(180px, 58vw);
        }

        .gauge-inner span {
            font-size: 2.6rem;
        }

        .speedtest-presets,
        .speedtest-results {
            grid-template-columns: 1fr;
        }

        .speedtest-note {
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const routes = {
            download: @json(route('speed-test.download')),
            upload: @json(route('speed-test.upload'))
        };
        const csrfToken = @json(csrf_token());
        const gauge = document.getElementById('speedGauge');
        const speedValue = document.getElementById('speedValue');
        const speedState = document.getElementById('speedState');
        const startButton = document.getElementById('speedStart');
        const options = Array.from(document.querySelectorAll('.speed-option'));
        const pingResult = document.getElementById('pingResult');
        const downloadResult = document.getElementById('downloadResult');
        const uploadResult = document.getElementById('uploadResult');
        const downloadProgressBar = document.getElementById('downloadProgressBar');
        const uploadProgressBar = document.getElementById('uploadProgressBar');
        const downloadProgressText = document.getElementById('downloadProgressText');
        const uploadProgressText = document.getElementById('uploadProgressText');
        let controller = null;
        let testing = false;

        function activeOption() {
            return options.find(function (option) {
                return option.classList.contains('active');
            }) || options[0];
        }

        function setGauge(mbps) {
            const numeric = Number.isFinite(mbps) ? Math.max(0, mbps) : 0;
            const percent = Math.min(numeric / 200, 1);
            const degrees = Math.round(percent * 360);
            speedValue.textContent = numeric.toFixed(numeric >= 100 ? 0 : 1);
            gauge.style.background = 'conic-gradient(#1d4ed8 ' + degrees + 'deg, #e6edf6 0deg)';
        }

        function setProgress(type, value) {
            const percent = Math.max(0, Math.min(100, value));
            const bar = type === 'download' ? downloadProgressBar : uploadProgressBar;
            const text = type === 'download' ? downloadProgressText : uploadProgressText;
            bar.style.width = percent.toFixed(0) + '%';
            text.textContent = percent.toFixed(0) + '%';
        }

        function setTesting(value) {
            testing = value;
            startButton.classList.toggle('testing', value);
            startButton.querySelector('i').className = value ? 'fas fa-stop' : 'fas fa-play';
            startButton.querySelector('span').textContent = value ? 'Stop Test' : 'Start Test';
            options.forEach(function (option) {
                option.disabled = value;
            });
        }

        function formatSpeed(mbps) {
            if (!Number.isFinite(mbps)) {
                return '--';
            }

            return mbps.toFixed(mbps >= 100 ? 0 : 1) + ' Mbps';
        }

        async function measurePing(signal) {
            const samples = [];

            for (let index = 0; index < 4; index++) {
                const started = performance.now();
                await fetch(routes.download + '?bytes=1024&t=' + Date.now() + '-' + index, {
                    cache: 'no-store',
                    credentials: 'same-origin',
                    signal: signal
                });
                samples.push(performance.now() - started);
            }

            return Math.round(Math.min.apply(null, samples));
        }

        async function measureDownload(bytes, signal) {
            const response = await fetch(routes.download + '?bytes=' + bytes + '&t=' + Date.now(), {
                cache: 'no-store',
                credentials: 'same-origin',
                signal: signal
            });

            if (!response.ok) {
                throw new Error('Download test failed.');
            }

            const expected = Number(response.headers.get('content-length')) || bytes;
            const started = performance.now();
            let received = 0;

            if (response.body && response.body.getReader) {
                const reader = response.body.getReader();

                while (true) {
                    const result = await reader.read();

                    if (result.done) {
                        break;
                    }

                    received += result.value.byteLength;
                    setProgress('download', (received / expected) * 100);
                    setGauge((received * 8) / Math.max(1, performance.now() - started) / 1000);
                }
            } else {
                const buffer = await response.arrayBuffer();
                received = buffer.byteLength;
                setProgress('download', 100);
            }

            const seconds = Math.max(0.001, (performance.now() - started) / 1000);
            return (received * 8) / seconds / 1000000;
        }

        function makeUploadBlob(bytes) {
            const chunks = [];
            const chunkSize = 64 * 1024;
            let remaining = bytes;

            while (remaining > 0) {
                const size = Math.min(chunkSize, remaining);
                const chunk = new Uint8Array(size);

                if (window.crypto && window.crypto.getRandomValues) {
                    window.crypto.getRandomValues(chunk);
                } else {
                    for (let index = 0; index < size; index++) {
                        chunk[index] = Math.floor(Math.random() * 256);
                    }
                }

                chunks.push(chunk);
                remaining -= size;
            }

            return new Blob(chunks, { type: 'application/octet-stream' });
        }

        function measureUpload(bytes, signal) {
            return new Promise(function (resolve, reject) {
                const xhr = new XMLHttpRequest();
                const blob = makeUploadBlob(bytes);
                let started = 0;

                xhr.open('POST', routes.upload + '?t=' + Date.now(), true);
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.onloadstart = function () {
                    started = performance.now();
                };

                xhr.upload.onprogress = function (event) {
                    if (!event.lengthComputable) {
                        return;
                    }

                    if (!started) {
                        started = performance.now();
                    }

                    setProgress('upload', (event.loaded / event.total) * 100);
                    setGauge((event.loaded * 8) / Math.max(1, performance.now() - started) / 1000);
                };

                xhr.onload = function () {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject(new Error('Upload test failed.'));
                        return;
                    }

                    const seconds = Math.max(0.001, (performance.now() - (started || performance.now())) / 1000);
                    setProgress('upload', 100);
                    resolve((blob.size * 8) / seconds / 1000000);
                };

                xhr.onerror = function () {
                    reject(new Error('Upload test failed.'));
                };

                xhr.onabort = function () {
                    reject(new DOMException('Aborted', 'AbortError'));
                };

                signal.addEventListener('abort', function () {
                    xhr.abort();
                }, { once: true });

                xhr.send(blob);
            });
        }

        async function runTest() {
            const option = activeOption();
            const downloadBytes = Number(option.dataset.download);
            const uploadBytes = Number(option.dataset.upload);

            controller = new AbortController();
            setTesting(true);
            setGauge(0);
            setProgress('download', 0);
            setProgress('upload', 0);
            pingResult.textContent = '--';
            downloadResult.textContent = '--';
            uploadResult.textContent = '--';

            try {
                speedState.textContent = 'Checking ping';
                const ping = await measurePing(controller.signal);
                pingResult.textContent = ping + ' ms';

                speedState.textContent = 'Testing download';
                const downloadMbps = await measureDownload(downloadBytes, controller.signal);
                downloadResult.textContent = formatSpeed(downloadMbps);
                setGauge(downloadMbps);

                speedState.textContent = 'Testing upload';
                const uploadMbps = await measureUpload(uploadBytes, controller.signal);
                uploadResult.textContent = formatSpeed(uploadMbps);
                setGauge(uploadMbps);

                speedState.textContent = 'Complete';
            } catch (error) {
                if (error.name === 'AbortError') {
                    speedState.textContent = 'Stopped';
                } else {
                    speedState.textContent = error.message || 'Test failed';
                }
            } finally {
                setTesting(false);
                controller = null;
            }
        }

        options.forEach(function (option) {
            option.addEventListener('click', function () {
                options.forEach(function (item) {
                    item.classList.toggle('active', item === option);
                });
            });
        });

        startButton.addEventListener('click', function () {
            if (testing && controller) {
                controller.abort();
                return;
            }

            runTest();
        });
    });
</script>
@endpush
