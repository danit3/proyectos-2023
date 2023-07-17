<?php
    include 'conexion.php';

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = ucfirst(strtolower($_POST["nombre"]));
        $referencia = strtoupper($_POST["referencia"]);
        $precio = $_POST["precio"];
        $peso = $_POST["peso"];
        $categoria = ucfirst(strtolower($_POST["categoria"]));
        $stock = $_POST["stock"];
        $fecha_creacion = $_POST["fecha_creacion"];

        // Consultar si ya existe un producto con el mismo nombre o referencia
        $sqlVerificar = "SELECT COUNT(*) as total FROM productos WHERE nombre = '$nombre' OR referencia = '$referencia'";
        $resultVerificar = $conn->query($sqlVerificar);
        $rowVerificar = $resultVerificar->fetch_assoc();
        $totalProductos = $rowVerificar['total'];

        if ($totalProductos > 0) {
            // Mostrar la alerta de error y redirigir al formulario
            echo "<script>alert('No se puede crear el producto. El nombre o la referencia ya existen.'); window.location.href = 'crear_productos.php';</script>";
            exit();
        } else {
            // Insertar los datos en la base de datos
            $sqlInsertar = "INSERT INTO productos (nombre, referencia, precio, peso, categoria, stock, fecha_creacion)
                            VALUES ('$nombre', '$referencia', $precio, $peso, '$categoria', $stock, '$fecha_creacion')";

            if ($conn->query($sqlInsertar) === TRUE) {
                // Obtener el ID del producto recién insertado
                $idProducto = $conn->insert_id;

                // Obtener el nombre del producto
                $sqlNombreProducto = "SELECT nombre FROM productos WHERE id = $idProducto";
                $resultNombreProducto = $conn->query($sqlNombreProducto);
                $rowNombreProducto = $resultNombreProducto->fetch_assoc();
                $nombreProducto = $rowNombreProducto["nombre"];

                // Mostrar la alerta con el nombre del producto y redirigir a la pagina principal
                echo "<script>alert('Producto creado: $nombreProducto'); window.location.href = '../index.php';</script>";
                exit();
            } else {
                echo "Error al guardar el producto: " . $conn->error;
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tu Cafetería - Crear</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    <body>
        <!-- Encabezado -->
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="#">
                    <img src="../images/logo.png" alt="Logo de Tu Cafetería" class="img-fluid mr-2" style="max-width: 50px;">
                    CAFETERÍA
                    </a>
                </div>
            </nav>
        </header>
    
        <!-- Cuerpo -->
        <main>
            <div class="container mt-5">

                <!-- Botón para volver al menú principal -->
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a href="../index.php" class="btn btn-secondary">VOLVER</a>
                    </div>
                </div>                
                <h1 class="mb-4">Registro de Productos</h1>
            
                    
                <!-- Formulario de ingreso de productos -->
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nombre">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre del producto" name="nombre">
                            </div>
                            <div class="mb-3">
                                <label for="referencia">Referencia</label>
                                <input type="text" class="form-control" id="referencia" placeholder="Ingrese la referencia" name="referencia">
                            </div>
                            <div class="mb-3">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" placeholder="Ingrese el precio" name="precio">
                            </div>
                            <div class="mb-3">
                                <label for="peso">Peso</label>
                                <input type="number" class="form-control" id="peso" placeholder="Ingrese el peso" name="peso">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categoria">Categoría</label>
                                <input type="text" class="form-control" id="categoria" placeholder="Ingrese la categoría" name="categoria">
                            </div>
                            <div class="mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" placeholder="Ingrese el stock" name="stock">
                            </div>
                            <div class="mb-3 mb-5">
                                <label for="fecha_creacion">Fecha de creación</label>
                                <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion">
                            </div>
                            <!-- Botón para guardar -->
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        <!-- Pie de página -->
        <footer>
            <div class="container py-3 text-center">
                <p>&copy; 2023 Tu Cafetería. Todos los derechos reservados.</p>
            </div>
        </footer>

        <script src="../js/bootstrap.bundle.min.js"></script>
    </body>
</html>
