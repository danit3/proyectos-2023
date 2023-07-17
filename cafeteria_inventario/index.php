<?php
    include 'pages/conexion.php';

    // Consulta para obtener todos los productos
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tu Cafetería - Inventario</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <!-- Encabezado -->
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="#">
                    <img src="images/logo.png" alt="Logo de Tu Cafetería" class="img-fluid mr-2" style="max-width: 50px;">
                    CAFETERÍA
                    </a>
                </div>
            </nav>
        </header>
    
        <!-- Cuerpo -->
        <main>
            <div class="container mt-5">            

                <!-- Botón para crear un nuevo producto -->
<div class="row justify-content-end">
  <div class="col-auto">
    <a href="pages/crear_productos.php" class="btn btn-success d-inline-block">Crear Producto</a>
    <a href="pages/ingresar_ventas.php" class="btn btn-success d-inline-block">Ingresar Ventas</a>
  </div>
</div>

                <h1>Productos en tienda</h1>
                
                <!-- Tabla de productos -->
                <table class="table mt-4">
                
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Referencia</th>
                            <th>Precio</th>
                            <th>Peso</th>
                            <th>Categoria</th>
                            <th>Stock</th>
                            <th>Fecha creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mostrar los registros de productos -->
                        <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["nombre"] . "</td>";
                                    echo "<td>" . $row["referencia"] . "</td>";
                                    echo "<td> $ " . round($row["precio"],2) . "</td>";
                                    echo "<td>" . $row["peso"] . " g. </td>";
                                    echo "<td>" . $row["categoria"] . "</td>";
                                    echo "<td>" . $row["stock"] . "</td>";
                                    echo "<td>" . $row["fecha_creacion"] . "</td>";
                                    echo "<td>";
                                    echo "<a class='btn btn-sm btn-primary' href='pages/editar_productos.php?id=" . $row["id"] . "'>Editar</a>";
                                    echo "<button class='btn btn-sm btn-danger' onclick='confirmarEliminacion(" . $row["id"] . ")'>Eliminar</button>";
                                    echo "</td>";

                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No se encontraron productos.</td></tr>";
                            }
                        ?>
                        </tbody>
                </table>
            </div>
        </main>

        <!-- Pie de página -->
        <footer>
            <div class="container py-3 text-center">
                <p>&copy; 2023 Tu Cafetería. Todos los derechos reservados.</p>
            </div>
        </footer>

        <script src="js/bootstrap.bundle.min.js"></script>
        <script>
            function confirmarEliminacion(id) {
                if (confirm("¿Estás seguro de eliminar este producto?")) {
                    // Realizar una solicitud AJAX para eliminar el producto
                    const xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Actualizar la página después de eliminar el producto
                            location.reload();
                        }
                    };
                    xhr.open("GET", "pages/eliminar_productos.php?id=" + id, true);
                    xhr.send();
                }
            }
        </script>
    </body>
</html>