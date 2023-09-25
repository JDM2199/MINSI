<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Ventas</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="home.css">

</head>
<body>


<div class="barra-de-tareas">
        <ul>
            <li><a href="sesion.html">home</a></li>
            <li><a href="clientes.php">clientes</a></li>
            <li><a href="proveedor.php">proveedores</a></li>
            <li><a href="productos.php">productos</a></li>
            <li><a href="ventas.php">ventas</a></li>
        </ul>
    </div>
    <h1>Formulario de Ventas</h1>
    <form action="ventasBD.php" method="POST">
        <!-- Datos de la venta -->
        <h2>Datos de la Venta</h2>
        <label for="id_venta">ID de Venta:</label>
        <input type="text" id="id_venta" name="id_venta" required><br>

        <label for="fecha_venta">Fecha de Venta:</label>
        <input type="date" id="fecha_venta" name="fecha_venta" required><br>

        <label for="cliente">ID del Cliente:</label>
        <input type="text" id="cliente" name="cliente" required><br>

        <label for="descuento">Descuento (%):</label>
        <input type="text" id="descuento" name="descuento" oninput="calcularMontoTotalRegistro(this)"><br>

        <!-- Datos de los detalles de venta -->
        <h2>Datos de los Detalles de Venta</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Monto Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="productos">
                <tr class="producto">
                    <td>
                        <select name="productos[]" class="producto-select" required onchange="actualizarPrecioRegistro(this)">
                            <option value="">Seleccione un producto</option>
                            <?php
                            // Conectarse a la base de datos y obtener los productos (repetido para PHP)
                            $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
                            if (mysqli_connect_errno()) {
                                printf("MySQL connection failed with the error: %s", mysqli_connect_error());
                                exit;
                            }

                            $queryProductos = "SELECT nombre, precio_actual FROM productos";
                            $resultProductos = mysqli_query($mysqli_link, $queryProductos);

                            if ($resultProductos) {
                                while ($row = mysqli_fetch_assoc($resultProductos)) {
                                    echo "<option value='" . $row['nombre'] . "' data-precio='" . $row['precio_actual'] . "'>" . $row['nombre'] . "</option>";
                                }
                                mysqli_free_result($resultProductos);
                            }

                            mysqli_close($mysqli_link);
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="precios[]" readonly></td>
                    <td><input type="text" name="cantidades[]" id="cantidad_0" oninput="calcularMontoTotalRegistro(this)" required></td>
                    <td><input type="text" name="montos[]" id="monto_0" readonly></td>
                    <td><button type="button" onclick="eliminarFilaRegistro(this)">Eliminar</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" onclick="agregarFilaRegistro()">Agregar Producto</button>

        <!-- Campo oculto para el monto final -->
        <input type="hidden" id="monto_final" name="monto_final" value="0.00">

        <!-- Mostrar el Monto Total fuera de la tabla -->
        <h2>Monto Total: <span id="monto_total">0.00</span></h2>

        <!-- Botón para enviar el formulario de venta -->
        <input type="submit" name="registrarVenta" value="Registrar Venta">
    </form>

    <!-- Formulario de Modificar Venta -->
    <h1>Modificar Venta</h1>
    <form action="ventasBD.php" method="POST">
        <!-- Datos de la venta -->
        <h2>Datos de la Venta</h2>
        <label for="id_venta_modificar">ID de Venta:</label>
        <input type="text" id="id_venta_modificar" name="id_venta_modificar" required><br>

        <label for="fecha_venta_modificar">Fecha de Venta:</label>
        <input type="date" id="fecha_venta_modificar" name="fecha_venta_modificar" required><br>

        <label for="cliente_modificar">ID del Cliente:</label>
        <input type="text" id="cliente_modificar" name="cliente_modificar" required><br>

        <label for="descuento_modificar">Descuento (%):</label>
        <input type="text" id="descuento_modificar" name="descuento_modificar" oninput="calcularMontoTotalModificacion(this)"><br>

        <!-- Datos de los detalles de venta -->
        <h2>Datos de los Detalles de Venta</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Monto Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="productos_modificar">
                <tr class="producto">
                    <td>
                        <select name="productos_modificar[]" class="producto-select" required onchange="actualizarPrecioModificacion(this)">
                            <option value="">Seleccione un producto</option>
                            <?php
                            // Conectarse a la base de datos y obtener los productos (repetido para PHP)
                            $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
                            if (mysqli_connect_errno()) {
                                printf("MySQL connection failed with the error: %s", mysqli_connect_error());
                                exit;
                            }

                            $queryProductos = "SELECT nombre, precio_actual FROM productos";
                            $resultProductos = mysqli_query($mysqli_link, $queryProductos);

                            if ($resultProductos) {
                                while ($row = mysqli_fetch_assoc($resultProductos)) {
                                    echo "<option value='" . $row['nombre'] . "' data-precio='" . $row['precio_actual'] . "'>" . $row['nombre'] . "</option>";
                                }
                                mysqli_free_result($resultProductos);
                            }

                            mysqli_close($mysqli_link);
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="precios_modificar[]" readonly></td>
                    <td><input type="text" name="cantidades_modificar[]" id="cantidad_modificar_0" oninput="calcularMontoTotalModificacion(this)" required></td>
                    <td><input type="text" name="montos_modificar[]" id="monto_modificar_0" readonly></td>
                    <td><button type="button" onclick="eliminarFilaModificacion(this)">Eliminar</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" onclick="agregarFilaModificacion()">Agregar Producto</button>

        <!-- Campo oculto para el monto final -->
        <input type="hidden" id="monto_final_modificar" name="monto_final_modificar" value="0.00">

        <!-- Mostrar el Monto Total fuera de la tabla -->
        <h2>Monto Total: <span id="monto_total_modificar">0.00</span></h2>

        <!-- Botón para enviar el formulario de modificación -->
        <input type="submit" name="modificarVenta" value="Modificar Venta">
    </form>

    <h1>Eliminar Venta</h1>
