<?php
// web/views/tools/image-cropper.php
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"
    integrity="sha512-hvNR0F/e2J7zPPfX0jJe3p8PkBpmpg8vYtY0eqe9rL65XLF6zw81b0egbIH11gJJ8/x95F4ei8e7Q9X8G9r+Ng=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .cropper-container {
        max-height: 500px;
        background-color: #f3f4f6;
    }

    .dark .cropper-container {
        background-color: #1f2937;
    }
</style>

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
                <p class="text-xs text-gray-500">PNG, JPG, JPEG, WEBP (Max 5MB)</p>
            </div>
        </div>
    </div>

    <!-- Editor Area (Hidden initially) -->
    <div id="editorArea" class="hidden space-y-6">
        <!-- Main Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Canvas / Preview -->
            <div class="lg:col-span-2 bg-gray-100 dark:bg-gray-900 rounded-2xl overflow-hidden flex items-center justify-center border border-gray-200 dark:border-gray-700 relative"
                style="min-height: 400px;">
                <img id="image" src="" class="max-w-full" style="display: block; max-height: 500px;">
            </div>

            <!-- Sidebar Controls -->
            <div class="space-y-6">
                <!-- Actions -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Crop Actions</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="cropper.rotate(-90)"
                            class="p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-medium">
                            <i class="fas fa-undo mr-2"></i> Rotate L
                        </button>
                        <button onclick="cropper.rotate(90)"
                            class="p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-medium">
                            <i class="fas fa-redo mr-2"></i> Rotate R
                        </button>
                        <button onclick="cropper.scaleX(-1)"
                            class="p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-medium">
                            <i class="fas fa-arrows-alt-h mr-2"></i> Flip H
                        </button>
                        <button onclick="cropper.scaleY(-1)"
                            class="p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-primary hover:text-white transition-colors text-sm font-medium">
                            <i class="fas fa-arrows-alt-v mr-2"></i> Flip V
                        </button>
                        <button onclick="cropper.reset()"
                            class="col-span-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:text-red-500 transition-colors text-sm font-medium">
                            <i class="fas fa-sync mr-2"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Aspect Ratio -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Aspect Ratio</h4>
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="cropper.setAspectRatio(16/9)"
                            class="px-3 py-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition-colors">16:9</button>
                        <button onclick="cropper.setAspectRatio(4/3)"
                            class="px-3 py-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition-colors">4:3</button>
                        <button onclick="cropper.setAspectRatio(1)"
                            class="px-3 py-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition-colors">1:1</button>
                        <button onclick="cropper.setAspectRatio(2/3)"
                            class="px-3 py-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition-colors">2:3</button>
                        <button onclick="cropper.setAspectRatio(NaN)"
                            class="px-3 py-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition-colors md:col-span-2">Free</button>
                    </div>
                </div>

                <!-- Download -->
                <button onclick="downloadCropped()"
                    class="w-full py-4 bg-primary text-white rounded-xl text-sm font-black uppercase tracking-wider shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    <i class="fas fa-download mr-2"></i> Download Image
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"
    integrity="sha512-9KkIqdfN7ipEW6B6k+Hb20PVt1c5Y5Wp162xE7A7FC2E5v7g5L6Owh+1tA248jKFE5e5E8f740f940z140x15g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    let cropper;
    const imageInput = document.getElementById('imageInput');
    const imageElement = document.getElementById('image');
    const uploadArea = document.getElementById('uploadArea');
    const editorArea = document.getElementById('editorArea');

    imageInput.addEventListener('change', function (e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Determine MIME type from file input to preserve or default
                // For simplified logic, we just load dataURL
                imageElement.src = e.target.result;
                uploadArea.classList.add('hidden');
                editorArea.classList.remove('hidden');

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(imageElement, {
                    viewMode: 1,
                    dragMode: 'move',
                    aspectRatio: NaN,
                    autoCropArea: 0.9,
                    background: false,
                    responsive: true,
                });
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function downloadCropped() {
        if (!cropper) return;

        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            maxWidth: 4096,
            maxHeight: 4096,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'cropped-image.png'; // Default to png
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }, 'image/png');
    }
</script>