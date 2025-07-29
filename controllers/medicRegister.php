<?php

function RegisterMedico($con, $completename, $apellidosDoctores, $cmp, $rne, $especialidad, $email, $telefono, $metododepago, $tarifa, $tiempoconsulta, $enlacedefoto, $numerodeatenciones, $resenia, $mensajeparapaciente, $prefijo, $horarios)
{
    $fechadeaceptacion = date("Y-m-d H:i:s");

    $sql = "INSERT INTO medico
(completename, apellidosDoctores, cmp, rne, especialidad, email, telefono, metodoDePago, tarifa, tiempoEnMinConsulta, LinkFoto, NumeroAtenciones, Resenia, mensajePacientes, fechaDeAceptacionCondicionesyEnvioDeformulacio,prefijo,horariosemanal)
VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?);";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssiissisiisssssss", $completename, $apellidosDoctores, $cmp, $rne, $especialidad, $email, $telefono, $metododepago, $tarifa, $tiempoconsulta, $enlacedefoto, $numerodeatenciones, $resenia, $mensajeparapaciente, $fechadeaceptacion, $prefijo, $horarios);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

function enviarCorreoInteresado($data)
{
    $email = $data['email'];
    $nombres = $data['Name'];
    $apellidos = $data['apellidos'];
    $nombres_separados = explode(" ", $nombres);
    $apellidos_separados = explode(" ", $apellidos);
    $mensaje = "Hola hemos recidido tus datos y generamos tu perfil medico,tu enlace es: https://www.consultame.pe/" . strtolower($nombres_separados[0] . $apellidos_separados[0]);
    // Validación básica
    if (empty($nombres) || empty($email) || empty($mensaje)) {
        return false;
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
        exit;
    }

    // Sanitizar el correo electrónico
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Datos del correo
    $para = $data['email'];
    $asunto = "Perfil medico Consultame.pe";
    $cabecera = "From: no-reply@consultame.pe";
    $mail = mail($para, $asunto, $mensaje, $cabecera);

    // Enviar el correo
    if ($mail) {
        return true;
    } else {
        return false;
    }
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
                if (!$result) {
                    echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
                    exit;
                }
            }
            try {
                $response = RegisterMedico($conexion, $data['Name'], $data['apellidos'], $data['cmp'], $data['rne'], $data['especialidad'], $data['email'], $data['telefono'], $data['metodoPago'], $data['tarifa'], $data['tiempoConsulta'], $data['linkimgurl'], $data['seleccionHoras'], $data['reseniaDoctor'], $data['mensajeFpaciente'], $data['prefijo'], $data['horarios']);

                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'registro exitoso', 'id' => $conexion->insert_id]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'registro fallido']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        case 'enviarcorreo':
            if (!$conexion) {
                if (!$result) {
                    echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
                    exit;
                }
            }
            try {
                $response = enviarCorreoInteresado($data);

                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'correo enviado con exito']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'correo fallido']);
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
