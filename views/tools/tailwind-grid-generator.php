<?php
// web/views/tools/tailwind-grid-generator.php
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full">
    <!-- Controls Panel -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Container Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
            <h3 class="text-sm font-black text-secondary dark:text-white uppercase tracking-widest mb-4">Grid Settings
            </h3>

            <div class="space-y-4">
                <!-- Columns -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Columns</label>
                    <div class="flex items-center space-x-4">
                        <input type="range" id="gridCols" min="1" max="12" value="3"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                        <span id="gridColsVal" class="text-sm font-bold w-6">3</span>
                    </div>
                </div>

                <!-- Gap -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gap (px)</label>
                    <select id="gridGap"
                        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="0">0 (gap-0)</option>
                        <option value="1">4px (gap-1)</option>
                        <option value="2">8px (gap-2)</option>
                        <option value="4" selected>16px (gap-4)</option>
                        <option value="6">24px (gap-6)</option>
                        <option value="8">32px (gap-8)</option>
                        <option value="10">40px (gap-10)</option>
                        <option value="12">48px (gap-12)</option>
                    </select>
                </div>

                <!-- Items Count -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Items</label>
                    <div class="flex items-center space-x-4">
                        <input type="number" id="itemCount" min="1" max="24" value="6"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Item Settings -->
        <div id="itemSettings"
            class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm opacity-50 pointer-events-none transition-all">
            <h3 class="text-sm font-black text-secondary dark:text-white uppercase tracking-widest mb-4">Item <span
                    id="selectedItemIndex">#</span></h3>

            <div class="space-y-4">
                <!-- Col Span -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Col Span</label>
                    <select id="itemColSpan"
                        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="auto">Auto</option>
                        <option value="1">Span 1</option>
                        <option value="2">Span 2</option>
                        <option value="3">Span 3</option>
                        <option value="4">Span 4</option>
                        <option value="5">Span 5</option>
                        <option value="6">Span 6</option>
                        <option value="full">Full Width</option>
                    </select>
                </div>

                <!-- Row Span -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Row Span</label>
                    <select id="itemRowSpan"
                        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="auto">Auto</option>
                        <option value="1">Span 1</option>
                        <option value="2">Span 2</option>
                        <option value="3">Span 3</option>
                        <option value="4">Span 4</option>
                        <option value="full">Full Height</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Output Code -->
        <div class="bg-gray-900 rounded-2xl p-6 border border-gray-700 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-black text-white uppercase tracking-widest">Tailwind Code</h3>
                <button onclick="copyGridCode()"
                    class="text-xs font-bold text-primary hover:text-white transition-colors">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
            <pre
                class="bg-black/50 rounded-xl p-4 overflow-x-auto text-[10px] text-green-400 font-mono leading-relaxed custom-scrollbar"><code id="codeOutput"></code></pre>
        </div>
    </div>

    <!-- Preview Panel -->
    <div class="lg:col-span-8 flex flex-col">
        <div
            class="flex-1 bg-gray-100 dark:bg-[#1a1c26] rounded-3xl border border-gray-200 dark:border-gray-700/50 p-8 flex items-center justify-center overflow-auto custom-scrollbar relative">
            <div class="absolute top-4 left-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Live
                Preview</div>

            <!-- The Grid -->
            <div id="gridPreview" class="w-full max-w-3xl transition-all duration-300">
                <!-- Generated items will go here -->
            </div>
        </div>
        <p class="text-center text-xs text-gray-400 mt-4 font-medium">Click on a grid item to customize its span.</p>
    </div>
</div>

