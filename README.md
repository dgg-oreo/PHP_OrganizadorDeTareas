# Sistema Organizador de Tareas Escolares

<img width="400" height="225" alt="Screencast From 2026-10-16 15-11-26" src="https://github.com/user-attachments/assets/a28e02e7-1704-4e9e-8a61-52c23d35c3ab" />


Aplicación web desarrollada con **CodeIgniter 4 (PHP)** para organizar las tareas académicas de un curso. Proyecto del curso de Algoritmos, Ingeniería en Sistemas de Información y Ciencias de la Computación, Universidad Mariano Gálvez de Guatemala.

## Descripción

La profesora y los alumnos acceden a un sistema centralizado donde pueden registrarse, iniciar sesión, administrar su perfil y gestionar tareas. Los administradores pueden además gestionar a todos los usuarios.

## Entorno de desarrollo

- Sistema operativo: **Fedora Linux**
- CodeIgniter **4.7.5**
- MySQL **8.4**
- Servidor de desarrollo: `php spark serve`

## Funcionalidades

- Pantalla de bienvenida con mensaje visible.
- Cambio de idioma **English / Español** en toda la interfaz.
- Registro de usuarios con validaciones.
- Inicio y cierre de sesión con mensajes de confirmación y opción **Remember me**.
- Perfil: ver datos, editar (pide la contraseña antes), cambiar contraseña, subir y eliminar imagen de perfil (con confirmación y avatar por defecto).
- Gestión de usuarios (solo administradores): listado paginado Newer/Older, crear, ver, editar y eliminar.
- Gestión de tareas: crear, ver, editar y eliminar, con búsqueda por palabra clave y paginación Newer/Older. Cada usuario ve solo sus tareas; el administrador ve todas.

## Seguridad

- Contraseñas almacenadas con `password_hash()` (nunca en texto plano).
- Filtros de acceso: `auth` (requiere sesión) y `admin` (requiere ser administrador).
- Un administrador no puede eliminarse ni quitarse sus propios permisos.
- Validación de tipo y tamaño (máx. 2 MB) en las imágenes subidas.
- "Remember me" guarda en la base de datos solo el hash del token.

## Requisitos

| Componente | Versión |
|---|---|
| PHP | 8.2 o superior (verifica con `php -v`) |
| MySQL o MariaDB | 8.x / 10.x |
| Git | cualquiera reciente |

Extensiones de PHP necesarias: `intl`, `mbstring`, `mysqlnd`, `xml`, `curl`, `zip`.

> No se necesita Composer: el repositorio ya incluye la carpeta `system/` del framework.

## Instalación



### 1. Instalar dependencias

**Fedora** (entorno donde se desarrolló):

```bash
sudo dnf install -y git php php-cli php-mysqlnd php-intl php-mbstring php-xml php-zip community-mysql-server
sudo systemctl enable --now mysqld
php -v
```

### 2. Clonar el repositorio

```bash
git clone https://github.com/dgg-oreo/PHP_OrganizadorDeTareas.git
cd PHP_OrganizadorDeTareas
```

### 3. Crear la base de datos

```bash
sudo mysql
```

```sql
CREATE DATABASE tareas_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'tareas_user'@'localhost' IDENTIFIED BY 'Tareas2026';
GRANT ALL PRIVILEGES ON tareas_db.* TO 'tareas_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Configurar el entorno

Crea un archivo .env en la raiz del proyecto

Deja estas líneas **sin `#` al inicio**:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = tareas_db
database.default.username = tareas_user
database.default.password = Tareas2026
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5. Crear las tablas y el usuario administrador

```bash
php spark migrate
php spark db:seed UserSeeder
```

### 6. Dar permisos de escritura (si hace falta)

```bash
mkdir -p public/uploads/avatars
chmod -R 775 writable public/uploads
```

### 7. Ejecutar la aplicación

```bash
php spark serve
```

Abre `http://localhost:8080` en el navegador.

## Usuario de prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | `admin@gmail.com` | `admin123` |

Los usuarios que se registran desde **Sign up** son usuarios normales (no administradores).

## Rutas principales

| Ruta | Descripción | Acceso |
|---|---|---|
| `/` | Bienvenida | Público |
| `/lang/en`, `/lang/es` | Cambio de idioma | Público |
| `/signup` | Registro | Público |
| `/login`, `/logout` | Inicio y cierre de sesión | Público |
| `/profile` | Perfil y sus acciones | Sesión iniciada |
| `/tasks` | Gestión de tareas | Sesión iniciada |
| `/users` | Gestión de usuarios | Administrador |

## Estructura del proyecto

```
app/
├── Config/          Rutas (Routes.php), filtros (Filters.php) y configuración
├── Controllers/     Auth, Home, Lang, Profile, Tasks, Users
├── Database/
│   ├── Migrations/  Tablas users y tasks
│   └── Seeds/       UserSeeder (administrador inicial)
├── Filters/         InitFilter, AuthFilter, AdminFilter
├── Language/        Textos en inglés (en) y español (es)
├── Models/          UserModel, TaskModel
└── Views/           Vistas y layout base
public/              Único directorio accesible desde el navegador
writable/            Logs, caché y sesiones
```

#
