function downloadAsImage() {
    const notification = document.querySelector('.notification.success');
    html2canvas(notification).then(canvas => {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'notificacion.png';
        link.click();
    });
}

function downloadAsPDF() {
    const { jsPDF } = window.jspdf;
    const notification = document.querySelector('.notification.success');
    html2canvas(notification).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF();
        pdf.addImage(imgData, 'PNG', 10, 10);
        pdf.save('notificacion.pdf');
    });
}

function hideNotification() {
    document.getElementById("successNotification").style.display = 'none';
}