<?php
// web/views/tools/image-compressor.php
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
    <!-- Configuration Panel -->
    <div class="lg:col-span-4 space-y-8">
        <div
            class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/20 dark:border-gray-700/50 shadow-2xl overflow-hidden relative group">
            <div
                class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors">
            </div>

            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8 flex items-center">
                <i class="fas fa-sliders-h mr-3 text-primary"></i>
                Processing Parameters
            </h3>

            <div class="space-y-8">
                <!-- Quality -->
                <div class="relative">
                    <div class="flex justify-between items-center mb-4">
                        <label
                            class="text-[11px] font-black text-secondary dark:text-gray-300 uppercase tracking-widest">Target
                            Quality</label>
                        <span class="px-3 py-1 bg-primary/10 text-primary text-[11px] font-black rounded-lg"
                            id="qualityVal">80%</span>
                    </div>
                    <input type="range" id="quality" min="0.1" max="1.0" step="0.1" value="0.8"
                        class="w-full h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full appearance-none cursor-pointer accent-primary transition-all hover:h-2">
                    <div
                        class="flex justify-between text-[9px] text-gray-400 font-black uppercase mt-3 tracking-widest opacity-60">
                        <span>Speed Optimized</span>
                        <span>Size Optimized</span>
                    </div>
                </div>

                <!-- Format selection -->
                <div>
                    <label
                        class="block text-[11px] font-black text-secondary dark:text-gray-300 uppercase tracking-widest mb-4">Output
                        Format</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="setFormat('image/jpeg')" class="luxury-fmt-btn active" data-fmt="image/jpeg">
                            <i class="fas fa-file-image mr-2 opacity-50"></i>JPEG
                        </button>
                        <button onclick="setFormat('image/webp')" class="luxury-fmt-btn" data-fmt="image/webp">
                            <i class="fas fa-wind mr-2 opacity-50"></i>WebP
                        </button>
                    </div>
                </div>

                <!-- Dimension Overrides -->
                <div class="space-y-3">
                    <label
                        class="block text-[11px] font-black text-secondary dark:text-gray-300 uppercase tracking-widest">Dimension
                        Override</label>
                    <div class="relative">
                        <input type="number" id="maxWidth" placeholder="Maintain Original Aspect"
                            class="w-full bg-gray-50/50 dark:bg-gray-900/50 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-4 px-6 text-sm font-bold focus:border-primary outline-none transition-all shadow-inner placeholder:text-gray-400">
                        <span
                            class="absolute right-5 top-1/2 -translate-y-1/2 text-[9px] font-black text-gray-300 uppercase tracking-widest pointer-events-none">PX</span>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-primary/5 to-accent/5 rounded-[2rem] p-6 border border-primary/10 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-shield-halved text-4xl text-primary"></i>
            </div>
            <h3 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-2 flex items-center">
                <i class="fas fa-lock-open mr-2"></i>
                Zero Server Exposure
            </h3>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 font-bold leading-relaxed">
                Binary processing occurs strictly within the <span class="text-primary italic">client-side
                    sandbox</span>. No assets are transmitted across the network.
            </p>
        </div>
    </div>

    <!-- Preview & Action Panel -->
    <div class="lg:col-span-8 flex flex-col space-y-8">
        <!-- Luxury Upload Area -->
        <div id="dropZone"
            class="group relative w-full min-h-[14rem] rounded-[3rem] border-2 border-dashed border-gray-200 dark:border-gray-700 bg-white/30 dark:bg-gray-800/30 backdrop-blur-sm flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-primary/5 transition-all duration-500 overflow-hidden">

            <div
                class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
            </div>

            <input type="file" id="fileInput" accept="image/png, image/jpeg, image/webp"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

            <div id="uploadPrompt" class="text-center z-10 transition-all duration-500 group-hover:scale-110">
                <div
                    class="w-16 h-16 bg-white dark:bg-gray-800 rounded-3xl shadow-xl flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-gray-700 group-hover:shadow-primary/20 group-hover:border-primary/30 transition-all">
                    <i
                        class="fas fa-cloud-arrow-up text-2xl text-gray-300 group-hover:text-primary transition-colors"></i>
                </div>
                <h3 class="text-lg font-black text-secondary dark:text-white uppercase tracking-tighter italic">Import
                    Media Node</h3>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] mt-2 opacity-60">
                    High-Resolution Support (JPG, PNG, WebP)</p>
            </div>
        </div>

        <!-- Luxury Comparison View -->
        <div id="compareView" class="hidden grid grid-cols-1 md:grid-cols-2 gap-8 animate-fade-in">
            <!-- Source Node -->
            <div
                class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl rounded-[2.5rem] p-6 border border-white/20 dark:border-gray-700/50 shadow-2xl relative group overflow-hidden">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Source File</span>
                    </div>
                    <span id="originalSize"
                        class="text-xs font-black text-secondary dark:text-white px-3 py-1 bg-gray-100 dark:bg-gray-900 rounded-lg">0
                        KB</span>
                </div>
                <div
                    class="aspect-square rounded-[2rem] bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-white/5 overflow-hidden flex items-center justify-center relative shadow-inner">
                    <img id="originalImg" class="max-w-full max-h-full object-contain p-4" />
                </div>
            </div>

            <!-- Optimized Node -->
            <div
                class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl rounded-[2.5rem] p-6 border-2 border-primary/20 shadow-[0_0_50px_-12px_rgba(var(--primary-rgb),0.3)] relative group overflow-hidden">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-primary/5 rounded-full blur-3xl"></div>

                <div class="flex justify-between items-center mb-6 relative z-10">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-2 h-2 bg-primary rounded-full animate-pulse shadow-[0_0_10px_rgba(var(--primary-rgb),0.8)]">
                        </div>
                        <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Optimized
                            Output</span>
                    </div>
                    <div class="flex flex-col items-end">
                        <span id="compressedSize"
                            class="text-xs font-black text-primary px-3 py-1 bg-primary/10 rounded-lg">0 KB</span>
                        <div class="inline-flex items-center py-1 mt-1">
                            <span id="savingParams"
                                class="text-[9px] font-black text-emerald-500 uppercase tracking-widest italic">SAVED
                                0%</span>
                        </div>
                    </div>
                </div>

                <div
                    class="aspect-square rounded-[2rem] bg-gray-50 dark:bg-gray-900 border border-primary/10 overflow-hidden flex items-center justify-center relative shadow-inner">
                    <div id="loader"
                        class="absolute inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center hidden">
                        <div class="relative">
                            <div
                                class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin">
                            </div>
                            <div class="absolute inset-x-0 top-14 text-center">
                                <span
                                    class="text-[9px] font-black text-primary uppercase tracking-widest animate-pulse">Encoding</span>
                            </div>
                        </div>
                    </div>
                    <img id="compressedImg" class="max-w-full max-h-full object-contain p-4" />
                </div>

                <a id="downloadBtn" href="#" download="compressed-media.jpg"
                    class="mt-6 w-full py-5 bg-primary text-white font-black rounded-3xl flex items-center justify-center shadow-2xl shadow-primary/30 hover:scale-[1.02] hover:shadow-primary/40 active:scale-95 transition-all text-sm uppercase tracking-widest relative overflow-hidden group/btn">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000">
                    </div>
                    <i class="fas fa-file-export mr-3"></i> Download Asset
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .luxury-fmt-btn {
        @apply py-4 text-[10px] font-black rounded-2xl border-2 border-gray-100 dark:border-gray-700 text-gray-400 transition-all uppercase tracking-widest hover:bg-white dark:hover:bg-gray-800 hover:border-primary/30 hover:text-primary;
    }

    .luxury-fmt-btn.active {
        @apply bg-white dark:bg-gray-800 text-primary border-primary shadow-xl shadow-primary/10;
    }
