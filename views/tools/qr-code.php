<?php
// web/views/tools/qr-code.php
?>
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>

<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
        <!-- Input Area (Left) -->
        <div class="lg:col-span-3 space-y-6">
            <div class="space-y-2">
                <label for="qrInput" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Content
                    (URL or Text)</label>
                <textarea id="qrInput" rows="6" placeholder="https://example.com"
                    class="w-full p-6 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm leading-relaxed transition-all custom-scrollbar"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Size (px)</label>
                    <input type="number" id="qrSize" value="256" step="64" min="128" max="1024"
                        class="w-full p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-bold transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Margin</label>
                    <input type="number" id="qrMargin" value="2" min="0" max="10"
                        class="w-full p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-bold transition-all">
                </div>
            </div>

            <div class="pt-4">
                <button onclick="generateQR()"
                    class="w-full py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Generate QR Code
                </button>
            </div>
        </div>

        <!-- Preview Area (Right) -->
        <div class="lg:col-span-2 flex flex-col items-center">
            <div
                class="bg-white p-8 rounded-[2.5rem] shadow-2xl shadow-black/5 dark:shadow-none mb-6 group relative overflow-hidden">
                <canvas id="qrCanvas" class="max-w-full h-auto"></canvas>
                <div id="qrOverlay"
                    class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <p class="text-[10px] font-black text-secondary tracking-widest uppercase">Live Preview</p>
                </div>
            </div>

            <button id="qrDownloadBtn" onclick="downloadQR()"
                class="hidden w-full py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-black/10 hover:scale-105 active:scale-95 transition-all">
                <i class="fas fa-download mr-2"></i> Download PNG
            </button>
        </div>
    </div>
</div>

<script>
    const qrInput = document.getElementById('qrInput');
    const qrCanvas = document.getElementById('qrCanvas');
    const qrDownloadBtn = document.getElementById('qrDownloadBtn');

    function generateQR() {
        const text = qrInput.value.trim() || 'https://sniptools.com';
        const size = parseInt(document.getElementById('qrSize').value) || 256;
        const margin = parseInt(document.getElementById('qrMargin').value) || 2;

        QRCode.toCanvas(qrCanvas, text, {
            width: size,
            margin: margin,
            color: {
                dark: '#1e1b4b',
                light: '#ffffff'
            }
        }, function (error) {
            if (error) console.error(error);
            qrDownloadBtn.classList.remove('hidden');
        });
    }

    function downloadQR() {
        const link = document.createElement('a');
        link.download = 'qrcode.png';
        link.href = qrCanvas.toDataURL();
        link.click();
    }

    // Auto generate on input
    qrInput.addEventListener('input', () => {
        // debounce would be better but for simple text it's fast
        generateQR();
    });

    // Initial
    generateQR();
</script>