<?php
// web/views/tools/password-generator.php
?>
<div class="space-y-10">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
        <!-- Configuration (Left) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Password
                        Length</label>
                    <span id="lengthValue" class="text-xs font-black text-primary">16</span>
                </div>
                <input type="range" id="passLength" min="4" max="64" value="16"
                    class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-primary">
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Character
                    Sets</label>
                <div class="grid grid-cols-1 gap-3">
                    <label
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl cursor-pointer group transition-all">
                        <span
                            class="text-xs font-bold text-gray-400 group-hover:text-primary transition-colors">Uppercase
                            (A-Z)</span>
                        <input type="checkbox" id="useUpper" checked class="w-5 h-5 accent-primary rounded-lg">
                    </label>
                    <label
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl cursor-pointer group transition-all">
                        <span
                            class="text-xs font-bold text-gray-400 group-hover:text-primary transition-colors">Lowercase
                            (a-z)</span>
                        <input type="checkbox" id="useLower" checked class="w-5 h-5 accent-primary rounded-lg">
                    </label>
                    <label
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl cursor-pointer group transition-all">
                        <span class="text-xs font-bold text-gray-400 group-hover:text-primary transition-colors">Numbers
                            (0-9)</span>
                        <input type="checkbox" id="useNumbers" checked class="w-5 h-5 accent-primary rounded-lg">
                    </label>
                    <label
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/30 rounded-2xl cursor-pointer group transition-all">
                        <span class="text-xs font-bold text-gray-400 group-hover:text-primary transition-colors">Symbols
                            (!@#$%^&*)</span>
                        <input type="checkbox" id="useSymbols" checked class="w-5 h-5 accent-primary rounded-lg">
                    </label>
                </div>
            </div>

            <button onclick="generatePassword()"
                class="w-full py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                <i class="fas fa-rotate mr-2"></i> Generate Password
            </button>
        </div>

        <!-- Result (Right) -->
        <div class="lg:col-span-3 space-y-6">
            <div class="space-y-4">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Generated
                    Password</label>
                <div class="relative group">
                    <input type="text" id="passResult" readonly
                        class="w-full p-8 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent text-xl font-mono text-center text-secondary dark:text-white transition-all outline-none">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-white/10 backdrop-blur-[2px] rounded-[2.5rem] transition-all pointer-events-none">
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em]">Securely Generated</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center pt-2">
                <button onclick="copyPassword()" id="copyBtn"
                    class="w-full max-w-xs py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-black/10 hover:scale-105 active:scale-95 transition-all">
                    <i class="fas fa-copy mr-2"></i> Copy Password
                </button>
            </div>

            <!-- Strength Indicator -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900/30 rounded-3xl border border-transparent space-y-3">
                <div class="flex items-center justify-between px-1">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Strength</span>
                    <span id="strengthText" class="text-[10px] font-black uppercase tracking-widest">Very Strong</span>
                </div>
                <div class="h-2 w-full bg-gray-200 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div id="strengthBar" class="h-full bg-green-500 transition-all duration-500" style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const chars = {
        upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        lower: 'abcdefghijklmnopqrstuvwxyz',
        numbers: '0123456789',
        symbols: '!@#$%^&*()_+-=[]{}|;:,.<>?'
    };

    function generatePassword() {
        const length = document.getElementById('passLength').value;
        const useUpper = document.getElementById('useUpper').checked;
        const useLower = document.getElementById('useLower').checked;
        const useNumbers = document.getElementById('useNumbers').checked;
        const useSymbols = document.getElementById('useSymbols').checked;

        document.getElementById('lengthValue').innerText = length;

        let pool = '';
        if (useUpper) pool += chars.upper;
        if (useLower) pool += chars.lower;
        if (useNumbers) pool += chars.numbers;
        if (useSymbols) pool += chars.symbols;

        if (!pool) {
            document.getElementById('passResult').value = 'Select at least one option!';
            return;
        }

        let password = '';
        for (let i = 0; i < length; i++) {
            password += pool.charAt(Math.floor(Math.random() * pool.length));
        }

        document.getElementById('passResult').value = password;
        updateStrength(password, length);
    }

    function updateStrength(pass, length) {
        let strength = 0;
        if (length > 8) strength += 25;
        if (length > 12) strength += 25;
        if (/[A-Z]/.test(pass)) strength += 10;
        if (/[a-z]/.test(pass)) strength += 10;
        if (/[0-9]/.test(pass)) strength += 15;
        if (/[^A-Za-z0-9]/.test(pass)) strength += 15;

        const bar = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');

        bar.style.width = strength + '%';
        if (strength < 40) {
            bar.style.backgroundColor = '#ef4444';
            text.innerText = 'Weak';
            text.style.color = '#ef4444';
        } else if (strength < 70) {
            bar.style.backgroundColor = '#f59e0b';
            text.innerText = 'Moderate';
            text.style.color = '#f59e0b';
        } else {
            bar.style.backgroundColor = '#22c55e';
            text.innerText = 'Safe & Strong';
            text.style.color = '#22c55e';
        }
    }

    function copyPassword() {
        const res = document.getElementById('passResult');
        if (res.value === 'Select at least one option!') return;

        res.select();
        document.execCommand('copy');

        const btn = document.getElementById('copyBtn');
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-2"></i> Copied!';
        setTimeout(() => btn.innerHTML = original, 2000);
    }

    document.getElementById('passLength').addEventListener('input', generatePassword);

    // Initial
    generatePassword();
</script>