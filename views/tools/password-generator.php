<?php
// web/views/tools/password-generator.php
?>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
    <!-- Configuration (Left) -->
    <div class="lg:col-span-5 space-y-8">
        <div
            class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/20 dark:border-gray-700/50 shadow-2xl relative group overflow-hidden">
            <div
                class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors">
            </div>

            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8 flex items-center">
                <i class="fas fa-cogs mr-3 text-primary"></i>
                Entropy Settings
            </h3>

            <div class="space-y-6">
                <div class="relative">
                    <div class="flex justify-between items-center mb-4">
                        <label
                            class="text-[11px] font-black text-secondary dark:text-gray-300 uppercase tracking-widest">Complexity
                            Length</label>
                        <span id="lengthValue"
                            class="px-3 py-1 bg-primary/10 text-primary text-[11px] font-black rounded-lg">16</span>
                    </div>
                    <input type="range" id="passLength" min="4" max="64" value="16"
                        class="w-full h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full appearance-none cursor-pointer accent-primary transition-all hover:h-2">
                </div>

                <div class="space-y-3">
                    <label
                        class="text-[11px] font-black text-secondary dark:text-gray-300 uppercase tracking-widest block">Character
                        Matrix</label>
                    <div class="grid grid-cols-1 gap-3">
                        <label
                            class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl cursor-pointer group transition-all hover:bg-white dark:hover:bg-gray-800 border-2 border-transparent hover:border-primary/10">
                            <span
                                class="text-[11px] font-bold text-gray-400 group-hover:text-primary transition-colors uppercase tracking-wider">A-Z
                                Uppercase</span>
                            <div class="relative">
                                <input type="checkbox" id="useUpper" checked class="peer sr-only">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                        </label>
                        <label
                            class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl cursor-pointer group transition-all hover:bg-white dark:hover:bg-gray-800 border-2 border-transparent hover:border-primary/10">
                            <span
                                class="text-[11px] font-bold text-gray-400 group-hover:text-primary transition-colors uppercase tracking-wider">a-z
                                Lowercase</span>
                            <div class="relative">
                                <input type="checkbox" id="useLower" checked class="peer sr-only">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                        </label>
                        <label
                            class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl cursor-pointer group transition-all hover:bg-white dark:hover:bg-gray-800 border-2 border-transparent hover:border-primary/10">
                            <span
                                class="text-[11px] font-bold text-gray-400 group-hover:text-primary transition-colors uppercase tracking-wider">0-9
                                Numbers</span>
                            <div class="relative">
                                <input type="checkbox" id="useNumbers" checked class="peer sr-only">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                        </label>
                        <label
                            class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl cursor-pointer group transition-all hover:bg-white dark:hover:bg-gray-800 border-2 border-transparent hover:border-primary/10">
                            <span
                                class="text-[11px] font-bold text-gray-400 group-hover:text-primary transition-colors uppercase tracking-wider">Special
                                Symbols</span>
                            <div class="relative">
                                <input type="checkbox" id="useSymbols" checked class="peer sr-only">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-2">
                    <button onclick="generatePassword()"
                        class="w-full py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-gray-900/10 flex items-center justify-center group/btn">
                        <i class="fas fa-rotate mr-2 group-hover/btn:spin-once transition-transform"></i>
                        Regenerate Key
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Result (Right) -->
    <div class="lg:col-span-7 space-y-8 flex flex-col justify-center">

        <div class="relative w-full">
            <div
                class="absolute inset-0 bg-gradient-to-r from-primary via-accent to-purple-600 rounded-[3rem] blur-3xl opacity-20 animate-pulse">
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-[3rem] p-10 shadow-2xl relative z-10 border border-gray-100 dark:border-gray-700 flex flex-col items-center">
                <div class="w-full mb-8 relative group">
                    <label
                        class="absolute -top-3 left-8 px-2 bg-white dark:bg-gray-800 text-[9px] font-black text-gray-400 uppercase tracking-widest z-20">Generated
                        Key</label>
                    <textarea id="passResult" readonly rows="2"
                        class="w-full p-8 rounded-[2rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/30 text-2xl md:text-3xl font-mono text-center text-secondary dark:text-white transition-all outline-none resize-none shadow-inner tracking-wider leading-relaxed selection:bg-primary selection:text-white break-all"></textarea>
                </div>

                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button onclick="copyPassword()" id="copyBtn"
                        class="w-full py-5 bg-gradient-to-r from-primary to-accent text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/25 hover:scale-[1.02] hover:shadow-primary/40 active:scale-95 transition-all relative overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center">
                            <i class="fas fa-copy mr-2"></i> Copy to Clipboard
                        </span>
                        <div
                            class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        </div>
                    </button>

                    <button onclick="downloadKey()"
                        class="w-full py-5 bg-gray-100 dark:bg-gray-700 text-secondary dark:text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition-all flex items-center justify-center">
                        <i class="fas fa-file-download mr-2"></i> Save as .TXT
                    </button>
                </div>

                <!-- Strength Meter -->
                <div
                    class="w-full mt-8 p-6 bg-gray-50 dark:bg-gray-900/50 rounded-[2rem] border border-gray-100 dark:border-gray-700/50">
                    <div class="flex items-center justify-between mb-3 px-2">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Security
                            Grade</span>
                        <span id="strengthText"
                            class="text-[9px] font-black uppercase tracking-widest text-emerald-500">Calculating...</span>
                    </div>
                    <div class="h-3 w-full bg-gray-200 dark:bg-gray-800 rounded-full overflow-hidden shadow-inner">
                        <div id="strengthBar"
                            class="h-full bg-emerald-500 relative overflow-hidden transition-all duration-700 ease-out"
                            style="width: 0%">
                            <div class="absolute inset-0 bg-white/20 w-full h-full animate-indeterminate"></div>
                        </div>
                    </div>
                    <p class="text-[9px] text-gray-400 mt-3 font-medium text-center opacity-60">
                        Entropy calculated based on character diversity and length
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes spin-once {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .group-hover\/btn\:spin-once:hover {
        animation: spin-once 0.5s ease-in-out;
    }

    @keyframes indeterminate {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .animate-indeterminate {
        animation: indeterminate 2s infinite linear;
    }
</style>

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

        let color = '#ef4444'; // red
        let label = 'Weak';

        if (strength >= 70) {
            color = '#10b981'; // emerald
            label = 'Maximum Security';
        } else if (strength >= 40) {
            color = '#f59e0b'; // orange
            label = 'Moderate';
        }

        bar.style.backgroundColor = color;
        text.innerText = label;
        text.style.color = color;
    }

    function copyPassword() {
        const res = document.getElementById('passResult');
        if (res.value === 'Select at least one option!') return;

        res.select();
        document.execCommand('copy');

        showToast ? showToast("Password copied to clipboard") : alert("Copied!");
    }

    function downloadKey() {
        const text = document.getElementById('passResult').value;
        if (text === 'Select at least one option!' || !text) return;

        snipToolsDownload(text, `secure-key-${Date.now()}.txt`, true);

        showToast ? showToast("Key file downloaded") : null;
    }

    document.getElementById('passLength').addEventListener('input', generatePassword);

    // Initial
    generatePassword();
</script>