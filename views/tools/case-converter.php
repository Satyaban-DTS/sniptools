<?php
// web/views/tools/case-converter.php
?>
<div class="space-y-6">
    <!-- Input Area -->
    <div class="space-y-2">
        <label for="caseInput" class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Input Text</label>
        <textarea id="caseInput" rows="8" placeholder="Paste your text here..."
            class="w-full p-6 pb-20 rounded-3xl bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 focus:bg-white dark:focus:bg-gray-900 transition-all outline-none text-sm leading-relaxed custom-scrollbar"></textarea>
    </div>

    <!-- Controls -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pb-2">
        <button onclick="convertCase('upper')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">UPPERCASE</button>
        <button onclick="convertCase('lower')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">lowercase</button>
        <button onclick="convertCase('sentence')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">Sentence
            case</button>
        <button onclick="convertCase('title')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">Title
            Case</button>
        <button onclick="convertCase('camel')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">camelCase</button>
        <button onclick="convertCase('pascal')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">PascalCase</button>
        <button onclick="convertCase('snake')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">snake_case</button>
        <button onclick="convertCase('constant')"
            class="py-3 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all uppercase tracking-wider">CONSTANT_CASE</button>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-700">
        <div class="flex items-center space-x-6">
            <div class="text-center">
                <p id="charCount" class="text-lg font-black text-secondary dark:text-white">0</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Chars</p>
            </div>
            <div class="text-center">
                <p id="wordCount" class="text-lg font-black text-secondary dark:text-white">0</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Words</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <button onclick="clearAll()"
                class="px-6 py-3 text-xs font-bold text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest">Clear</button>
            <button id="copyBtn" onclick="copyResult()"
                class="px-8 py-3 bg-primary text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                <i class="fas fa-copy mr-2"></i> Copy
            </button>
        </div>
    </div>
</div>

<script>
    function convertCase(type) {
        const input = document.getElementById('caseInput');
        let text = input.value;

        switch (type) {
            case 'upper': text = text.toUpperCase(); break;
            case 'lower': text = text.toLowerCase(); break;
            case 'sentence':
                text = text.toLowerCase().replace(/(^\s*\w|[\.\!\?]\s*\w)/g, c => c.toUpperCase());
                break;
            case 'title':
                text = text.toLowerCase().split(' ').map(s => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
                break;
            case 'camel':
                text = text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => index === 0 ? word.toLowerCase() : word.toUpperCase()).replace(/\s+/g, '');
                break;
            case 'pascal':
                text = text.replace(/(?:^\w|[A-Z]|\b\w)/g, word => word.toUpperCase()).replace(/\s+/g, '');
                break;
            case 'snake':
                text = text.match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g).map(x => x.toLowerCase()).join('_');
                break;
            case 'constant':
                text = text.match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g).map(x => x.toUpperCase()).join('_');
                break;
        }
        input.value = text;
        updateStats();
    }

    function updateStats() {
        const text = document.getElementById('caseInput').value;
        document.getElementById('charCount').innerText = text.length;
        document.getElementById('wordCount').innerText = text.trim() ? text.trim().split(/\s+/).length : 0;
    }

    function clearAll() {
        document.getElementById('caseInput').value = '';
        updateStats();
    }

    function copyResult() {
        const input = document.getElementById('caseInput');
        const btn = document.getElementById('copyBtn');
        input.select();
        document.execCommand('copy');
        showToast("Copied to clipboard!");

        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-2"></i> Copied!';
        btn.classList.replace('bg-primary', 'bg-green-500');
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.replace('bg-green-500', 'bg-primary');
        }, 2000);
    }

    document.getElementById('caseInput').addEventListener('input', updateStats);
</script>