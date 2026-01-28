<?php
// views/tools/split-image.php
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

    <!-- Process Area -->
    <div id="editorArea" class="hidden space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-4 flex items-center justify-center min-h-[200px]">
                    <img id="preview" class="max-h-64 shadow-md rounded-lg">
                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Split Settings</h4>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 mb-1 block">Rows (Horizontal)</label>
                            <input type="number" id="rows" value="1" min="1" max="10"
                                class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 font-bold">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500 mb-1 block">Columns (Vertical)</label>
                            <input type="number" id="cols" value="1" min="1" max="10"
                                class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 font-bold">
                        </div>
                    </div>

                    <button onclick="processSplit()"
                        class="w-full py-4 bg-primary text-white rounded-xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <i class="fas fa-scissors mr-2"></i> Split Image
                    </button>
                </div>
            </div>

            <!-- Results -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Results</h4>
                <div id="resultsGrid" class="grid gap-4 bg-gray-100 dark:bg-gray-900 p-4 rounded-2xl min-h-[200px]">
                    <p class="text-sm text-gray-400 col-span-full text-center py-10">Splitted pieces will appear here.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    const resultsGrid = document.getElementById('resultsGrid');
    let originalImage = new Image();

    imageInput.addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                originalImage.onload = function () {
                    preview.src = originalImage.src;
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('editorArea').classList.remove('hidden');
                }
                originalImage.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function processSplit() {
        const rows = parseInt(document.getElementById('rows').value);
        const cols = parseInt(document.getElementById('cols').value);

        resultsGrid.innerHTML = '';
        resultsGrid.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;

        const pieceW = originalImage.width / cols;
        const pieceH = originalImage.height / rows;

        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < cols; c++) {
                const canvas = document.createElement('canvas');
                canvas.width = pieceW;
                canvas.height = pieceH;
                const ctx = canvas.getContext('2d');

                ctx.drawImage(originalImage, c * pieceW, r * pieceH, pieceW, pieceH, 0, 0, pieceW, pieceH);

                // Create container element
                const div = document.createElement('div');
                div.className = 'relative group bg-white p-2 rounded-xl shadow-sm hover:shadow-lg transition-all';

                const img = new Image();
                img.src = canvas.toDataURL('image/png');
                img.className = 'w-full h-auto rounded';

                const btn = document.createElement('a');
                btn.href = img.src;
                btn.download = `split_${r}_${c}.png`;
                btn.className = 'absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl';
                btn.innerHTML = '<i class="fas fa-download text-white"></i>';

                div.appendChild(img);
                div.appendChild(btn);
                resultsGrid.appendChild(div);
            }
        }
    }
</script>