<?php
    include 'conexion.php';

    // Obtener el ID del producto a eliminar
    $idProducto = $_GET['id'];

    // Ejecutar la consulta SQL para eliminar el producto
    $sqlEliminar = "DELETE FROM productos WHERE id = $idProducto";
    if ($conn->query($sqlEliminar) === TRUE) {
        // Éxito al eliminar el producto
        echo "Producto eliminado correctamente";
    } else {
        // Error al eliminar el producto
        echo "Error al eliminar el producto: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
?>