<form action="ventasBD.php" method="POST">
    <!-- Datos de la venta a eliminar -->
    <label for="id_venta_eliminar">ID de Venta a Eliminar:</label>
    <input type="text" id="id_venta_eliminar" name="id_venta_eliminar" required><br>

    <!-- Botón para eliminar la venta -->
    <input type="submit" name="eliminarVenta" value="Eliminar Venta">
</form>


<h1>Mostrar Ventas</h1>
    <form method="POST" action="">
        <label for="cliente_seleccion">Seleccionar Cliente:</label>
        <select id="cliente_seleccion" name="cliente_seleccion">
            <option value="todos">Todos</option>
            <?php
            // Conectarse a la base de datos y obtener la lista de clientes
            $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

            if ($mysqli->connect_error) {
                die("La conexión a la base de datos ha fallado: " . $mysqli->connect_error);
            }

            $queryClientes = "SELECT rut FROM clientes";
            $resultClientes = $mysqli->query($queryClientes);

            if ($resultClientes) {
                while ($row = $resultClientes->fetch_assoc()) {
                    echo "<option value='" . $row['rut'] . "'>" . $row['rut'] . "</option>";
                }
                $resultClientes->free();
            }

            $mysqli->close();
            ?>
        </select>
        <input type="submit" name="mostrarVentas" value="Mostrar Ventas">
    </form>

    <?php
    if (isset($_POST['mostrarVentas'])) {
        // Obtener la selección del cliente
        $clienteSeleccionado = $_POST['cliente_seleccion'];

        // Realizar la conexión a la base de datos (ajusta los detalles de la conexión según tu configuración)
        $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

        if ($mysqli->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $mysqli->connect_error);
        }

        // Consulta SQL para obtener las ventas del cliente seleccionado o de todos los clientes
        if ($clienteSeleccionado === 'todos') {
            $queryVentas = "SELECT * FROM ventas";
        } else {
            $queryVentas = "SELECT * FROM ventas WHERE rut_cliente = '$clienteSeleccionado'";
        }

        $resultVentas = $mysqli->query($queryVentas);

        if ($resultVentas && $resultVentas->num_rows > 0) {
            echo "<h2>Ventas</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Monto Final</th><th>Descuento</th></tr>";
            while ($row = $resultVentas->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['rut_cliente'] . "</td>";
                echo "<td>" . $row['monto_final'] . "</td>";
                echo "<td>" . $row['descuento'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            $resultVentas->free();
        } else {
            echo "<p>No se encontraron ventas para el cliente seleccionado.</p>";
        }

        $mysqli->close();
    }
    ?>
    <script>

let filaId = 1;
    let filaIdModificacion = 1;

    // Función para agregar una nueva fila de registro
    function agregarFilaRegistro() {
        const tbody = document.getElementById("productos");
        const newRow = tbody.insertRow(tbody.rows.length);
        newRow.className = "producto";

        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        const cell3 = newRow.insertCell(2);
        const cell4 = newRow.insertCell(3);
        const cell5 = newRow.insertCell(4);

        const selectId = `producto_select_${filaId}`;
        const precioId = `precio_${filaId}`;
        const cantidadId = `cantidad_${filaId}`;
        const montoId = `monto_${filaId}`;

        cell1.innerHTML = `
            <select name="productos[]" class="producto-select" required>
                <option value="">Seleccione un producto</option>
                <?php
                // Conectarse a la base de datos y obtener los productos (repetido para PHP)
                $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
                if (mysqli_connect_errno()) {
                    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
                    exit;
                }

                $queryProductos = "SELECT nombre, precio_actual FROM productos";
                $resultProductos = mysqli_query($mysqli_link, $queryProductos);

                if ($resultProductos) {
                    while ($row = mysqli_fetch_assoc($resultProductos)) {
                        echo "<option value='" . $row['nombre'] . "' data-precio='" . $row['precio_actual'] . "'>" . $row['nombre'] . "</option>";
                    }
                    mysqli_free_result($resultProductos);
                }

                mysqli_close($mysqli_link);
                ?>
            </select>
        `;

        cell2.innerHTML = `<input type="text" name="precios[]" id="${precioId}" readonly>`;
        cell3.innerHTML = `<input type="text" name="cantidades[]" id="${cantidadId}" oninput="calcularMontoTotalRegistro(this)" required>`;
        cell4.innerHTML = `<input type="text" name="montos[]" id="${montoId}" readonly>`;
        cell5.innerHTML = '<button type="button" onclick="eliminarFilaRegistro(this)">Eliminar</button>';

        filaId++;
    }

    // Función para agregar una nueva fila de modificación
    function agregarFilaModificacion() {
        const tbody = document.getElementById("productos_modificar");
        const newRow = tbody.insertRow(tbody.rows.length);
        newRow.className = "producto";

        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        const cell3 = newRow.insertCell(2);
        const cell4 = newRow.insertCell(3);
        const cell5 = newRow.insertCell(4);

        const selectId = `producto_select_modificar_${filaIdModificacion}`;
        const precioId = `precio_modificar_${filaIdModificacion}`;
        const cantidadId = `cantidad_modificar_${filaIdModificacion}`;
        const montoId = `monto_modificar_${filaIdModificacion}`;

        cell1.innerHTML = `
            <select name="productos_modificar[]" class="producto-select" required>
                <option value="">Seleccione un producto</option>
                <?php
                // Conectarse a la base de datos y obtener los productos (repetido para PHP)
                $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
                if (mysqli_connect_errno()) {
                    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
                    exit;
                }

                $queryProductos = "SELECT nombre, precio_actual FROM productos";
                $resultProductos = mysqli_query($mysqli_link, $queryProductos);

                if ($resultProductos) {
                    while ($row = mysqli_fetch_assoc($resultProductos)) {
                        echo "<option value='" . $row['nombre'] . "' data-precio='" . $row['precio_actual'] . "'>" . $row['nombre'] . "</option>";
                    }
                    mysqli_free_result($resultProductos);
                }

                mysqli_close($mysqli_link);
                ?>
            </select>
        `;

        cell2.innerHTML = `<input type="text" name="precios_modificar[]" id="${precioId}" readonly>`;
        cell3.innerHTML = `<input type="text" name="cantidades_modificar[]" id="${cantidadId}" oninput="calcularMontoTotalModificacion(this)" required>`;
        cell4.innerHTML = `<input type="text" name="montos_modificar[]" id="${montoId}" readonly>`;
        cell5.innerHTML = '<button type="button" onclick="eliminarFilaModificacion(this)">Eliminar</button>';

        filaIdModificacion++;
    }
 // Función para eliminar una fila de registro
 function eliminarFilaRegistro(button) {
        const row = button.parentNode.parentNode;
        const tbody = row.parentNode;
        tbody.removeChild(row);
    }

    // Función para eliminar una fila de modificación
    function eliminarFilaModificacion(button) {
        const row = button.parentNode.parentNode;
        const tbody = row.parentNode;
        tbody.removeChild(row);
    }
 
    // Event delegation para actualizar el precio en el registro
    document.getElementById("productos").addEventListener("change", function (event) {
        const target = event.target;
        if (target && target.classList.contains("producto-select")) {
            actualizarPrecioRegistro(target);
        }
    });

    // Event delegation para actualizar el precio en la modificación
    document.getElementById("productos_modificar").addEventListener("change", function (event) {
        const target = event.target;
        if (target && target.classList.contains("producto-select")) {
            actualizarPrecioModificacion(target);
        }
    });

    function actualizarPrecioRegistro(select) {
        const selectedOption = select.options[select.selectedIndex];
        const precioInput = select.parentNode.nextElementSibling.querySelector('input[name="precios[]"]');
        precioInput.value = selectedOption.getAttribute('data-precio');
        calcularMontoTotalRegistro(select);
    }

    function actualizarPrecioModificacion(select) {
        const selectedOption = select.options[select.selectedIndex];
        const precioInput = select.parentNode.nextElementSibling.querySelector('input[name="precios_modificar[]"]');
        precioInput.value = selectedOption.getAttribute('data-precio');
        calcularMontoTotalModificacion(select);
    }


    function calcularMontoTotalRegistro(input) {
        const cantidadInput = input;
        const precioInput = input.parentNode.previousElementSibling.querySelector('input[name="precios[]"]');
        const montoInput = input.parentNode.nextElementSibling.querySelector('input[name="montos[]"]');
        const montoTotalSpan = document.getElementById("monto_total");
        const montoFinalInput = document.getElementById("monto_final");
        const descuentoInput = document.getElementById("descuento");

        const cantidad = parseFloat(cantidadInput.value);
        const precio = parseFloat(precioInput.value);
        const descuento = parseFloat(descuentoInput.value);

        if (!isNaN(cantidad) && !isNaN(precio)) {
            let montoTotal = cantidad * precio;
            if (!isNaN(descuento)) {
                // Aplicar descuento si se ha ingresado un valor válido
                montoTotal -= (montoTotal * (descuento / 100));
            }
            montoInput.value = montoTotal.toFixed(2);

            // Calcular el monto total acumulado
            let montoTotalAcumulado = 0;
            const montos = document.querySelectorAll('input[name="montos[]"]');
            montos.forEach(function (monto) {
                montoTotalAcumulado += parseFloat(monto.value);
            });

            // Actualizar el valor en el campo oculto
            montoFinalInput.value = montoTotalAcumulado.toFixed(2);

            // Actualizar el valor en el span de monto total
            montoTotalSpan.textContent = montoTotalAcumulado.toFixed(2);
        } else {
            montoInput.value = '';
        }
    }

    function calcularMontoTotalModificacion(input) {
        const cantidadInput = input;
        const precioInput = input.parentNode.previousElementSibling.querySelector('input[name="precios_modificar[]"]');
        const montoInput = input.parentNode.nextElementSibling.querySelector('input[name="montos_modificar[]"]');
        const montoTotalSpan = document.getElementById("monto_total_modificar");
        const montoFinalInput = document.getElementById("monto_final_modificar");
        const descuentoInput = document.getElementById("descuento_modificar");

        const cantidad = parseFloat(cantidadInput.value);
        const precio = parseFloat(precioInput.value);
        const descuento = parseFloat(descuentoInput.value);

        if (!isNaN(cantidad) && !isNaN(precio)) {
            let montoTotal = cantidad * precio;
            if (!isNaN(descuento)) {
                // Aplicar descuento si se ha ingresado un valor válido
                montoTotal -= (montoTotal * (descuento / 100));
            }
            montoInput.value = montoTotal.toFixed(2);

            // Calcular el monto total acumulado
            let montoTotalAcumulado = 0;
            const montos = document.querySelectorAll('input[name="montos_modificar[]"]');
            montos.forEach(function (monto) {
                montoTotalAcumulado += parseFloat(monto.value);
            });

            // Actualizar el valor en el campo oculto
            montoFinalInput.value = montoTotalAcumulado.toFixed(2);

            // Actualizar el valor en el span de monto total
            montoTotalSpan.textContent = montoTotalAcumulado.toFixed(2);
        } else {
            montoInput.value = '';
        }
    }
</script>
</body>
</html>