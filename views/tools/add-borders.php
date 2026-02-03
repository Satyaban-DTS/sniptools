<?php
// web/views/tools/add-borders.php
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
            <!-- Canvas Preview -->
            <div class="lg:col-span-2 bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-hidden flex items-center justify-center border border-gray-200 dark:border-gray-700 p-4"
                style="min-height: 400px;">
                <canvas id="canvas" class="max-w-full h-auto shadow-2xl"></canvas>
            </div>

            <!-- Controls -->
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm space-y-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Border Color</h4>
                        <input type="color" id="borderColor" value="#ffffff"
                            class="w-full h-12 rounded-xl cursor-pointer" onchange="draw()">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Border Thickness</h4>
                            <span id="thicknessVal" class="text-xs font-bold text-primary">20px</span>
                        </div>
                        <input type="range" id="borderThickness" min="0" max="200" value="20"
                            class="w-full accent-primary" oninput="updateThickness(this.value)">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Border Radius</h4>
                            <span id="radiusVal" class="text-xs font-bold text-primary">0px</span>
                        </div>
                        <input type="range" id="borderRadius" min="0" max="100" value="0" class="w-full accent-primary"
                            oninput="updateRadius(this.value)">
                        <p class="text-[10px] text-gray-400 mt-2">Note: Radius clips the image corners.</p>
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
                    draw();
                }
                originalImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function updateThickness(val) {
        document.getElementById('thicknessVal').innerText = val + 'px';
        draw();
    }

    function updateRadius(val) {
        document.getElementById('radiusVal').innerText = val + 'px';
        draw();
    }

    function draw() {
        let thickness = parseInt(document.getElementById('borderThickness').value);
        let color = document.getElementById('borderColor').value;
        let radius = parseInt(document.getElementById('borderRadius').value);

        // Canvas size = Image Size + Border * 2
        canvas.width = originalImage.width + (thickness * 2);
        canvas.height = originalImage.height + (thickness * 2);

        // Fill background (Border Color)
        ctx.fillStyle = color;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Draw Image Centered
        // Handle Radius? Complex in canvas for specific valid "border radius on image" vs "border radius on frame"
        // Let's assume user wants the image to be clipped inside the border.
        // OR user wants the border outside. Simple "Border around image" usually implies rectangular.

        ctx.save();

        // If we want to support rounded corners on the image itself:
        if (radius > 0) {
            roundedRect(ctx, thickness, thickness, originalImage.width, originalImage.height, radius);
            ctx.clip();
        }

        ctx.drawImage(originalImage, thickness, thickness);
        ctx.restore();
    }

    // Helper function for rounded rectangles
    function roundedRect(ctx, x, y, width, height, radius) {
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
    }

    function downloadImage() {
        const format = document.getElementById('format').value;
        const ext = format.split('/')[1];
        canvas.toBlob((blob) => {
            snipToolsDownload(blob, `bordered-image.${ext}`);
        }, format);
    }
</script>