// Show alert for 3 seconds and auto-hide
document.addEventListener('DOMContentLoaded', function () {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    });
});
