<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // dejar vacío no tiene contraseña
    $dbname = "cafeteria_inventario";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar si hay errores de conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
?>
