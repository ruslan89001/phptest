document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.querySelector('a[href="/logout"]');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            fetch('/logout', { method: 'POST' })
                .then(() => window.location.href = '/');
        });
    }
});