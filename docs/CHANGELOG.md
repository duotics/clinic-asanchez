# Changelog

Todos los cambios relevantes de la aplicación se registran en este archivo.

El formato sigue [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/) y el proyecto usa [Semantic Versioning](https://semver.org/lang/es/):

- **MAJOR**: cambios incompatibles, por ejemplo en la estructura de la base de datos que exige migrar datos, en la versión de PHP o en la forma de desplegar.
- **MINOR**: funcionalidad nueva compatible, como un módulo, una pantalla, un reporte, una variable de `.env` o una columna nueva.
- **PATCH**: correcciones de errores sin funcionalidad nueva.

La versión actual, su fecha y su estado (`alpha`, `beta`, `rc`, `stable`) están en [`docs/VERSION`](VERSION).

## [1.1.1] - 2026-09-23 - beta

### Corregido
- Los documentos con imagen (firma y sello) ya se pueden guardar en el servidor. Antes el filtro de seguridad del hosting (ModSecurity) los bloqueaba con el error "Not Acceptable" porque el editor guardaba la ruta de la imagen como `../../assets/...`. Ahora guarda la dirección completa. Los documentos anteriores se corrigen al abrirlos y presionar ACTUALIZAR.

## [1.1.0] - 2026-09-23 - beta

### Agregado
- Variable `APP_ENV` en `.env` (`DEVELOPMENT` o `PRODUCTION`), expuesta como constante `APP_ENV` en `init.php`.
- Estructura real de la base de datos en `docs/schema.sql`, sin datos.
- Archivo de versión `docs/VERSION` y este changelog.
- La versión, con su estado y la fecha de lanzamiento en un tooltip, se muestra en la barra inferior de todas las páginas y en el login.
- `CLAUDE.md` con el entorno, la arquitectura y las convenciones del proyecto.

### Cambiado
- El modo debug global (`$vD`) solo se activa cuando `APP_ENV` es `DEVELOPMENT`. Antes estaba siempre activo.
- `temp/` se ignora en git y se actualizó `package-lock.json`.

### Corregido
- Avisos (notices) de PHP en todos los módulos: variables e índices sin definir, claves de arrays sin comillas y constantes sin comillas.
- Errores de parseo por depender de `short_open_tag` (`<?`) en `com_iess`, `com_types` y otros archivos.
- Errores SQL fatales en el filtro de fecha del reporte de procedencia de pacientes y en el filtro por tipo de la lista de documentos.
- Guardado manual de los reportes obstétricos y ecográficos.
- Enlaces a fotos de empleados, productos y pacientes.
- Columna de auditoría incorrecta en la lista de formatos de documentos.
- Columna de usuario incorrecta en la cabecera de permisos de usuario.
- Breadcrumb con el nombre del paciente copiado por error en 5 módulos que no corresponden.
- Variable `$id` sin definir e include del footer con mayúsculas incorrectas en el formulario de contenedores de menú.

### Eliminado
- Archivo de registro de errores obsoleto.

### Seguridad
- Se bloqueó el acceso web a `docs/` para que no se pueda descargar la estructura de la base de datos.

## [1.0.0] - 2023-09-01 - stable

Versión base: el estado de la aplicación en producción antes de empezar a registrar versiones.
