<?php
// web/views/tools/word-counter.php
?>
<div class="space-y-8">
    <!-- Input Area -->
    <div class="space-y-2">
        <label for="wordInput" class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Source
            Text</label>
        <textarea id="wordInput" rows="10" placeholder="Type or paste your content here for analysis..."
            class="w-full p-6 pb-20 rounded-3xl bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 focus:bg-white dark:focus:bg-gray-900 transition-all outline-none text-sm leading-relaxed custom-scrollbar"></textarea>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div
            class="bg-gray-50 dark:bg-gray-900/30 p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-all text-center">
            <p id="statWords" class="text-3xl font-black text-secondary dark:text-white mb-1">0</p>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Words</p>
        </div>
        <div
            class="bg-gray-50 dark:bg-gray-900/30 p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-all text-center">
            <p id="statChars" class="text-3xl font-black text-secondary dark:text-white mb-1">0</p>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Characters</p>
        </div>
        <div
            class="bg-gray-50 dark:bg-gray-900/30 p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-all text-center">
            <p id="statSentences" class="text-3xl font-black text-secondary dark:text-white mb-1">0</p>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Sentences</p>
        </div>
        <div
            class="bg-gray-50 dark:bg-gray-900/30 p-6 rounded-3xl border border-transparent hover:border-primary/10 transition-all text-center">
            <p id="statReadingTime" class="text-3xl font-black text-secondary dark:text-white mb-1">0m</p>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Read Time</p>
        </div>
    </div>

    <!-- Extra Analysis (Hidden by default, shown when content exists) -->
    <div id="densitySection" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1 mb-4">Keyword Density</h3>
        <div id="densityList" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <!-- Dynamic items -->
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100 dark:border-gray-700">
        <button onclick="document.getElementById('wordInput').value = ''; updateAll();"
            class="px-6 py-3 text-xs font-bold text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest">Clear</button>
        <button onclick="copyAll()"
            class="px-8 py-3 bg-secondary dark:bg-white dark:text-secondary text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-black/10 hover:scale-105 active:scale-95 transition-all">
            <i class="fas fa-copy mr-2"></i> Copy Text
        </button>
    </div>
</div>

<script>
    const wordInput = document.getElementById('wordInput');

    function updateAll() {
        const text = wordInput.value;
        const words = text.trim() ? text.trim().split(/\s+/).length : 0;
        const chars = text.length;
        const sentences = text.split(/[.!?]+/).filter(Boolean).length;

        // Stats update
        document.getElementById('statWords').innerText = words;
        document.getElementById('statChars').innerText = chars;
        document.getElementById('statSentences').innerText = sentences;

        const readMinutes = Math.ceil(words / 200);
        document.getElementById('statReadingTime').innerText = readMinutes + 'm';

        // Density update
        updateDensity(text);
    }

    function updateDensity(text) {
        const densitySection = document.getElementById('densitySection');
        const densityList = document.getElementById('densityList');

        if (!text.trim()) {
            densitySection.classList.add('hidden');
            return;
        }

        densitySection.classList.remove('hidden');
        const words = text.toLowerCase().match(/\b\w{3,}\b/g) || [];
        const counts = {};
        words.forEach(w => counts[w] = (counts[w] || 0) + 1);

        const sorted = Object.entries(counts).sort((a, b) => b[1] - a[1]).slice(0, 6);

        densityList.innerHTML = sorted.map(([word, count]) => `
        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl border border-transparent">
            <span class="text-xs font-bold truncate mr-2">${word}</span>
            <span class="text-[10px] px-2 py-0.5 bg-primary/10 text-primary rounded-full font-black">${count}</span>
        </div>
    `).join('');
    }

    function copyAll() {
        wordInput.select();
        document.execCommand('copy');
    }

    wordInput.addEventListener('input', updateAll);
</script>