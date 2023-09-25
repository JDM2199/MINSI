<?php
// Establecer los datos de conexión a la base de datos
$mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
if (mysqli_connect_errno()) {
    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
    exit;
}

// Procesar el registro de un nuevo cliente
if (isset($_POST["registrarCliente"])) {
    // Recuperar datos del formulario de registro
    $rut = $_POST["rut"];
    $nombre = $_POST["nombre"];
    $calle = $_POST["calle"];
    $numero = $_POST["numero"];
    $comuna = $_POST["comuna"];
    $ciudad = $_POST["ciudad"];
    $telefonos = isset($_POST["telefonos"]) ? $_POST["telefonos"] : [];

    // Insertar datos del cliente en la tabla "clientes"
    $queryCliente = "INSERT INTO clientes (rut, nombre, direccion_calle, direccion_numero, direccion_comuna, direccion_ciudad)
                     VALUES ('$rut', '$nombre', '$calle', '$numero', '$comuna', '$ciudad')";

    if (mysqli_query($mysqli_link, $queryCliente)) {
        // Éxito al insertar cliente

        // Obtener el ID del cliente recién insertado
        $clienteID = mysqli_insert_id($mysqli_link);

        // Insertar números de teléfono en la tabla "telefonos_clientes"
        foreach ($telefonos as $telefono) {
            $queryTelefono = "INSERT INTO telefonos_clientes (rut_cliente, telefono)
                              VALUES ('$rut', '$telefono')";
            
            if (!mysqli_query($mysqli_link, $queryTelefono)) {
                die("Error al insertar teléfono: " . mysqli_error($mysqli_link));
            }
        }
        
         // Éxito
         $mensaje_registro = "Cliente registrado con éxito.";
        } else {
            // Error al insertar cliente
            $mensaje_registro = "Error al registrar cliente: " . mysqli_error($mysqli_link);
        }
        // Proceso exitoso en el formulario de registro
header("Location: clientes.php?mensaje_confirmacion=$mensaje_registro");
exit;

    }

// Procesar la modificación de un cliente existente
if (isset($_POST["modificarCliente"])) {
    // Recuperar datos del formulario de modificación
    $rutModificar = $_POST["rutModificar"];
    $nombreModificar = $_POST["nombreModificar"];
    $calleModificar = $_POST["calleModificar"];
    $numeroModificar = $_POST["numeroModificar"];
    $comunaModificar = $_POST["comunaModificar"];
    $ciudadModificar = $_POST["ciudadModificar"];
    $telefonosModificar = isset($_POST["telefonosModificar"]) ? $_POST["telefonosModificar"] : [];

    // Actualizar datos del cliente en la tabla "clientes"
    $queryModificarCliente = "UPDATE clientes SET
        nombre = '$nombreModificar',
        direccion_calle = '$calleModificar',
        direccion_numero = '$numeroModificar',
        direccion_comuna = '$comunaModificar',
        direccion_ciudad = '$ciudadModificar'
        WHERE rut = '$rutModificar'";

    if (mysqli_query($mysqli_link, $queryModificarCliente)) {
        // Éxito al modificar cliente

        if (!empty($telefonosModificar)) {
            // Eliminar números de teléfono existentes para este cliente
            $queryEliminarTelefonos = "DELETE FROM telefonos_clientes WHERE rut_cliente = '$rutModificar'";
            mysqli_query($mysqli_link, $queryEliminarTelefonos);

            // Insertar números de teléfono actualizados en la tabla "telefonos_clientes"
            foreach ($telefonosModificar as $telefonoModificar) {
                $queryTelefono = "INSERT INTO telefonos_clientes (rut_cliente, telefono)
                                  VALUES ('$rutModificar', '$telefonoModificar')";

                if (!mysqli_query($mysqli_link, $queryTelefono)) {
                    die("Error al insertar teléfono: " . mysqli_error($mysqli_link));
                }
            }
        }

       // Éxito
       $mensaje_modificar = "Cliente registrado modificado con éxito.";
    } else {
        // Error al insertar cliente
        $mensaje_modificar = "Error al registrar cliente modificado: " . mysqli_error($mysqli_link);
    }
    // Proceso exitoso en el formulario de registro
header("Location: clientes.php?mensaje_modificar=$mensaje_modificar");
exit;

}


