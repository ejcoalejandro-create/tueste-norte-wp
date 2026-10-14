1.	 Tueste Norte — WordPress (semana 3)

Web de **Tueste Norte**, tostadero de café de especialidad, montada con WordPress en local sobre XAMPP.
En esta entrega la web tiene **tema propio hecho desde cero** (sin tema padre) y **dos plugins propios**: uno que define los cafés como tipo de contenido y los expone por la API REST, y otro que permite elegir cada semana el «tueste de la semana».

URL local: `http://localhost/tueste-norte-wp/`
PHP con el que se ha desarrollado y probado: **8.2.12**

## Estructura del proyecto

Tema propio: `wp-content/themes/tueste-norte-tema/` - Tema desde cero, sin `Template:` ni tema padre.
Plugin de cafés: `wp-content/plugins/tueste-norte-cafes/` - Registra el CPT `cafe` y el campo `ficha` en la API REST.
Plugin del tueste: `wp-content/plugins/tueste-norte-tueste-semana/` - Pantalla de admin para elegir el café destacado.
Imágenes: `wp-content/uploads/` - Fotos de los cafés y del contenido.
Base de datos: `db/tueste-norte.sql` - Páginas, cafés, menús, ajustes y usuarios .
Ejercicios: `ejercicios/` - Ejercicios de las semanas anteriores (fuera de WordPress).

2.	Plantillas del tema

* `style.css`  Cabecera del tema y toda la identidad visual 
* `functions.php`  Soporte del tema, menú y CSS encolado con `wp_enqueue_style` 
*`header.php` / `footer.php`  Estructura común, con `wp_head()` y `wp_footer()` 
* `index.php`  Listado del blog y plantilla de último recurso 
* `front-page.php`  Portada, con la pizarra del tueste de la semana 
* `page.php`  Páginas (Quiénes somos, Contacto…) 
* `single.php`  Entradas del blog 
* `single-cafe.php`  Ficha de un café (campos ACF, con comprobación de vacíos y salida escapada) 
* `archive-cafe.php`  Catálogo de cafés, con paginación 


3.	Cómo activar el tema y los plugins

1. **Plugins → Plugins instalados:** activar *Tueste Norte – Cafés*, *Tueste Norte – Tueste de la semana* y *Advanced Custom Fields*.
2. **Apariencia → Temas:** activar *Tueste Norte Tema*.
3. **Ajustes → Enlaces permanentes → Guardar cambio s** (sin cambiar nada). Regenera las reglas de URL; sin esto, las páginas de los cafés dan 404.
4. **Apariencia → Menús:** asignar el menú *Principal* a la ubicación *Menú principal*. El enlace «Cafés» apunta a `/cafes/`.
5. **Cafés → Tueste de la semana:** elegir el café destacado y guardar.

4.	Decisiones técnicas

Por qué el CPT está en un plugin y no en el tema

Los datos (los cafés) tienen que sobrevivir a un cambio de diseño. Si el tipo de contenido viviera en el tema, al cambiar de tema, o al hacer una web nueva encima de la API, el catálogo desaparecería del admin. Además, los cafés tienen su propia sección en el menú del administrador, separada de las entradas del blog, lo que evita que se borren por error al limpiar noticias.

5.	El tueste de la semana

Marta elige un café cada semana y lo escribe en una pizarra de la tienda. La web lo refleja desde
Cafés → Tueste de la semana: un desplegable con todos los cafés y un botón Guardar.

 Casilla «destacado» en cada café | Se pueden marcar dos cafés o ninguno por error 
 Categoría «Destacado» | Mismo problema que la casilla 
 Página de opciones de ACF | Es una función de pago (ACF Pro) 
 Desplegable con un único valor guardado: Solo puede haber un café elegido; se cambia cada lunes sin tocar código. 

El ID del café elegido se guarda en una opción de WordPress (`tn_tueste_semana_id`). Al cambiarla se actualizan a la vez
la portada, el catálogo y la API.

