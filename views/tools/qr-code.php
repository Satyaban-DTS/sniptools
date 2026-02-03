<!-- Library for advanced styling -->
<script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
    <!-- Configuration Panel (Left) -->
    <div class="lg:col-span-5 space-y-6">
        <div
            class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/20 dark:border-gray-700/50 shadow-2xl relative group overflow-hidden">
            <!-- Background Decors -->
            <div
                class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors">
            </div>

            <div class="space-y-8">
                <!-- 1. Data Content -->
                <div class="space-y-4">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] flex items-center">
                        <i class="fas fa-database mr-2 text-primary"></i> Data Content
                    </h3>
                    <div class="relative group">
                        <textarea id="qrData" rows="3" placeholder="https://sniptools.com"
                            class="w-full p-5 rounded-2xl bg-white dark:bg-gray-900 border-2 border-gray-100 dark:border-gray-700 focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none text-sm font-medium leading-relaxed transition-all resize-none shadow-inner placeholder:text-gray-300 dark:placeholder:text-gray-700"></textarea>
                    </div>
                </div>

                <!-- 2. Shape & Form -->
                <div class="space-y-4">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] flex items-center">
                        <i class="fas fa-shapes mr-2 text-primary"></i> Shape & Form
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Dot
                                Style</label>
                            <select id="dotsStyle"
                                class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-xs font-bold outline-none focus:border-primary">
                                <option value="square">Square</option>
                                <option value="dots">Dots</option>
                                <option value="rounded">Rounded</option>
                                <option value="extra-rounded">Extra Rounded</option>
                                <option value="classy">Classy</option>
                                <option value="classy-rounded">Classy Rounded</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Corner
                                Square</label>
                            <select id="cornerSquareStyle"
                                class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-xs font-bold outline-none focus:border-primary">
                                <option value="square">Square</option>
                                <option value="dot">Dot</option>
                                <option value="extra-rounded">Extra Rounded</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Corner
                                Dot</label>
                            <select id="cornerDotStyle"
                                class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-xs font-bold outline-none focus:border-primary">
                                <option value="square">Square</option>
                                <option value="dot">Dot</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Colors & Branding -->
                <div class="space-y-4">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] flex items-center">
                        <i class="fas fa-palette mr-2 text-primary"></i> Colors & Logo
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Primary
                                Color</label>
                            <div class="flex items-center space-x-2">
                                <input type="color" id="dotsColor" value="#000000"
                                    class="w-10 h-10 rounded-xl cursor-pointer border-none p-0 bg-transparent">
                                <input type="text" id="dotsColorText" value="#000000"
                                    class="w-full p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-[10px] font-mono">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label
                                class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Background</label>
                            <div class="flex items-center space-x-2">
                                <input type="color" id="bgColor" value="#ffffff"
                                    class="w-10 h-10 rounded-xl cursor-pointer border-none p-0 bg-transparent">
                                <input type="text" id="bgColorText" value="#ffffff"
                                    class="w-full p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-[10px] font-mono">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <label class="block w-full cursor-pointer group">
                            <input type="file" id="logoInput" accept="image/*" class="hidden">
                            <div
                                class="w-full p-4 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl group-hover:border-primary/50 group-hover:bg-primary/5 transition-all text-center">
                                <span id="logoFileName"
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest group-hover:text-primary transition-colors">
                                    <i class="fas fa-image mr-2"></i> Upload Central Logo
                                </span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Panel (Right) -->
    <div class="lg:col-span-7 flex flex-col pt-8 lg:pt-0">
        <div class="sticky top-8 space-y-6">
            <div class="relative w-full aspect-square max-w-md mx-auto">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-primary via-accent to-purple-600 rounded-[3rem] blur-3xl opacity-20 transform scale-110 animate-pulse">
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-[3rem] shadow-2xl relative z-10 border border-gray-100 dark:border-gray-700 flex items-center justify-center p-8 lg:p-12 h-full w-full">
                    <div id="qr-container"
                        class="rounded-xl overflow-hidden transition-all duration-300 transform hover:scale-105"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-md mx-auto w-full">
                <div class="relative">
                    <select id="downloadExt"
                        class="w-full p-4 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs font-bold outline-none appearance-none">
                        <option value="png">PNG Format</option>
                        <option value="jpeg">JPEG Format</option>
                        <option value="webp">WEBP Format</option>
                        <option value="svg">SVG Vector</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <button onclick="downloadQR()"
                    class="w-full py-4 bg-gradient-to-r from-primary to-accent text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i> Download Asset
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let qrCode;
    let logoFile = null;

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize QR Code Styling with display dimensions first
        qrCode = new QRCodeStyling({
            width: 300,
            height: 300,
            type: "svg",
            data: "https://sniptools.com",
            image: "",
            dotsOptions: { color: "#000000", type: "square" },
            backgroundOptions: { color: "#ffffff" },
            imageOptions: { crossOrigin: "anonymous", margin: 10 }
        });

        const container = document.getElementById("qr-container");
        qrCode.append(container);

        // Listeners for inputs
        const inputs = ['qrData', 'dotsStyle', 'cornerSquareStyle', 'cornerDotStyle', 'dotsColor', 'bgColor'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', updateQR);
            document.getElementById(id).addEventListener('change', updateQR);
        });

        // Sync color text inputs
        document.getElementById('dotsColor').addEventListener('input', (e) => document.getElementById('dotsColorText').value = e.target.value);
        document.getElementById('bgColor').addEventListener('input', (e) => document.getElementById('bgColorText').value = e.target.value);
        document.getElementById('dotsColorText').addEventListener('input', (e) => {
            document.getElementById('dotsColor').value = e.target.value;
            updateQR();
        });
        document.getElementById('bgColorText').addEventListener('input', (e) => {
            document.getElementById('bgColor').value = e.target.value;
            updateQR();
        });

        // Logo upload
        document.getElementById('logoInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (evt) {
                    logoFile = evt.target.result;
                    document.getElementById('logoFileName').innerHTML = `<i class="fas fa-check text-green-500 mr-2"></i> ${file.name}`;
                    updateQR();
                }
                reader.readAsDataURL(file);
            }
        });

        // Initial Update
        const dataInput = document.getElementById('qrData');
        if (dataInput.value.trim() === "") dataInput.value = "https://sniptools.com";
        updateQR();
    });

    function updateQR() {
        if (!qrCode) return;

        const data = document.getElementById('qrData').value || " ";
        const dotsStyle = document.getElementById('dotsStyle').value;
        const cornerSquareStyle = document.getElementById('cornerSquareStyle').value;
        const cornerDotStyle = document.getElementById('cornerDotStyle').value;
        const dotsColor = document.getElementById('dotsColor').value;
        const bgColor = document.getElementById('bgColor').value;

        // Keep preview size reasonable
        qrCode.update({
            width: 300,
            height: 300,
            data: data,
            image: logoFile,
            dotsOptions: {
                color: dotsColor,
                type: dotsStyle
            },
            backgroundOptions: {
                color: bgColor,
            },
            cornersSquareOptions: {
                type: cornerSquareStyle,
                color: dotsColor
            },
            cornersDotOptions: {
                type: cornerDotStyle,
                color: dotsColor
            }
        });
    }

    async function downloadQR() {
        const ext = document.getElementById('downloadExt').value;
        const data = document.getElementById('qrData').value || "qr-code";
        let name = data.substring(0, 15).replace(/[^a-z0-9]/gi, '_').toLowerCase();

        // Temporarily upgrade resolution for download
        qrCode.update({
            width: 2000,
            height: 2000
        });

        await qrCode.download({ name: `SnipTools - qr_${name}`, extension: ext });

        // Revert to preview size
        qrCode.update({
            width: 300,
            height: 300
        });

        if (typeof showToast === 'function') showToast("Asset downloaded successfully");
    }
</script>