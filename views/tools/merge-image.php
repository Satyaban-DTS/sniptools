<?php
// views/tools/merge-image.php
?>
<div class="space-y-6">
    <!-- Upload Area -->
    <div id="uploadArea"
        class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl p-10 text-center hover:border-primary/50 transition-colors cursor-pointer bg-gray-50 dark:bg-gray-800/50"
        onclick="document.getElementById('imageInput').click()">
        <input type="file" id="imageInput" class="hidden" accept="image/*" multiple>
        <div class="space-y-4">
            <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto">
                <i class="fas fa-layer-group text-3xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Select Multiple Images</h3>
                <p class="text-xs text-gray-500">Select images to merge (Vertical or Horizontal)</p>
            </div>
        </div>
    </div>

    <!-- Editor Area -->
    <div id="editorArea" class="hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Canvas Preview -->
            <div class="lg:col-span-2 bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-auto flex items-start justify-center border border-gray-200 dark:border-gray-700 p-4"
                style="min-height: 400px; max-height: 800px;">
                <canvas id="canvas" class="max-w-full h-auto shadow-2xl"></canvas>
            </div>

            <!-- Controls -->
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Merge Direction</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="direction='vertical'; merge()"
                            class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-bold flex flex-col items-center">
                            <i class="fas fa-arrows-down-to-line mb-1"></i> Vertical
                        </button>
                        <button onclick="direction='horizontal'; merge()"
                            class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-bold flex flex-col items-center">
                            <i class="fas fa-arrows-left-right-to-line mb-1"></i> Horizontal
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Export</h4>
                    <button onclick="downloadImage()"
                        class="w-full py-4 bg-primary text-white rounded-xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <i class="fas fa-download mr-2"></i> Download Merged
                    </button>
                    <button onclick="location.reload()"
                        class="w-full mt-3 py-3 text-xs font-bold text-gray-400 hover:text-red-500">Start Over</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let images = [];
    let direction = 'vertical';

    imageInput.addEventListener('change', async function (e) {
        if (this.files && this.files.length > 0) {
            document.getElementById('uploadArea').classList.add('hidden');
            document.getElementById('editorArea').classList.remove('hidden');

            // Load all images
            images = [];
            for (let file of this.files) {
                await loadImage(file);
            }
            merge();
        }
    });

    function loadImage(file) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.onload = function () {
                    images.push(img);
                    resolve();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    function merge() {
        if (images.length === 0) return;

        let totalWidth = 0;
        let totalHeight = 0;

        if (direction === 'vertical') {
            totalWidth = Math.max(...images.map(i => i.width));
            totalHeight = images.reduce((sum, i) => sum + i.height, 0);
        } else {
            totalWidth = images.reduce((sum, i) => sum + i.width, 0);
            totalHeight = Math.max(...images.map(i => i.height));
        }

        canvas.width = totalWidth;
        canvas.height = totalHeight;

        // Fill background white
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, totalWidth, totalHeight);

        let x = 0;
        let y = 0;

        images.forEach(img => {
            if (direction === 'vertical') {
                // Center horizontally if smaller
                let dx = (totalWidth - img.width) / 2;
                ctx.drawImage(img, dx, y);
                y += img.height;
            } else {
                // Center vertically if smaller
                let dy = (totalHeight - img.height) / 2;
                ctx.drawImage(img, x, dy);
                x += img.width;
            }
        });
    }

    function downloadImage() {
        const link = document.createElement('a');
        link.download = 'merged-image.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }
</script>