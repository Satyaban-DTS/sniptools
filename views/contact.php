<?php include_once __DIR__ . '/../includes/header.php'; ?>
<?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

<main class="flex-1 overflow-y-auto bg-[#f8f9fc] dark:bg-[#0f111a] p-6 lg:p-8 custom-scrollbar">
    <div class="max-w-4xl mx-auto min-h-[calc(100vh-250px)]">
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 lg:p-12 mb-12">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">Contact Us</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Have questions or feedback? We'd love to hear from you.</p>

            <form id="contactForm" onsubmit="submitContactForm(event)" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Your
                            Name</label>
                        <input type="text" name="name" required
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all dark:text-white"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email
                            Address</label>
                        <input type="email" name="email" required
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all dark:text-white"
                            placeholder="john@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Message</label>
                    <textarea name="message" required rows="6"
                        class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all dark:text-white"
                        placeholder="How can we help you?"></textarea>
                </div>

                <div id="formStatus" class="hidden p-4 rounded-2xl text-sm font-medium"></div>

                <button type="submit" id="submitBtn"
                    class="w-full py-4 bg-primary text-white rounded-2xl font-bold uppercase tracking-wider hover:scale-[1.01] active:scale-95 transition-all shadow-xl shadow-primary/20 flex items-center justify-center">
                    <span>Send Message</span>
                </button>
            </form>
        </div>
    </div>
    <div class="pb-10"></div>
    <?php include_once __DIR__ . '/../includes/visual_footer.php'; ?>
</main>

<script>
    function submitContactForm(e) {
        e.preventDefault();
        const form = e.target;
        const btn = document.getElementById('submitBtn');
        const status = document.getElementById('formStatus');
        const btnText = btn.querySelector('span');

        btn.disabled = true;
        btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';

        const formData = {
            name: form.name.value,
            email: form.email.value,
            message: form.message.value,
            type: 'contact'
        };

        fetch('<?php echo url("api/submit_feedback.php"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    status.innerHTML = 'Thanks! Your message has been sent successfully. We will get back to you soon.';
                    status.className = 'p-4 rounded-2xl text-sm font-medium bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400';
                    status.classList.remove('hidden');
                    form.reset();
                    btnText.innerText = 'Sent Successfully!';
                    btn.classList.add('bg-green-500');
                } else {
                    throw new Error(data.error || 'Failed to send message');
                }
            })
            .catch(err => {
                status.innerHTML = err.message || 'Something went wrong. Please try again later.';
                status.className = 'p-4 rounded-2xl text-sm font-medium bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400';
                status.classList.remove('hidden');
                btn.disabled = false;
                btnText.innerText = 'Try Again';
            });
    }
</script>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>