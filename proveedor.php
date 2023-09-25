<!DOCTYPE html>
<html>
<head>

    <title>Formulario de Proveedores</title>
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


    <h1>Formulario de Proveedores</h1>
    <form action="proveedorBD.php" method="POST">
        <!-- Datos del proveedor -->
        <h2>Datos del Proveedor</h2>
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

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono"><br>

        <label for="pagina_web">Página Web:</label>
        <input type="text" id="pagina_web" name="pagina_web"><br>

        <!-- Botón para enviar el formulario de registro -->
        <input type="submit" name="registrar" value="Registrar Proveedor">
    </form>


    <?php
    // Verificar si hay un mensaje de confirmación en la sesión
    session_start();
    if (isset($_SESSION['confirmacion_registrar_proveedor'])) {
        echo '<p>' . $_SESSION['confirmacion_registrar_proveedor'] . '</p>';
        // Limpiar el mensaje de confirmación para que no se muestre nuevamente
        unset($_SESSION['confirmacion_registrar_proveedor']);
    }
    ?>

    <h1>Modificar Proveedor</h1>
    <form action="proveedorBD.php" method="POST">
        <label for="rutModificar">RUT del Proveedor a Modificar:</label>
        <input type="text" id="rutModificar" name="rutModificar" required><br>

        <!-- Datos del proveedor a modificar -->
        <h2>Datos del Proveedor</h2>
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

        <label for="telefonoModificar">Teléfono:</label>
        <input type="text" id="telefonoModificar" name="telefonoModificar"><br>

        <label for="pagina_webModificar">Página Web:</label>
        <input type="text" id="pagina_webModificar" name="pagina_webModificar"><br>

        <!-- Botón para enviar el formulario de modificación -->
        <input type="submit" name="modificar" value="Modificar Proveedor">
    </form>

    <?php
    // Verificar si hay un mensaje de confirmación en la sesión
    if (isset($_SESSION['confirmacion_modificar_proveedor'])) {
        echo '<p>' . $_SESSION['confirmacion_modificar_proveedor'] . '</p>';
        // Limpiar el mensaje de confirmación para que no se muestre nuevamente
        unset($_SESSION['confirmacion_modificar_proveedor']);
    }
    ?>

    <h1>Eliminar Proveedor</h1>
<form action="proveedorBD.php" method="POST">
    <label for="rutEliminar">RUT del Proveedor a Eliminar:</label>
    <input type="text" id="rutEliminar" name="rutEliminar" required><br>

    <!-- Botón para enviar el formulario de eliminación -->
    <input type="submit" name="eliminar" value="Eliminar Proveedor">
</form>
<?php
    // Verificar si hay un mensaje de confirmación en la sesión
   
    if (isset($_SESSION['confirmacion_eliminar_proveedor'])) {
        echo '<p>' . $_SESSION['confirmacion_eliminar_proveedor'] . '</p>';
        // Limpiar el mensaje de confirmación para que no se muestre nuevamente
        unset($_SESSION['confirmacion_eliminar_proveedor']);
    }
    ?>


  <!-- Formulario para mostrar un proveedor individual -->
  <form action="proveedor.php" method="POST">
        <h2>Mostrar Proveedor Individual</h2>
        <label for="rutIndividual">RUT del Proveedor:</label>
        <input type="text" id="rutIndividual" name="rutIndividual" required>
        <input type="submit" name="mostrarIndividual" value="Mostrar Proveedor">
    </form>

    <!-- Formulario para mostrar todos los proveedores -->
    <form action="proveedor.php" method="POST">
        <h2>Mostrar Todos los Proveedores</h2>
        <input type="submit" name="mostrarTodos" value="Mostrar Todos">
        
    </form>


    <?php
// Establecer los datos de conexión a la base de datos
$mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
if (mysqli_connect_errno()) {
    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
    exit;
}

// Procesar la solicitud de mostrar proveedor individual
if (isset($_POST["mostrarIndividual"])) {
    $rutIndividual = $_POST["rutIndividual"];
    $query = "SELECT * FROM proveedores WHERE rut = '$rutIndividual'";
    $result = mysqli_query($mysqli_link, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            echo "<h2>Proveedor Encontrado:</h2>";
            echo "<p>RUT: " . $row["rut"] . "</p>";
            echo "<p>Nombre: " . $row["nombre"] . "</p>";
            echo "<p>Calle: " . $row["direccion_calle"] . "</p>";
            echo "<p>Número: " . $row["direccion_numero"] . "</p>";
            echo "<p>Comuna: " . $row["direccion_comuna"] . "</p>";
            echo "<p>Ciudad: " . $row["direccion_ciudad"] . "</p>";
            echo "<p>Teléfono: " . $row["telefono"] . "</p>";
            echo "<p>Página Web: " . $row["pagina_web"] . "</p>";
        } else {
            echo "Proveedor no encontrado.";
        }
    } else {
        echo "Error al buscar proveedor: " . mysqli_error($mysqli_link);
    }
}

// Procesar la solicitud de mostrar todos los proveedores
if (isset($_POST["mostrarTodos"])) {
    $query = "SELECT * FROM proveedores";
    $result = mysqli_query($mysqli_link, $query);

    if ($result) {
        echo "<h2>Proveedores:</h2>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>RUT: " . $row["rut"] . "</p>";
            echo "<p>Nombre: " . $row["nombre"] . "</p>";
            echo "<p>Calle: " . $row["direccion_calle"] . "</p>";
            echo "<p>Número: " . $row["direccion_numero"] . "</p>";
            echo "<p>Comuna: " . $row["direccion_comuna"] . "</p>";
            echo "<p>Ciudad: " . $row["direccion_ciudad"] . "</p>";
            echo "<p>Teléfono: " . $row["telefono"] . "</p>";
            echo "<p>Página Web: " . $row["pagina_web"] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "Error al obtener la lista de proveedores: " . mysqli_error($mysqli_link);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($mysqli_link);
?>

    

</body>
</html>
