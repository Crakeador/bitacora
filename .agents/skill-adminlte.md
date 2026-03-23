# AdminLTE Skill Documentation

## Descripción
Skill para el desarrollo de componentes y vistas utilizando el tema AdminLTE en el proyecto Bitácora.

## Versión
AdminLTE v2.x (versión utilizada en el proyecto)

---

## 1. Estructura del Tema AdminLTE

### Layout Principal
```
┌─────────────────────────────────────────┐
│           TOP NAVIGATION BAR            │
│  (Logo, Toggle, Messages, Notifications)│
├─────────────┬───────────────────────────┤
│             │                           │
│   SIDEBAR   │      MAIN CONTENT         │
│  (Menu Nav) │      (Content Header)     │
│             │      (Page Content)       │
│             │                           │
├─────────────┴───────────────────────────┤
│              FOOTER                     │
└─────────────────────────────────────────┘
```

### Componentes de Navegación
- **Top Navigation Bar**: Logo, sidebar toggle, notificaciones, mensajes, tareas, perfil de usuario
- **Sidebar**: Menú principal con navegación multinivel
- **Content Header**: Breadcrumbs y título de página
- **Footer**: Información de versión y copyright

---

## 2. Componentes Disponibles

### Widgets (Info Boxes)
```html
<!-- Ejemplo de Info Box -->
<div class="info-box">
  <span class="info-box-icon bg-blue">
    <i class="fa fa-envelope"></i>
  </span>
  <div class="info-box-content">
    <span class="info-box-text">Messages</span>
    <span class="info-box-number">1,410</span>
  </div>
</div>
```

### Paneles (Small Boxes)
```html
<div class="small-box bg-success">
  <div class="inner">
    <h3>150</h3>
    <p>New Orders</p>
  </div>
  <div class="icon">
    <i class="fa fa-shopping-bag"></i>
  </div>
  <a href="#" class="small-box-footer">
    More info <i class="fa fa-arrow-circle-right"></i>
  </a>
</div>
```

### Tablas
- **Simple Tables**: Tablas básicas con estilos Bootstrap
- **Data Tables**: Tablas avanzadas con paginación, búsqueda y ordenamiento

### Gráficos (Charts)
- **ChartJS**: Gráficos de barras, líneas, doughnut, pie
- **Morris**: Gráficos de área, línea, barra, donut
- **Flot**: Gráficos personalizados
- **Inline Charts**: Gráficos pequeños inline (sparklines)

### Tabs
```html
<ul class="nav nav-tabs">
  <li class="active"><a href="#tab1" data-toggle="tab">Tab 1</a></li>
  <li><a href="#tab2" data-toggle="tab">Tab 2</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="tab1">Content 1</div>
  <div class="tab-pane" id="tab2">Content 2</div>
</div>
```

### Modales
```html
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Title</h4>
      </div>
      <div class="modal-body">Content</div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
```

### Barras de Progreso
```html
<div class="progress">
  <div class="progress-bar progress-bar-success" style="width: 70%">
    <span class="sr-only">70% Complete</span>
  </div>
</div>

<!-- Progress bar vertical -->
<div class="progress vertical">
  <div class="progress-bar bg-success" style="height: 70%"></div>
</div>
```

---

## 3. Clases CSS y Estilos Principales

### Clases de Contenedores
| Clase | Descripción |
|-------|-------------|
| `.content-wrapper` | Contenedor principal del contenido |
| `.content-header` | Cabecera de página con breadcrumbs |
| `.container-fluid` | Contenedor fluido Bootstrap |
| `.row` | Fila del grid system |
| `.col-*-*` | Columnas responsive |

### Clases de Componentes
| Clase | Descripción |
|-------|-------------|
| `.box` | Panel/contenedor principal |
| `.box-header` | Cabecera del panel |
| `.box-body` | Cuerpo del panel |
| `.box-footer` | Pie del panel |
| `.box-title` | Título del panel |
| `.box-tools` | Herramientas del panel (botones) |
| `.info-box` | Widget de información |
| `.small-box` | Widget pequeño con icono |

### Clases de Estado
| Clase | Descripción |
|-------|-------------|
| `.callout` | Mensajes informativos |
| `.alert` | Alertas Bootstrap |
| `.label` | Etiquetas |
| `.badge` | Insignias numéricas |

---

## 4. Layout y Grid System

### Sistema de Grid (Bootstrap)
```html
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <!-- Contenido -->
  </div>
</div>
```

### Breakpoints
| Clase | Tamaño |
|-------|--------|
| `.col-xs-*` | Extra pequeño (<768px) |
| `.col-sm-*` | Pequeño (≥768px) |
| `.col-md-*` | Mediano (≥992px) |
| `.col-lg-*` | Grande (≥1200px) |

### Opciones de Layout
1. **Top Navigation**: Navegación superior en lugar de sidebar
2. **Boxed**: Layout en caja con ancho máximo
3. **Fixed**: Sidebar y header fijos
4. **Collapsed Sidebar**: Sidebar colapsado por defecto

---

## 5. Colores y Variantes

