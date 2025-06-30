<?php

function Registercita($con, $cita)
{
    $sql = "INSERT INTO citasform ( dni,email,idmedico,motivo,nombre,telefono) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssissi", $cita['dni'], $cita['email'], $cita['idMedico'], $cita['motivo'], $cita['nombre'], $cita['telefono']);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

function validarhoradecita($con,$horastr,$idmedico){
    $fecha = DateTime::createFromFormat('d/m/Y, H:i:s', $horastr);
    $fechahora = $fecha->format('Y-m-d H:i:s');
    $sql = "SELECT * FROM citasform WHERE idmedico = ? AND fechahora = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $idmedico, $fechahora);
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
        case 'registrarCita':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = Registercita($conexion, $data['cita']);

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