6.	Identidad visual: la pizarra

La web no parte de ninguna plantilla. El elemento propio es la pizarra de la tienda: la portada
reproduce la pizarra donde ya anuncian el tueste de la semana (fondo verde oscuro, marco de madera, letra tipo tiza).
Los colores salen del café y del papel: marrón `#2b1d12`, crema `#faf6f1` y un acento tostado `#b4541a`, con tipografía serif del sistema (Georgia) para no cargar fuentes externas.

7.	API REST

El CPT `cafe` está expuesto con `rest_base => 'cafes'`. Además de los campos estándar (título, contenido, extracto, imagen), el plugin añade el campo `ficha` con los datos de ACF y la URL de la imagen destacada, y `tueste_semana`.

GET http://localhost/tueste-norte-wp/wp-json/wp/v2/cafes?_fields=id,title,ficha,tueste_semana

 
Fragmento de la respuesta real de esta instalación (uno de los cuatro cafés):

```json
{
  "id": 75,
  "title": { "rendered": "Amanecer" },
  "ficha": {
    "origen": "Etiopía — Yirgacheffe",
    "notas_cata": "Jazmín, bergamota y un final largo que recuerda al té negro.",
    "nivel_tueste": "claro",
    "precio": 12.5,
    "imagen": "http://localhost/tueste-norte-wp/wp-content/uploads/2026/10/images-1.jpg"
  },
  "tueste_semana": true
}
```

8.	Cafés (contenido)

Cuatro cafés publicados, cada uno con foto y todos los campos rellenos:

Amanecer | Etiopía — Yirgacheffe | Claro | 12,50 € 
Tierra Alta | Colombia — Huila | Medio | 10,90 € 
Fondo de Casa | Brasil — Cerrado | Medio | 9,50 € 
Ceniza Volcánica | Guatemala — Antigua | Oscuro | 11,20 € 

Campos del grupo ACF Ficha de café (ubicación: Tipo de contenido = Café): `origen` (texto), `notas_cata` (área de texto), `nivel_tueste` (selección: claro / medio / oscuro) y `precio` (número).

9.	Restaurar el proyecto desde cero (XAMPP)

1. Instala XAMPP (PHP 8.x) y arranca Apache y MySQL.
2. Descarga WordPress en español desde es.wordpress.org y descomprímelo en `C:\xampp\htdocs\tueste-norte-wp\`.
3. Clona este repositorio en otra carpeta y copia su `wp-content` sobre el de WordPress, sustituyéndolo.
   Así llegan el tema, los dos plugins propios y las imágenes. Copia también la carpeta `db/`.
4. En phpMyAdmin crea la base de datos `tueste_norte` (cotejamiento `utf8mb4_general_ci`) e importa `db/tueste-norte.sql`.
5. Copia `wp-config-sample.php` como `wp-config.php` y edita: `DB_NAME` = `tueste_norte`, `DB_USER` = `root`,
   `DB_PASSWORD` vacía, `DB_HOST` = `localhost`. Añade `define( 'WP_DEBUG', true );`.
6. Entra en `http://localhost/tueste-norte-wp/wp-admin`. En Plugins → Añadir nuevo instala y activa
   ACF, Contact Form 7, Flamingo y Yoast SEO. Los dos plugins propios ya aparecen en la lista: actívalos.
7. Apariencia → Temas: activa *Tueste Norte Tema*.
8. Ajustes → Enlaces permanentes → Guardar cambios para regenerar `.htaccess` y las URLs de los cafés.
9. Comprueba que funcionan `http://localhost/tueste-norte-wp/cafes/` y `http://localhost/tueste-norte-wp/wp-json/wp/v2/cafes`.

10.	Usuarios

`root` - Administrador: Montaje y mantenimiento (contraseña facilitada aparte)
 `marta` - Editor: Gestiona textos, fotos, cafés, precios y el tueste de la semana, sin acceso a plugins ni a temas.

