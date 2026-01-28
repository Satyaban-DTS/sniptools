<?php include_once __DIR__ . '/../includes/header.php'; ?>
<?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-8 custom-scrollbar">
    <div class="max-w-4xl mx-auto min-h-[calc(100vh-250px)]">
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 lg:p-12 mb-12">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-8 tracking-tight">Privacy Policy</h1>

            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                <p class="mb-8 font-bold text-primary uppercase tracking-widest text-xs">Last updated:
                    <?php echo date('F Y'); ?></p>

                <p class="mb-6">
                    At SnipTools, we take your privacy seriously. We understand that when you use developer tools,
                    you're often working with sensitive data. Our platform is designed to be as "local" as possible.
                </p>

                <h2 class="text-2xl font-black text-gray-800 dark:text-white mt-12 mb-6">Data Processing</h2>
                <p class="mb-4">
                    <strong>Client-Side Execution:</strong> The vast majority of our tools (including Image Converters,
                    JWT Decoder, JSON Formatter, etc.) run entirely in your web browser using JavaScript. No data is
                    uploaded to our servers for processing.
                </p>
                <p class="mb-6">
                    <strong>Feedback Interface:</strong> If you choose to submit feedback using our feedback widget, the
                    name, email, and message you provide are sent to and securely stored on our database to allow us to
                    respond to your inquiries.
                </p>

                <h2 class="text-2xl font-black text-gray-800 dark:text-white mt-12 mb-6">Cookies & Storage</h2>
                <p class="mb-6">
                    We use local storage to save your preferences (like dark mode) and to keep track of your recently
                    used tools for convenience. We do not use third-party tracking cookies or sell your data.
                </p>

                <h2 class="text-2xl font-black text-gray-800 dark:text-white mt-12 mb-6">External Links</h2>
                <p class="mb-6">
                    Our site may contain links to external sites that are not operated by us. We have no control over
                    and assume no responsibility for the content, privacy policies, or practices of any third-party
                    sites or services.
                </p>
            </div>
        </div>
    </div>
    <?php include_once __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>