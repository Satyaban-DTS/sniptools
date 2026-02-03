<?php
// includes/feedback-widget.php
?>
<!-- Feedback Trigger -->
<button onclick="document.getElementById('feedbackModal').classList.remove('hidden')"
    class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-white dark:bg-gray-800 text-primary rounded-full shadow-2xl border border-gray-100 dark:border-gray-700 flex items-center justify-center hover:scale-110 hover:bg-primary hover:text-white transition-all duration-300 group">
    <i class="fas fa-comment-alt text-lg group-hover:rotate-12 transition-transform"></i>
</button>

<!-- Feedback Modal -->
<div id="feedbackModal" class="hidden fixed inset-0 z-[100] flex items-end sm:items-center justify-center p-4 sm:p-0">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/20 backdrop-blur-sm transition-opacity"
        onclick="document.getElementById('feedbackModal').classList.add('hidden')"></div>

    <!-- Modal Content -->
    <div
        class="bg-white dark:bg-gray-800 w-full max-w-md rounded-[2rem] shadow-2xl relative z-10 overflow-hidden animate-[fadeIn_0.2s_ease-out]">

        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-accent p-6 text-white relative">
            <button onclick="document.getElementById('feedbackModal').classList.add('hidden')"
                class="absolute top-4 right-4 p-2 bg-white/10 rounded-full hover:bg-white/20 transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>
            <h3 class="text-xl font-black">We value your feedback!</h3>
            <p class="text-primary-100 text-xs mt-1">Help us improve SnipTools for everyone.</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            <form id="feedbackForm" onsubmit="submitFeedback(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Name</label>
                        <input type="text" required
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all dark:text-white"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" required
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all dark:text-white"
                            placeholder="john@example.com">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Feedback</label>
                        <textarea required rows="4"
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all dark:text-white"
                            placeholder="Tell us what you think..."></textarea>
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-8 py-4 bg-secondary dark:bg-white dark:text-secondary text-white rounded-xl font-bold uppercase tracking-wider hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-secondary/10">
                    Send Feedback
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openFeedbackModal(context = '', type = 'feedback') {
        const modal = document.getElementById('feedbackModal');
        const form = document.getElementById('feedbackForm');
        const textarea = form.querySelector('textarea');

        // Store type in form for retrieval during submission
        form.dataset.type = type;

        if (context) {
            textarea.value = `${context} \n\n`;
        } else {
            textarea.value = '';
        }
        modal.classList.remove('hidden');
        textarea.focus();
    }

    function submitFeedback(e) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerText;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';

        const formData = {
            name: form.querySelector('input[type="text"]').value,
            email: form.querySelector('input[type="email"]').value,
            message: form.querySelector('textarea').value,
            type: form.dataset.type || 'feedback'
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
                    btn.innerHTML = '<i class="fas fa-check mr-2"></i> Sent!';
                    btn.classList.add('bg-green-500', 'hover:bg-green-600');
                    showToast("Thanks! Your feedback has been received.");
                    setTimeout(() => {
                        document.getElementById('feedbackModal').classList.add('hidden');
                        e.target.reset();
                        btn.disabled = false;
                        btn.innerText = originalText;
                        btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                    }, 1500);
                } else {
                    showToast(data.error || 'Failed to send', 'error');
                    btn.disabled = false;
                    btn.innerText = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Something went wrong. Please try again.', 'error');
                btn.disabled = false;
                btn.innerText = originalText;
            });
    }
</script>