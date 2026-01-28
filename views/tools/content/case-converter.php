<?php
// views/tools/content/case-converter.php
?>
<div class="mt-12 space-y-12">
    <!-- Introduction -->
    <section>
        <h2 class="text-2xl font-black text-secondary dark:text-white mb-4">Introduction</h2>
        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
            The <strong>Case Converter</strong> is a versatile text utility designed to transform your text into any
            case format instantly. Whether you working with code, writing an article, or just need to fix accidental
            caps lock, this tool handles it all client-side for maximum speed and privacy.
        </p>
    </section>

    <!-- How to Use -->
    <section>
        <h2 class="text-2xl font-black text-secondary dark:text-white mb-4">How to Use Case Converter</h2>
        <ol
            class="list-decimal list-inside space-y-3 text-gray-600 dark:text-gray-400 marker:font-bold marker:text-primary">
            <li>Type or paste your text into the main input area.</li>
            <li>Select your desired format from the buttons above (e.g., UPPECASE, lowercase, CamelCase).</li>
            <li>The text will convert instantly.</li>
            <li>Click "Copy to Clipboard" to use the result or "Clear" to start over.</li>
        </ol>
    </section>

    <!-- Key Features -->
    <section>
        <h2 class="text-2xl font-black text-secondary dark:text-white mb-4">Key Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-start">
                <div
                    class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0 mr-4">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <h4 class="font-bold text-secondary dark:text-white">Instant Conversion</h4>
                    <p class="text-sm text-gray-500 mt-1">No server uploads. Text is processed locally in milliseconds.
                    </p>
                </div>
            </div>
            <div class="flex items-start">
                <div
                    class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0 mr-4">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h4 class="font-bold text-secondary dark:text-white">Privacy First</h4>
                    <p class="text-sm text-gray-500 mt-1">Your content never leaves your browser.</p>
                </div>
            </div>
            <div class="flex items-start">
                <div
                    class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0 mr-4">
                    <i class="fas fa-code"></i>
                </div>
                <div>
                    <h4 class="font-bold text-secondary dark:text-white">Developer Friendly</h4>
                    <p class="text-sm text-gray-500 mt-1">Supports programming cases like snake_case, camelCase, and
                        kebab-case.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section>
        <h2 class="text-2xl font-black text-secondary dark:text-white mb-4">Frequently Asked Questions</h2>
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                <h4 class="font-bold text-secondary dark:text-white mb-2">Is there a character limit?</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">No, you can convert as much text as your browser
                    memory allows.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                <h4 class="font-bold text-secondary dark:text-white mb-2">Can I invert the case?</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Yes, use the "Inverse Case" button to flip uppercase
                    to lowercase and vice versa.</p>
            </div>
        </div>
    </section>
</div>