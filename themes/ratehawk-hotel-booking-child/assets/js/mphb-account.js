// mphb-account.js
document.addEventListener('DOMContentLoaded', function() {
    // Simple password confirmation on client-side (non-critical)
    const form = document.querySelector('.mphb-account-details-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const newPass = document.getElementById('mphb-new-password');
        const confirmPass = document.getElementById('mphb-confirm-new-password');

        if (newPass && confirmPass && newPass.value && confirmPass.value) {
            if (newPass.value !== confirmPass.value) {
                e.preventDefault();
                alert('New password and confirmation do not match.');
                confirmPass.focus();
                return false;
            }
        }
    });
});
