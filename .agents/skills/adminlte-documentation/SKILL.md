---
name: adminlte-documentation
description: Documenta AdminLTE para desarrolladores que necesitan usar, personalizar o integrar el tema de administración AdminLTE en páginas web y aplicaciones.
---

# AdminLTE Documentation Skill

Usa esta skill cuando el usuario pregunte sobre AdminLTE, su instalación, sus componentes, layouts, plugins integrados o cómo integrarlo en un proyecto web.

## Qué es AdminLTE

AdminLTE es un tema de panel de administración open source construido sobre Bootstrap. Ofrece un conjunto completo de componentes UI listos para usar, layouts responsivos y una colección de plugins de JavaScript para dashboards, tablas, formularios y navegación.

## Características principales

- Basado en Bootstrap 5.3.
- Componentes UI preconstruidos: tarjetas, botones, tablas, formularios, badges, alertas, cajas, pequeñas estadísticas y más.
- Layouts de panel: barra lateral (sidebar), navbar, top-nav, boxed layout, layout fijo y layout de ancho completo.
- Plugins integrados: Chart.js, DataTables, Select2, SweetAlert2, jQuery UI, datepicker, timepicker, Summernote, overlayScrollbars, y más.
- Soporte para temas y skins mediante clases CSS y variables Sass.
- Compatible con dispositivos móviles y pantallas de diferentes tamaños.

## Instalación rápida

### Opción 1: npm

```bash
npm install admin-lte@4
```

### Opción 2: CDN

Incluir CSS y JS desde CDN en el HTML:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4/dist/css/adminlte.min.css">
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4/dist/js/adminlte.min.js"></script>
```

### Opción 3: descarga directa

Descargar el repositorio o paquete oficial y copiar los archivos `dist/css` y `dist/js` a tu proyecto.

## Uso básico

### Estructura HTML mínima

```html
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- ... -->
    </nav>
    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- ... -->
    </aside>
    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <!-- Contenido -->
        </div>
      </section>
    </div>
    <footer class="main-footer">
      <!-- ... -->
    </footer>
  </div>
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
```

## Layouts y opciones de página

- `sidebar-mini`: minimiza la barra lateral.
- `sidebar-collapse`: colapsa la barra lateral.
- `layout-fixed`: fija la barra de navegación y el sidebar.
- `layout-navbar-fixed`: fija la navbar superior.
- `layout-footer-fixed`: fija el pie de página.
- `dark-mode`: habilita modo oscuro.

## Frameworks compatibles

AdminLTE puede integrarse con cualquier backend o stack frontend.

- Laravel: plantillas Blade y paquetes como `jeroennoten/laravel-adminlte`.
- React: uso con componentes y wrappers que cargan CSS/JS de AdminLTE.
- Vue: integración con componentes Vue y páginas SPA.
- Next.js: renderizado SSR / SSG combinando AdminLTE con React.
- Tailwind / Astro / Svelte: se puede usar solo como UI CSS y JS.

## Personalización

- Cambia colores y estilos con variables Sass.
- Modifica el sidebar y la navbar con clases de utilidad.
- Usa `layout-fixed`, `sidebar-mini`, `dark-mode`, `navbar-white`, `sidebar-dark-primary` y otros helpers de clase.
- Ajusta la navegación, los widgets y los elementos del dashboard mediante HTML y data attributes.

## Buenas prácticas

- AdminLTE es un tema UI, no un backend: usa tu propio servidor o framework para datos y lógica.
- Incluye primero `plugins/jquery` y `plugins/bootstrap` antes de `adminlte.min.js`.
- Si necesitas solo estilos, basta con cargar el CSS y no el JS.
- Para usar plugins, carga los archivos JS/CSS requeridos y luego inicializa los componentes según la documentación.

## Enfoque de respuestas

Cuando el usuario pida ayuda sobre AdminLTE:

- aclarar que AdminLTE es un tema Bootstrap de frontend.
- explicar cómo instalarlo y dónde cargar sus recursos.
- mostrar ejemplos de layout básicos si pide HTML.
- no confundirlo con un sistema administrativo completo.
- dirigir a la documentación oficial para detalles de componentes: `https://adminlte.io/docs`.

## Referencias

- https://adminlte.io/
- https://adminlte.io/docs
