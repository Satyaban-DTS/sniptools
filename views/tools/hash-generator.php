<?php
// web/views/tools/hash-generator.php
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<div class="space-y-8">
    <!-- Input -->
    <div class="space-y-2">
        <label for="hashInput" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Source
            Text</label>
        <textarea id="hashInput" rows="6" placeholder="Enter text to hash..."
            class="w-full p-6 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm leading-relaxed transition-all custom-scrollbar"></textarea>
    </div>

    <!-- Results -->
    <div class="grid grid-cols-1 gap-4">
        <!-- MD5 -->
        <div
            class="p-6 bg-gray-50 dark:bg-gray-900/30 rounded-[2rem] border border-transparent hover:border-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">MD5</span>
                <button onclick="copyHash('md5')"
                    class="text-[10px] font-black text-primary opacity-0 group-hover:opacity-100 transition-all uppercase tracking-widest">Copy</button>
            </div>
            <code id="hashMD5" class="block text-xs font-mono text-secondary dark:text-gray-300 break-all">...</code>
        </div>

        <!-- SHA-1 -->
        <div
            class="p-6 bg-gray-50 dark:bg-gray-900/30 rounded-[2rem] border border-transparent hover:border-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">SHA-1</span>
                <button onclick="copyHash('sha1')"
                    class="text-[10px] font-black text-primary opacity-0 group-hover:opacity-100 transition-all uppercase tracking-widest">Copy</button>
            </div>
            <code id="hashSHA1" class="block text-xs font-mono text-secondary dark:text-gray-300 break-all">...</code>
        </div>

        <!-- SHA-256 -->
        <div
            class="p-6 bg-gray-50 dark:bg-gray-900/30 rounded-[2rem] border border-transparent hover:border-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">SHA-256</span>
                <button onclick="copyHash('sha256')"
                    class="text-[10px] font-black text-primary opacity-0 group-hover:opacity-100 transition-all uppercase tracking-widest">Copy</button>
            </div>
            <code id="hashSHA256" class="block text-xs font-mono text-secondary dark:text-gray-300 break-all">...</code>
        </div>
    </div>
</div>

<script>
    const hashInput = document.getElementById('hashInput');

    function updateHashes() {
        const text = hashInput.value;
        if (!text) {
            document.getElementById('hashMD5').innerText = '...';
            document.getElementById('hashSHA1').innerText = '...';
            document.getElementById('hashSHA256').innerText = '...';
            return;
        }

        document.getElementById('hashMD5').innerText = CryptoJS.MD5(text).toString();
        document.getElementById('hashSHA1').innerText = CryptoJS.SHA1(text).toString();
        document.getElementById('hashSHA256').innerText = CryptoJS.SHA256(text).toString();
    }

    function copyHash(type) {
        let id = '';
        switch (type) {
            case 'md5': id = 'hashMD5'; break;
            case 'sha1': id = 'hashSHA1'; break;
            case 'sha256': id = 'hashSHA256'; break;
        }
        const text = document.getElementById(id).innerText;
        if (text === '...') return;

        navigator.clipboard.writeText(text);
        // Visual feedback could be added here
    }

    hashInput.addEventListener('input', updateHashes);
</script>