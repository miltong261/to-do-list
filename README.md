# API - to do list

La API de este proyecto es una solución completa para gestionar tareas de manera eficiente. Permite crear, leer, actualizar y eliminar tareas en una lista, facilitando la administración de pendientes en aplicaciones de productividad. Hasta el momento se tiene una versión básica, pero se vienen mejoras. 😊

# Características

- **Gestión de Tareas**: Crear, leer, actualizar, cambiar estado, eliminar (de forma lógica) y restaurar tareas.

# Instalación
- Clonar el repositorio
```
https://github.com/miltong261/to-do-list.git
```
- Navegar al directorio del proyecto
```
cd to-do-list
```
- Instalar las dependencias
```
composer install
```
- Configurar el archivo `.env` con tus credenciales de base de datos y otras configuraciones (zona horaria para guatemala).
```
TIMEZONE='America/Guatemala'
```
- Ejecutar las migraciones y seeders para llenar la tabla con data dummy
```
php artisan migrate --seed
```
- Iniciar el servidor
```
php artisan serve
```

# Uso
Para probar los endpoints, puedes usar herramientas como [Postman](https://www.postman.com/)

# Endpoints y variables de entorno para [Postman](https://www.postman.com/)
En la raíz del proyecto puedes encontrar las colecciones:
```
to do list.postman_collection.json
to-do-list.postman_environment.json
```

# Mejoras (en construcción)
- **Autenticación**: Acceso controlado mediante tokens. 
- **Filtrado y Búsqueda**: Búsqueda de tareas por fecha, estado o palabras clave. 
- **Soporte para Fechas**: Búsqueda tareas dentro de rangos de fechas específicos.
- **Refactorización**: Aplicar buenas prácticas, como implementar patrones de diseño, utilizar un manejador de respuestas y crear recursos de Laravel para enviar la data procesada de manera más clara y comprensible.
