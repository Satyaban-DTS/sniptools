<?php
// web/views/tools/css-to-tailwind.php
?>
<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Input -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="cssInput" class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Standard
                    CSS</label>
                <button onclick="clearCSS()"
                    class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest">Clear</button>
            </div>
            <textarea id="cssInput" rows="12"
                placeholder=".my-class {&#10;  padding: 20px;&#10;  background-color: #f3f4f6;&#10;  border-radius: 8px;&#10;}"
                class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-mono leading-relaxed transition-all custom-scrollbar"></textarea>
        </div>

        <!-- Output -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="twResult" class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tailwind
                    Classes</label>
                <button onclick="copyTW()" id="twCopyBtn"
                    class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest">Copy
                    Classes</button>
            </div>
            <div id="twResult"
                class="w-full min-h-[12rem] p-8 rounded-[2.5rem] bg-gray-900 text-green-400 font-mono text-sm leading-loose border border-white/5 relative group">
                <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
                    <i class="fas fa-wand-magic-sparkles text-6xl"></i>
                </div>
                <div id="twOutputLines" class="relative z-10 flex flex-wrap gap-2">
                    <!-- Dynamic spans -->
                    <span class="text-gray-600 italic">Result will appear here...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-center pt-4">
        <button onclick="convertToTailwind()"
            class="w-full max-w-md py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
            <i class="fas fa-bolt mr-2"></i> Magic Convert
        </button>
    </div>
</div>

<script>
    const cssToTailwindMap = {
        // Layout
        'display: block': 'block',
        'display: flex': 'flex',
        'display: grid': 'grid',
        'display: inline-block': 'inline-block',
        'display: none': 'hidden',
        'flex-direction: row': 'flex-row',
        'flex-direction: column': 'flex-col',
        'align-items: center': 'items-center',
        'justify-content: center': 'justify-center',

        // Spacing (Simplified)
        'padding: 4px': 'p-1', 'padding: 8px': 'p-2', 'padding: 12px': 'p-3', 'padding: 16px': 'p-4', 'padding: 20px': 'p-5', 'padding: 24px': 'p-6', 'padding: 32px': 'p-8',
        'margin: 4px': 'm-1', 'margin: 8px': 'm-2', 'margin: 12px': 'm-3', 'margin: 16px': 'm-4', 'margin: 20px': 'm-5', 'margin: 24px': 'm-6', 'margin: 32px': 'm-8',

        // Border Radius
        'border-radius: 2px': 'rounded-sm', 'border-radius: 4px': 'rounded', 'border-radius: 6px': 'rounded-md', 'border-radius: 8px': 'rounded-lg', 'border-radius: 12px': 'rounded-xl', 'border-radius: 16px': 'rounded-2xl', 'border-radius: 24px': 'rounded-3xl', 'border-radius: 9999px': 'rounded-full',

        // Typography
        'font-weight: 400': 'font-normal', 'font-weight: 500': 'font-medium', 'font-weight: 600': 'font-semibold', 'font-weight: 700': 'font-bold', 'font-weight: 800': 'font-extrabold', 'font-weight: 900': 'font-black',
        'text-align: center': 'text-center', 'text-align: right': 'text-right',
        'font-size: 12px': 'text-xs', 'font-size: 14px': 'text-sm', 'font-size: 16px': 'text-base', 'font-size: 18px': 'text-lg', 'font-size: 20px': 'text-xl', 'font-size: 24px': 'text-2xl',
    };

    function convertToTailwind() {
        const input = document.getElementById('cssInput').value;
        const outputContainer = document.getElementById('twOutputLines');
        outputContainer.innerHTML = '';

        const lines = input.split('\n');
        const classes = [];

        lines.forEach(line => {
            const cleanLine = line.trim().replace(';', '');
            if (cssToTailwindMap[cleanLine]) {
                classes.push(cssToTailwindMap[cleanLine]);
            } else {
                // JIT handling for arbitrary values
                const parts = cleanLine.split(':');
                if (parts.length === 2) {
                    const prop = parts[0].trim();
                    const val = parts[1].trim();

                    if (prop === 'background-color') classes.push(`bg-[${val}]`);
                    else if (prop === 'color') classes.push(`text-[${val}]`);
                    else if (prop === 'padding') classes.push(`p-[${val}]`);
                    else if (prop === 'margin') classes.push(`m-[${val}]`);
                    else if (prop === 'width') classes.push(`w-[${val}]`);
                    else if (prop === 'height') classes.push(`h-[${val}]`);
                    else if (prop === 'border-radius') classes.push(`rounded-[${val}]`);
                }
            }
        });

        if (classes.length === 0) {
            outputContainer.innerHTML = '<span class="text-gray-600 italic">No matches found. Try specific properties.</span>';
            return;
        }

        classes.forEach(c => {
            const span = document.createElement('span');
            span.className = "px-3 py-1 bg-white/10 rounded-lg text-primary-200 hover:bg-white/20 transition-all cursor-default select-all";
            span.innerText = c;
            outputContainer.appendChild(span);
        });
    }

    function clearCSS() {
        document.getElementById('cssInput').value = '';
        document.getElementById('twOutputLines').innerHTML = '<span class="text-gray-600 italic">Result will appear here...</span>';
    }

    function copyTW() {
        const classes = Array.from(document.querySelectorAll('#twOutputLines span')).map(s => s.innerText).join(' ');
        if (!classes) return;
        navigator.clipboard.writeText(classes);

        const btn = document.getElementById('twCopyBtn');
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        setTimeout(() => btn.innerText = original, 2000);
    }
</script>