if (isset($_POST["eliminar_cliente"])) {
    // Recuperar el RUT del cliente a eliminar
    $clienteAEliminar = $_POST['rutEliminar'];

    // Realizar la conexión a la base de datos (ajusta los detalles de la conexión según tu configuración)
    $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("La conexión a la base de datos ha fallado: " . $mysqli->connect_error);
    }

    // Iniciar una transacción
    $mysqli->begin_transaction();

    try {
        // Eliminar los registros de telefonos_clientes relacionados con el cliente
        $queryEliminarTelefonos = "DELETE FROM telefonos_clientes WHERE rut_cliente = '$clienteAEliminar'";
        if (!$mysqli->query($queryEliminarTelefonos)) {
            throw new Exception("Error al eliminar los teléfonos relacionados: " . $mysqli->error);
        }

        // Eliminar los detalles de ventas relacionados con el cliente
        $queryEliminarDetallesVentas = "DELETE FROM detalles_ventas WHERE id_venta IN (SELECT id FROM ventas WHERE rut_cliente = '$clienteAEliminar')";
        if (!$mysqli->query($queryEliminarDetallesVentas)) {
            throw new Exception("Error al eliminar los detalles de ventas relacionados: " . $mysqli->error);
        }

        // Eliminar las ventas relacionadas con el cliente
        $queryEliminarVentas = "DELETE FROM ventas WHERE rut_cliente = '$clienteAEliminar'";
        if (!$mysqli->query($queryEliminarVentas)) {
            throw new Exception("Error al eliminar las ventas relacionadas: " . $mysqli->error);
        }

        // Finalmente, eliminar al cliente
        $queryEliminarCliente = "DELETE FROM clientes WHERE rut = '$clienteAEliminar'";
        if (!$mysqli->query($queryEliminarCliente)) {
            throw new Exception("Error al eliminar el cliente: " . $mysqli->error);
        }

        // Confirmar la transacción
        $mysqli->commit();
       
        $mensaje_eliminar = "Cliente eliminado con éxito.";
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $mysqli->rollback();
        $mensaje_eliminar= "Error: " . $e->getMessage();
       

    }

    // Cierra la conexión a la base de datos cuando hayas terminado
    
    $mysqli->close();
    header("Location: clientes.php?mensaje_eliminar=$mensaje_eliminar");
    exit;
}



/*mostrar */
if (isset($_POST["rutIndividual"])) {
    // Mostrar un cliente individual por RUT
    $rutIndividual = $_POST["rutIndividual"];

    // Consulta para obtener información del cliente y sus teléfonos
    $queryCliente = "SELECT * FROM clientes WHERE rut = '$rutIndividual'";
    $resultCliente = mysqli_query($mysqli_link, $queryCliente);

    if ($resultCliente) {
        $cliente = mysqli_fetch_assoc($resultCliente);
        if ($cliente) {
            // Mostrar la información del cliente individual
            echo "Información del Cliente:<br>";
            echo "RUT: " . $cliente["rut"] . "<br>";
            echo "Nombre: " . $cliente["nombre"] . "<br>";
            echo "Calle: " . $cliente["direccion_calle"] . "<br>";
            echo "Número: " . $cliente["direccion_numero"] . "<br>";
            echo "Comuna: " . $cliente["direccion_comuna"] . "<br>";
            echo "Ciudad: " . $cliente["direccion_ciudad"] . "<br>";

            // Consulta para obtener los teléfonos del cliente
            $queryTelefonos = "SELECT telefono FROM telefonos_clientes WHERE rut_cliente = '$rutIndividual'";
            $resultTelefonos = mysqli_query($mysqli_link, $queryTelefonos);

            if ($resultTelefonos) {
                echo "Teléfonos del Cliente:<br>";
                while ($rowTelefono = mysqli_fetch_assoc($resultTelefonos)) {
                    echo "- " . $rowTelefono["telefono"] . "<br>";
                }
            }
        } else {
            echo "Cliente no encontrado.";
        }
    } else {
        echo "Error al buscar cliente: " . mysqli_error($mysqli_link);
    }
} elseif (isset($_POST["mostrarTodos"])) {
    // Mostrar todos los clientes y sus teléfonos
    $queryClientes = "SELECT * FROM clientes";
    $resultClientes = mysqli_query($mysqli_link, $queryClientes);

    if ($resultClientes) {
        echo "Información de Todos los Clientes:<br>";
        while ($cliente = mysqli_fetch_assoc($resultClientes)) {
            echo "RUT: " . $cliente["rut"] . "<br>";
            echo "Nombre: " . $cliente["nombre"] . "<br>";
            echo "Calle: " . $cliente["direccion_calle"] . "<br>";
            echo "Número: " . $cliente["direccion_numero"] . "<br>";
            echo "Comuna: " . $cliente["direccion_comuna"] . "<br>";
            echo "Ciudad: " . $cliente["direccion_ciudad"] . "<br>";

            // Consulta para obtener los teléfonos del cliente
            $rutCliente = $cliente["rut"];
            $queryTelefonos = "SELECT telefono FROM telefonos_clientes WHERE rut_cliente = '$rutCliente'";
            $resultTelefonos = mysqli_query($mysqli_link, $queryTelefonos);

            if ($resultTelefonos) {
                echo "Teléfonos del Cliente:<br>";
                while ($rowTelefono = mysqli_fetch_assoc($resultTelefonos)) {
                    echo "- " . $rowTelefono["telefono"] . "<br>";
                }
            }

            echo "<hr>";
        }
    } else {
        echo "Error al buscar clientes: " . mysqli_error($mysqli_link);
    }
}


// Cerrar la conexión a la base de datos
mysqli_close($mysqli_link);
?>
