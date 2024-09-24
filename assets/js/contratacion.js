document.addEventListener('DOMContentLoaded', function() {
    // Obtener el elemento de notificación
    const notification = document.querySelector('.notification');
    const okButton = document.getElementById('ok-button');

    // Mostrar la notificación si hay un mensaje
    if (notification) {
        notification.style.display = 'block';
        
        // Manejar el clic en el botón "OK"
        if (okButton) {
            okButton.addEventListener('click', function() {
                notification.style.display = 'none';
            });
        }
    }
});
