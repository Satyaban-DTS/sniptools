<?php
// web/views/tools/yaml-json-converter.php
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-yaml/4.1.0/js-yaml.min.js"></script>

<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Input Panel -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Input (YAML or
                    JSON)</label>
                <button onclick="clearConv()"
                    class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-all">Clear</button>
            </div>
            <textarea id="convInput" rows="15" placeholder="Paste YAML or JSON here..."
                class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-mono leading-relaxed transition-all custom-scrollbar"></textarea>
        </div>

        <!-- Output Panel -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label id="outputLabel" class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Converted
                    Result</label>
                <button onclick="copyConv()" id="convCopyBtn"
                    class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest transition-all">Copy
                    Result</button>
            </div>
            <textarea id="convOutput" rows="15" readonly placeholder="Result will appear here..."
                class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent outline-none text-sm font-mono leading-relaxed transition-all custom-scrollbar text-gray-600 dark:text-gray-300"></textarea>
        </div>
    </div>

    <!-- Conversion Actions -->
    <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
        <button onclick="convert('toJson')"
            class="px-10 py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
            <i class="fas fa-file-code mr-2"></i> Convert to JSON
        </button>
        <button onclick="convert('toYaml')"
            class="px-10 py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-black/10 hover:scale-[1.02] active:scale-95 transition-all">
            <i class="fas fa-file-lines mr-2"></i> Convert to YAML
        </button>
    </div>
</div>

<script>
    function convert(action) {
        const input = document.getElementById('convInput').value.trim();
        if (!input) return;

        try {
            let parsed;
            // Try to parse as JSON first, if failing, try YAML
            try {
                parsed = JSON.parse(input);
            } catch (e) {
                parsed = jsyaml.load(input);
            }

            if (parsed === null || typeof parsed !== 'object') {
                throw new Error('Invalid YAML or JSON input.');
            }

            let result = '';
            if (action === 'toJson') {
                result = JSON.stringify(parsed, null, 2);
                document.getElementById('outputLabel').innerText = 'JSON RESULT';
            } else {
                result = jsyaml.dump(parsed);
                document.getElementById('outputLabel').innerText = 'YAML RESULT';
            }

            document.getElementById('convOutput').value = result;
        } catch (e) {
            document.getElementById('convOutput').value = 'Error: ' + e.message;
        }
    }

    function clearConv() {
        document.getElementById('convInput').value = '';
        document.getElementById('convOutput').value = '';
        document.getElementById('outputLabel').innerText = 'CONVERTED RESULT';
    }

    function copyConv() {
        const output = document.getElementById('convOutput');
        if (!output.value || output.value.startsWith('Error:')) return;

        output.select();
        document.execCommand('copy');

        const btn = document.getElementById('convCopyBtn');
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        setTimeout(() => btn.innerText = original, 2000);
    }
</script>