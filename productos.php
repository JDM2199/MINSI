<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Productos</title>

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

    <h1>Formulario de Productos</h1>
    <form action="productosBD.php" method="POST">
        <!-- Datos del producto -->
        <h2>Datos del Producto</h2>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="precio">Precio Actual:</label>
        <input type="text" id="precio" name="precio" required><br>

        <label for="stock">Stock:</label>
        <input type="text" id="stock" name="stock" required><br>

        <!-- Select para la categoría -->
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php
            // Conectarse a la base de datos y obtener las categorías
            $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
            if (mysqli_connect_errno()) {
                printf("MySQL connection failed with the error: %s", mysqli_connect_error());
                exit;
            }

            $queryCategorias = "SELECT id, nombre FROM categorias";
            $resultCategorias = mysqli_query($mysqli_link, $queryCategorias);

            if ($resultCategorias) {
                while ($row = mysqli_fetch_assoc($resultCategorias)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                }
                mysqli_free_result($resultCategorias);
            }

            mysqli_close($mysqli_link);
            ?>
        </select><br>

        <!-- Select para el proveedor -->
        <label for="proveedor">Proveedor:</label>
        <select id="proveedor" name="proveedor" required>
            <?php
            // Conectarse a la base de datos y obtener los proveedores
            $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
            if (mysqli_connect_errno()) {
                printf("MySQL connection failed with the error: %s", mysqli_connect_error());
                exit;
            }

            $queryProveedores = "SELECT rut, nombre FROM proveedores";
            $resultProveedores = mysqli_query($mysqli_link, $queryProveedores);

            if ($resultProveedores) {
                while ($row = mysqli_fetch_assoc($resultProveedores)) {
                    echo "<option value='" . $row['rut'] . "'>" . $row['nombre'] . "</option>";
                }
                mysqli_free_result($resultProveedores);
            }

            mysqli_close($mysqli_link);
            ?>
        </select><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" name="registrar"value="Registrar Producto">
    </form>

    <?php
    // Verificar si hay un mensaje de confirmación en la sesión
    session_start();
    if (isset($_SESSION['confirmacion_registrar'])) {
        echo '<p>' . $_SESSION['confirmacion_registrar'] . '</p>';
        // Limpiar el mensaje de confirmación para que no se muestre nuevamente
        unset($_SESSION['confirmacion_registrar']);
    }
    ?>


    <h2>Modificar Producto</h2>
<form action="productosBD.php" method="POST">
    <label for="idModificar">Nombre del Producto a Modificar:</label>
    <input type="text" id="idModificar" name="idModificar" required><br>

    <!-- Datos del producto a modificar -->
    <label for="nombreModificar">Nombre:</label>
    <input type="text" id="nombreModificar" name="nombreModificar" required><br>

    <label for="precioModificar">Precio:</label>
    <input type="text" id="precioModificar" name="precioModificar" required><br>

    <label for="stockModificar">Stock:</label>
    <input type="text" id="stockModificar" name="stockModificar" required><br>

    <!-- Select para la categoría -->
    <label for="categoriaModificar">Categoría:</label>
    <select id="categoriaModificar" name="categoriaModificar" required>
        <?php
        // Conectarse a la base de datos y obtener las categorías
        $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
        if (mysqli_connect_errno()) {
            printf("MySQL connection failed with the error: %s", mysqli_connect_error());
            exit;
        }

        $queryCategorias = "SELECT id, nombre FROM categorias";
        $resultCategorias = mysqli_query($mysqli_link, $queryCategorias);

        if ($resultCategorias) {
            while ($row = mysqli_fetch_assoc($resultCategorias)) {
                echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
            }
            mysqli_free_result($resultCategorias);
        }

        mysqli_close($mysqli_link);
        ?>
    </select><br>

    <!-- Select para el proveedor -->
    <label for="proveedorModificar">Proveedor:</label>
    <select id="proveedorModificar" name="proveedorModificar" required>
        <?php
        // Conectarse a la base de datos y obtener los proveedores
        $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
        if (mysqli_connect_errno()) {
            printf("MySQL connection failed with the error: %s", mysqli_connect_error());
            exit;
        }

        $queryProveedores = "SELECT rut, nombre FROM proveedores";
        $resultProveedores = mysqli_query($mysqli_link, $queryProveedores);

        if ($resultProveedores) {
            while ($row = mysqli_fetch_assoc($resultProveedores)) {
                echo "<option value='" . $row['rut'] . "'>" . $row['nombre'] . "</option>";
            }
            mysqli_free_result($resultProveedores);
        }

        mysqli_close($mysqli_link);
        ?>
    </select><br>

    <!-- Botón para enviar el formulario de modificación -->
    <input type="submit" name="modificar" value="Modificar Producto">

