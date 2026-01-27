<?php
// web/views/tools/image-compressor.php
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Configuration Panel -->
    <div class="lg:col-span-4 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
            <h3 class="text-sm font-black text-secondary dark:text-white uppercase tracking-widest mb-6">Compression
                Settings</h3>

            <div class="space-y-6">
                <!-- Quality -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Quality</label>
                    <input type="range" id="quality" min="0.1" max="1.0" step="0.1" value="0.8"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                    <div class="flex justify-between text-[10px] text-gray-400 font-bold mt-1">
                        <span>Low (10%)</span>
                        <span class="text-primary" id="qualityVal">80%</span>
                        <span>High (100%)</span>
                    </div>
                </div>

                <!-- Format -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Output
                        Format</label>
                    <div class="grid grid-cols-2 gap-4">
                        <button onclick="setFormat('image/jpeg')" class="fmt-btn active"
                            data-fmt="image/jpeg">JPEG</button>
                        <button onclick="setFormat('image/webp')" class="fmt-btn" data-fmt="image/webp">WebP</button>
                    </div>
                </div>

                <!-- Max Width -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Max Width
                        (px)</label>
                    <input type="number" id="maxWidth" placeholder="Original"
                        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                    <p class="text-[10px] text-gray-400 mt-1 font-medium">Leave empty to keep original dimensions.</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/10 rounded-2xl p-6 border border-blue-100 dark:border-blue-900/30">
            <h3 class="text-sm font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-2">Browser-Only
            </h3>
            <p class="text-xs text-blue-800 dark:text-blue-300 font-medium leading-relaxed">
                Compression happens 100% in your browser. Large files might make your browser tab lag slightly during
                processing.
            </p>
        </div>
    </div>

    <!-- Preview & Action Panel -->
    <div class="lg:col-span-8 flex flex-col space-y-6">
        <!-- Upload Area -->
        <div id="dropZone"
            class="group relative w-full h-48 rounded-[2.5rem] border-4 border-dashed border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-primary/5 transition-all text-center p-6 overflow-hidden">

            <input type="file" id="fileInput" accept="image/png, image/jpeg, image/webp"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

            <div id="uploadPrompt" class="transition-all duration-300 pointer-events-none">
                <i class="fas fa-image text-3xl text-gray-300 mb-3 group-hover:text-primary transition-colors"></i>
                <h3 class="text-base font-black text-secondary dark:text-white">Click or Drop Image</h3>
            </div>
        </div>

        <!-- Comparison View -->
        <div id="compareView" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Original -->
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-4 px-2">
                    <span class="text-xs font-black text-gray-400 uppercase tracking-wider">Original</span>
                    <span id="originalSize" class="text-xs font-bold text-secondary dark:text-white">0 KB</span>
                </div>
                <div
                    class="aspect-square rounded-2xl bg-gray-100 dark:bg-gray-900 overflow-hidden flex items-center justify-center relative">
                    <img id="originalImg" class="max-w-full max-h-full object-contain" />
                </div>
            </div>

            <!-- Compressed -->
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-4 shadow-lg ring-2 ring-primary/20 border border-primary/10 relative">
                <div
                    class="absolute -top-3 -right-3 bg-green-500 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-lg">
                    SAVED <span id="savingParams">0%</span>
                </div>

                <div class="flex justify-between items-center mb-4 px-2">
                    <span class="text-xs font-black text-primary uppercase tracking-wider">Compressed</span>
                    <span id="compressedSize" class="text-xs font-bold text-primary">0 KB</span>
                </div>
                <div
                    class="aspect-square rounded-2xl bg-gray-100 dark:bg-gray-900 overflow-hidden flex items-center justify-center relative">
                    <div id="loader"
                        class="absolute inset-0 bg-white/50 dark:bg-black/50 backdrop-blur-sm z-10 flex items-center justify-center hidden">
                        <i class="fas fa-circle-notch fa-spin text-2xl text-primary"></i>
                    </div>
                    <img id="compressedImg" class="max-w-full max-h-full object-contain" />
                </div>

                <a id="downloadBtn" href="#" download="compressed-image.jpg"
                    class="mt-4 w-full py-3 bg-primary text-white font-bold rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all text-sm">
                    <i class="fas fa-download mr-2"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .fmt-btn {
        @apply py-3 text-xs font-bold rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 transition-all hover:bg-gray-50 dark:hover:bg-gray-700;
    }

    .fmt-btn.active {
        @apply bg-primary text-white border-primary shadow-md shadow-primary/20;
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
            downloadBtn.href = dataUrl;
            const ext = currentFormat === 'image/jpeg' ? 'jpg' : 'webp';
            downloadBtn.download = `compressed-image.${ext}`;

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