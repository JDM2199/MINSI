<?php
if (isset($_POST['registrarVenta'])) {
    // Obtener los datos del formulario de venta
    $idVenta = $_POST['id_venta'];
    $fechaVenta = $_POST['fecha_venta'];
    $cliente = $_POST['cliente'];
    $descuento = isset($_POST['descuento']) ? floatval($_POST['descuento']) : 0.00;

    // Realizar la conexión a la base de datos (ajusta los detalles de la conexión según tu configuración)
    $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("La conexión a la base de datos ha fallado: " . $mysqli->connect_error);
    }

    // Iniciar una transacción
    $mysqli->begin_transaction();

    // Verificar si el cliente ya existe en la tabla "clientes"
    $queryClienteExist = "SELECT rut FROM clientes WHERE rut = ?";
    $stmtClienteExist = $mysqli->prepare($queryClienteExist);
    $stmtClienteExist->bind_param("s", $cliente);
    $stmtClienteExist->execute();
    $stmtClienteExist->store_result();

    if ($stmtClienteExist->num_rows == 0) {
        // El cliente no existe, insertarlo en la tabla "clientes" primero
        $queryInsertCliente = "INSERT INTO clientes (rut) VALUES (?)";
        $stmtInsertCliente = $mysqli->prepare($queryInsertCliente);
        $stmtInsertCliente->bind_param("s", $cliente);

        if (!$stmtInsertCliente->execute()) {
            // Si ocurre un error en la inserción del cliente, cancela la transacción y muestra un mensaje de error
            $mysqli->rollback();
            echo "Error en la inserción del cliente: " . $stmtInsertCliente->error;
            $stmtInsertCliente->close();
            $mysqli->close();
            exit;
        }

        $stmtInsertCliente->close();
    }

    // Calcular el monto total antes de aplicar el descuento
    $productos = $_POST['productos'];
    $cantidades = $_POST['cantidades'];
    $montos = $_POST['montos'];
    $montoTotal = 0;

    for ($i = 0; $i < count($productos); $i++) {
        $montoTotal += $montos[$i];
    }

    // Aplicar el descuento al monto total
    $montoFinal = $montoTotal - $descuento;

    // Insertar la venta en la tabla "ventas" con el monto final
    $queryInsertVenta = "INSERT INTO ventas (id, fecha, rut_cliente, monto_final, descuento) VALUES (?, ?, ?, ?, ?)";
    $stmtInsertVenta = $mysqli->prepare($queryInsertVenta);
    $stmtInsertVenta->bind_param("ssssd", $idVenta, $fechaVenta, $cliente, $montoFinal, $descuento);

    if (!$stmtInsertVenta->execute()) {
        // Si ocurre un error en la inserción, cancela la transacción y muestra un mensaje de error
        $mysqli->rollback();
        echo "Error en la inserción de la venta: " . $stmtInsertVenta->error;
        $stmtInsertVenta->close();
        $mysqli->close();
        exit;
    }

    $stmtInsertVenta->close();

    // Obtener los datos de los detalles de venta del formulario
    $queryInsertDetalleVenta = "INSERT INTO detalles_ventas (id_venta, nombre_producto, monto_total, cantidad) VALUES (?, ?, ?, ?)";
    $stmtInsertDetalleVenta = $mysqli->prepare($queryInsertDetalleVenta);
    $stmtInsertDetalleVenta->bind_param("ssdd", $idVenta, $nombre_producto, $monto_total, $cantidad);

    for ($i = 0; $i < count($productos); $i++) {
        $producto = $productos[$i];
        $monto_total = $montos[$i];
        $cantidad = $cantidades[$i];

        // Verifica que el campo "nombre_producto" no esté vacío antes de insertar
        if (!empty($producto)) {
            $nombre_producto = $producto;
            if (!$stmtInsertDetalleVenta->execute()) {
                // Si ocurre un error en la inserción de un detalle, cancela la transacción y muestra un mensaje de error
                $mysqli->rollback();
                echo "Error en la inserción de un detalle de venta: " . $stmtInsertDetalleVenta->error;
                $stmtInsertDetalleVenta->close();
                $mysqli->close();
                exit;
            }
        }
    }

    $stmtInsertDetalleVenta->close();

    // Finaliza la transacción y confirma los cambios
    $mysqli->commit();

    // Redirige o muestra un mensaje de éxito
    header("Location: ventas.php"); // Cambia esto a la página de éxito que desees
    exit;
}


