<?php
// web/views/tools/tailwind-flexbox-playground.php
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full">
    <!-- Controls Panel -->
    <div class="lg:col-span-4 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
            <h3 class="text-sm font-black text-secondary dark:text-white uppercase tracking-widest mb-6">Flex Properties
            </h3>

            <div class="space-y-5">
                <!-- Flex Direction -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Direction</label>
                    <select id="flexDirection"
                        class="control-input w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="flex-row">Row (default)</option>
                        <option value="flex-row-reverse">Row Reverse</option>
                        <option value="flex-col">Column</option>
                        <option value="flex-col-reverse">Column Reverse</option>
                    </select>
                </div>

                <!-- Flex Wrap -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Wrap</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="setProp('wrap', 'flex-nowrap')" class="prop-btn active" data-group="wrap"
                            data-val="flex-nowrap">No Wrap</button>
                        <button onclick="setProp('wrap', 'flex-wrap')" class="prop-btn" data-group="wrap"
                            data-val="flex-wrap">Wrap</button>
                        <button onclick="setProp('wrap', 'flex-wrap-reverse')" class="prop-btn" data-group="wrap"
                            data-val="flex-wrap-reverse">Reverse</button>
                    </div>
                </div>

                <!-- Justify Content -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Justify
                        Content</label>
                    <select id="justifyContent"
                        class="control-input w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="justify-start">Start</option>
                        <option value="justify-end">End</option>
                        <option value="justify-center">Center</option>
                        <option value="justify-between">Space Between</option>
                        <option value="justify-around">Space Around</option>
                        <option value="justify-evenly">Space Evenly</option>
                    </select>
                </div>

                <!-- Align Items -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Align
                        Items</label>
                    <select id="alignItems"
                        class="control-input w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="items-start">Start</option>
                        <option value="items-end">End</option>
                        <option value="items-center">Center</option>
                        <option value="items-baseline">Baseline</option>
                        <option value="items-stretch" selected>Stretch</option>
                    </select>
                </div>

                <!-- Gap -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gap</label>
                    <input type="range" id="gapRange" min="0" max="12" step="1" value="4"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                    <div class="flex justify-between text-[10px] text-gray-400 font-bold mt-1">
                        <span>0</span>
                        <span class="text-primary" id="gapVal">gap-4</span>
                        <span>12</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Output Code -->
        <div class="bg-gray-900 rounded-2xl p-6 border border-gray-700 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-black text-white uppercase tracking-widest">Tailwind Classes</h3>
                <button onclick="copyCode()" class="text-xs font-bold text-primary hover:text-white transition-colors">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
            <code id="codeOutput" class="block bg-black/50 rounded-xl p-4 text-xs text-green-400 font-mono break-all">
                flex flex-row flex-nowrap justify-start items-stretch gap-4
            </code>
        </div>
    </div>

    <!-- Preview Panel -->
    <div class="lg:col-span-8 flex flex-col h-full min-h-[500px]">
        <div
            class="flex-1 bg-gray-100 dark:bg-[#1a1c26] rounded-3xl border border-gray-200 dark:border-gray-700/50 p-8 flex flex-col overflow-hidden relative">
            <div class="absolute top-4 left-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Live
                Preview</div>

            <!-- The Flex Container -->
            <div id="flexContainer"
                class="flex flex-row flex-nowrap justify-start items-stretch gap-4 w-full h-full border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl p-4 transition-all duration-300 bg-white/50 dark:bg-black/20 overflow-auto">

                <!-- Flex Items -->
                <div
                    class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-500/30 shrink-0 transform transition-all">
                    1</div>
                <div
                    class="w-16 h-24 bg-purple-500 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-purple-500/30 shrink-0 transform transition-all">
                    2</div>
                <div
                    class="w-16 h-16 bg-pink-500 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-pink-500/30 shrink-0 transform transition-all">
                    3</div>
                <div
                    class="w-24 h-16 bg-orange-500 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-orange-500/30 shrink-0 transform transition-all">
                    4</div>

            </div>
        </div>

        <!-- Controls for items -->
        <div class="flex justify-center space-x-4 mt-6">
            <button onclick="addItem()"
                class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-bold rounded-xl shadow-sm text-sm hover:text-primary transition-all">
                <i class="fas fa-plus mr-2"></i> Add Item
            </button>
            <button onclick="removeItem()"
                class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-bold rounded-xl shadow-sm text-sm hover:text-red-500 transition-all">
                <i class="fas fa-minus mr-2"></i> Remove Item
            </button>
        </div>
    </div>
</div>

<style>
    .prop-btn {
        @apply px-2 py-2 text-[10px] font-bold rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 transition-all hover:bg-gray-50 dark:hover:bg-gray-700;
    }

    .prop-btn.active {
        @apply bg-primary text-white border-primary shadow-md shadow-primary/20;
    }
</style>

<script>
    // State
    const state = {
        direction: 'flex-row',
        wrap: 'flex-nowrap',
        justify: 'justify-start',
        align: 'items-stretch',
        gap: 'gap-4'
    };

    // DOM Elements
    const container = document.getElementById('flexContainer');
    const codeOutput = document.getElementById('codeOutput');
    const gapVal = document.getElementById('gapVal');

    // Inputs
    document.getElementById('flexDirection').addEventListener('change', (e) => updateState('direction', e.target.value));
    document.getElementById('justifyContent').addEventListener('change', (e) => updateState('justify', e.target.value));
    document.getElementById('alignItems').addEventListener('change', (e) => updateState('align', e.target.value));
    document.getElementById('gapRange').addEventListener('input', (e) => {
        state.gap = `gap-${e.target.value}`;
        gapVal.textContent = state.gap;
        render();
    });

    function setProp(prop, val) {
        state[prop] = val;

        // Update Button UI
        document.querySelectorAll(`button[data-group="${prop}"]`).forEach(btn => {
            if (btn.dataset.val === val) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        render();
    }

    function updateState(key, val) {
        state[key] = val;
        render();
    }

    function render() {
        const classes = `flex ${state.direction} ${state.wrap} ${state.justify} ${state.align} ${state.gap} w-full h-full border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl p-4 transition-all duration-300 bg-white/50 dark:bg-black/20 overflow-auto`;

        container.className = classes;
        codeOutput.textContent = `flex ${state.direction} ${state.wrap} ${state.justify} ${state.align} ${state.gap}`;
    }

    // Add/Remove Items logic for interactivity
    const colors = ['bg-blue-500', 'bg-purple-500', 'bg-pink-500', 'bg-orange-500', 'bg-green-500', 'bg-teal-500', 'bg-red-500'];

    function addItem() {
        if (container.children.length >= 12) return;

        const i = container.children.length + 1;
        const div = document.createElement('div');
        const color = colors[Math.floor(Math.random() * colors.length)];
        const w = (i % 3 === 0) ? 'w-24' : 'w-16';
        const h = (i % 2 === 0) ? 'h-24' : 'h-16';

        div.className = `${w} ${h} ${color} rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-${color.split('-')[1]}-500/30 shrink-0 transform transition-all animate-bounce-in`;
        div.textContent = i;

        container.appendChild(div);
    }

    function removeItem() {
        if (container.lastElementChild && container.children.length > 1) {
            container.removeChild(container.lastElementChild);
        }
    }

    function copyCode() {
        navigator.clipboard.writeText(codeOutput.textContent.trim()).then(() => {
            alert('Classes copied!');
        });
    }
</script>