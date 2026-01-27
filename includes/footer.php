<?php // includes/footer.php ?>
</div> <!-- end flex-1 overflow-hidden -->

</div> <!-- end flex flex-col -->

<script>
    // Theme Management
    const applyTheme = () => {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    };
    applyTheme();

    const toggleTheme = () => {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.theme = isDark ? 'dark' : 'light';
    };

    const darkModeBtnHeader = document.getElementById('darkModeToggleHeader');
    const darkModeBtnSidebar = document.getElementById('darkModeToggleSidebar');

    if (darkModeBtnHeader) darkModeBtnHeader.addEventListener('click', toggleTheme);
    if (darkModeBtnSidebar) darkModeBtnSidebar.addEventListener('click', toggleTheme);

    // Sidebar Desktop Logic
    const sidebar = document.getElementById('sidebar');
    const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');

    const toggleSidebar = () => {
        if (sidebar) {
            sidebar.classList.toggle('collapsed');
            localStorage.sidebarCollapsed = sidebar.classList.contains('collapsed');
        }
    };

    if (sidebarCollapseBtn) {
        sidebarCollapseBtn.addEventListener('click', toggleSidebar);
    }

    // Restore sidebar state
    if (localStorage.sidebarCollapsed === 'true' && sidebar) {
        sidebar.classList.add('collapsed');
    }

    // Mobile Sidebar Logic
    const sidebarMobileToggle = document.getElementById('sidebarToggleMobile');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    const toggleMobileSidebar = () => {
        if (sidebar) sidebar.classList.toggle('-translate-x-full');
        if (sidebarOverlay) sidebarOverlay.classList.toggle('hidden');
    };

    if (sidebarMobileToggle) sidebarMobileToggle.addEventListener('click', toggleMobileSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleMobileSidebar);

    // Keyboard Shortcuts (/)
    window.addEventListener('keydown', (e) => {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            const searchInput = document.getElementById('mainSearch');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
    });
</script>
</body>

</html>