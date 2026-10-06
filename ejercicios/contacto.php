<?php
// Array donde iremos acumulando los mensajes de error, si los hay.
$errores = [];

// --- Recogida de datos ---
// trim() quita espacios en blanco al principio/final.
// El operador ?? '' evita un error si algún campo no llegó en el POST (ej: petición manipulada).
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

// --- Validación del nombre ---
if ($nombre === '') {
    $errores[] = 'El nombre no puede estar vacío.';
}

// --- Validación del email ---
// FILTER_VALIDATE_EMAIL comprueba que el texto tenga forma de correo (algo@algo.algo).
// Si está vacío o mal escrito, filter_var devuelve false.
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $errores[] = 'El correo electrónico no tiene un formato válido.';
}

// --- Validación del mensaje ---
if ($mensaje === '') {
    $errores[] = 'El mensaje no puede estar vacío.';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tueste Norte - Tu mensaje</title>
    <link rel="stylesheet" href="ficha-cata.css">
</head>

<body>
    <header class="cabecera">
        <h1>Tueste Norte</h1>
        <p>Tu mensaje</p>
        <nav>
            <a href="index.html">Inicio</a>
            <a href="contacto.html">Volver al formulario</a>
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
                <p><a href="contacto.html">Volver al formulario</a></p>
            <?php else: ?>
                <!-- Todo correcto: mensaje de agradecimiento personalizado.
                     htmlspecialchars() es OBLIGATORIO en $nombre, $email y $mensaje porque son
                     texto escrito por el usuario. Sin esto, alguien podría meter código HTML/JS
                     en cualquiera de esos campos y se ejecutaría en la página (ataque XSS).
                     htmlspecialchars() convierte < > " ' & en su versión segura. -->
                <h2>¡Gracias, <?php echo htmlspecialchars($nombre); ?>!</h2>
                <p>Hemos recibido tu mensaje y te contestaremos a
                    <?php echo htmlspecialchars($email); ?> en cuanto podamos.</p>
                <p>Esto es lo que nos has contado:</p>
                <p>"<?php echo htmlspecialchars($mensaje); ?>"</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>Tueste Norte — Café de especialidad</p>
    </footer>
</body>

</html>
