<?php

function RegisterMedico($con, $completename, $apellidosDoctores, $cmp, $rne, $especialidad, $email, $telefono, $metododepago, $tarifa, $tiempoconsulta, $horario, $enlacedefoto, $numerodeatenciones, $resenia, $mensajeparapaciente)
{
    $fechadeaceptacion = date("Y-m-d H:i:s");

    $sql = "INSERT INTO medico
(completename, apellidosDoctores, cmp, rne, especialidad, email, telefono, metodoDePago, tarifa, tiempoEnMinConsulta, HorarioDeConsulta, LinkFoto, NumeroAtenciones, Resenia, mensajePacientes, fechaDeAceptacionCondicionesyEnvioDeformulacio)
VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssiissisiissssss", $completename, $apellidosDoctores, $cmp, $rne, $especialidad, $email, $telefono, $metododepago, $tarifa, $tiempoconsulta, $horario, $enlacedefoto, $numerodeatenciones, $resenia, $mensajeparapaciente, $fechadeaceptacion);
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
        case 'register':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = RegisterMedico($conexion, $data['Name'], $data['apellidos'], $data['cmp'], $data['rne'], $data['especialidad'], $data['email'], $data['telefono'], $data['metodoPago'], $data['tarifa'], $data['tiempoConsulta'], $data['horarioConsulta'], $data['linkimgurl'], $data['seleccionHoras'], $data['reseniaDoctor'], $data['mensajeFpaciente']);

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
