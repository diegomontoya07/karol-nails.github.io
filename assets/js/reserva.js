function mostrarDisponibilidad() {
    const manicurista = document.getElementById('manicurista').value;
    const disponibilidadDiv = document.getElementById('disponibilidad');

    if (manicurista) {
        disponibilidadDiv.style.display = 'block';
    } else {
        disponibilidadDiv.style.display = 'none';
    }

    mostrarHorasDisponibles(); // Para asegurar que el cambio en el manicurista también refresque las horas disponibles.
}

function mostrarHorasDisponibles() {
    const manicurista = document.getElementById('manicurista').value;
    const servicio = document.getElementById('servicio').value;
    const fecha = document.getElementById('fecha').value;
    const selectHora = document.getElementById('hora');

    if (manicurista && servicio && fecha) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "obtener-horas-disponibles.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const horasDisponibles = JSON.parse(xhr.responseText);
                selectHora.innerHTML = '';
                horasDisponibles.forEach(function(hora) {
                    const option = document.createElement('option');
                    option.value = hora;
                    option.textContent = hora;
                    selectHora.appendChild(option);
                });
            }
        };

        xhr.send(`manicurista=${manicurista}&servicio=${servicio}&fecha=${fecha}`);
    } else {
        selectHora.innerHTML = '';
    }
}

function cerrarNotificacion() {
    document.getElementById('notificacion').style.display = 'none';
}

function descargarComoImagen() {
    html2canvas(document.getElementById('notificacion')).then(function(canvas) {
        const link = document.createElement('a');
        link.href = canvas.toDataURL();
        link.download = 'cita.png';
        link.click();
    });
}

function descargarComoPDF() {
    const doc = new jsPDF();
    html2canvas(document.getElementById('notificacion')).then(function(canvas) {
        const imgData = canvas.toDataURL('image/png');
        doc.addImage(imgData, 'PNG', 10, 10);
        doc.save('cita.pdf');
    });
}