### Colores de Fondo (Background)
| Clase | Color | Uso |
|-------|-------|-----|
| `.bg-success` | Verde | Éxito, positivo |
| `.bg-info` | Azul claro | Información |
| `.bg-warning` | Amarillo/Naranja | Advertencia |
| `.bg-danger` | Rojo | Error, peligro |
| `.bg-primary` | Azul | Primario |
| `.bg-secondary` | Gris | Secundario |
| `.bg-dark` | Negro/Gris oscuro | Oscuro |
| `.bg-light` | Gris claro | Claro |

### Colores de Texto
| Clase | Descripción |
|-------|-------------|
| `.text-success` | Texto verde |
| `.text-info` | Texto azul claro |
| `.text-warning` | Texto amarillo/naranja |
| `.text-danger` | Texto rojo |
| `.text-primary` | Texto azul |
| `.text-muted` | Texto atenuado |

### Variantes en Componentes
```html
<!-- Small Box variants -->
<div class="small-box bg-success">...</div>
<div class="small-box bg-info">...</div>
<div class="small-box bg-warning">...</div>
<div class="small-box bg-danger">...</div>

<!-- Progress bar variants -->
<div class="progress-bar bg-success">...</div>
<div class="progress-bar bg-info">...</div>
<div class="progress-bar bg-warning">...</div>
<div class="progress-bar bg-danger">...</div>

<!-- Label variants -->
<span class="label label-success">Success</span>
<span class="label label-info">Info</span>
<span class="label label-warning">Warning</span>
<span class="label label-danger">Danger</span>
```

---

## 6. Iconos Disponibles

### Font Awesome (versión incluida)
AdminLTE utiliza **Font Awesome** para iconos. Algunos ejemplos:

| Categoría | Iconos |
|-----------|--------|
| **Usuario** | `fa-user`, `fa-users`, `fa-user-plus` |
| **Comunicación** | `fa-envelope`, `fa-comment`, `fa-comments` |
| **Navegación** | `fa-home`, `fa-dashboard`, `fa-bars` |
| **Estadísticas** | `fa-chart-bar`, `fa-chart-line`, `fa-chart-pie` |
| **Comercio** | `fa-shopping-cart`, `fa-shopping-bag`, `fa-credit-card` |
| **Archivos** | `fa-file`, `fa-folder`, `fa-download`, `fa-upload` |
| **Estado** | `fa-check`, `fa-times`, `fa-exclamation`, `fa-info` |
| **Acciones** | `fa-edit`, `fa-trash`, `fa-save`, `fa-print` |
| **Tiempo** | `fa-clock`, `fa-calendar`, `fa-history` |
| **Multimedia** | `fa-image`, `fa-video`, `fa-music` |

### Uso de Iconos
```html
<i class="fa fa-home"></i>
<span class="fa fa-shopping-cart"></span>
```

---

## 7. Ejemplos de Código para Dashboard y Estadísticas

### Info Boxes (Widgets de Información)
```html
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>150</h3>
        <p>New Orders</p>
      </div>
      <div class="icon">
        <i class="fa fa-shopping-bag"></i>
      </div>
      <a href="#" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>53</h3>
        <p>Bounce Rate</p>
      </div>
      <div class="icon">
        <i class="fa fa-bar-chart"></i>
      </div>
      <a href="#" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>44</h3>
        <p>User Registrations</p>
      </div>
      <div class="icon">
        <i class="fa fa-user-plus"></i>
      </div>
      <a href="#" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>65</h3>
        <p>Unique Visitors</p>
      </div>
      <div class="icon">
        <i class="fa fa-chart-pie"></i>
      </div>
      <a href="#" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>
```

### Gráfico de Área (ChartJS)
```html
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title">Sales Graph</h3>
  </div>
  <div class="box-body">
    <canvas id="salesChart" style="height: 300px;"></canvas>
  </div>
</div>

<script>
  var salesChart = new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Sales',
        data: [65, 59, 80, 81, 56, 55],
        borderColor: 'rgba(75, 192, 192, 1)',
        fill: true
      }]
    }
  });
</script>
```

### Gráfico Donut
```html
<div class="box box-primary">
  <div class="box-header">
    <h3 class="box-title">Donut Chart</h3>
  </div>
  <div class="box-body">
    <canvas id="donutChart" style="height: 250px;"></canvas>
  </div>
</div>

<script>
  var donutChart = new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
      labels: ['Online', 'In-Store', 'Mail-Orders'],
      datasets: [{
        data: [300, 150, 100],
        backgroundColor: ['#00a65a', '#f39c12', '#dd4b39']
      }]
    }
  });
</script>
```

