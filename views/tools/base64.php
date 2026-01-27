<?php
// web/views/tools/base64.php
?>
<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Input -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="b64Input" class="text-xs font-bold text-gray-400 uppercase tracking-widest">Input
                    Text</label>
                <div class="flex space-x-2">
                    <button onclick="clearB64()"
                        class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest">Clear</button>
                </div>
            </div>
            <textarea id="b64Input" rows="12" placeholder="Enter text or base64 here..."
                class="w-full p-6 rounded-[2rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 focus:bg-white dark:focus:bg-gray-900 transition-all outline-none text-sm font-mono custom-scrollbar"></textarea>
        </div>

        <!-- Output -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="b64Output" class="text-xs font-bold text-gray-400 uppercase tracking-widest">Result</label>
                <button onclick="copyB64()" id="b64CopyBtn"
                    class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest">Copy
                    Result</button>
            </div>
            <textarea id="b64Output" rows="12" readonly placeholder="Result will appear here..."
                class="w-full p-6 rounded-[2rem] bg-gray-100/50 dark:bg-gray-800/30 border-2 border-transparent outline-none text-sm font-mono custom-scrollbar text-gray-500"></textarea>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-center space-x-4 pt-6 border-t border-gray-100 dark:border-gray-700">
        <button onclick="encode()"
            class="flex-1 max-w-xs py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
            <i class="fas fa-lock mr-2"></i> Encode to Base64
        </button>
        <button onclick="decode()"
            class="flex-1 max-w-xs py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-black/10 hover:scale-105 active:scale-95 transition-all">
            <i class="fas fa-unlock-keyhole mr-2"></i> Decode from Base64
        </button>
    </div>
</div>

<script>
    const b64Input = document.getElementById('b64Input');
    const b64Output = document.getElementById('b64Output');

    function encode() {
        try {
            const str = b64Input.value;
            b64Output.value = btoa(unescape(encodeURIComponent(str)));
            b64Output.classList.remove('text-red-500');
        } catch (e) {
            b64Output.value = "Error: Invalid input for encoding.";
            b64Output.classList.add('text-red-500');
        }
    }

    function decode() {
        try {
            const str = b64Input.value;
            b64Output.value = decodeURIComponent(escape(atob(str)));
            b64Output.classList.remove('text-red-500');
        } catch (e) {
            b64Output.value = "Error: Invalid Base64 string.";
            b64Output.classList.add('text-red-500');
        }
    }

    function clearB64() {
        b64Input.value = '';
        b64Output.value = '';
    }

    function copyB64() {
        b64Output.select();
        document.execCommand('copy');
        const btn = document.getElementById('b64CopyBtn');
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        setTimeout(() => btn.innerText = original, 2000);
    }
</script>