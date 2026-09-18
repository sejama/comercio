# Skill Symfony para `src/comercio`

## Contexto y Configuración

- **Ubicación local**: `src/comercio` | **Ubicación en contenedor**: `/var/www/html/comercio`
- **Servicio Docker**: `server-php-apache`
- **Acceso HTTP**: http://localhost:8080/comercio/public/
- **Ruta de Comandos**: `php /var/www/html/comercio/bin/console`

## Reglas Específicas del Subproyecto

1. **Gestión de Dependencias y Caché**:
   ```bash
   docker compose exec server-php-apache composer install --working-dir /var/www/html/comercio
   docker compose exec server-php-apache php /var/www/html/comercio/bin/console cache:clear
   ```
2. **Frontend & AssetMapper**:
   - Este subproyecto utiliza **Symfony AssetMapper** (`importmap.php` y directorio `assets/`).
   - Para añadir/actualizar librerías JavaScript sin Node.js en build:
     ```bash
     docker compose exec server-php-apache php /var/www/html/comercio/bin/console importmap:require <paquete>
     ```
3. **Pruebas Automatizadas**:
   ```bash
   docker compose exec server-php-apache php /var/www/html/comercio/vendor/bin/phpunit
   ```

## Mejores Prácticas de Desarrollo (Comercio Electrónico)

- **Integridad Transaccional**: Para operaciones de checkout, cambios de estado de pedidos o actualización de stock, encapsular la lógica en transacciones de Doctrine (`$em->wrapInTransaction()`).
- **Separación de Lógica en Servicios**: La lógica de carrito, pasarelas de pago y cálculo de totales debe residir en servicios/managers dedicados dentro de `src/Service/` o `src/Manager/`, no en los controladores.
- **Gestión de Assets**: Modificar únicamente `importmap.php` o `assets/app.js` mediante la consola de Symfony AssetMapper para asegurar la compatibilidad en despliegue.
- **Migraciones de Base de Datos**: Ejecutar siempre `doctrine:migrations:migrate` al actualizar la estructura de catálogos u órdenes.
