<?php
// web/views/tools/box-shadow.php
?>
<div class="space-y-10">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
        <!-- Controls (Left) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Type -->
            <div class="space-y-4">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Shadow Type</label>
                <div class="flex p-1 bg-gray-100 dark:bg-gray-900/50 rounded-2xl">
                    <button onclick="updateShadowType(false)" id="typeOutset"
                        class="flex-1 py-3 text-xs font-bold rounded-xl transition-all bg-white dark:bg-gray-800 shadow-sm text-primary">Outset</button>
                    <button onclick="updateShadowType(true)" id="typeInset"
                        class="flex-1 py-3 text-xs font-bold rounded-xl transition-all text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">Inset</button>
                </div>
            </div>

            <!-- Sliders -->
            <div class="space-y-6">
                <div class="space-y-4">
                    <div class="flex justify-between px-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Horizontal
                            Offset</label>
                        <span id="labelX" class="text-xs font-bold text-primary">10px</span>
                    </div>
                    <input type="range" id="shiftX" min="-50" max="50" value="10"
                        class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-primary">
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between px-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Vertical
                            Offset</label>
                        <span id="labelY" class="text-xs font-bold text-primary">10px</span>
                    </div>
                    <input type="range" id="shiftY" min="-50" max="50" value="10"
                        class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-primary">
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between px-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Blur
                            Radius</label>
                        <span id="labelBlur" class="text-xs font-bold text-primary">20px</span>
                    </div>
                    <input type="range" id="blur" min="0" max="100" value="20"
                        class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-primary">
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between px-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Spread
                            Radius</label>
                        <span id="labelSpread" class="text-xs font-bold text-primary">0px</span>
                    </div>
                    <input type="range" id="spread" min="-50" max="50" value="0"
                        class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-primary">
                </div>
            </div>

            <!-- Color -->
            <div class="space-y-4">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Shadow Color</label>
                <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl">
                    <input type="color" id="shadowColor" value="#000000"
                        class="w-12 h-12 rounded-xl cursor-pointer bg-transparent border-none">
                    <div class="flex-1">
                        <input type="range" id="opacity" min="0" max="100" value="20"
                            class="w-full h-1 bg-gray-300 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-primary">
                        <div class="flex justify-between mt-2">
                            <span id="labelOpacity" class="text-[10px] font-bold text-gray-400">Opacity: 20%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview & Code (Right) -->
        <div class="lg:col-span-3 space-y-12">
            <!-- Preview Box -->
            <div
                class="w-full h-80 bg-gray-50 dark:bg-gray-900/20 rounded-[3rem] flex items-center justify-center p-12">
                <div id="shadowTarget"
                    class="w-48 h-48 bg-white dark:bg-gray-800 rounded-[2rem] transition-all duration-200 flex items-center justify-center">
                    <p class="text-[10px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest">Preview
                        Object</p>
                </div>
            </div>

            <!-- Code Output -->
            <div class="space-y-3">
                <div class="flex items-center justify-between px-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">CSS Output</label>
                    <button onclick="copyShadowCode()" id="shadowCopyBtn"
                        class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest">Copy
                        Code</button>
                </div>
                <div class="p-6 bg-gray-900 rounded-[2.5rem] border border-white/5">
                    <code id="shadowCss"
                        class="text-xs font-mono text-green-400 leading-relaxed break-all">box-shadow: 10px 10px 20px 0px rgba(0, 0, 0, 0.2);</code>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let isInset = false;
    const target = document.getElementById('shadowTarget');
    const cssLabel = document.getElementById('shadowCss');
    const inputs = ['shiftX', 'shiftY', 'blur', 'spread', 'shadowColor', 'opacity'];

    function hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    function updateShadow() {
        const x = document.getElementById('shiftX').value;
        const y = document.getElementById('shiftY').value;
        const b = document.getElementById('blur').value;
        const s = document.getElementById('spread').value;
        const color = document.getElementById('shadowColor').value;
        const opacity = document.getElementById('opacity').value / 100;

        document.getElementById('labelX').innerText = x + 'px';
        document.getElementById('labelY').innerText = y + 'px';
        document.getElementById('labelBlur').innerText = b + 'px';
        document.getElementById('labelSpread').innerText = s + 'px';
        document.getElementById('labelOpacity').innerText = 'Opacity: ' + Math.round(opacity * 100) + '%';

        const rgba = hexToRgba(color, opacity);
        const shadowValue = `${isInset ? 'inset ' : ''}${x}px ${y}px ${b}px ${s}px ${rgba}`;

        target.style.boxShadow = shadowValue;
        cssLabel.innerText = `box-shadow: ${shadowValue};`;
    }

    function updateShadowType(inset) {
        isInset = inset;
        const oBtn = document.getElementById('typeOutset');
        const iBtn = document.getElementById('typeInset');

        if (inset) {
            iBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all bg-white dark:bg-gray-800 shadow-sm text-primary";
            oBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all text-gray-400 hover:text-gray-600 dark:hover:text-gray-200";
        } else {
            oBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all bg-white dark:bg-gray-800 shadow-sm text-primary";
            iBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all text-gray-400 hover:text-gray-600 dark:hover:text-gray-200";
        }
        updateShadow();
    }

    function copyShadowCode() {
        navigator.clipboard.writeText(cssLabel.innerText);
        const btn = document.getElementById('shadowCopyBtn');
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        setTimeout(() => btn.innerText = original, 2000);
    }

    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', updateShadow);
    });

    // Initial
    updateShadow();
</script>