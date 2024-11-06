# Sistema de Gestión de Resoluciones CBVP

Sistema de gestion de resoluciones desarrollo con laravel utilizando ademas el paquete filament

## Tecnologías
- Laravel 11
- Filament 3 

## Requisitos previos

- PHP 8.2 o superior
- Composer
- Una base de datos compatible (MySQL, PostgreSQL, SQLite, etc.) por defecto usamos mysql

## Instalación

1. Clona el repositorio:

  ``bash
  git clone https://github.com/rniz06/cbvpresoluciones.git

2. En el directorio Instala las dependencias de Composer:
    composer install

3. Copia el archivo de configuración .env.example a .env y configura tus variables de entorno:
    cp .env.example .env

4. Genera una nueva clave de aplicación:
    php artisan key:generate

5. Realiza las migraciones y ejecuta los seeders:
    php artisan migrate --seed

6. Ejecutar el comando de shield para generar los roles y permisos para cada modulo:
    php artisan shield:install

¡Listo! Ahora puedes acceder al sistema en tu navegador web.

# Uso

Una vez instalado, puedes iniciar sesión en el sistema utilizando las siguientes credenciales:

Correo: ronaldalexisniznunez@gmail.com
Contraseña: Paraguay2024!

# Soporte

Ante dudas o consultas contactar con el departamento de TI