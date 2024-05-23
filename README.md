# Healthub

Este sistema está diseñado específicamente para hospitales y centros médicos, con el objetivo de facilitar la gestión de citas, informes y resultados de pacientes de manera eficiente. Incluye un completo perfil de usuario que permite a los usuarios modificar sus datos personales según sea necesario.

Además, cuenta con una función de mensajería instantánea que conecta a los usuarios con los profesionales médicos, facilitando la comunicación rápida y directa para consultas o seguimientos.

Una característica destacada es el menú de idiomas incorporado, que permite a los usuarios cambiar el idioma de la interfaz según sus preferencias, asegurando una experiencia personalizada y accesible para todos.

¡Optimiza la gestión médica y mejora la comunicación entre pacientes y profesionales con nuestra aplicación!

## Comenzando 🚀

Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas.

Mira **Instalación** para conocer como desplegar el proyecto.


### Pre-requisitos 📋

Para la instalación del proyecto necesitaremos lo siguiente:

```
- Cuenta de Github
- Github en local para ejecutar comandos GIT
- Mysql con base de datos de Healthub
```

### Instalación 🔧

Sigue los siguientes pasos para instalar la aplicación:

1. Crear una carpeta y iniciar un repositorio de GIT local.  
Iniciamos el repositorio ejecutando el siguiente comando dentro de la carpeta.

    ```
    git init
    ```
2. Añadir repositorio remoto de Healthub
    ```
    git remote add origin https://github.com/M12-proyecto/healthub.git
    ```
3. Hacer un pull para obtener el proyecto
    ```
    git pull origin dev-main
    ```
4. Instalar dependencias de Laravel y React
    ```
    composer install
    npm install
    ```
5. Crear .env del proyecto, lo pondremos en la carpeta principal.
    ```
    APP_NAME=Healthub
    APP_ENV=local
    APP_KEY=base64:RoSl+NvBpk1jIcEyM8iJ0rSwAjQ0ezkWQcXLqDZK8jc=
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug

    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=healthub
    DB_USERNAME=healthub_user
    DB_PASSWORD=Admin@2024

    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120

    MEMCACHED_HOST=127.0.0.1

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=mailpit
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false

    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=mt1

    VITE_APP_NAME="${APP_NAME}"
    VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    VITE_PUSHER_HOST="${PUSHER_HOST}"
    VITE_PUSHER_PORT="${PUSHER_PORT}"
    VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
    VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    ```
6. Generar una clave de aplicación
    ```
    php artisan key:generate
    ```
7. Crear usuario, base de datos y tablas en mysql e insertar los datos de prueba.
    ```
    Ejecutamos estos comandos en mysql:

        CREATE USER 'healthub_user'@'localhost' IDENTIFIED BY 'Admin@2024';
        GRANT ALL PRIVILEGES ON healthub.* TO 'healthub_user'@'localhost';
        FLUSH PRIVILEGES;

    Luego ejecutamos el script healthub.sql ubicado en la carpeta database del proyecto.
    ```
8. Iniciar servidor de Laravel y React desde la carpeta principal
    ```
    php artisan serve
    npm run dev
    ```
Una vez realizados todos los pasos ya tendriamos operativa la aplicación.

## Ejecutando las pruebas ⚙️

_Explica como ejecutar las pruebas automatizadas para este sistema_

### Analice las pruebas end-to-end 🔩

_Explica que verifican estas pruebas y por qué_

```
Da un ejemplo
```

### Y las pruebas de estilo de codificación ⌨️

_Explica que verifican estas pruebas y por qué_

```
Da un ejemplo
```

## Despliegue 📦

_Agrega notas adicionales sobre como hacer deploy_

## Construido con 🛠️

Esta aplicación está desarrollada con:

* [Laravel](https://laravel.com) - El framework web utilizado
* [React](https://es.react.dev) - La biblioteca de javascript utilizada
* [Composer](https://getcomposer.org) - Manejador de dependencias
* [npm](https://www.npmjs.com) - Manejador de dependencias

## Autores ✒️

Este proyecto ha sido desarrollado por:

* **Jose Jerlin Mejia** - *Desarrollo de la aplicación* - [Jose]()
* **Jonathan Sánchez Escutia** - *Desarrollo de la aplicación + Documentación* - [thosjsanchez](https://github.com/thosjsanchez)

## Licencia 📄

Este proyecto está bajo la Licencia (Tu Licencia) - mira el archivo [LICENSE.md](LICENSE.md) para detalles

## Expresiones de Gratitud 🎁

* Comenta a otros sobre este proyecto 📢
* Invita una cerveza 🍺 o un café ☕ a alguien del equipo.
* Gracias por ver

---
⌨️ con ❤️ por [thosjsanchez](https://github.com/thosjsanchez) 😊