</form>

<?php
// Verificar si hay un mensaje de confirmación en la sesión
if (isset($_SESSION['confirmacion'])) {
    echo '<p>' . $_SESSION['confirmacion'] . '</p>';
    // Limpiar el mensaje de confirmación para que no se muestre nuevamente
    unset($_SESSION['confirmacion']);
}
?>


<h1>Eliminar Producto</h1>
    <form action="productosBD.php" method="POST">
        <label for="nombreEliminar">Nombre del Producto a Eliminar:</label>
        <input type="text" id="nombreEliminar" name="nombreEliminar" required><br>

        <!-- Botón para eliminar el producto -->
        <input type="submit" name="eliminar" value="Eliminar Producto">
    </form>
    <?php
    // Verificar si hay un mensaje de confirmación en la sesión
    if (isset($_SESSION['confirmacion_eliminar'])) {
        echo '<p>' . $_SESSION['confirmacion_eliminar'] . '</p>';
        // Limpiar el mensaje de confirmación para que no se muestre nuevamente
        unset($_SESSION['confirmacion_eliminar']);
    }
    ?>


    <h1>Mostrar Productos</h1>

    <!-- Formulario para mostrar un producto por nombre -->
    <form action="productos.php" method="POST">
        <h2>Mostrar Producto Individual</h2>
        <label for="nombreMostrar">Nombre del Producto:</label>
        <input type="text" id="nombreMostrar" name="nombreMostrar" required><br>
        <input type="submit" name="mostrarIndividual" value="Mostrar Producto Individual">
    </form>

    <!-- Formulario para mostrar todos los productos -->
    <form action="productos.php" method="POST">
        <h2>Mostrar Todos los Productos</h2>
        <input type="submit" name="mostrarTodos" value="Mostrar Todos los Productos">
    </form>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión a la base de datos
    $mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
    if (mysqli_connect_errno()) {
        printf("MySQL connection failed with the error: %s", mysqli_connect_error());
        exit;
    }
    
    if (isset($_POST["mostrarIndividual"])) {
        // Procesar la solicitud de mostrar un producto individual
        $nombreMostrar = $_POST["nombreMostrar"];
        
        $queryMostrarProducto = "SELECT * FROM productos WHERE nombre = '$nombreMostrar'";
        $resultMostrarProducto = mysqli_query($mysqli_link, $queryMostrarProducto);
        
        if ($resultMostrarProducto) {
            // Mostrar los detalles del producto individual
            while ($row = mysqli_fetch_assoc($resultMostrarProducto)) {
                echo "<h2>Detalles del Producto</h2>";
                echo "Nombre: " . $row["nombre"] . "<br>";
                echo "Precio Actual: " . $row["precio_actual"] . "<br>";
                echo "Stock: " . $row["stock"] . "<br>";
                echo "Categoría: " . $row["id_categoria"] . "<br>";
                echo "Proveedor: " . $row["rut_proveedor"] . "<br>";
            }
        } else {
            // No se encontró el producto
            echo "Producto no encontrado.";
        }
    }

    if (isset($_POST["mostrarTodos"])) {
        // Procesar la solicitud de mostrar todos los productos
        $queryMostrarTodos = "SELECT * FROM productos";
        $resultMostrarTodos = mysqli_query($mysqli_link, $queryMostrarTodos);
        
        if ($resultMostrarTodos && mysqli_num_rows($resultMostrarTodos) > 0) {
            // Mostrar todos los productos disponibles
            echo "<h2>Lista de Todos los Productos</h2>";
            while ($row = mysqli_fetch_assoc($resultMostrarTodos)) {
                echo "<h3>Producto: " . $row["nombre"] . "</h3>";
                echo "Precio Actual: " . $row["precio_actual"] . "<br>";
                echo "Stock: " . $row["stock"] . "<br>";
                echo "Categoría: " . $row["id_categoria"] . "<br>";
                echo "Proveedor: " . $row["rut_proveedor"] . "<br><br>";
            }
        } else {
            // No se encontraron productos
            echo "No hay productos disponibles.";
        }
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($mysqli_link);
}
?>


</body>
</html>
