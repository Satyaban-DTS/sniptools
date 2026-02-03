<!-- Fonts for preview -->
<link
    href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Playfair+Display:wght@700&family=Roboto+Mono:wght@500&display=swap"
    rel="stylesheet">

<div class="space-y-8" x-data="{ mode: 'text' }">
    <!-- Initial Upload State -->
    <div id="uploadArea" class="animate-fade-in">
        <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-[2.5rem] p-16 text-center hover:border-primary/50 hover:bg-primary/5 transition-all cursor-pointer group bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm"
            onclick="document.getElementById('imageInput').click()">
            <input type="file" id="imageInput" class="hidden" accept="image/*">
            <div class="space-y-6">
                <div
                    class="w-24 h-24 bg-white dark:bg-gray-800 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                    <i
                        class="fas fa-magic text-4xl text-primary bg-gradient-to-br from-primary to-purple-600 bg-clip-text text-transparent"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-secondary dark:text-white tracking-tight mb-2">Upload Source
                        Image</h3>
                    <p class="text-sm text-gray-400 font-medium">Supports high-res PNG, JPG, and WEBP</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Editor Workspace -->
    <div id="editorArea" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-8 animate-slide-up">

        <!-- Controls Panel (Left) -->
        <div class="lg:col-span-4 space-y-6">
            <div
                class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl rounded-[2.5rem] p-6 lg:p-8 border border-white/20 dark:border-gray-700/50 shadow-2xl h-[calc(100vh-12rem)] overflow-y-auto custom-scrollbar">

                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6 flex items-center">
                    <i class="fas fa-sliders-h mr-2 text-primary"></i> Configuration
                </h3>

                <!-- Type Toggle -->
                <div class="flex bg-gray-100 dark:bg-gray-900/50 p-1.5 rounded-2xl mb-8">
                    <button id="btnTextMode" onclick="setMode('text')"
                        class="flex-1 py-3 type-btn active rounded-xl text-xs font-black uppercase tracking-widest transition-all text-center">
                        <i class="fas fa-font mr-2"></i> Text
                    </button>
                    <button id="btnImageMode" onclick="setMode('image')"
                        class="flex-1 py-3 type-btn rounded-xl text-xs font-black uppercase tracking-widest transition-all text-center text-gray-400 hover:text-primary">
                        <i class="fas fa-image mr-2"></i> Logo
                    </button>
                </div>

                <div class="space-y-8">
                    <!-- Text Controls -->
                    <div id="textControls" class="space-y-5 animate-fade-in">
                        <div class="space-y-2">
                            <label
                                class="text-[9px] font-bold text-gray-500 uppercase tracking-widest px-1">Content</label>
                            <textarea id="watermarkText" rows="2" placeholder="© 2026 My Brand"
                                class="w-full p-4 rounded-xl bg-gray-50 dark:bg-gray-900 border border-transparent focus:border-primary/30 outline-none text-base font-semibold transition-all resize-none">© Sniptools</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label
                                    class="text-[9px] font-bold text-gray-500 uppercase tracking-widest px-1">Typography</label>
                                <select id="fontFamily"
                                    class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 text-xs font-bold outline-none">
                                    <option value="Inter, sans-serif">Modern Sans</option>
                                    <option value="'Playfair Display', serif">Elegant Serif</option>
                                    <option value="'Dancing Script', cursive">Handwritten</option>
                                    <option value="'Roboto Mono', monospace">Monospace</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="text-[9px] font-bold text-gray-500 uppercase tracking-widest px-1">Color</label>
                                <div class="flex items-center space-x-2 bg-gray-50 dark:bg-gray-900 rounded-xl p-2">
                                    <input type="color" id="textColor" value="#ffffff"
                                        class="w-8 h-8 rounded-lg cursor-pointer border-none p-0 bg-transparent">
                                    <span class="text-[10px] font-mono opacity-50 flex-1 text-right">#HEX</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Controls -->
                    <div id="imageControls" class="hidden space-y-5 animate-fade-in">
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest px-1">Watermark
                                Source</label>
                            <label class="block w-full cursor-pointer group">
                                <input type="file" id="logoUpload" accept="image/*" class="hidden">
                                <div
                                    class="w-full p-6 border-2 border-dashed border-gray-200 dark:border-gray-700/50 rounded-2xl group-hover:border-primary/50 group-hover:bg-primary/5 transition-all flex flex-col items-center justify-center">
                                    <i
                                        class="fas fa-cloud-upload-alt text-2xl text-gray-300 group-hover:text-primary mb-2"></i>
                                    <span id="logoFileName"
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Select
                                        Logo Png</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Common Controls -->
                    <div class="space-y-6 pt-6 border-t border-gray-100 dark:border-gray-700/50">
                        <!-- Sliders -->
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Size /
                                        Scale</label>
                                    <span id="labelSize" class="text-[9px] font-mono text-primary">50%</span>
                                </div>
                                <input type="range" id="size" min="10" max="200" value="50"
                                    class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-primary">
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <label
                                        class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Opacity</label>
                                    <span id="labelOpacity" class="text-[9px] font-mono text-primary">80%</span>
                                </div>
                                <input type="range" id="opacity" min="0" max="100" value="80"
                                    class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-primary">
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <label
                                        class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Rotation</label>
                                    <span id="labelRotation" class="text-[9px] font-mono text-primary">0°</span>
                                </div>
                                <input type="range" id="rotation" min="0" max="360" value="0"
                                    class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-primary">
                            </div>
                        </div>

                        <!-- Tiling Toggle -->
                        <label
                            class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl cursor-pointer hover:bg-white dark:hover:bg-gray-800 transition-colors border border-transparent hover:border-primary/20">
                            <span
                                class="text-[10px] font-black text-secondary dark:text-gray-300 uppercase tracking-widest flex items-center">
                                <i class="fas fa-th mr-2 text-gray-400"></i> Tile Repeat
                            </span>
                            <div class="relative">
                                <input type="checkbox" id="tileCheck" class="peer sr-only">
                                <div
                                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                        </label>

                        <!-- Position Grid -->
                        <div id="positionGrid" class="space-y-3">
                            <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Anchor
                                Point</label>
                            <div class="grid grid-cols-3 gap-2 w-32">
                                <button onclick="pos='tl'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-up rotate-[-45deg]"></i></button>
                                <button onclick="pos='tc'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-up"></i></button>
                                <button onclick="pos='tr'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-up rotate-[45deg]"></i></button>
                                <button onclick="pos='cl'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-left"></i></button>
                                <button onclick="pos='cc'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-crosshairs"></i></button>
                                <button onclick="pos='cr'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-right"></i></button>
                                <button onclick="pos='bl'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-down rotate-[45deg]"></i></button>
                                <button onclick="pos='bc'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-down"></i></button>
                                <button onclick="pos='br'; draw()"
                                    class="h-8 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white transition-colors text-[10px]"><i
                                        class="fas fa-arrow-down rotate-[-45deg]"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700/50">
                    <button onclick="downloadImage()"
                        class="w-full py-4 bg-gradient-to-r from-primary to-accent text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center">
                        <i class="fas fa-file-export mr-2"></i> Export Result
                    </button>
                </div>
            </div>
        </div>

        <!-- Canvas Preview (Right) -->
        <div class="lg:col-span-8 flex flex-col justify-center h-full min-h-[500px]">
            <div
                class="relative w-full h-full flex items-center justify-center bg-gray-100/50 dark:bg-[#0a0c14] rounded-[3rem] border-2 border-dashed border-gray-200 dark:border-gray-800 p-8 overflow-hidden group">
                <!-- Canvas Wrapper -->
                <div class="relative shadow-2xl rounded-lg overflow-hidden transition-transform duration-500">
                    <canvas id="canvas" class="max-w-full max-h-[70vh] object-contain"></canvas>
                </div>

                <div
                    class="absolute bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 bg-black/50 backdrop-blur-md rounded-full text-white text-[10px] font-bold uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                    Preview Mode
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .type-btn.active {
        background-color: white;
        color: #c026d3;
        /* primary */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .dark .type-btn.active {
        background-color: #1f2937;
        /* gray-800 */
        color: white;
    }
</style>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    // State
    let state = {
        baseImage: null,
        watermarkType: 'text', // text | image
        watermarkImage: null,
        pos: 'cc',
        text: '© Sniptools',
        font: 'Inter, sans-serif',
        color: '#ffffff',
        size: 50,    // 10-200 (scale factor)
        opacity: 80, // 0-100
        rotation: 0, // 0-360
        tiled: false
    };

    // --- Inputs Listeners ---

    // Text inputs
    const controls = ['watermarkText', 'fontFamily', 'textColor', 'size', 'opacity', 'rotation', 'tileCheck'];
    controls.forEach(id => {
        document.getElementById(id).addEventListener('input', updateStateFromDOM);
        document.getElementById(id).addEventListener('change', updateStateFromDOM);
    });

    function updateStateFromDOM(e) {
        state.text = document.getElementById('watermarkText').value;
        state.font = document.getElementById('fontFamily').value;
        state.color = document.getElementById('textColor').value;
        state.size = parseInt(document.getElementById('size').value);
        state.opacity = parseInt(document.getElementById('opacity').value);
        state.rotation = parseInt(document.getElementById('rotation').value);
        state.tiled = document.getElementById('tileCheck').checked;

        // Update Labels
        document.getElementById('labelSize').innerText = state.size + '%';
        document.getElementById('labelOpacity').innerText = state.opacity + '%';
        document.getElementById('labelRotation').innerText = state.rotation + '°';
        document.getElementById('positionGrid').classList.toggle('opacity-50', state.tiled);
        document.getElementById('positionGrid').classList.toggle('pointer-events-none', state.tiled);

        draw();
    }

    // Mode Switching
    window.setMode = function (mode) {
        state.watermarkType = mode;
        const btnText = document.getElementById('btnTextMode');
        const btnImage = document.getElementById('btnImageMode');
        const textControls = document.getElementById('textControls');
        const imageControls = document.getElementById('imageControls');

        if (mode === 'text') {
            btnText.classList.add('active');
            btnText.classList.remove('text-gray-400');
            btnImage.classList.remove('active');
            btnImage.classList.add('text-gray-400');

            textControls.classList.remove('hidden');
            imageControls.classList.add('hidden');
        } else {
            btnImage.classList.add('active');
            btnImage.classList.remove('text-gray-400');
            btnText.classList.remove('active');
            btnText.classList.add('text-gray-400');

            imageControls.classList.remove('hidden');
            textControls.classList.add('hidden');
        }
        draw();
    }

    // Position Setting
    window.pos = state.pos; // global hook for onclick
    // Hijack the global setter to update state and draw
    const originalPosSetter = Object.getOwnPropertyDescriptor(window, 'pos');
    Object.defineProperty(window, 'pos', {
        set: function (val) { state.pos = val; draw(); },
        get: function () { return state.pos; }
    });


    // --- Image Handling ---

    // Base Image
    document.getElementById('imageInput').addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                const img = new Image();
                img.onload = function () {
                    state.baseImage = img;
                    // Switch view
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('editorArea').classList.remove('hidden');
                    draw();
                };
                img.src = evt.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Watermark Logo
    document.getElementById('logoUpload').addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                const img = new Image();
                img.onload = function () {
                    state.watermarkImage = img;
                    document.getElementById('logoFileName').innerHTML = `<span class="text-primary font-bold">${e.target.files[0].name}</span>`;
                    draw();
                };
                img.src = evt.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });


    // --- Core Logic ---

    function draw() {
        if (!state.baseImage) return;

        // Reset Canvas
        canvas.width = state.baseImage.width;
        canvas.height = state.baseImage.height;
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw Base
        ctx.drawImage(state.baseImage, 0, 0);

        ctx.save();
        ctx.globalAlpha = state.opacity / 100;

        if (state.tiled) {
            drawTiled();
        } else {
            drawSingle();
        }

        ctx.restore();
    }

    function drawSingle() {
        const { x, y, width, height } = calculateWatermarkMetrics();

        // Translate to center of watermark for rotation
        const cx = x + width / 2;
        const cy = y + height / 2;

        ctx.translate(cx, cy);
        ctx.rotate((state.rotation * Math.PI) / 180);
        ctx.translate(-cx, -cy);

        renderWatermarkAt(x, y, width, height);
    }

    function drawTiled() {
        const { width, height } = calculateWatermarkMetrics();

        // Staggered pattern logic (brick layout)
        const cols = 5; // Fixed relative density
        const rows = 5;

        // Calculate gap based on canvas size div by density
        const gapX = canvas.width / 3;
        const gapY = canvas.height / 3;

        // Render slightly outside bounds to ensure coverage during rotation
        const startX = -canvas.width * 0.5;
        const startY = -canvas.height * 0.5;
        const endX = canvas.width * 1.5;
        const endY = canvas.height * 1.5;

        let rowCount = 0;

        for (let py = startY; py < endY; py += height * 2 + 100) { // vertical spacing
            rowCount++;
            let offsetX = (rowCount % 2 === 0) ? (width + 50) : 0; // Stagger every other row

            for (let px = startX; px < endX; px += width * 2 + 50) { // horizontal spacing
                ctx.save();

                // Center of the watermark
                const cx = px + offsetX + width / 2;
                const cy = py + height / 2;

                ctx.translate(cx, cy);
                ctx.rotate((state.rotation * Math.PI) / 180); // Individual rotation

                // Draw centered
                if (state.watermarkType === 'text') {
                    ctx.font = `bold ${height}px ${state.font}`;
                    ctx.fillStyle = state.color;
                    ctx.textBaseline = 'middle';
                    ctx.textAlign = 'center';
                    ctx.shadowColor = "rgba(0,0,0,0.5)";
                    ctx.shadowBlur = 4;
                    ctx.fillText(state.text, 0, 0);

                    // Stroke for better visibility (optional "sticker" look from example)
                    ctx.strokeStyle = "rgba(255,255,255,0.2)";
                    ctx.lineWidth = 1;
                    ctx.strokeText(state.text, 0, 0);

                } else if (state.watermarkType === 'image' && state.watermarkImage) {
                    ctx.drawImage(state.watermarkImage, -width / 2, -height / 2, width, height);
                }

                ctx.restore();
            }
        }
    }

    function renderWatermarkAt(x, y, w, h) {
        if (state.watermarkType === 'text') {
            ctx.font = `bold ${h}px ${state.font}`; // h is font size approx
            ctx.fillStyle = state.color;
            ctx.textBaseline = 'top';
            // Shadow for better visibility
            ctx.shadowColor = "rgba(0,0,0,0.5)";
            ctx.shadowBlur = 4;
            ctx.fillText(state.text, x, y);
        } else if (state.watermarkType === 'image' && state.watermarkImage) {
            ctx.drawImage(state.watermarkImage, x, y, w, h);
        }
    }

    function calculateWatermarkMetrics() {
        let width, height;

        if (state.watermarkType === 'text') {
            // Text Metrics
            // Base font size is relative to canvas width for consistency? 
            // Or just raw pixels? Raw pixels can be tiny on huge images.
            // Let's make size relative to image width. 50 = 5% of width?
            const baseFontSize = (canvas.width * 0.05); // 5% baseline
            const scale = state.size / 50; // 1.0 at 50
            const finalSize = baseFontSize * scale;

            ctx.font = `bold ${finalSize}px ${state.font}`;
            const m = ctx.measureText(state.text);
            width = m.width;
            height = finalSize; // approximate
        } else {
            // Image Metrics
            if (state.watermarkImage) {
                const aspect = state.watermarkImage.width / state.watermarkImage.height;
                // Base size: 20% of canvas width
                const baseW = canvas.width * 0.20;
                const scale = state.size / 50;
                width = baseW * scale;
                height = width / aspect;
            } else {
                width = 0; height = 0;
            }
        }

        // Calculate Position (only if not tiled)
        let x = 0, y = 0;
        const p = state.pos;
        const padding = canvas.width * 0.03; // 3% padding

        if (p.includes('l')) x = padding;
        if (p.includes('c') && !p.startsWith('c')) x = (canvas.width - width) / 2; // Horizontal center
        if (p.includes('r')) x = canvas.width - width - padding;

        if (p.startsWith('t')) y = padding;
        if (p.startsWith('c')) y = (canvas.height - height) / 2; // Vertical center
        if (p.startsWith('b')) y = canvas.height - height - padding;

        return { x, y, width, height };
    }

    window.downloadImage = function () {
        canvas.toBlob((blob) => {
            snipToolsDownload(blob, 'watermarked-export.png');
        }, 'image/png');
        if (typeof showToast === 'function') showToast("Image exported successfully");
    }

</script>