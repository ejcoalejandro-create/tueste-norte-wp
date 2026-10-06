# Tueste Norte — Web del tostadero

Landing page para Tueste Norte, un tostadero pequeño de café de especialidad. El
sitio presenta el negocio, los cafés de origen, las catas mensuales, la futura
suscripción de café a domicilio y permite a los clientes escribir a través de un
formulario de contacto validado en el servidor.

## Herramientas utilizadas

- **Visual Studio Code** como editor para todo el código (HTML, CSS, JS y PHP).
- **IA** como apoyo puntual durante el desarrollo: generación de fragmentos de código, revisión de la validación en PHP.
  Todo el código generado ha sido revisado y entendido antes de incluirlo en el
  proyecto.
- **XAMPP** (Apache + PHP) como servidor local, necesario porque el formulario de
  contacto usa PHP y este no se ejecuta abriendo los archivos directamente con
  doble clic (`file://`), solo funciona servido por un servidor web real
  (`http://localhost/...`).
- **Git y GitHub** para llevar el control de versiones y alojar el repositorio del
  proyecto.

## Estructura del proyecto y por qué existe cada archivo

| Archivo | Para qué sirve |
|---|---|
| `index.html` | Página principal (landing). Reúne quiénes somos, los 4 cafés de origen, las catas mensuales, la suscripción y el acceso a contacto. Es el punto de entrada del sitio. |
| `ficha-cata.css` | Hoja de estilos única, compartida por todas las páginas, para que el diseño (colores, tipografía, formularios, botones) sea consistente en todo el sitio y no haya que repetir CSS en cada archivo. |
| `script.js` | JavaScript de `index.html`: controla mostrar/ocultar los detalles de la próxima cata y el aviso de interés en la suscripción. Va en fichero aparte (no incrustado en el HTML) para mantener el contenido y el comportamiento separados. |
| `Cata.html` / `Cata.php` | Formulario para reservar plaza en la cata mensual (nombre y número de plazas). `Cata.php` valida los datos en el servidor y confirma la reserva o muestra los errores. |
| `contacto.html` / `contacto.php` | Formulario de contacto general (nombre, email y mensaje), pedido explícitamente por el cliente para no perder recados. `contacto.php` valida en el servidor que el nombre y el mensaje no estén vacíos y que el email tenga un formato correcto, y responde con un mensaje de agradecimiento o con la lista de errores. |
| `conversor.html` / `conversor.js` | Herramienta interna (no pensada para el cliente final) para calcular el precio por kilo a partir del precio de un paquete de 250 g. Se enlaza de forma discreta desde el pie de página. |
| `README.md` | Este documento. |

### Por qué hay páginas PHP separadas y no solo HTML

Los formularios (`Cata.html`→`Cata.php` y `contacto.html`→`contacto.php`) se envían
con `method="POST"` a un script PHP porque la validación se hace en el **servidor**,
no solo en el navegador. Esto es importante: cualquiera puede saltarse las
validaciones del HTML (el atributo `required`, por ejemplo, se puede quitar con las
herramientas de desarrollador), así que si la validación solo estuviera en el
navegador, datos vacíos o incorrectos podrían llegar igualmente. Por eso `Cata.php`
y `contacto.php` vuelven a comprobar todo con PHP antes de dar por buena la reserva
o el mensaje, y todo dato que el usuario ha escrito se imprime siempre pasado por
`htmlspecialchars()`, para evitar que alguien pueda meter código HTML/JavaScript en
un campo de texto y que se ejecute en la página (ataque XSS).

## Cómo arrancarlo en local con XAMPP

Sigue estos pasos aunque no hayas visto el proyecto antes.

### 1. Requisitos

- Tener [XAMPP](https://www.apachefriends.org/) instalado, con el módulo **Apache**
  (no hace falta MySQL para este proyecto).

### 2. Coloca la carpeta del proyecto dentro de `htdocs`

XAMPP solo sirve por `http://` lo que está dentro de su carpeta `htdocs`. Copia (o
clona desde GitHub) toda la carpeta del proyecto ahí, de forma que quede así:

```
C:\xampp\htdocs\Semana1\
├── index.html
├── ficha-cata.css
├── script.js
├── Cata.html
├── Cata.php
├── contacto.html
├── contacto.php
├── conversor.html
├── conversor.js
└── README.md
```

> Importante: todos los archivos deben estar **juntos, en la misma carpeta**. Los
> enlaces y las rutas de CSS/JS (`href="ficha-cata.css"`, `src="script.js"`, etc.)
> son relativos y buscan los archivos ahí mismo.

### 3. Arranca Apache

Abre el **XAMPP Control Panel** y pulsa **Start** en la fila de Apache. Tiene que
quedar en verde. Si no arranca, suele ser porque el puerto 80 lo está usando otro
programa (Skype, IIS, otro Apache...); en ese caso cambia el puerto de Apache a
8080 desde el botón **Config** del panel.

### 4. Abre el sitio por localhost (nunca con doble clic)

En el navegador, entra en:

```
http://localhost/Semana1/index.html
```

(cambia `Semana1` por el nombre real de tu carpeta dentro de `htdocs`).

No abras los archivos haciendo doble clic ni con una ruta que empiece por
`file:///C:/...`: así el navegador no tiene servidor detrás y el PHP no se ejecuta
(verás el código en vez de la página, o un error).

### 5. Prueba el formulario de contacto

1. Desde `index.html`, ve a la sección **Contacto** y pulsa "Ir al formulario de
   contacto" (o entra directamente en
   `http://localhost/Semana1/contacto.html`).
2. **Prueba de validación con errores**: deja el nombre vacío, escribe un email sin
   `@` (por ejemplo `abc`) y deja el mensaje vacío. Pulsa "Enviar mensaje". Deberías
   ver una lista con los tres errores y un enlace para volver al formulario.
3. **Prueba correcta**: rellena los tres campos con datos válidos (por ejemplo,
   nombre "Marta", email "marta@correo.com" y un mensaje cualquiera) y pulsa
   "Enviar mensaje". Deberías ver un mensaje de agradecimiento personalizado con tu
   nombre y tu email.
4. **Prueba saltándote la validación del navegador**: abre las herramientas de
   desarrollador (F12), busca el campo de email en el HTML y quita el atributo
   `required`. Envía el formulario vacío. El PHP debe seguir avisando de los
   errores igualmente, porque la validación real está en el servidor, no solo en
   el navegador.

El formulario de reserva de cata (`Cata.html`) se prueba exactamente igual, con
nombre y número de plazas entre 1 y 4.

### 6. Comprueba que se ve bien en móvil

Con la página abierta, estrecha la ventana del navegador poco a poco, o abre las
herramientas de desarrollador (F12) y activa el modo de dispositivo móvil (icono de
móvil/tablet arriba a la izquierda del panel). El menú y las tarjetas de café deben
reorganizarse en una sola columna sin que nada se corte ni se salga de la pantalla.

## Repositorio

El código está también disponible en GitHub para su seguimiento y control de
versiones:
`https://github.com/ejcoalejandro-create/Semana1`
