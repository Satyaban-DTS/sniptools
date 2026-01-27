<?php
// web/views/tools/uuid-generator.php
?>
<div class="space-y-8">
    <!-- Controls -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">How many UUIDs?</label>
            <div class="flex space-x-3">
                <input type="number" id="uuidCount" value="5" min="1" max="100"
                    class="flex-1 p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-bold transition-all">
                <button onclick="generateUUIDs()"
                    class="px-8 py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Generate
                </button>
            </div>
        </div>
        <div class="flex items-end pb-1">
            <button onclick="copyUUIDs()" id="uuidCopyBtn"
                class="w-full py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-black/10 hover:scale-[1.02] active:scale-95 transition-all">
                <i class="fas fa-copy mr-2"></i> Copy All
            </button>
        </div>
    </div>

    <!-- Output -->
    <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Results</label>
        <div id="uuidResults" class="space-y-3">
            <!-- Dynamic items -->
        </div>
    </div>
</div>

<script>
    function cryptoUUID() {
        return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }

    function generateUUIDs() {
        const count = parseInt(document.getElementById('uuidCount').value) || 5;
        const container = document.getElementById('uuidResults');
        container.innerHTML = '';

        for (let i = 0; i < count; i++) {
            const uuid = cryptoUUID();
            const div = document.createElement('div');
            div.className = "flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-transparent hover:border-primary/10 transition-all group animate-in slide-in-from-left-4 duration-300";
            div.style.animationDelay = (i * 50) + 'ms';
            div.innerHTML = `
            <code class="text-xs font-mono text-secondary dark:text-gray-300">${uuid}</code>
            <button onclick="copyItem('${uuid}', this)" class="text-[10px] font-black text-primary opacity-0 group-hover:opacity-100 transition-all uppercase tracking-widest">
                Copy
            </button>
        `;
            container.appendChild(div);
        }
    }

    function copyItem(text, btn) {
        navigator.clipboard.writeText(text);
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        btn.classList.add('text-green-500');
        setTimeout(() => {
            btn.innerText = original;
            btn.classList.remove('text-green-500');
        }, 2000);
    }

    function copyUUIDs() {
        const uuids = Array.from(document.querySelectorAll('#uuidResults code')).map(c => c.innerText).join("\n");
        navigator.clipboard.writeText(uuids);

        const btn = document.getElementById('uuidCopyBtn');
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-2"></i> Copied!';
        setTimeout(() => btn.innerHTML = original, 2000);
    }

    // Initial
    generateUUIDs();
</script>