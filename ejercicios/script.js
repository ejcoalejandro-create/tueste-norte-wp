/* ===== Interacción 1: mostrar/ocultar los detalles de la cata ===== */

// 1. SELECCIONAR: guardamos referencias a los elementos que necesitamos.
const btnDetallesCata = document.getElementById('btn-detalles-cata');
const detallesCata = document.getElementById('detalles-cata');

// 2. ESCUCHAR: reaccionamos al evento "click" sobre el botón.
btnDetallesCata.addEventListener('click', function () {
    // 3. REACCIONAR: alternamos la clase que oculta el bloque de detalles.
    // classList.toggle() la quita si estaba puesta y la pone si no lo estaba.
    detallesCata.classList.toggle('oculto');

    // Comprobamos si, tras el toggle, el bloque ha quedado visible.
    const estaVisible = !detallesCata.classList.contains('oculto');

    // Cambiamos el texto del botón para que tenga sentido con el nuevo estado.
    btnDetallesCata.textContent = estaVisible
        ? 'Ocultar detalles de la próxima cata'
        : 'Ver detalles de la próxima cata';

    // aria-expanded informa a lectores de pantalla de si el contenido
    // que controla el botón está abierto o cerrado.
    btnDetallesCata.setAttribute('aria-expanded', estaVisible);
});


/* ===== Interacción 2: avisar interés por la suscripción ===== */

// 1. SELECCIONAR
const btnSuscripcion = document.getElementById('btn-suscripcion');
const mensajeSuscripcion = document.getElementById('mensaje-suscripcion');

// 2. ESCUCHAR
btnSuscripcion.addEventListener('click', function () {
    // 3. REACCIONAR: escribimos el mensaje de confirmación...
    mensajeSuscripcion.textContent = 'Genial, te avisaremos en cuanto abramos la suscripción.';

    // ...y desactivamos el botón para que quede claro que ya se ha registrado
    // el interés y evitar que se pulse varias veces sin motivo.
    btnSuscripcion.disabled = true;
});
