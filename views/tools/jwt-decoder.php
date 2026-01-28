<?php
// views/tools/jwt-decoder.php
?>
<div class="space-y-6">
    <!-- Input Area -->
    <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-8 border border-gray-100 dark:border-gray-700/50 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Encoded Token</h3>
            <button onclick="clearAll()"
                class="text-xs font-bold text-red-500 hover:text-red-600 transition-colors">Clear</button>
        </div>
        <textarea id="jwtInput" rows="5"
            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 font-mono text-xs text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-gray-400"
            placeholder="Paste your JWT here (e.g. eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...)"></textarea>
    </div>

    <!-- Output Grid -->
    <div id="outputArea" class="hidden grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Header -->
        <div
            class="bg-white dark:bg-gray-800 rounded-[2rem] p-8 border border-gray-100 dark:border-gray-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-heading text-6xl text-red-500"></i>
            </div>
            <h3 class="text-xs font-bold text-red-500 uppercase tracking-widest mb-4">Header</h3>
            <pre id="headerOutput"
                class="text-xs font-mono text-gray-600 dark:text-gray-300 whitespace-pre-wrap break-all"></pre>
        </div>

        <!-- Payload -->
        <div
            class="bg-white dark:bg-gray-800 rounded-[2rem] p-8 border border-gray-100 dark:border-gray-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-code text-6xl text-purple-500"></i>
            </div>
            <h3 class="text-xs font-bold text-purple-500 uppercase tracking-widest mb-4">Payload</h3>
            <pre id="payloadOutput"
                class="text-xs font-mono text-gray-600 dark:text-gray-300 whitespace-pre-wrap break-all"></pre>
        </div>

        <!-- Signature -->
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-[2rem] p-8 border border-gray-100 dark:border-gray-700/50 shadow-sm bg-blue-50/50 dark:bg-blue-900/10">
            <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-2">Signature</h3>
            <p class="text-[10px] text-gray-400 font-mono break-all" id="signatureOutput"></p>
        </div>
    </div>
</div>

<script>
    const jwtInput = document.getElementById('jwtInput');
    const outputArea = document.getElementById('outputArea');
    const headerOutput = document.getElementById('headerOutput');
    const payloadOutput = document.getElementById('payloadOutput');
    const signatureOutput = document.getElementById('signatureOutput');

    jwtInput.addEventListener('input', decodeJWT);

    function decodeJWT() {
        const token = jwtInput.value.trim();
        if (!token) {
            outputArea.classList.add('hidden');
            return;
        }

        const parts = token.split('.');
        if (parts.length !== 3) {
            // Invalid JWT format
            return;
        }

        try {
            const header = JSON.parse(atob(parts[0]));
            const payload = JSON.parse(atob(parts[1]));

            headerOutput.innerText = JSON.stringify(header, null, 2);
            payloadOutput.innerText = JSON.stringify(payload, null, 2);
            signatureOutput.innerText = parts[2]; // Can't verify on client without secret, just show it

            outputArea.classList.remove('hidden');
        } catch (e) {
            console.error('Failed to decode JWT', e);
        }
    }

    function clearAll() {
        jwtInput.value = '';
        outputArea.classList.add('hidden');
        jwtInput.focus();
    }
</script>