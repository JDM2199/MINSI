<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión a la base de datos
    $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
    if (mysqli_connect_errno()) {
        printf("MySQL connection failed with the error: %s", mysqli_connect_error());
        exit;
    }
    
    if (isset($_POST["registrar"])) {
        // Procesar el registro de un nuevo producto
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $categoria = $_POST["categoria"];
        $proveedor = $_POST["proveedor"];

        $queryRegistroProducto = "INSERT INTO productos (nombre, precio_actual, stock, id_categoria, rut_proveedor)
                                VALUES ('$nombre', '$precio', '$stock', '$categoria', '$proveedor')";
        
        if (mysqli_query($mysqli_link, $queryRegistroProducto)) {
            // Éxito al insertar el producto
            // Configura un mensaje de confirmación en la sesión
            $_SESSION['confirmacion_registrar'] = "Producto registrado con éxito.";
            
            // Redirige de nuevo al formulario para mostrar el mensaje
            header('Location: productos.php');
            exit;
        } else {
            // Error al insertar el producto
            echo "Error al registrar el producto: " . mysqli_error($mysqli_link);
        }
    }

    if (isset($_POST["modificar"])) {
        // Procesar la modificación de un producto existente
        $nombreid = $_POST["idModificar"];
        $nombreModificar=$_POST["nombreModificar"];
        $precioModificar = $_POST["precioModificar"];
        $stockModificar = $_POST["stockModificar"];
        $categoriaModificar = $_POST["categoriaModificar"];
        $proveedorModificar = $_POST["proveedorModificar"];
    
        $queryModificarProducto = "UPDATE productos
                                   SET nombre = '$nombreModificar', precio_actual = '$precioModificar', stock = '$stockModificar', 
                                       id_categoria = '$categoriaModificar', rut_proveedor = '$proveedorModificar'
                                   WHERE nombre = '$nombreid'";
        
        if (mysqli_query($mysqli_link, $queryModificarProducto)) {
            // Éxito al modificar el producto
            // Configura un mensaje de confirmación en la sesión
            session_start();
            $_SESSION['confirmacion'] = "Producto modificado con éxito.";
            
            // Redirige de nuevo al formulario para mostrar el mensaje
            header('Location: productos.php');
            exit;
        } else {
            // Error al modificar el producto
            echo "Error al modificar el producto: " . mysqli_error($mysqli_link);
        }
    }
    
    

if(isset($_POST["eliminar"])) {
    // Procesar la eliminación de un producto
    $nombreEliminar = $_POST["nombreEliminar"];
    
    $queryEliminarProducto = "DELETE FROM productos WHERE nombre = '$nombreEliminar'";
    
    if (mysqli_query($mysqli_link, $queryEliminarProducto)) {
        // Éxito al eliminar el producto
        // Configura un mensaje de confirmación en la sesión
        $_SESSION['confirmacion_eliminar'] = "Producto eliminado con éxito.";
        
        // Redirige de nuevo al formulario para mostrar el mensaje
        header('Location: productos.php');
        exit;
    } else {
        // Error al eliminar el producto
        echo "Error al eliminar el producto: " . mysqli_error($mysqli_link);
    }
}

    

    // Cerrar la conexión a la base de datos
    mysqli_close($mysqli_link);
}
?>
