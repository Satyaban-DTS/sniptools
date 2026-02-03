<?php
// views/tools/image-to-ascii.php
?>
<div class="space-y-6">
    <!-- Upload Area -->
    <div id="uploadArea"
        class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl p-10 text-center hover:border-primary/50 transition-colors cursor-pointer bg-gray-50 dark:bg-gray-800/50"
        onclick="document.getElementById('imageInput').click()">
        <input type="file" id="imageInput" class="hidden" accept="image/*">
        <div class="space-y-4">
            <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto">
                <i class="fas fa-cloud-upload-alt text-3xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Click to Upload Image</h3>
                <p class="text-xs text-gray-500">PNG, JPG, JPEG, WEBP</p>
            </div>
        </div>
    </div>

    <!-- Output Area -->
    <div id="outputArea" class="hidden space-y-6">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Settings -->
            <div class="w-full lg:w-1/3 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Settings</h4>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 mb-1 block">Resolution (Width)</label>
                            <input type="range" id="widthRange" min="20" max="200" value="100"
                                class="w-full accent-primary" oninput="updateAscii()">
                            <span id="widthVal" class="text-xs font-mono">100 chars</span>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-500 mb-1 block">Contrast</label>
                            <input type="range" id="contrastRange" min="0" max="200" value="100"
                                class="w-full accent-primary" oninput="updateAscii()">
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="invertCheck" class="rounded text-primary focus:ring-primary"
                                onchange="updateAscii()">
                            <label for="invertCheck" class="text-sm font-medium">Invert Colors</label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button onclick="copyAscii()"
                        class="w-full py-4 bg-gray-100 dark:bg-gray-700 text-secondary dark:text-white rounded-xl text-sm font-black uppercase tracking-wider hover:bg-gray-200 transition-all">
                        <i class="fas fa-copy mr-2"></i> Copy
                    </button>
                    <button onclick="downloadAscii()"
                        class="w-full py-4 bg-primary text-white rounded-xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <i class="fas fa-download mr-2"></i> Save
                    </button>
                </div>
            </div>

            <!-- Preview -->
            <div class="w-full lg:w-2/3">
                <div class="bg-gray-900 text-white p-4 rounded-2xl overflow-auto custom-scrollbar border border-gray-800"
                    style="max-height: 600px;">
                    <pre id="asciiOutput" class="font-mono text-[8px] leading-[8px] whitespace-pre"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const asciiOutput = document.getElementById('asciiOutput');
    const CHARS = " .:-=+*#%@"; // Simple density string

    let originalImage = new Image();

    imageInput.addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                originalImage.onload = function () {
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('outputArea').classList.remove('hidden');
                    updateAscii();
                }
                originalImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function updateAscii() {
        // Document values
        const width = parseInt(document.getElementById('widthRange').value);
        document.getElementById('widthVal').innerText = width + ' chars';
        const contrast = parseInt(document.getElementById('contrastRange').value);
        const invert = document.getElementById('invertCheck').checked;

        // Create off-screen canvas
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Calculate height based on aspect ratio (multiply by 0.5 because chars are roughly 2:1 height:width)
        const aspectRatio = originalImage.height / originalImage.width;
        const height = Math.floor(width * aspectRatio * 0.5);

        canvas.width = width;
        canvas.height = height;

        ctx.drawImage(originalImage, 0, 0, width, height);

        const imageData = ctx.getImageData(0, 0, width, height);
        const data = imageData.data;

        let asciiStr = "";

        for (let y = 0; y < height; y++) {
            for (let x = 0; x < width; x++) {
                const offset = (y * width + x) * 4;
                const r = data[offset];
                const g = data[offset + 1];
                const b = data[offset + 2];
                // alpha = data[offset + 3];

                // Simple grayscale
                let gray = (r + g + b) / 3;

                // Contrast (basic mult)
                gray = (gray - 128) * (contrast / 100) + 128;
                gray = Math.max(0, Math.min(255, gray));

                if (invert) gray = 255 - gray;

                // Map to CHARS
                const charIndex = Math.floor((gray / 255) * (CHARS.length - 1));
                asciiStr += CHARS[charIndex];
            }
            asciiStr += "\n";
        }

        asciiOutput.innerText = asciiStr;
    }

    function copyAscii() {
        navigator.clipboard.writeText(asciiOutput.innerText).then(() => {
            showToast ? showToast("ASCII Art copied!") : alert('Copied!');
        });
    }

    function downloadAscii() {
        const text = asciiOutput.innerText;
        if (!text) return;
        snipToolsDownload(text, `ascii-art-${Date.now()}.txt`, true);
    }
</script>