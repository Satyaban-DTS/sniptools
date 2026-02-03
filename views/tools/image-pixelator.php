<?php
// views/tools/image-pixelator.php
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

    <!-- Editor Area -->
    <div id="editorArea" class="hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Canvas -->
            <div class="lg:col-span-2 bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-hidden flex items-center justify-center border border-gray-200 dark:border-gray-700 p-4"
                style="min-height: 400px;">
                <canvas id="canvas" class="max-w-full h-auto shadow-lg"></canvas>
            </div>

            <!-- Controls -->
            <div class="space-y-6 min-h-[400px]">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm space-y-6">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pixel Size</h4>
                            <span id="pixelVal" class="text-xs font-bold text-primary">10px</span>
                        </div>
                        <input type="range" id="pixelRange" min="1" max="100" value="10" class="w-full accent-primary"
                            oninput="pixelate()">
                        <p class="text-[10px] text-gray-400 mt-2">Higher value = larger blocks (more privacy).</p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Export Format</h4>
                    <select id="format"
                        class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border-none text-sm font-bold focus:ring-2 focus:ring-primary/20">
                        <option value="image/png">PNG</option>
                        <option value="image/jpeg">JPG</option>
                    </select>
                </div>

                <button onclick="downloadImage()"
                    class="w-full py-4 bg-primary text-white rounded-xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    <i class="fas fa-download mr-2"></i> Download Image
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let originalImage = new Image();

    document.getElementById('imageInput').addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                originalImage.onload = function () {
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('editorArea').classList.remove('hidden');
                    pixelate();
                }
                originalImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function pixelate() {
        const size = parseInt(document.getElementById('pixelRange').value) / 100; // 0.01 to 1.0 logic? No.
        // Better logic: Downsample by factor, then upsample.
        // Factor = 1 / blockSize. 
        // e.g. Block size 10 -> Factor 0.1

        const blockSize = parseInt(document.getElementById('pixelRange').value);
        document.getElementById('pixelVal').innerText = blockSize + 'px Blocks';

        if (blockSize === 1) {
            canvas.width = originalImage.width;
            canvas.height = originalImage.height;
            ctx.drawImage(originalImage, 0, 0);
            return;
        }

        const w = originalImage.width;
        const h = originalImage.height;

        // Disable smoothing for pixel look
        ctx.imageSmoothingEnabled = false;

        // 1. Draw tiny version
        const tinyW = Math.ceil(w / blockSize);
        const tinyH = Math.ceil(h / blockSize);

        // We can draw to offscreen or just same canvas?
        // Let's use same canvas but scale context.
        canvas.width = w;
        canvas.height = h;

        // Memory-efficient: Draw image small to offscreen canvas
        const offCanvas = document.createElement('canvas');
        offCanvas.width = tinyW;
        offCanvas.height = tinyH;
        const offCtx = offCanvas.getContext('2d');
        offCtx.drawImage(originalImage, 0, 0, tinyW, tinyH);

        // Draw offscreen back to main with nearest-neighbor scaling
        ctx.imageSmoothingEnabled = false;
        ctx.mozImageSmoothingEnabled = false;
        ctx.webkitImageSmoothingEnabled = false;
        ctx.drawImage(offCanvas, 0, 0, tinyW, tinyH, 0, 0, w, h);
    }

    function downloadImage() {
        const format = document.getElementById('format').value;
        const ext = format.split('/')[1];
        canvas.toBlob((blob) => {
            snipToolsDownload(blob, `pixelated-image.${ext}`);
        }, format);
    }
</script>