<script>
    // State
    const state = {
        cols: 3,
        gap: 4,
        count: 6,
        selectedIndex: null,
        items: [] // { colSpan: 'auto', rowSpan: 'auto' }
    };

    // DOM Elements
    const els = {
        cols: document.getElementById('gridCols'),
        colsVal: document.getElementById('gridColsVal'),
        gap: document.getElementById('gridGap'),
        count: document.getElementById('itemCount'),
        preview: document.getElementById('gridPreview'),
        codeOutput: document.getElementById('codeOutput'),
        itemSettings: document.getElementById('itemSettings'),
        itemIndex: document.getElementById('selectedItemIndex'),
        itemColSpan: document.getElementById('itemColSpan'),
        itemRowSpan: document.getElementById('itemRowSpan')
    };

    // Initialize
    function init() {
        // Build initial items state
        for (let i = 0; i < state.count; i++) {
            state.items.push({ colSpan: 'auto', rowSpan: 'auto' });
        }

        render();
        updateCode();

        // Listeners
        els.cols.addEventListener('input', (e) => {
            state.cols = e.target.value;
            els.colsVal.textContent = state.cols;
            render();
            updateCode();
        });

        els.gap.addEventListener('change', (e) => {
            state.gap = e.target.value;
            render();
            updateCode();
        });

        els.count.addEventListener('input', (e) => {
            const newCount = parseInt(e.target.value) || 1;

            // Adjust items array
            if (newCount > state.items.length) {
                for (let i = state.items.length; i < newCount; i++) {
                    state.items.push({ colSpan: 'auto', rowSpan: 'auto' });
                }
            } else {
                state.items = state.items.slice(0, newCount);
                if (state.selectedIndex !== null && state.selectedIndex >= newCount) {
                    deselectItem();
                }
            }

            state.count = newCount;
            render();
            updateCode();
        });

        els.itemColSpan.addEventListener('change', (e) => {
            if (state.selectedIndex === null) return;
            state.items[state.selectedIndex].colSpan = e.target.value;
            render();
            updateCode();
        });

        els.itemRowSpan.addEventListener('change', (e) => {
            if (state.selectedIndex === null) return;
            state.items[state.selectedIndex].rowSpan = e.target.value;
            render();
            updateCode();
        });
    }

    // Render Grid
    function render() {
        // Container Classes
        let containerClasses = `grid grid-cols-${state.cols}`;
        if (state.gap > 0) containerClasses += ` gap-${state.gap}`;

        els.preview.className = `w-full transition-all duration-300 ${containerClasses}`;
        els.preview.innerHTML = '';

        state.items.forEach((item, index) => {
            const div = document.createElement('div');

            // Item Classes
            let classes = ['bg-primary', 'rounded-xl', 'text-white', 'flex', 'items-center', 'justify-center', 'font-black', 'text-xl', 'shadow-lg', 'shadow-primary/20', 'cursor-pointer', 'transition-all', 'hover:bg-primary-dark', 'relative', 'overflow-hidden', 'min-h-[100px]'];

            if (state.selectedIndex === index) {
                classes.push('ring-4', 'ring-accent', 'z-10', 'scale-[1.02]');
            } else {
                classes.push('opacity-90', 'hover:opacity-100');
            }

            if (item.colSpan !== 'auto') classes.push(item.colSpan === 'full' ? 'col-span-full' : `col-span-${item.colSpan}`);
            if (item.rowSpan !== 'auto') classes.push(item.rowSpan === 'full' ? 'row-span-full' : `row-span-${item.rowSpan}`);

            div.className = classes.join(' ');
            div.innerHTML = `<span class="opacity-30 select-none">${index + 1}</span>`;
            div.onclick = () => selectItem(index);

            els.preview.appendChild(div);
        });
    }

    // Select Item
    function selectItem(index) {
        state.selectedIndex = index;
        const item = state.items[index];

        els.itemSettings.classList.remove('opacity-50', 'pointer-events-none');
        els.itemIndex.textContent = '#' + (index + 1);
        els.itemColSpan.value = item.colSpan;
        els.itemRowSpan.value = item.rowSpan;

        render(); // to update active ring
    }

    function deselectItem() {
        state.selectedIndex = null;
        els.itemSettings.classList.add('opacity-50', 'pointer-events-none');
        render();
    }

    // Generate Code
    function updateCode() {
        let html = `<div class="grid grid-cols-${state.cols}`;
        if (state.gap > 0) html += ` gap-${state.gap}`;
        html += `">\n`;

        state.items.forEach((item, i) => {
            let div = `  <div class="`;
            let classes = ['bg-indigo-500', 'p-4', 'rounded-lg']; // Generic classes for export

            if (item.colSpan !== 'auto') classes.push(item.colSpan === 'full' ? 'col-span-full' : `col-span-${item.colSpan}`);
            if (item.rowSpan !== 'auto') classes.push(item.rowSpan === 'full' ? 'row-span-full' : `row-span-${item.rowSpan}`);

            div += classes.join(' ') + `">${i + 1}</div>\n`;
            html += div;
        });

        html += `</div>`;
        els.codeOutput.textContent = html;
    }

    function copyGridCode() {
        const code = els.codeOutput.textContent;
        navigator.clipboard.writeText(code).then(() => {
            alert('Code copied to clipboard!');
        });
    }

    // Init
    init();
</script>