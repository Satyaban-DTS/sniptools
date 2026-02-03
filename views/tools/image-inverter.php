<?php
// web/views/tools/image-inverter.php
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Original -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Original</h4>
                <div
                    class="bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 flex items-center justify-center p-4 min-h-[300px]">
                    <img id="originalPreview" class="max-w-full h-auto shadow-md">
                </div>
            </div>

            <!-- Inverted -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-primary uppercase tracking-widest text-center">Inverted Result</h4>
                <div
                    class="bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-hidden border border-primary/20 flex items-center justify-center p-4 min-h-[300px]">
                    <canvas id="canvas" class="max-w-full h-auto shadow-md"></canvas>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div
            class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
            <div class="flex items-center space-x-4">
                <button onclick="document.getElementById('imageInput').click()"
                    class="text-sm font-bold text-gray-500 hover:text-primary transition-colors">
                    <i class="fas fa-upload mr-2"></i> Upload New
                </button>
            </div>
            <button onclick="downloadImage()"
                class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                <i class="fas fa-download mr-2"></i> Download Result
            </button>
        </div>
    </div>
</div>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const originalPreview = document.getElementById('originalPreview');
    let originalImage = new Image();

    document.getElementById('imageInput').addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                originalImage.onload = function () {
                    originalPreview.src = originalImage.src;
                    invert();
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('editorArea').classList.remove('hidden');
                }
                originalImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function invert() {
        // Set canvas to match image
        canvas.width = originalImage.width;
        canvas.height = originalImage.height;

        // Draw image
        ctx.drawImage(originalImage, 0, 0);

        // Get absolute pixel data
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;

        // Invert loop
        for (let i = 0; i < data.length; i += 4) {
            data[i] = 255 - data[i];     // Red
            data[i + 1] = 255 - data[i + 1]; // Green
            data[i + 2] = 255 - data[i + 2]; // Blue
            // data[i+3] is Alpha, keep as is
        }

        // Put back
        ctx.putImageData(imageData, 0, 0);
    }

    function downloadImage() {
        canvas.toBlob((blob) => {
            snipToolsDownload(blob, 'inverted-image.png');
        }, 'image/png');
    }
</script>