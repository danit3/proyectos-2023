# Inventario de Cafetería

Este es un sistema de inventario para gestionar los productos de una cafetería.

## Requisitos del sistema

- Asegúrate de tener instalado un servidor web compatible, como Apache o Nginx, y PHP en tu máquina local o servidor de alojamiento.
- Debes tener una base de datos MySQL o MariaDB disponible para utilizar la prueba.

## Configuración de la base de datos

- Crea una nueva base de datos en tu servidor MySQL o MariaDB para el sistema de inventario.
- Importa el archivo de script SQL proporcionado (`cafeteria_inventario.sql`) en la base de datos recién creada. Esto creará las tablas necesarias y cargará datos de ejemplo.

## Configuración de la conexión a la base de datos

- Abre el archivo `conexion.php` en la carpeta `pages`.
- Modifica los valores de host, usuario, contraseña y nombre de la base de datos en las variables correspondientes según la configuración de tu entorno.

## Configuración del entorno web

- Copia todos los archivos y carpetas en tu servidor web o en la carpeta pública de tu servidor de alojamiento.

## Acceso a la aplicación

- Abre un navegador web y accede a la URL correspondiente a la ubicación de los archivos en tu servidor.
- Deberías poder ver la interfaz de la aplicación de inventario de la cafetería.

## Uso de la aplicación

- La aplicación permite realizar ventas de productos de la cafetería y realiza un seguimiento del stock de productos.
- En la página de inicio, puedes ver una lista de productos disponibles con su stock actual.
- Para realizar una venta, selecciona un producto, ingresa la cantidad y haz clic en "Realizar Venta". La aplicación verificará si hay suficiente stock y actualizará el stock y registrará la venta en la base de datos.
- Se mostrará un mensaje de éxito o error después de realizar una venta.
- En el pie de página de la aplicación, se muestra el producto con más stock y el producto más vendido.

## Consideraciones adicionales

- Puedes personalizar el diseño y la apariencia de la aplicación modificando los archivos HTML y CSS correspondientes en la carpeta `pages` y la carpeta `css`.
- Asegúrate de que los permisos de escritura estén configurados correctamente en la carpeta `pages` para que la aplicación pueda actualizar la base de datos y generar las alertas.
