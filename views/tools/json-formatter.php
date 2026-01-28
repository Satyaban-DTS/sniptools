<?php
// web/views/tools/json-formatter.php
?>
<div class="space-y-6">
    <!-- Editor Container -->
    <div class="relative group">
        <div class="flex items-center justify-between mb-4 px-1">
            <label for="jsonInput" class="text-xs font-bold text-gray-400 uppercase tracking-widest">JSON Input /
                Output</label>
            <div id="jsonBadge"
                class="hidden text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full">Valid</div>
        </div>

        <div
            class="relative rounded-[2rem] overflow-hidden border-2 border-transparent focus-within:border-primary/20 transition-all shadow-inner bg-gray-900">
            <!-- Line Numbers (Simulated) -->
            <div
                class="absolute inset-y-0 left-0 w-12 bg-gray-800/50 text-gray-600 text-[10px] font-mono py-6 text-right pr-3 select-none">
                1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br>10<br>11<br>12<br>13<br>14<br>15
            </div>
            <textarea id="jsonInput" rows="15" placeholder='{"key": "value"}'
                class="w-full pl-16 pr-6 py-6 bg-transparent text-primary-100 font-mono text-xs leading-relaxed outline-none custom-scrollbar text-green-400"></textarea>
        </div>
    </div>

    <!-- Controls -->
    <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
        <div class="flex items-center space-x-3">
            <button onclick="formatJson(2)"
                class="px-6 py-3 bg-primary text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                Beautify (2 Spaces)
            </button>
            <button onclick="formatJson(4)"
                class="px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                Beautify (4 Spaces)
            </button>
            <button onclick="minifyJson()"
                class="px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                Minify
            </button>
        </div>

        <div class="flex items-center space-x-3">
            <button onclick="clearJson()" class="p-3 text-gray-300 hover:text-red-500 transition-colors">
                <i class="fas fa-trash-can"></i>
            </button>
            <button onclick="copyJson()" id="jsonCopyBtn"
                class="px-8 py-3 bg-secondary text-white dark:bg-white dark:text-secondary rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-black/10 hover:scale-105 active:scale-95 transition-all">
                <i class="fas fa-copy mr-2"></i> Copy Result
            </button>
        </div>
    </div>
</div>

<script>
    const jsonInput = document.getElementById('jsonInput');
    const jsonBadge = document.getElementById('jsonBadge');

    function validate() {
        const val = jsonInput.value;
        if (!val.trim()) {
            jsonBadge.classList.add('hidden');
            return true;
        }

        try {
            JSON.parse(val);
            jsonBadge.innerText = 'Valid JSON';
            jsonBadge.className = 'block text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full bg-green-500/10 text-green-500';
            return true;
        } catch (e) {
            jsonBadge.innerText = 'Invalid JSON';
            jsonBadge.className = 'block text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full bg-red-500/10 text-red-500';
            return false;
        }
    }

    function formatJson(spaces) {
        if (!validate()) {
            showToast("Invalid JSON structure", "error");
            return;
        }
        const val = jsonInput.value;
        if (!val.trim()) return;
        jsonInput.value = JSON.stringify(JSON.parse(val), null, spaces);
        showToast("JSON Beautified!");
    }

    function minifyJson() {
        if (!validate()) {
            showToast("Invalid JSON structure", "error");
            return;
        }
        const val = jsonInput.value;
        if (!val.trim()) return;
        jsonInput.value = JSON.stringify(JSON.parse(val));
        showToast("JSON Minified!");
    }

    function clearJson() {
        jsonInput.value = '';
        validate();
    }

    function copyJson() {
        if (!jsonInput.value.trim()) return;
        jsonInput.select();
        document.execCommand('copy');
        showToast("Copied to clipboard!");

        const btn = document.getElementById('jsonCopyBtn');
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-2"></i> Copied!';
        setTimeout(() => btn.innerHTML = original, 2000);
    }

    jsonInput.addEventListener('input', validate);
</script>