<?php
// web/views/tools/uuid-generator.php
?>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
    <!-- Controls (Left) -->
    <div class="lg:col-span-4 space-y-8">
        <div
            class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/20 dark:border-gray-700/50 shadow-2xl relative group overflow-hidden">
            <div
                class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors">
            </div>

            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8 flex items-center">
                <i class="fas fa-fingerprint mr-3 text-primary"></i>
                Identifier Specs
            </h3>

            <div class="space-y-6">
                <div class="space-y-3">
                    <label
                        class="text-[11px] font-black text-secondary dark:text-gray-300 uppercase tracking-widest block">Batch
                        Volume</label>
                    <div class="relative">
                        <input type="number" id="uuidCount" value="5" min="1" max="100"
                            class="w-full bg-gray-50/50 dark:bg-gray-900/50 border-2 border-gray-100 dark:border-gray-700 rounded-2xl py-4 px-6 text-sm font-bold focus:border-primary outline-none transition-all shadow-inner text-center">
                        <span
                            class="absolute right-5 top-1/2 -translate-y-1/2 text-[9px] font-black text-gray-300 uppercase tracking-widest pointer-events-none">Items</span>
                    </div>
                </div>

                <div class="pt-2">
                    <button onclick="generateUUIDs()"
                        class="w-full py-4 bg-primary text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center">
                        <i class="fas fa-microchip mr-2"></i> Compute UUIDs
                    </button>

                    <button onclick="copyUUIDs()" id="uuidCopyBtn"
                        class="w-full mt-4 py-4 bg-white dark:bg-gray-700 text-secondary dark:text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-black/5 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all flex items-center justify-center">
                        <i class="fas fa-copy mr-2"></i> Copy Manifest
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-emerald-500/5 rounded-[2rem] p-6 border border-emerald-500/10 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-globe text-4xl text-emerald-500"></i>
            </div>
            <h3 class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-2">RFC 4122 Standard</h3>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 font-bold leading-relaxed">
                Cryptographically secure Version 4 UUIDs generated via browser entropy.
            </p>
        </div>
    </div>

    <!-- Output (Right) -->
    <div class="lg:col-span-8 flex flex-col space-y-4">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-4">Generated Identifiers</label>

        <div
            class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-md rounded-[2.5rem] p-4 border border-white/20 dark:border-gray-700/50 shadow-xl min-h-[300px]">
            <div id="uuidResults" class="space-y-3 h-full overflow-y-auto custom-scrollbar max-h-[600px] p-2">
                <!-- Dynamic items -->
            </div>
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
            div.className = "flex items-center justify-between p-4 bg-white/40 dark:bg-gray-900/40 rounded-2xl border border-white/20 dark:border-gray-700/50 hover:border-primary/20 hover:bg-white/60 dark:hover:bg-gray-800/60 backdrop-blur-sm transition-all group animate-in slide-in-from-left-4 duration-300 shadow-sm";
            div.style.animationDelay = (i * 50) + 'ms';
            div.innerHTML = `
            <code class="text-xs font-mono text-secondary dark:text-gray-300 tracking-wide">${uuid}</code>
            <button onclick="copyItem('${uuid}', this)" class="w-8 h-8 rounded-xl flex items-center justify-center bg-white/50 dark:bg-gray-800/50 text-gray-400 hover:text-primary hover:scale-110 opacity-0 group-hover:opacity-100 transition-all shadow-sm">
                <i class="fas fa-copy text-xs"></i>
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