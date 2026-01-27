<?php
// web/views/tools/gradient-generator.php
?>
<div class="space-y-10">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
        <!-- Controls (Left) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="space-y-4">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Gradient Type</label>
                <div class="flex p-1 bg-gray-100 dark:bg-gray-900/50 rounded-2xl">
                    <button onclick="updateType('linear')" id="typeLinear"
                        class="flex-1 py-3 text-xs font-bold rounded-xl transition-all bg-white dark:bg-gray-800 shadow-sm text-primary">Linear</button>
                    <button onclick="updateType('radial')" id="typeRadial"
                        class="flex-1 py-3 text-xs font-bold rounded-xl transition-all text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">Radial</button>
                </div>
            </div>

            <div id="directionControl" class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Angle /
                        Direction</label>
                    <span id="angleValue" class="text-xs font-black text-primary">90°</span>
                </div>
                <input type="range" id="gradientAngle" min="0" max="360" value="90"
                    class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-primary">
                <div class="grid grid-cols-4 gap-2">
                    <button onclick="setAngle(0)"
                        class="py-2 text-[10px] font-bold bg-gray-50 dark:bg-gray-900/30 rounded-lg hover:bg-primary hover:text-white transition-all">To
                        Top</button>
                    <button onclick="setAngle(90)"
                        class="py-2 text-[10px] font-bold bg-gray-50 dark:bg-gray-900/30 rounded-lg hover:bg-primary hover:text-white transition-all">To
                        Right</button>
                    <button onclick="setAngle(180)"
                        class="py-2 text-[10px] font-bold bg-gray-50 dark:bg-gray-900/30 rounded-lg hover:bg-primary hover:text-white transition-all">To
                        Bottom</button>
                    <button onclick="setAngle(270)"
                        class="py-2 text-[10px] font-bold bg-gray-50 dark:bg-gray-900/30 rounded-lg hover:bg-primary hover:text-white transition-all">To
                        Left</button>
                </div>
            </div>

            <div class="space-y-6">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Color Stops</label>
                <div class="space-y-4">
                    <div
                        class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-transparent">
                        <input type="color" id="colorStart" value="#c026d3"
                            class="w-12 h-12 rounded-xl cursor-pointer bg-transparent border-none">
                        <div class="flex-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Start Color
                            </p>
                            <input type="text" id="colorStartHex" value="#c026d3"
                                class="w-full bg-transparent text-xs font-mono font-bold outline-none uppercase">
                        </div>
                    </div>
                    <div
                        class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-transparent">
                        <input type="color" id="colorEnd" value="#2563eb"
                            class="w-12 h-12 rounded-xl cursor-pointer bg-transparent border-none">
                        <div class="flex-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">End Color</p>
                            <input type="text" id="colorEndHex" value="#2563eb"
                                class="w-full bg-transparent text-xs font-mono font-bold outline-none uppercase">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview & Code (Right) -->
        <div class="lg:col-span-3 space-y-8">
            <div id="gradientPreview"
                class="w-full h-80 rounded-[3rem] shadow-2xl transition-all duration-300 relative group overflow-hidden">
                <div
                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/10 backdrop-blur-[2px] transition-all">
                    <p class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Visual Preview</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <!-- CSS Output -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">CSS Output</label>
                        <button onclick="copyCode('css')"
                            class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest">Copy
                            CSS</button>
                    </div>
                    <div class="p-5 bg-gray-900 rounded-3xl border border-white/5 group relative">
                        <code id="cssOutput"
                            class="text-xs font-mono text-green-400 break-all leading-relaxed">background: linear-gradient(90deg, #c026d3, #2563eb);</code>
                    </div>
                </div>

                <!-- Tailwind Output -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tailwind Config
                            (JIT)</label>
                        <button onclick="copyCode('tw')"
                            class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest">Copy
                            Classes</button>
                    </div>
                    <div class="p-5 bg-gray-900 rounded-3xl border border-white/5">
                        <code id="twOutput"
                            class="text-xs font-mono text-blue-300 break-all leading-relaxed">bg-gradient-to-r from-[#c026d3] to-[#2563eb]</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentType = 'linear';
    const preview = document.getElementById('gradientPreview');
    const cssOutput = document.getElementById('cssOutput');
    const twOutput = document.getElementById('twOutput');
    const angleInput = document.getElementById('gradientAngle');
    const angleValue = document.getElementById('angleValue');

    function updateGradient() {
        const startColor = document.getElementById('colorStart').value;
        const endColor = document.getElementById('colorEnd').value;
        const angle = angleInput.value;

        document.getElementById('colorStartHex').value = startColor;
        document.getElementById('colorEndHex').value = endColor;
        angleValue.innerText = angle + '°';

        let css = '';
        let tw = '';

        if (currentType === 'linear') {
            css = `background: linear-gradient(${angle}deg, ${startColor}, ${endColor});`;

            // Simplified Tailwind directions
            let twDir = 'to-r';
            const a = parseInt(angle);
            if (a >= 315 || a < 45) twDir = 'to-t';
            else if (a >= 45 && a < 135) twDir = 'to-r';
            else if (a >= 135 && a < 225) twDir = 'to-b';
            else twDir = 'to-l';

            tw = `bg-gradient-${twDir} from-[${startColor}] to-[${endColor}]`;
        } else {
            css = `background: radial-gradient(circle, ${startColor}, ${endColor});`;
            tw = `bg-[radial-gradient(circle,_var(--tw-gradient-stops))] from-[${startColor}] to-[${endColor}]`;
        }

        preview.style.background = currentType === 'linear'
            ? `linear-gradient(${angle}deg, ${startColor}, ${endColor})`
            : `radial-gradient(circle, ${startColor}, ${endColor})`;

        cssOutput.innerText = css;
        twOutput.innerText = tw;
    }

    function updateType(type) {
        currentType = type;
        const lBtn = document.getElementById('typeLinear');
        const rBtn = document.getElementById('typeRadial');
        const dirCtrl = document.getElementById('directionControl');

        if (type === 'linear') {
            lBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all bg-white dark:bg-gray-800 shadow-sm text-primary";
            rBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all text-gray-400 hover:text-gray-600 dark:hover:text-gray-200";
            dirCtrl.classList.remove('hidden');
        } else {
            rBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all bg-white dark:bg-gray-800 shadow-sm text-primary";
            lBtn.className = "flex-1 py-3 text-xs font-bold rounded-xl transition-all text-gray-400 hover:text-gray-600 dark:hover:text-gray-200";
            dirCtrl.classList.add('hidden');
        }
        updateGradient();
    }

    function setAngle(deg) {
        angleInput.value = deg;
        updateGradient();
    }

    function copyCode(type) {
        const text = type === 'css' ? cssOutput.innerText : twOutput.innerText;
        navigator.clipboard.writeText(text);
        // Visual feedback could be added
    }

    // Event Listeners
    [document.getElementById('colorStart'), document.getElementById('colorEnd'), angleInput].forEach(el => {
        el.addEventListener('input', updateGradient);
    });

    [document.getElementById('colorStartHex'), document.getElementById('colorEndHex')].forEach(el => {
        el.addEventListener('change', (e) => {
            const picker = document.getElementById(el.id.replace('Hex', ''));
            picker.value = e.target.value;
            updateGradient();
        });
    });

    // Initial
    updateGradient();
</script>