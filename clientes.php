<!DOCTYPE html>
<html>
<head>
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


    <h1>Formulario de Clientes</h1>
 <?php
    // Manejo de mensajes de confirmación o error
    if (isset($_GET['mensaje_confirmacion'])) {
        echo "<p>Mensaje Confirmación: {$_GET['mensaje_confirmacion']}</p>";
    }

    if (isset($_GET['mensaje_error'])) {
        echo "<p>Mensaje Error: {$_GET['mensaje_error']}</p>";
    }
    ?>
    <form action="clientesBD.php" method="POST">
        <!-- Datos del cliente -->
        <h2>Datos del Cliente</h2>
        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="calle">Calle:</label>
        <input type="text" id="calle" name="calle"><br>

        <label for="numero">Número:</label>
        <input type="text" id="numero" name="numero"><br>

        <label for="comuna">Comuna:</label>
        <input type="text" id="comuna" name="comuna"><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad"><br>

        <!-- Números de teléfono -->
        <h2>Números de Teléfono</h2>
        <div id="telefonosContainer">
            <div class="telefono">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefonos[]" required>
                <button type="button" onclick="agregarTelefono()">Agregar Teléfono</button>
            </div>
        </div>

        <!-- Botón para enviar el formulario de registro -->
        <input type="submit" name="registrarCliente" value="Registrar Cliente">
    </form>
    

    <h2>Modificar Cliente</h2>
    <?php
    // Manejo de mensajes de confirmación o error
    if (isset($_GET['mensaje_modificar'])) {
        echo "<p>Mensaje Confirmación: {$_GET['mensaje_modificar']}</p>";
    }

    if (isset($_GET['mensaje_error'])) {
        echo "<p>Mensaje Error: {$_GET['mensaje_error']}</p>";
    }
    ?>
    <form action="clientesBD.php" method="POST">
        <label for="rutModificar">RUT del Cliente a Modificar:</label>
        <input type="text" id="rutModificar" name="rutModificar" required><br>

        <!-- Datos del cliente a modificar -->
        <h3>Datos del Cliente</h3>
        <label for="nombreModificar">Nombre:</label>
        <input type="text" id="nombreModificar" name="nombreModificar" required><br>

        <label for="calleModificar">Calle:</label>
        <input type="text" id="calleModificar" name="calleModificar"><br>

        <label for="numeroModificar">Número:</label>
        <input type="text" id="numeroModificar" name="numeroModificar"><br>

        <label for="comunaModificar">Comuna:</label>
        <input type="text" id="comunaModificar" name="comunaModificar"><br>

        <label for="ciudadModificar">Ciudad:</label>
        <input type="text" id="ciudadModificar" name="ciudadModificar"><br>

        <!-- Números de teléfono a modificar -->
        <h3>Números de Teléfono a Modificar</h3>
        <div id="telefonosModificarContainer">
            <div class="telefonoModificar">
                <label for="telefonoModificar">Teléfono:</label>
                <input type="text" name="telefonosModificar[]">
                <button type="button" onclick="agregarTelefonoModificar()">Agregar Teléfono</button>
            </div>
        </div>

        <!-- Botón para enviar el formulario de modificación -->
        <input type="submit" name="modificarCliente" value="Modificar Cliente">
    </form>
    <h1>Eliminar Cliente</h1>

    <?php
    // Manejo de mensajes de confirmación o error
    if (isset($_GET['mensaje_eliminar'])) {
        echo "<p>Mensaje Confirmación: {$_GET['mensaje_eliminar']}</p>";
    }

    if (isset($_GET['mensaje_eliminar'])) {
        echo "<p>Mensaje Error: {$_GET['mensaje_eliminar']}</p>";
    }
    ?>


    <form action="clientesBD.php" method="POST">
        <label for="rutEliminar">RUT del Cliente a Eliminar:</label>
        <input type="text" id="rutEliminar" name="rutEliminar" required><br>

        <!-- Botón para eliminar el cliente y sus teléfonos -->
        <input type="submit" name="eliminar_cliente" value="Eliminar Cliente">
    </form>

    <h1>Mostrar Clientes</h1>
    
    <!-- Formulario para mostrar un cliente individual por RUT -->
    <form action="clientes.php" method="POST">
        <h2>Mostrar Cliente por RUT</h2>
        <label for="rutIndividual">RUT del Cliente:</label>
        <input type="text" id="rutIndividual" name="rutIndividual" required>
        <input type="submit" value="Mostrar Cliente Individual">
    </form>

    <!-- Botón para mostrar todos los clientes -->
    <form action="clientes.php" method="POST">
        <input type="hidden" name="mostrarTodos" value="true">
        <input type="submit" value="Mostrar Todos los Clientes">
    </form>
    <?php
// Establecer los datos de conexión a la base de datos
$mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
if (mysqli_connect_errno()) {
    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
    exit;
}

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

    <script>
        function agregarTelefono() {
            const telefonosContainer = document.getElementById('telefonosContainer');
            const telefonoDiv = document.createElement('div');
            telefonoDiv.className = 'telefono';
            telefonoDiv.innerHTML = `
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefonos[]" required>
                <button type="button" onclick="eliminarTelefono(this)">Eliminar Teléfono</button>
            `;
            telefonosContainer.appendChild(telefonoDiv);
        }

        function eliminarTelefono(button) {
            const telefonoDiv = button.parentElement;
            const telefonosContainer = document.getElementById('telefonosContainer');
            telefonosContainer.removeChild(telefonoDiv);
        }

        function agregarTelefonoModificar() {
            const telefonosModificarContainer = document.getElementById('telefonosModificarContainer');
            const telefonoModificarDiv = document.createElement('div');
            telefonoModificarDiv.className = 'telefonoModificar';
            telefonoModificarDiv.innerHTML = `
                <label for="telefonoModificar">Teléfono:</label>
                <input type="text" name="telefonosModificar[]">
                <button type="button" onclick="eliminarTelefonoModificar(this)">Eliminar Teléfono</button>
            `;
            telefonosModificarContainer.appendChild(telefonoModificarDiv);
        }

        function eliminarTelefonoModificar(button) {
            const telefonoModificarDiv = button.parentElement;
            const telefonosModificarContainer = document.getElementById('telefonosModificarContainer');
            telefonosModificarContainer.removeChild(telefonoModificarDiv);
        }
    </script>
</body>
</html>
