<?php
    include '../pages/conexion.php';

    // Obtener el ID del producto a editar
    $idProducto = $_GET['id'];

    // Consulta para obtener los detalles del producto
    $sql = "SELECT * FROM productos WHERE id = $idProducto";
    $result = $conn->query($sql);

    // Verificar si se encontró el producto
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // Obtener los datos del producto
        $nombre = $producto["nombre"];
        $referencia = $producto["referencia"];
        $precio = $producto["precio"];
        $peso = $producto["peso"];
        $categoria = $producto["categoria"];
        $stock = $producto["stock"];

        // Actualizar el producto cuando se envíe el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los datos actualizados del formulario
            $nombreActualizado = ucfirst(strtolower($_POST["nombre"]));
            $referenciaActualizada = strtoupper($_POST["referencia"]);
            $precioActualizado = $_POST["precio"];
            $pesoActualizado = $_POST["peso"];
            $categoriaActualizada = ucfirst(strtolower($_POST["categoria"]));
            $stockActualizado = $_POST["stock"];

            // Consultar si ya existe otro producto con el mismo nombre o referencia
            $sqlVerificar = "SELECT COUNT(*) as total FROM productos WHERE (nombre = '$nombreActualizado' OR referencia = '$referenciaActualizada') AND id != $idProducto";
            $resultVerificar = $conn->query($sqlVerificar);
            $rowVerificar = $resultVerificar->fetch_assoc();
            $totalProductos = $rowVerificar['total'];

            if ($totalProductos > 0) {
                // Mostrar la alerta de error y redirigir a la pagina principal
                echo "<script>alert('No se puede actualizar el producto. El nombre o la referencia ya existen.'); window.location.href = '../index.php';</script>";
                exit;
            } else {
                // Ejecutar la consulta SQL para actualizar el producto en la base de datos
                $sqlActualizar = "UPDATE productos SET nombre='$nombreActualizado', referencia='$referenciaActualizada', precio=$precioActualizado, peso=$pesoActualizado, categoria='$categoriaActualizada', stock=$stockActualizado WHERE id = $idProducto";

                if ($conn->query($sqlActualizar) === TRUE) {
                    echo "<script>alert('Producto actualizado correctamente'); window.location.href = '../index.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Error al actualizar el producto: " . $conn->error . "'); window.location.href = '../index.php';</script>";
                    exit;
                }
            }
        }
    } else {
        echo "<script>alert('Producto no encontrado'); window.location.href = '../index.php';</script>";
        exit;
    }
?>





<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tu Cafetería - Editar</title>
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
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a href="../index.php" class="btn btn-secondary">VOLVER</a>
                    </div>
                </div>
                <h1 class="mb-4">Editar Producto</h1>              

                <!-- Formulario de edición de producto -->
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del producto" value="<?php echo $nombre; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="referencia">Referencia</label>
                                <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ingrese la referencia" value="<?php echo $referencia; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" placeholder="Ingrese el precio" value="<?php echo $precio; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">                            
                            <div class="mb-3">
                                <label for="peso">Peso</label>
                                <input type="number" class="form-control" id="peso" name="peso" placeholder="Ingrese el peso" value="<?php echo $peso; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="categoria">Categoría del Producto</label>
                                <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ingrese la categoría del producto" value="<?php echo $categoria; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Ingrese el stock del producto" value="<?php echo $stock; ?>">                            
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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