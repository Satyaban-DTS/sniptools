<?php
// views/tools/image-watermark.php
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
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Click to Upload Base Image</h3>
                <p class="text-xs text-gray-500">PNG, JPG, JPEG, WEBP</p>
            </div>
        </div>
    </div>

    <!-- Editor Area -->
    <div id="editorArea" class="hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Canvas -->
            <div class="lg:col-span-2 bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-hidden flex items-center justify-center border border-gray-200 dark:border-gray-700 p-4"
                style="min-height: 400px; max-height: 600px;">
                <canvas id="canvas" class="max-w-full h-auto shadow-lg" style="object-fit: contain;"></canvas>
            </div>

            <!-- Controls -->
            <div class="space-y-6">
                <!-- Text Watermark -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Text Watermark</h4>

                    <input type="text" id="watermarkText" placeholder="Enter text..."
                        class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm font-medium outline-none focus:border-primary"
                        oninput="draw()">

                    <div class="grid grid-cols-2 gap-2">
                        <input type="color" id="textColor" value="#ffffff" class="w-full h-10 rounded-lg cursor-pointer"
                            onchange="draw()">
                        <input type="range" id="fontSize" min="10" max="200" value="48" class="w-full accent-primary"
                            oninput="draw()">
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500">Opacity</span>
                        <input type="range" id="opacity" min="0" max="1" step="0.1" value="0.5"
                            class="w-24 accent-primary" oninput="draw()">
                    </div>
                </div>

                <!-- Position -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Position</h4>
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="pos='tl'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-up rotate-[-45deg]"></i></button>
                        <button onclick="pos='tc'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-up"></i></button>
                        <button onclick="pos='tr'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-up rotate-[45deg]"></i></button>
                        <button onclick="pos='cl'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-left"></i></button>
                        <button onclick="pos='cc'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-crosshairs"></i></button>
                        <button onclick="pos='cr'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-right"></i></button>
                        <button onclick="pos='bl'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-down rotate-[45deg]"></i></button>
                        <button onclick="pos='bc'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-down"></i></button>
                        <button onclick="pos='br'; draw()"
                            class="p-2 bg-gray-100 dark:bg-gray-700 rounded hover:bg-primary hover:text-white"><i
                                class="fas fa-arrow-down rotate-[-45deg]"></i></button>
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
    let pos = 'cc'; // Center-Center default

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

    function draw() {
        canvas.width = originalImage.width;
        canvas.height = originalImage.height;

        ctx.drawImage(originalImage, 0, 0);

        const text = document.getElementById('watermarkText').value;
        if (!text) return;

        const fontSize = document.getElementById('fontSize').value;
        const color = document.getElementById('textColor').value;
        const opacity = document.getElementById('opacity').value;

        ctx.font = `bold ${fontSize}px sans-serif`;
        ctx.fillStyle = color;
        ctx.globalAlpha = opacity;

        const metrics = ctx.measureText(text);
        const textW = metrics.width;
        const textH = parseInt(fontSize); // approx height

        let x = (canvas.width / 2) - (textW / 2);
        let y = (canvas.height / 2) + (textH / 4);

        const padding = 20;

        if (pos === 'tl') { x = padding; y = textH + padding; }
        if (pos === 'tc') { x = (canvas.width / 2) - (textW / 2); y = textH + padding; }
        if (pos === 'tr') { x = canvas.width - textW - padding; y = textH + padding; }

        if (pos === 'cl') { x = padding; y = (canvas.height / 2) + (textH / 4); }
        if (pos === 'cc') { x = (canvas.width / 2) - (textW / 2); y = (canvas.height / 2) + (textH / 4); }
        if (pos === 'cr') { x = canvas.width - textW - padding; y = (canvas.height / 2) + (textH / 4); }

        if (pos === 'bl') { x = padding; y = canvas.height - padding; }
        if (pos === 'bc') { x = (canvas.width / 2) - (textW / 2); y = canvas.height - padding; }
        if (pos === 'br') { x = canvas.width - textW - padding; y = canvas.height - padding; }

        ctx.fillText(text, x, y);
    }

    function downloadImage() {
        const format = document.getElementById('format').value;
        const link = document.createElement('a');
        link.download = 'watermarked-image.' + format.split('/')[1];
        link.href = canvas.toDataURL(format);
        link.click();
    }
</script>