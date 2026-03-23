Sistema de Gestión de Agentes de Seguridad, Usuarios Administrativos y Clientes
Proyecto PHP 7.4 + MySQL - Versión 1.0.0

🎯 Propósito
Este documento describe la implementación de un sistema web/móvil para gestionar Agentes de Seguridad, Usuarios Administrativos y Clientes en una única interfaz, con soporte para dispositivos móviles y web. Incluye:

Autenticación basada en roles (Agente, Admin, Cliente).
Gestión de departamentos y asignación de usuarios.
Integración con APIs de dispositivos móviles (GPS, Cámara, Almacenamiento).
Diseño responsivo compatible con móviles y escritorio.

🚀 Características Clave
Funcionalidad	Descripción
Autenticación Única	Inicio de sesión para todos los roles desde una misma interfaz.
Gestión de Roles	Permisos diferenciados por rol (Admin: total control; Agente: reportes; Cliente: visualización).
Departamentos	Creación y asignación de usuarios a departamentos (ej: "Seguridad", "Soporte").
GPS en Tiempo Real	Registra la ubicación del agente al crear un reporte (usando Geolocation API).
Cámara y Almacenamiento	Toma fotos desde la cámara del dispositivo y las adjunta a reportes (usando MediaDevices API).
Responsive Design	Interfaz adaptable para móviles (Android/iOS) y web (Bootstrap 5).
Base de Datos Centralizada	Almacena usuarios, roles, departamentos y reportes en MySQL.

⚙️ Stack Técnico
Componente	Versión/Tecnología
Backend	PHP 7.4 (sin frameworks)
Base de Datos	MySQL 8.0
Frontend	Bootstrap 5, HTML5, JavaScript (ES6+)
APIs Móviles	Geolocation API, MediaDevices API, File System API
Servidor	Apache 2.4 (recomendado) o Nginx
Dependencias	php-mysqli, php-json, php-curl

⚠️ Nota de Seguridad: PHP 7.4 ya no recibe actualizaciones de seguridad. Para producción, actualice a PHP 8.1+.

📋 Requisitos Previos
Servidor Linux (Ubuntu 20.04+/CentOS 7+).
PHP 7.4 con módulos: mysqli, curl, json, mbstring.
MySQL 8.0 con usuario administrador.
Acceso a internet para APIs móviles (en dispositivos).

🛠️ Configuración del Proyecto
1. Estructura de Carpetas
bitacora/
├── core/
│   ├── controller/        # Manejo de los controles del sistema
│   ├── app/
│   │   ├── model/         # Modelos de datos 
│   │   ├── layouts/       # Manejo de los perfiles y opciones del menu
│   │   ├── action/        # Acciones para la verificacion de usuarios
│   │   └── view/          # Vista de todas las pantallas
│   ├── ajax/              # Selection de datos e insert sin necesidad de recargas
│   ├── plugins/
│   ├── storage/
│   │   ├── fotos
│   │   ├── horarios
│   │   ├── novedad
│   │   └── aproducto
├── index.php
└── .htacess  # Variables url amigables

3. Configurar la Base de Datos
Almacenada en core/controller/Database.php:


🔐 Seguridad
Contraseñas: Hash con password_hash() (algoritmo bcrypt).
Protección contra inyecciones: Uso de mysqli_real_escape_string().
HTTPS obligatorio: Para evitar robo de credenciales en dispositivos móviles.
Validación de roles: Todos los endpoints verifican el rol del usuario mediante session_start().

📱 Ejemplo de Uso en Dispositivo Móvil
Un Agente abre el sistema en su teléfono.
Crea un reporte usando la cámara para documentar un incidente.
El GPS registra su ubicación exacta al enviar el reporte.
El Admin recibe una notificación en tiempo real con la ubicación en un mapa (Google Maps API).

🐞 Problemas Conocidos
Android < 10: Algunos dispositivos no soportan MediaDevices.getUserMedia().
Batería en GPS: Uso intensivo del GPS puede agotar la batería.
Sincronización offline: Los reportes guardados localmente no se envían si el servidor está caído.

🤝 Contribuir
Fork el repositorio.
Cree una rama: git checkout -b feature/nueva-funcion.
Haga commit: git commit -m "Agrega GPS en reportes".
Envíe un Pull Request.

📄 Licencia
Este proyecto está bajo la licencia MIT. Consulte el archivo LICENSE [blocked] para más detalles.

