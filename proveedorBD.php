<?php
session_start();
// Establecer los datos de conexión a la base de datos
$mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
if (mysqli_connect_errno()) {
    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
    exit;
}

// Procesar los datos del formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["registrar"])) {
        // Recuperar datos del formulario de registro
        $rut = $_POST["rut"];
        $nombre = $_POST["nombre"];
        $calle = $_POST["calle"];
        $numero = $_POST["numero"];
        $comuna = $_POST["comuna"];
        $ciudad = $_POST["ciudad"];
        $telefono = $_POST["telefono"];
        $pagina_web = $_POST["pagina_web"];

        // Insertar datos del proveedor en la tabla "proveedores"
        $queryProveedor = "INSERT INTO proveedores (rut, nombre, direccion_calle, direccion_numero, direccion_comuna, direccion_ciudad, telefono, pagina_web)
                         VALUES ('$rut', '$nombre', '$calle', '$numero', '$comuna', '$ciudad', '$telefono', '$pagina_web')";

if (mysqli_query($mysqli_link, $queryProveedor)) {
    // Éxito al insertar proveedor
    // Configura un mensaje de confirmación en la sesión
    $_SESSION['confirmacion_registrar_proveedor'] = "Proveedor registrado con éxito.";
    
    // Redirige de nuevo al formulario para mostrar el mensaje
    header('Location: proveedor.php');
    exit;
} else {
    // Error al insertar proveedor
    echo "Error al registrar proveedor: " . mysqli_error($mysqli_link);
}



    } elseif (isset($_POST["modificar"])) {
        // Recuperar el RUT del proveedor a modificar
        $rutModificar = $_POST["rutModificar"];

        // Recuperar los nuevos datos del formulario de modificación
        $nombreModificar = $_POST["nombreModificar"];
        $calleModificar = $_POST["calleModificar"];
        $numeroModificar = $_POST["numeroModificar"];
        $comunaModificar = $_POST["comunaModificar"];
        $ciudadModificar = $_POST["ciudadModificar"];
        $telefonoModificar = $_POST["telefonoModificar"];
        $pagina_webModificar = $_POST["pagina_webModificar"];

        // Actualizar los datos del proveedor en la tabla "proveedores"
        $queryModificarProveedor = "UPDATE proveedores SET
                                    nombre='$nombreModificar',
                                    direccion_calle='$calleModificar',
                                    direccion_numero='$numeroModificar',
                                    direccion_comuna='$comunaModificar',
                                    direccion_ciudad='$ciudadModificar',
                                    telefono='$telefonoModificar',
                                    pagina_web='$pagina_webModificar'
                                    WHERE rut='$rutModificar'";

if (mysqli_query($mysqli_link, $queryModificarProveedor)) {
    // Éxito al modificar proveedor
    // Configura un mensaje de confirmación en la sesión
    $_SESSION['confirmacion_modificar_proveedor'] = "Proveedor modificado con éxito.";
    
    // Redirige de nuevo al formulario para mostrar el mensaje
    header('Location: proveedor.php');
    exit;
} else {
    // Error al modificar proveedor
    echo "Error al modificar proveedor: " . mysqli_error($mysqli_link);
}
}

    // Procesar la eliminación de un proveedor
if (isset($_POST["eliminar"])) {
    // Recuperar el RUT del proveedor a eliminar
    $rutEliminar = $_POST["rutEliminar"];

    // Eliminar proveedor de la tabla "proveedores"
    $queryEliminarProveedor = "DELETE FROM proveedores WHERE rut = '$rutEliminar'";

    if (mysqli_query($mysqli_link, $queryEliminarProveedor)) {
        // Éxito al eliminar proveedor
        // Configura un mensaje de confirmación en la sesión
        $_SESSION['confirmacion_eliminar_proveedor'] = "Proveedor eliminado con éxito.";
        
        // Redirige de nuevo al formulario para mostrar el mensaje
        header('Location: proveedor.php');
        exit;
    } else {
        // Error al eliminar proveedor
        echo "Error al eliminar proveedor: " . mysqli_error($mysqli_link);
    }
}


    
    // Cerrar la conexión a la base de datos
    mysqli_close($mysqli_link);
}
?>