### Barras de Progreso con Porcentaje
```html
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">Tasks Progress</h3>
  </div>
  <div class="box-body">
    <div class="progress-group">
      <span class="progress-text">Custom Template Design</span>
      <span class="progress-number">70/100</span>
      <div class="progress">
        <div class="progress-bar bg-success" style="width: 70%">70%</div>
      </div>
    </div>
    
    <div class="progress-group">
      <span class="progress-text">Update Resume</span>
      <span class="progress-number">95/100</span>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 95%">95%</div>
      </div>
    </div>
    
    <div class="progress-group">
      <span class="progress-text">Laravel Integration</span>
      <span class="progress-number">50/100</span>
      <div class="progress">
        <div class="progress-bar bg-warning" style="width: 50%">50%</div>
      </div>
    </div>
    
    <div class="progress-group">
      <span class="progress-text">Back End Framework</span>
      <span class="progress-number">68/100</span>
      <div class="progress">
        <div class="progress-bar bg-danger" style="width: 68%">68%</div>
      </div>
    </div>
  </div>
</div>
```

### Panel de Chat
```html
<div class="box box-primary direct-chat direct-chat-primary">
  <div class="box-header">
    <h3 class="box-title">Chat</h3>
    <div class="box-tools">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <div class="direct-chat-messages">
      <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">Alexander Pierce</span>
          <span class="direct-chat-timestamp pull-right">1/23/17 3:15 PM</span>
        </div>
        <img class="direct-chat-img" src="user.jpg" alt="User">
        <div class="direct-chat-text">
          Is this template really for free?
        </div>
      </div>
    </div>
    <div class="direct-chat-form">
      <input type="text" class="form-control" placeholder="Type Message">
      <button class="btn btn-primary">Send</button>
    </div>
  </div>
</div>
```

### Lista de Tareas (Todo List)
```html
<div class="box box-primary">
  <div class="box-header">
    <h3 class="box-title">To Do List</h3>
  </div>
  <div class="box-body">
    <ul class="todo-list">
      <li>
        <input type="checkbox" class="minimal">
        <span class="text">Design a nice theme</span>
        <span class="label label-danger pull-right">2 mins</span>
      </li>
      <li>
        <input type="checkbox" class="minimal">
        <span class="text">Make the theme responsive</span>
        <span class="label label-info pull-right">4 hours</span>
      </li>
      <li>
        <input type="checkbox" class="minimal">
        <span class="text">Let theme shine like a star</span>
        <span class="label label-warning pull-right">1 day</span>
      </li>
    </ul>
  </div>
  <div class="box-footer">
    <input type="text" class="form-control" placeholder="Add new item">
    <button class="btn btn-primary pull-right">Add</button>
  </div>
</div>
```

### Calendario
```html
<div class="box box-primary">
  <div class="box-header">
    <h3 class="box-title">Calendar</h3>
    <div class="box-tools">
      <button class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> Add new event
      </button>
    </div>
  </div>
  <div class="box-body">
    <div id="calendar"></div>
  </div>
</div>
```

---

## 8. Componentes Relevantes para Dashboard

### Resumen de Componentes Clave

| Componente | Clase Principal | Uso |
|------------|-----------------|-----|
| **Small Box** | `.small-box` | Métricas principales (ventas, usuarios, etc.) |
| **Info Box** | `.info-box` | Widgets compactos de información |
| **Box/Panel** | `.box` | Contenedor principal de contenido |
| **Chart** | `canvas` + ChartJS | Gráficos estadísticos |
| **Progress Bar** | `.progress` | Barras de progreso y completado |
| **Direct Chat** | `.direct-chat` | Widget de chat |
| **Todo List** | `.todo-list` | Lista de tareas |
| **Timeline** | `.timeline` | Línea de tiempo de actividades |
| **Data Table** | `.dataTable` | Tablas avanzadas |

### Estructura Típica de Dashboard
```html
<!-- Content Header -->
<div class="content-header">
  <h1>Dashboard <small>Control panel</small></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</div>

<!-- Main Content -->
<div class="content">
  <!-- Small Boxes Row -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-success">...</div>
    </div>
    <!-- More small boxes -->
  </div>
  
  <!-- Charts Row -->
  <div class="row">
    <div class="col-md-8">
      <div class="box box-info">
        <div class="box-header"><h3 class="box-title">Sales Graph</h3></div>
        <div class="box-body"><canvas id="chart"></canvas></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header"><h3 class="box-title">Donut Chart</h3></div>
        <div class="box-body"><canvas id="donut"></canvas></div>
      </div>
    </div>
  </div>
  
  <!-- Additional Widgets -->
  <div class="row">
    <div class="col-md-6">
      <div class="box box-solid">
        <div class="box-header"><h3 class="box-title">Tasks Progress</h3></div>
        <div class="box-body">...</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header"><h3 class="box-title">Recent Activity</h3></div>
        <div class="box-body">...</div>
      </div>
    </div>
  </div>
</div>
```

---

## Recursos Adicionales

Para documentación completa y actualizada, visita:
- **Sitio Oficial**: https://adminlte.io
- **Documentación**: https://adminlte.io/docs/
- **Repositorio GitHub**: https://github.com/ColorlibHQ/AdminLTE
- **Demo**: https://adminlte.io/themes/AdminLTE/

---

> **Nota**: Esta documentación se extrajo de la página de demostración. Para información técnica detallada sobre APIs, opciones de configuración y todos los componentes disponibles, consulta la documentación oficial en el sitio de AdminLTE.
