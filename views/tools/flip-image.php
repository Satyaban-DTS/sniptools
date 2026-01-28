<?php
// web/views/tools/flip-image.php
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
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Flip Controls</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="flip('horizontal')"
                            class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-black flex flex-col items-center justify-center gap-2">
                            <i class="fas fa-arrows-alt-h text-xl"></i> Flip Horizontal
                        </button>
                        <button onclick="flip('vertical')"
                            class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-black flex flex-col items-center justify-center gap-2">
                            <i class="fas fa-arrows-alt-v text-xl"></i> Flip Vertical
                        </button>
                        <button onclick="reset()"
                            class="col-span-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:text-red-500 transition-colors text-sm font-medium">
                            <i class="fas fa-sync mr-2"></i> Reset Original
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Export Format</h4>
                    <select id="format"
                        class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border-none text-sm font-bold focus:ring-2 focus:ring-primary/20">
                        <option value="image/png">PNG</option>
                        <option value="image/jpeg">JPG</option>
                        <option value="image/webp">WEBP</option>
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
    let currentScaleX = 1;
    let currentScaleY = 1;

    document.getElementById('imageInput').addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                originalImage.onload = function () {
                    reset();
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('editorArea').classList.remove('hidden');
                }
                originalImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function draw() {
        canvas.width = originalImage.width;
        canvas.height = originalImage.height;

        ctx.save();
        ctx.translate(canvas.width / 2, canvas.height / 2);
        ctx.scale(currentScaleX, currentScaleY);
        ctx.drawImage(originalImage, -originalImage.width / 2, -originalImage.height / 2);
        ctx.restore();
    }

    function flip(direction) {
        if (direction === 'horizontal') {
            currentScaleX *= -1;
        } else {
            currentScaleY *= -1;
        }
        draw();
    }

    function reset() {
        currentScaleX = 1;
        currentScaleY = 1;
        draw();
    }

    function downloadImage() {
        const format = document.getElementById('format').value;
        const link = document.createElement('a');
        link.download = 'flipped-image.' + format.split('/')[1];
        link.href = canvas.toDataURL(format);
        link.click();
    }
</script>