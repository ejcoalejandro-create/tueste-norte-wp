// Guardamos referencias a los tres elementos con los que vamos a trabajar,
// para no tener que buscarlos en el DOM cada vez.
const inputPrecio = document.getElementById('precio-paquete');
const btnCalcular = document.getElementById('btn-calcular');
const parrafoResultado = document.getElementById('resultado');

// Función que hace todo el trabajo: leer, validar, calcular y escribir el resultado.
function calcularPrecioPorKilo() {
    // parseFloat convierte el texto del campo en número decimal.
    // Si el campo está vacío o tiene texto no numérico, devuelve NaN ("Not a Number").
    const precioPaquete = parseFloat(inputPrecio.value);

    // Comprobamos dos cosas a la vez:
    // 1) isNaN(precioPaquete) -> true si no es un número válido
    // 2) precioPaquete <= 0   -> true si es cero o negativo (no tiene sentido un precio así)
    if (isNaN(precioPaquete) || precioPaquete <= 0) {
        parrafoResultado.textContent = 'Introduce un precio válido (un número mayor que 0).';
        return; // Salimos de la función, no seguimos calculando nada.
    }

    // Un paquete es de 250 g, así que un kilo son 4 paquetes de 250 g.
    // Por eso el precio por kilo es el precio del paquete multiplicado por 4.
    const precioPorKilo = precioPaquete * 4;

    // toFixed(2) redondea y formatea el número a 2 decimales (devuelve un texto, ej: "17.00").
    parrafoResultado.textContent = `Precio por kilo: ${precioPorKilo.toFixed(2)} €`;
}

// Al hacer click en el botón, ejecutamos la función de cálculo.
btnCalcular.addEventListener('click', calcularPrecioPorKilo);

// Extra: permitir pulsar Enter dentro del campo para calcular sin tocar el botón.
inputPrecio.addEventListener('keydown', function (evento) {
    // 'Enter' es el nombre que da el navegador a la tecla Enter/Intro.
    if (evento.key === 'Enter') {
        calcularPrecioPorKilo();
    }
});