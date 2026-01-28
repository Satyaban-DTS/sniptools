<?php
// includes/toast_provider.php
// This file should be included at the end of the <body> or in the header.
?>
<style>
    #toast-container {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        pointer-events: none;
    }

    .toast-item {
        min-width: 300px;
        max-width: 450px;
        padding: 1rem 1.25rem;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        display: flex;
        items-center: center;
        gap: 0.75rem;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: auto;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .dark .toast-item {
        background: #1f2937;
        border-color: rgba(255, 255, 255, 0.05);
        color: white;
    }

    .toast-item.show {
        transform: translateX(0);
    }

    .toast-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .toast-success .toast-icon {
        background: #ecfdf5;
        color: #10b981;
    }

    .toast-error .toast-icon {
        background: #fef2f2;
        color: #ef4444;
    }

    .toast-info .toast-icon {
        background: #eff6ff;
        color: #3b82f6;
    }

    .dark .toast-success .toast-icon {
        background: rgba(16, 185, 129, 0.1);
    }

    .dark .toast-error .toast-icon {
        background: rgba(239, 68, 68, 0.1);
    }

    .dark .toast-info .toast-icon {
        background: rgba(59, 130, 246, 0.1);
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 700;
        font-size: 0.875rem;
    }

    .toast-message {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .dark .toast-message {
        color: #9ca3af;
    }

    @keyframes slideIn {
        from {
            transform: translateX(120%);
        }

        to {
            transform: translateX(0);
        }
    }
</style>

<div id="toast-container"></div>

<script>
    const toastContainer = document.getElementById('toast-container');

    function showToast(message, type = 'success', title = '') {
        if (!title) {
            title = type.charAt(0).toUpperCase() + type.slice(1);
        }

        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;

        let icon = 'fa-check-circle';
        if (type === 'error') icon = 'fa-exclamation-circle';
        if (type === 'info') icon = 'fa-info-circle';

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas ${icon}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        `;

        toastContainer.appendChild(toast);

        // Force reflow for animation
        setTimeout(() => toast.classList.add('show'), 10);

        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 5000);
    }

    <?php
    $flash = get_flash_message();
    if ($flash):
        ?>
                window.addEventListener('DOMContentLoaded', () => {
                    showToast(<?php echo json_encode($flash['message']); ?>, <?php echo json_encode($flash['type']); ?>);
        });
    <?php endif; ?>
</script>