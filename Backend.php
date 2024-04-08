<?php

// Incluir archivo de conexión a la base de datos
include 'Conexion.php';

// Verificar el tipo de solicitud y llamar a la función correspondiente
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    obtenerCatalogo();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'obtener':
            obtenerProducto($_POST['id']);
            break;
        case 'comprar':
            comprarProductos($_POST['carrito']);
            break;
        default:
            // Si se recibe una solicitud no válida, devolver un mensaje de error
            echo "Solicitud no válida.";
            break;
    }
} else {
    // Si se recibe una solicitud no válida, devolver un mensaje de error
    echo "Solicitud no válida.";
}

// Función para obtener los productos del catálogo
function obtenerCatalogo() {
    // Simulación de productos (en un caso real se debería obtener de una base de datos)
    $productos = array(
        array('id' => 1, 'nombre' => 'Producto 1', 'precio' => 10.99, 'stock' => 10),
        array('id' => 2, 'nombre' => 'Producto 2', 'precio' => 19.99, 'stock' => 10),
        array('id' => 3, 'nombre' => 'Producto 3', 'precio' => 14.99, 'stock' => 10),
    );
    echo json_encode($productos);
}

// Función para obtener un producto por su ID
function obtenerProducto($idProducto) {
    // Simulación de búsqueda de producto por ID (en un caso real se debería obtener de una base de datos)
    $producto = array('id' => $idProducto, 'nombre' => 'Producto ' . $idProducto, 'precio' => 10.99, 'stock' => 10);
    echo json_encode($producto);
}

// Función para comprar los productos del carrito
function comprarProductos($carrito) {
    // Convertir el JSON del carrito a un array
    $carritos = json_decode($carrito, true);

    if ($carritos === null) {
        echo "Error: Los datos del carrito no son válidos.";
        return;
    }

    // Aquí se debe establecer la conexión a la base de datos
    $conexionBD = ConexionBD::obtenerInstancia()->obtenerConexion();

    // Supongamos que $idUsuario es el ID del usuario actual
    $idUsuario = 1; // Por ejemplo, el ID del usuario actual

    foreach ($carritos as $productos) {
        foreach ($productos as $producto) {
            // Verificar que los valores sean válidos
            $idProducto = isset($producto['id']) ? $producto['id'] : null;
            $cantidad = isset($producto['cantidad']) ? $producto['cantidad'] : null;

            // Validar que los valores no estén vacíos y sean numéricos
            if (!is_numeric($idProducto) || !is_numeric($cantidad)) {
                echo "Error: Los datos del producto no son válidos.";
                return;
            }

            // Aquí se debe preparar la consulta SQL para insertar los datos en la tabla de carrito
            $sql = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES ('$idUsuario', '$idProducto', '$cantidad')";

            // Aquí se ejecuta la consulta SQL
            if ($conexionBD->query($sql) !== TRUE) {
                echo "Error al agregar el producto al carrito: " . $conexionBD->error;
                return;
            }
        }
    }

    echo "Productos comprados correctamente.";
}
?>
