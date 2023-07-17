<?php
    include 'conexion.php';

    $mensaje = ""; // Inicializar la variable $mensaje

    // Consulta para obtener todos los productos con stock mayor a cero
    $sql = "SELECT * FROM productos WHERE stock > 0";
    $result = $conn->query($sql);

    if (!$result) {
        echo "Error en la consulta: " . $conn->error;
    }

    // Obtener el producto seleccionado si se envió el formulario
    $productoSeleccionado = isset($_POST["producto"]) ? $_POST["producto"] : "";

    // Obtener los datos del formulario cuando se envía
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["producto"]) && isset($_POST["cantidad"])) {
            $idProducto = $_POST["producto"];
            $cantidad = $_POST["cantidad"];

            // Verificar si el producto tiene suficiente stock
            $sqlStock = "SELECT stock, nombre FROM productos WHERE id = $idProducto";
            $resultStock = $conn->query($sqlStock);

            if (!$resultStock) {
                echo "Error en la consulta de stock: " . $conn->error;
            } else {
                $rowStock = $resultStock->fetch_assoc();
                $stock = $rowStock["stock"];
                $nombreProducto = $rowStock["nombre"];

                if ($stock >= $cantidad) {
                    // Actualizar el stock del producto
                    $nuevoStock = $stock - $cantidad;
                    $sqlActualizarStock = "UPDATE productos SET stock = $nuevoStock WHERE id = $idProducto";
                    $conn->query($sqlActualizarStock);

                    // Registrar la venta en la tabla de ventas
                    $fechaVenta = date("Y-m-d"); // Obtener la fecha actual
                    $sqlInsertarVenta = "INSERT INTO ventas (producto_id, cantidad, fecha_venta) VALUES ($idProducto, $cantidad, '$fechaVenta')";
                    $conn->query($sqlInsertarVenta);

                    // Calcular cantidad vendida y cantidad restante
                    $cantidadVendida = $cantidad;
                    $cantidadRestante = $nuevoStock;

                    // Mostrar mensaje de éxito con cantidad vendida y cantidad restante
                    $mensaje = "Venta realizada exitosamente. Cantidad vendida: $cantidadVendida. Cantidad restante: $cantidadRestante";
                    $claseMensaje = "alert-success";
                } else {
                    // Mostrar mensaje de error con la cantidad de stock disponible y el nombre del producto
                    $mensaje = "No hay suficiente stock disponible para el producto '$nombreProducto'. Stock actual: $stock";
                    $claseMensaje = "alert-danger";
                }
            }
        } else {
            // Mostrar mensaje de error si los campos no están definidos
            $mensaje = "Error al enviar el formulario.";
            $claseMensaje = "alert-danger";
        }
    }

    // Consulta para obtener el producto con más stock
    $sqlStockMaximo = "SELECT * FROM productos ORDER BY stock DESC LIMIT 1";
    $resultStockMaximo = $conn->query($sqlStockMaximo);
    $productoStockMaximo = ($resultStockMaximo && $resultStockMaximo->num_rows > 0) ? $resultStockMaximo->fetch_assoc() : null;

    // Consulta para obtener el producto más vendido
    $sqlProductoMasVendido = "SELECT p.*, SUM(v.cantidad) AS total_vendido
                            FROM productos p
                            JOIN ventas v ON p.id = v.producto_id
                            GROUP BY p.id
                            ORDER BY total_vendido DESC
                            LIMIT 1";
    $resultProductoMasVendido = $conn->query($sqlProductoMasVendido);
    $productoMasVendido = ($resultProductoMasVendido && $resultProductoMasVendido->num_rows > 0) ? $resultProductoMasVendido->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tu Cafetería - Ventas</title>
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
                <h1>Ingreso de Ventas</h1>

                <!-- Formulario de ingreso de ventas -->
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <?php
                        if ($result->num_rows > 0) {
                            echo "<select class='form-select' id='producto' name='producto'>";
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row["id"] == $productoSeleccionado) ? "selected" : "";
                                echo "<option value='" . $row["id"] . "' $selected>" . $row["nombre"] . "</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                    </div>
                    <?php if ($mensaje !== "") { ?>
                        <div class="alert alert-dismissible fade show <?php echo $claseMensaje; ?>" role="alert">
                            <?php echo $mensaje; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <script>
                            setTimeout(function() {
                                $(".alert").alert("close");
                            }, 3000);
                        </script>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary">Realizar Venta</button>
                </form>
            </div>
        </main>

        <!-- Pie de página -->
        <footer>
            <div class="container py-3 text-center">
                <p>&copy; 2023 Tu Cafetería. Todos los derechos reservados.</p>
                <p>Producto con más stock:
                    <?php
                    if ($productoStockMaximo !== null) {
                        echo $productoStockMaximo["nombre"] . " (Stock: " . $productoStockMaximo["stock"] . ")";
                    } else {
                        echo "No hay productos con stock.";
                    }
                    ?>
                </p>
                <p>Producto más vendido:
                    <?php
                    if ($productoMasVendido !== null) {
                        echo $productoMasVendido["nombre"] . " (Cantidad vendida: " . $productoMasVendido["total_vendido"] . ")";
                    } else {
                        echo "No hay productos vendidos.";
                    }
                    ?>
                </p>
            </div>
        </footer>

        <script src="../js/bootstrap.bundle.min.js"></script>
    </body>
</html>
