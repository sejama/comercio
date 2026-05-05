# Skill Symfony para `src/comercio`

## Contexto

- Proyecto Symfony ubicado en `src/comercio`.
- La carpeta se monta en Docker en `/var/www/html/comercio`.
- El contenedor principal es `server-php-apache`.
- Usa `composer install --working-dir /var/www/html/comercio` y `php /var/www/html/comercio/bin/console`.

## Reglas específicas

- Identifica la configuración propia de este proyecto en `src/comercio/.env` y `src/comercio/.env.local`.
- Para ejecutar tareas de Symfony usa la ruta completa del proyecto.
- Para correr PHPUnit usa `php /var/www/html/comercio/vendor/bin/phpunit` si está instalado.

## Buenas prácticas

- Mantén los cambios de configuración dentro de `src/comercio`.
- Si el proyecto usa `importmap.php`, asegúrate de no romper la infraestructura de frontend del subproyecto.
- Prioriza el uso de `docker compose exec server-php-apache bash` para correr comandos con el contexto correcto.