if (isset($_POST['modificarVenta'])) {
    // Obtener los datos del formulario de modificación de venta
    $idVentaModificar = $_POST['id_venta_modificar'];
    $fechaVentaModificar = $_POST['fecha_venta_modificar'];
    $clienteModificar = $_POST['cliente_modificar'];
    $descuentoModificar = isset($_POST['descuento_modificar']) ? floatval($_POST['descuento_modificar']) : 0.00;

    // Realizar la conexión a la base de datos (ajusta los detalles de la conexión según tu configuración)
    $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("La conexión a la base de datos ha fallado: " . $mysqli->connect_error);
    }

    // Iniciar una transacción
    $mysqli->begin_transaction();

    // Actualizar la venta en la tabla "ventas" con el monto final modificado
    $queryUpdateVenta = "UPDATE ventas SET fecha = ?, rut_cliente = ?, descuento = ? WHERE id = ?";
    $stmtUpdateVenta = $mysqli->prepare($queryUpdateVenta);
    $stmtUpdateVenta->bind_param("ssds", $fechaVentaModificar, $clienteModificar, $descuentoModificar, $idVentaModificar);

    if (!$stmtUpdateVenta->execute()) {
        // Si ocurre un error en la actualización de la venta, cancela la transacción y muestra un mensaje de error
        $mysqli->rollback();
        echo "Error en la actualización de la venta: " . $stmtUpdateVenta->error;
        $stmtUpdateVenta->close();
        $mysqli->close();
        exit;
    }

    $stmtUpdateVenta->close();

    // Eliminar los detalles de venta actuales de la venta
    $queryDeleteDetalles = "DELETE FROM detalles_ventas WHERE id_venta = ?";
    $stmtDeleteDetalles = $mysqli->prepare($queryDeleteDetalles);
    $stmtDeleteDetalles->bind_param("s", $idVentaModificar);

    if (!$stmtDeleteDetalles->execute()) {
        // Si ocurre un error al eliminar los detalles de venta, cancela la transacción y muestra un mensaje de error
        $mysqli->rollback();
        echo "Error al eliminar los detalles de venta: " . $stmtDeleteDetalles->error;
        $stmtDeleteDetalles->close();
        $mysqli->close();
        exit;
    }

    $stmtDeleteDetalles->close();

    // Obtener los datos de los detalles de venta modificados del formulario
    $productosModificar = $_POST['productos_modificar'];
    $cantidadesModificar = $_POST['cantidades_modificar'];
    $montosModificar = $_POST['montos_modificar'];

    // Insertar los detalles de venta modificados en la tabla "detalles_ventas"
    $queryInsertDetallesVenta = "INSERT INTO detalles_ventas (id_venta, nombre_producto, monto_total, cantidad) VALUES (?, ?, ?, ?)";
    $stmtInsertDetallesVenta = $mysqli->prepare($queryInsertDetallesVenta);
    $stmtInsertDetallesVenta->bind_param("ssdd", $idVentaModificar, $nombreProducto, $montoTotal, $cantidad);

    for ($i = 0; $i < count($productosModificar); $i++) {
        $productoModificar = $productosModificar[$i];
        $montoTotal = $montosModificar[$i];
        $cantidad = $cantidadesModificar[$i];

        // Verifica que el campo "nombre_producto" no esté vacío antes de insertar
        if (!empty($productoModificar)) {
            $nombreProducto = $productoModificar;
            if (!$stmtInsertDetallesVenta->execute()) {
                // Si ocurre un error en la inserción de un detalle, cancela la transacción y muestra un mensaje de error
                $mysqli->rollback();
                echo "Error en la inserción de un detalle de venta: " . $stmtInsertDetallesVenta->error;
                $stmtInsertDetallesVenta->close();
                $mysqli->close();
                exit;
            }
        }
    }


    // Aplicar el descuento al monto total
