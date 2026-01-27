<?php
// web/views/tools/image-to-base64.php
?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Drop Zone -->
    <div class="space-y-6">
        <h2 class="text-xl font-black text-secondary dark:text-white">1. Upload Image</h2>

        <div id="dropZone"
            class="group relative w-full h-80 rounded-[2.5rem] border-4 border-dashed border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-primary/5 transition-all text-center p-8 overflow-hidden">

            <input type="file" id="fileInput" accept="image/*"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

            <div id="uploadPrompt" class="transition-all duration-300">
                <div
                    class="w-20 h-20 bg-white dark:bg-gray-700 rounded-3xl shadow-lg shadow-gray-200/50 dark:shadow-none flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform">
                    <i class="fas fa-cloud-upload-alt text-4xl text-primary"></i>
                </div>
                <h3 class="text-lg font-black text-secondary dark:text-white mb-2">Drop your image here</h3>
                <p class="text-sm text-gray-400 font-medium">Supports PNG, JPG, GIF, WEBP, SVG</p>
                <button
                    class="mt-6 px-6 py-2 bg-primary/10 text-primary rounded-xl text-sm font-bold hover:bg-primary hover:text-white transition-all">
                    Browse Files
                </button>
            </div>

            <div id="loadingState"
                class="hidden absolute inset-0 bg-white/80 dark:bg-gray-800/80 z-10 flex flex-col items-center justify-center">
                <i class="fas fa-circle-notch fa-spin text-4xl text-primary mb-4"></i>
                <p class="font-bold text-gray-500">Processing...</p>
            </div>

            <!-- Image Preview Background -->
            <img id="imagePreviewBg"
                class="hidden absolute inset-0 w-full h-full object-cover opacity-10 blur-xl z-0" />
            <img id="imagePreview"
                class="hidden absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 max-w-[80%] max-h-[80%] object-contain rounded-2xl shadow-2xl z-10 ring-4 ring-white dark:ring-gray-800" />

        </div>

        <div id="fileInfo"
            class="hidden bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-4">
                <div
                    class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-500 flex items-center justify-center">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <p id="fileName" class="text-sm font-bold text-secondary dark:text-white truncate max-w-[200px]">
                        image.png</p>
                    <p id="fileSize" class="text-xs text-gray-400 font-medium">124 KB</p>
                </div>
            </div>
            <button onclick="resetApp()"
                class="text-xs font-black text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-1.5 rounded-lg transition-colors">
                REMOVE
            </button>
        </div>
    </div>

    <!-- Output -->
    <div class="space-y-6">
        <h2 class="text-xl font-black text-secondary dark:text-white">2. Get Base64 String</h2>

        <div
            class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-700 shadow-sm h-80 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Output String</span>
                <span id="charCount" class="text-[10px] font-bold text-gray-300">0 chars</span>
            </div>

            <textarea id="output" readonly
                class="flex-1 w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 text-xs font-mono text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 resize-none custom-scrollbar mb-6"
                placeholder="Base64 string will appear here..."></textarea>

            <div class="grid grid-cols-2 gap-4">
                <button onclick="copyBase64()" id="copyBtn" disabled
                    class="px-6 py-4 bg-gray-100 dark:bg-gray-700 text-gray-400 font-bold rounded-2xl flex items-center justify-center group disabled:opacity-50 disabled:cursor-not-allowed hover:bg-primary hover:text-white transition-all">
                    <i class="fas fa-copy mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Copy to Clipboard</span>
                </button>
                <button onclick="copyImgTag()" id="copyImgBtn" disabled
                    class="px-6 py-4 bg-secondary text-white font-bold rounded-2xl flex items-center justify-center group disabled:opacity-50 disabled:cursor-not-allowed hover:bg-secondary/90 transition-all shadow-lg shadow-secondary/20">
                    <i class="fas fa-code mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Copy &lt;img&gt; Tag</span>
                </button>
            </div>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/10 rounded-2xl p-6 border border-blue-100 dark:border-blue-900/30">
            <h3 class="text-sm font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-2">Privacy Note
            </h3>
            <p class="text-xs text-blue-800 dark:text-blue-300 font-medium leading-relaxed">
                Your images are processed entirely in your browser using the JavaScript FileReader API. No files are
                ever uploaded to our servers.
            </p>
        </div>
    </div>
</div>

<script>
    // Elements
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const output = document.getElementById('output');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewBg = document.getElementById('imagePreviewBg');
    const loadingState = document.getElementById('loadingState');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const copyBtn = document.getElementById('copyBtn');
    const copyImgBtn = document.getElementById('copyImgBtn');
    const charCount = document.getElementById('charCount');

    // Drag Effects
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-primary', 'bg-primary/5');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-primary/5');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-primary/5');
        // Handle file drop handled by input change if overlay covers, 
        // but here input is covering so change event will fire naturally if clickable
        // For drag drop we might need to manually set files if input doesn't capture drop
    });

    // File Input Change
    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) processFile(file);
    });

    function processFile(file) {
        // Reset view
        loadingState.classList.remove('hidden');
        uploadPrompt.classList.add('hidden');

        // Show file info
        fileName.textContent = file.name;
        fileSize.textContent = formatBytes(file.size);
        fileInfo.classList.remove('hidden');

        // Read File
        const reader = new FileReader();

        reader.onload = function (e) {
            const result = e.target.result;

            // Render Preview
            imagePreview.src = result;
            imagePreviewBg.src = result;

            imagePreview.classList.remove('hidden');
            imagePreviewBg.classList.remove('hidden');

            // Output
            output.value = result;
            charCount.textContent = result.length.toLocaleString() + ' chars';

            // Enable buttons
            copyBtn.removeAttribute('disabled');
            copyBtn.classList.remove('text-gray-400', 'bg-gray-100');
            copyBtn.classList.add('bg-white', 'text-secondary', 'border-2', 'border-gray-100');

            copyImgBtn.removeAttribute('disabled');

            loadingState.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    }

    function resetApp() {
        fileInput.value = '';
        output.value = '';
        charCount.textContent = '0 chars';

        uploadPrompt.classList.remove('hidden');
        imagePreview.classList.add('hidden');
        imagePreviewBg.classList.add('hidden');
        fileInfo.classList.add('hidden');

        copyBtn.setAttribute('disabled', 'true');
        copyImgBtn.setAttribute('disabled', 'true');

        // Reset styles for copy btn
        copyBtn.classList.add('text-gray-400', 'bg-gray-100');
        copyBtn.classList.remove('bg-white', 'text-secondary', 'border-2', 'border-gray-100');
    }

    function formatBytes(bytes, decimals = 2) {
        if (!+bytes) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
    }

    function copyBase64() {
        output.select();
        document.execCommand('copy');

        const originalText = copyBtn.lastElementChild.textContent;
        copyBtn.lastElementChild.textContent = 'Copied!';
        setTimeout(() => copyBtn.lastElementChild.textContent = originalText, 2000);
    }

    function copyImgTag() {
        const tag = `<img src="${output.value}" alt="base64 image" />`;
        navigator.clipboard.writeText(tag).then(() => {
            const originalText = copyImgBtn.lastElementChild.textContent;
            copyImgBtn.lastElementChild.textContent = 'Copied Tag!';
            setTimeout(() => copyImgBtn.lastElementChild.textContent = originalText, 2000);
        });
    }
</script>