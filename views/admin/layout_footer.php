</div> <!-- end adminContent -->
</main>

<!-- Global Context Confirmation Modal -->
<div id="globalConfirmModal"
    class="fixed inset-0 bg-secondary/80 backdrop-blur-md z-[100] hidden items-center justify-center p-6 transition-all duration-300">
    <div
        class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl max-w-md w-full p-10 transform scale-95 transition-all text-center">
        <div id="gConfirmIconContainer"
            class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
            <i id="gConfirmIcon" class="fas fa-exclamation-triangle text-3xl"></i>
        </div>
        <h2 id="gConfirmTitle" class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight mb-3">
            Confirm Action</h2>
        <p id="gConfirmMessage" class="text-sm text-gray-400 dark:text-gray-400 mb-8 font-medium italic"></p>

        <div class="flex space-x-4">
            <button type="button" onclick="closeGlobalConfirm()"
                class="flex-1 py-4 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-2xl font-black text-sm hover:bg-gray-200 transition-all">
                Abort
            </button>
            <button type="button" id="gConfirmSubmitBtn"
                class="flex-1 py-4 bg-red-500 text-white rounded-2xl font-black text-sm hover:scale-[1.02] transition-all shadow-xl shadow-red-500/20">
                Execute
            </button>
        </div>
    </div>
</div>

<script>
    let globalConfirmCallback = null;

    function showGlobalConfirm({ title, message, icon, color, confirmText, onConfirm }) {
        const modal = document.getElementById('globalConfirmModal');
        const titleEl = document.getElementById('gConfirmTitle');
        const messageEl = document.getElementById('gConfirmMessage');
        const iconEl = document.getElementById('gConfirmIcon');
        const iconContainer = document.getElementById('gConfirmIconContainer');
        const submitBtn = document.getElementById('gConfirmSubmitBtn');

        titleEl.textContent = title || 'Confirm Action';
        messageEl.innerHTML = message || 'Are you sure you want to proceed?';
        iconEl.className = `fas ${icon || 'fa-exclamation-triangle'} text-3xl`;

        // Color Theme
        if (color === 'primary') {
            iconContainer.className = "w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 text-primary";
            submitBtn.className = "flex-1 py-4 bg-primary text-white rounded-2xl font-black text-sm hover:scale-[1.02] transition-all shadow-xl shadow-primary/20";
        } else {
            iconContainer.className = "w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500";
            submitBtn.className = "flex-1 py-4 bg-red-500 text-white rounded-2xl font-black text-sm hover:scale-[1.02] transition-all shadow-xl shadow-red-500/20";
        }

        submitBtn.textContent = confirmText || 'Execute';
        globalConfirmCallback = onConfirm;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => modal.children[0].classList.remove('scale-95'), 10);
    }

    function closeGlobalConfirm() {
        const modal = document.getElementById('globalConfirmModal');
        modal.children[0].classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    document.getElementById('gConfirmSubmitBtn').addEventListener('click', () => {
        if (globalConfirmCallback) globalConfirmCallback();
        closeGlobalConfirm();
    });

    // Mobile Sidebar Logic
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const adminSidebar = document.getElementById('adminSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    const toggleMenu = () => {
        adminSidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
    };

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleMenu);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleMenu);

    // Sidebar resize logic (avoiding FOUC)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            adminSidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        }
    });

    window.onclick = function (event) {
        if (event.target == document.getElementById('globalConfirmModal')) closeGlobalConfirm();
    }
</script>
</body>

</html>