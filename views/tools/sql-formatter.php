<?php
// web/views/tools/sql-formatter.php
?>
<script src="https://cdn.jsdelivr.net/npm/sql-formatter@12.2.4/dist/sql-formatter.min.js"></script>

<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Input -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="sqlInput" class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Minified
                    SQL</label>
                <div class="flex space-x-4">
                    <select id="dialect"
                        class="bg-transparent text-[10px] font-black text-primary uppercase tracking-widest border-none outline-none cursor-pointer">
                        <option value="sql">Standard SQL</option>
                        <option value="mysql">MySQL</option>
                        <option value="postgresql">PostgreSQL</option>
                        <option value="sqlite">SQLite</option>
                    </select>
                    <button onclick="clearSQL()"
                        class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-all">Clear</button>
                </div>
            </div>
            <textarea id="sqlInput" rows="12"
                placeholder="SELECT * FROM users WHERE id = 1 AND status = 'active' ORDER BY created_at DESC;"
                class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent focus:border-primary/20 outline-none text-sm font-mono leading-relaxed transition-all custom-scrollbar"></textarea>
        </div>

        <!-- Output -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <label for="sqlOutput" class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Beautified
                    SQL</label>
                <button onclick="copySQL()" id="sqlCopyBtn"
                    class="text-[10px] font-black text-primary hover:text-accent uppercase tracking-widest transition-all">Copy
                    SQL</button>
            </div>
            <textarea id="sqlOutput" rows="12" readonly placeholder="Formatted query will appear here..."
                class="w-full p-6 pb-20 rounded-[2.5rem] bg-gray-50 dark:bg-gray-900/50 border-2 border-transparent outline-none text-sm font-mono leading-relaxed transition-all custom-scrollbar text-gray-600 dark:text-gray-300"></textarea>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-center pt-4">
        <button onclick="formatSQL()"
            class="w-full max-w-md py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
            <i class="fas fa-magic mr-2"></i> Beautify Query
        </button>
    </div>
</div>

<script>
    function formatSQL() {
        const input = document.getElementById('sqlInput').value.trim();
        if (!input) return;

        const dialect = document.getElementById('dialect').value;

        try {
            const formatted = window.sqlFormatter.format(input, {
                language: dialect,
                uppercase: true,
                indent: '  '
            });
            document.getElementById('sqlOutput').value = formatted;
        } catch (e) {
            document.getElementById('sqlOutput').value = 'Error: Could not format query. Check your syntax.';
        }
    }

    function clearSQL() {
        document.getElementById('sqlInput').value = '';
        document.getElementById('sqlOutput').value = '';
    }

    function copySQL() {
        const output = document.getElementById('sqlOutput');
        if (!output.value) return;

        output.select();
        document.execCommand('copy');

        const btn = document.getElementById('sqlCopyBtn');
        const original = btn.innerText;
        btn.innerText = 'COPIED!';
        setTimeout(() => btn.innerText = original, 2000);
    }
</script>