// Add interactive functionality
document.addEventListener('DOMContentLoaded', function () {
    // Confirmation dialog for delete actions
    const deleteButtons = document.querySelectorAll('form[action*="delete"] button, a[onclick*="confirm"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this?')) {
                e.preventDefault();
            }
        });
    });

    // Toggle mobile menu (if needed)
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
});