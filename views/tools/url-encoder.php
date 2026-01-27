<?php
// web/views/tools/url-encoder.php
?>
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Input -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="urlInput" class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Input
                    Text</label>
                <div class="flex space-x-4">
                    <button onclick="clearAll()"
                        class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-all">Clear</button>
                </div>
            </div>
            <textarea id="urlInput" rows="10" placeholder="Paste URL or text here..."
                class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm leading-relaxed transition-all custom-scrollbar"></textarea>
        </div>

        <!-- Output -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="urlOutput"
                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Result</label>
                <button onclick="copyOutput()" id="copyBtn"
                    class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest transition-all">Copy
                    Result</button>
            </div>
            <textarea id="urlOutput" rows="10" readonly placeholder="Result will appear here..."
                class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent outline-none text-sm leading-relaxed transition-all custom-scrollbar text-gray-600 dark:text-gray-300"></textarea>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
        <button onclick="processURL('encode')"
            class="px-10 py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
            <i class="fas fa-lock mr-2"></i> Encode URL
        </button>
        <button onclick="processURL('decode')"
            class="px-10 py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-black/10 hover:scale-[1.02] active:scale-95 transition-all">
            <i class="fas fa-lock-open mr-2"></i> Decode URL
        </button>
    </div>
</div>

<script>
    function processURL(action) {
        const input = document.getElementById('urlInput').value.trim();
        if (!input) return;

        let result = '';
        try {
            if (action === 'encode') {
                result = encodeURIComponent(input);
            } else {
                result = decodeURIComponent(input);
            }
            document.getElementById('urlOutput').value = result;
        } catch (e) {
            document.getElementById('urlOutput').value = 'Error: Invalid input for ' + action + 'ing.';
        }
    }

    function clearAll() {
        document.getElementById('urlInput').value = '';
        document.getElementById('urlOutput').value = '';
    }

    function copyOutput() {
        const output = document.getElementById('urlOutput');
        if (!output.value) return;

        output.select();
        document.execCommand('copy');

        const btn = document.getElementById('copyBtn');
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        setTimeout(() => btn.innerText = original, 2000);
    }

    // Optional: Process on input if it's small? 
    // For URLs usually manual trigger is better to avoid halfway errors
</script>