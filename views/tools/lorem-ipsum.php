<?php
// web/views/tools/lorem-ipsum.php
?>
<div class="space-y-8">
    <!-- Configuration -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Amount</label>
            <input type="number" id="loremCount" value="3" min="1" max="50"
                class="w-full p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-bold transition-all">
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Type</label>
            <select id="loremType"
                class="w-full p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-bold transition-all appearance-none cursor-pointer">
                <option value="paragraphs">Paragraphs</option>
                <option value="sentences">Sentences</option>
                <option value="words">Words</option>
            </select>
        </div>
        <div class="flex items-end pb-1">
            <button onclick="generateLorem()"
                class="w-full py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                <i class="fas fa-rotate mr-2"></i> Generate
            </button>
        </div>
    </div>

    <!-- Output -->
    <div class="space-y-2">
        <div class="flex items-center justify-between px-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Generated Text</label>
            <button onclick="copyLorem()" id="loremCopyBtn"
                class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest transition-all">
                Copy Result
            </button>
        </div>
        <textarea id="loremOutput" rows="12" readonly
            class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent outline-none text-sm leading-relaxed custom-scrollbar text-gray-600 dark:text-gray-300"></textarea>
    </div>
</div>

<script>
    const loremText = [
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
        "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
        "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.",
        "Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.",
        "Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.",
        "Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur.",
        "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores."
    ];

    function generateLorem() {
        const count = parseInt(document.getElementById('loremCount').value) || 3;
        const type = document.getElementById('loremType').value;
        let result = "";

        if (type === 'paragraphs') {
            const paras = [];
            for (let i = 0; i < count; i++) {
                paras.push(loremText.sort(() => Math.random() - 0.5).join(" "));
            }
            result = paras.join("\n\n");
        } else if (type === 'sentences') {
            const sentences = [];
            for (let i = 0; i < count; i++) {
                sentences.push(loremText[Math.floor(Math.random() * loremText.length)]);
            }
            result = sentences.join(" ");
        } else if (type === 'words') {
            const pool = loremText.join(" ").split(" ");
            const words = [];
            for (let i = 0; i < count; i++) {
                words.push(pool[Math.floor(Math.random() * pool.length)]);
            }
            result = words.join(" ");
        }

        document.getElementById('loremOutput').value = result;
    }

    function copyLorem() {
        const output = document.getElementById('loremOutput');
        output.select();
        document.execCommand('copy');

        const btn = document.getElementById('loremCopyBtn');
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        setTimeout(() => btn.innerText = original, 2000);
    }

    // Initial generate
    generateLorem();
</script>