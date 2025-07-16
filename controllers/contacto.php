<?php

function registrarconsulta($con, $motivo, $name, $email, $telefono, $tituloMensaje, $contenidomensaje, $linkFoto)
{
    $sql = "INSERT INTO contactos
(motivo,name,email,telefono,titulomensaje,contenidomensaje,linkfoto)
VALUES(?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $motivo, $name, $email, $telefono, $tituloMensaje, $contenidomensaje, $linkFoto);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

// Verify if receiving POST request with JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set response header as JSON
    header('Content-Type: application/json');

    // Decode received JSON
    $data = json_decode(file_get_contents("php://input"), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    // Validate received data    

    include_once('db.php');
    switch ($data['action']) {
        case 'consulta':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = registrarconsulta($conexion, $data['motivo'], $data['name'], $data['email'], $data['telefono'], $data['tituloMensaje'], $data['contenidomensaje'], $data['linkimgurl']);

                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'registro exitoso', 'id' => $conexion->insert_id]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'registro fallido']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(['success' => false]);
            break;
    }
}
