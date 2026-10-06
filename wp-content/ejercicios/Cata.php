<?php
// Array donde iremos acumulando los mensajes de error, si los hay.
$errores = [];

// --- Recogida de datos ---
// trim() quita espacios en blanco al principio/final (así " " no cuenta como nombre válido).
// El operador ?? '' evita un error si 'nombre' no llegó en el POST (ej: petición manipulada).
$nombre = trim($_POST['nombre'] ?? '');
$plazasCrudo = $_POST['plazas'] ?? '';

// --- Validación del nombre ---
// Con el campo ya recortado, si queda vacío es que no escribieron nada útil.
if ($nombre === '') {
    $errores[] = 'El nombre no puede estar vacío.';
}

// --- Validación de las plazas ---
// filter_var con FILTER_VALIDATE_INT comprueba que sea un entero Y que esté en el rango indicado.
// Si no cumple (no es número, tiene decimales, está fuera de rango, o falta), devuelve false.
$plazas = filter_var($plazasCrudo, FILTER_VALIDATE_INT, [
    'options' => [
        'min_range' => 1,
        'max_range' => 4,
    ],
]);

if ($plazas === false) {
    $errores[] = 'El número de plazas debe ser un número entero entre 1 y 4.';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tueste Norte - Resultado de la reserva</title>
    <link rel="stylesheet" href="ficha-cata.css">
</head>

<body>
    <header class="cabecera">
        <h1>Tueste Norte</h1>
        <p>Resultado de tu reserva</p>
        <nav>
            <a href="index.html">Inicio</a>
            <a href="Cata.html">Volver al formulario</a>
        </nav>
    </header>

    <main>
        <section>
            <?php if (!empty($errores)): ?>
                <!-- Si hay errores, los listamos todos y ofrecemos un enlace para corregir -->
                <h2>Hemos encontrado algún problema</h2>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <!-- htmlspecialchars() por si algún día un error incluyera texto del usuario -->
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><a href="Cata.html">Volver al formulario</a></p>
            <?php else: ?>
                <!-- Todo correcto: mostramos el mensaje de confirmación.
                     htmlspecialchars($nombre) es OBLIGATORIO aquí: $nombre viene del usuario
                     y lo estamos imprimiendo tal cual en el HTML. Sin esto, alguien podría
                     escribir código HTML/JS en el campo nombre y se ejecutaría en la página
                     (ataque XSS). htmlspecialchars() convierte < > " ' & en su versión segura. -->
                <h2>¡Reserva confirmada!</h2>
                <p>
                    ¡Hecho, <?php echo htmlspecialchars($nombre); ?>!
                    Te hemos reservado <?php echo $plazas; ?>
                    <?php echo $plazas === 1 ? 'plaza' : 'plazas'; ?> para la próxima cata.
                </p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>Tueste Norte — Café de especialidad</p>
    </footer>
</body>

</html>