</style>

<script>
    // Elements
    const fileInput = document.getElementById('fileInput');
    const compareView = document.getElementById('compareView');
    const originalImg = document.getElementById('originalImg');
    const compressedImg = document.getElementById('compressedImg');
    const originalSize = document.getElementById('originalSize');
    const compressedSize = document.getElementById('compressedSize');
    const savingParams = document.getElementById('savingParams');
    const downloadBtn = document.getElementById('downloadBtn');
    const loader = document.getElementById('loader');

    // Controls
    const qualityInput = document.getElementById('quality');
    const qualityVal = document.getElementById('qualityVal');
    const maxWidthInput = document.getElementById('maxWidth');

    // State
    let currentFile = null;
    let currentFormat = 'image/jpeg';

    // Listeners
    fileInput.addEventListener('change', (e) => {
        if (e.target.files && e.target.files[0]) {
            currentFile = e.target.files[0];
            loadFile(currentFile);
        }
    });

    qualityInput.addEventListener('input', (e) => {
        qualityVal.textContent = Math.round(e.target.value * 100) + '%';
        if (currentFile) compressImage();
    });

    maxWidthInput.addEventListener('change', () => {
        if (currentFile) compressImage();
    });

    function setFormat(fmt) {
        currentFormat = fmt;
        document.querySelectorAll('.fmt-btn').forEach(btn => {
            if (btn.dataset.fmt === fmt) btn.classList.add('active');
            else btn.classList.remove('active');
        });
        if (currentFile) compressImage();
    }

    function loadFile(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            originalImg.src = e.target.result;
            originalSize.textContent = formatBytes(file.size);
            compareView.classList.remove('hidden');
            compressImage();
        };
        reader.readAsDataURL(file);
    }

    function compressImage() {
        if (!originalImg.src) return;

        loader.classList.remove('hidden');

        const img = new Image();
        img.src = originalImg.src;

        img.onload = () => {
            const canvas = document.createElement('canvas');
            let width = img.width;
            let height = img.height;

            // Resize if needed
            const maxWidth = parseInt(maxWidthInput.value);
            if (maxWidth && width > maxWidth) {
                height = Math.round(height * (maxWidth / width));
                width = maxWidth;
            }

            canvas.width = width;
            canvas.height = height;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);

            // Compress
            const quality = parseFloat(qualityInput.value);
            const dataUrl = canvas.toDataURL(currentFormat, quality);

            // Update UI
            compressedImg.src = dataUrl;

            // Calculate size
            const head = 'data:' + currentFormat + ';base64,';
            const size = Math.round((dataUrl.length - head.length) * 3 / 4);
            compressedSize.textContent = formatBytes(size);

            // Calculate savings
            const savings = Math.round((1 - (size / currentFile.size)) * 100);
            savingParams.textContent = (savings > 0 ? '-' : '+') + Math.abs(savings) + '%';

            // Update Download Link
            const ext = currentFormat === 'image/jpeg' ? 'jpg' : 'webp';
            downloadBtn.onclick = (e) => {
                e.preventDefault();
                canvas.toBlob((blob) => {
                    snipToolsDownload(blob, `compressed-image.${ext}`);
                }, currentFormat, quality);
            };

            loader.classList.add('hidden');
        };
    }

    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
</script>