$montoFinal = $montoTotal - $descuento;

// Actualizar la venta en la tabla "ventas" con el monto final modificado
$queryUpdateVenta = "UPDATE ventas SET fecha = ?, rut_cliente = ?, descuento = ?, monto_final = ? WHERE id = ?";
$stmtUpdateVenta = $mysqli->prepare($queryUpdateVenta);
$stmtUpdateVenta->bind_param("ssdds", $fechaVentaModificar, $clienteModificar, $descuentoModificar, $montoFinal, $idVentaModificar);

if (!$stmtUpdateVenta->execute()) {
    // Si ocurre un error en la actualización de la venta, cancela la transacción y muestra un mensaje de error
    $mysqli->rollback();
    echo "Error en la actualización de la venta: " . $stmtUpdateVenta->error;
    $stmtUpdateVenta->close();
    $mysqli->close();
    exit;
}

    $stmtInsertDetallesVenta->close();

    // Finaliza la transacción y confirma los cambios
    $mysqli->commit();

    // Cierra la conexión a la base de datos
    $mysqli->close();

    // Redirige o muestra un mensaje de éxito
    header("Location: ventas.php"); // Cambia esto a la página de éxito que desees
    exit;

}
    if (isset($_POST['eliminarVenta'])) {
        // Obtener el ID de la venta a eliminar
        $idVentaEliminar = $_POST['id_venta_eliminar'];
    
        // Realizar la conexión a la base de datos (ajusta los detalles de la conexión según tu configuración)
        $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");
    
        // Verificar la conexión
        if ($mysqli->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $mysqli->connect_error);
        }
    
        // Iniciar una transacción
        $mysqli->begin_transaction();
    
        // Eliminar los detalles de la venta
        $queryEliminarDetalles = "DELETE FROM detalles_ventas WHERE id_venta = ?";
        $stmtEliminarDetalles = $mysqli->prepare($queryEliminarDetalles);
        $stmtEliminarDetalles->bind_param("s", $idVentaEliminar);
    
        if (!$stmtEliminarDetalles->execute()) {
            // Si ocurre un error al eliminar los detalles, cancela la transacción y muestra un mensaje de error
            $mysqli->rollback();
            echo "Error al eliminar los detalles de la venta: " . $stmtEliminarDetalles->error;
            $stmtEliminarDetalles->close();
            $mysqli->close();
            exit;
        }
    
        $stmtEliminarDetalles->close();
    
        // Eliminar la venta
        $queryEliminarVenta = "DELETE FROM ventas WHERE id = ?";
        $stmtEliminarVenta = $mysqli->prepare($queryEliminarVenta);
        $stmtEliminarVenta->bind_param("s", $idVentaEliminar);
    
        if (!$stmtEliminarVenta->execute()) {
            // Si ocurre un error al eliminar la venta, cancela la transacción y muestra un mensaje de error
            $mysqli->rollback();
            echo "Error al eliminar la venta: " . $stmtEliminarVenta->error;
            $stmtEliminarVenta->close();
            $mysqli->close();
            exit;
        }
    
        $stmtEliminarVenta->close();
    
        // Finaliza la transacción y confirma los cambios
        $mysqli->commit();
    
        // Cierra la conexión a la base de datos
        $mysqli->close();
    
        // Redirige o muestra un mensaje de éxito
        header("Location: ventas.php"); // Cambia esto a la página de éxito que desees
        exit;
    }

?>