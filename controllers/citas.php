<?php
function guardarlink($con, $data)
{
    $sql = "UPDATE citasform SET linkreunion=? WHERE id=?;";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "si", $data['link'], $data['id']);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $filasAfectadas = mysqli_stmt_affected_rows($stmt);
        if ($filasAfectadas == 1) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            mysqli_stmt_close($stmt);
            return false;
        }
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}
function crearlinkdezoom($data)
{
    $clientId = 'ScQutIeWQwqFMJQ97jwNgQ';       // Reemplaza con el real
    $clientSecret = '6Ft0c7BMeOxxC43vqgdjNQckYheMtfXR'; // Reemplaza con el real
    $accountId = 'wm9CTj3PQoyX3lsxfb06_Q';     // Reemplaza con el real
    $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$accountId";
    $headers = [
        "Authorization: Basic " . base64_encode("$clientId:$clientSecret")
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $access_token = json_decode($response)->access_token;
    curl_close($ch);

    $hostEmail = 'acostasanchezangelgabriel@gmail.com';
    $fechaLocal = new DateTime($data['fecha'], new DateTimeZone('America/Mexico_City'));
    $fechaUTC = $fechaLocal->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d\TH:i:s\Z');

    $meetingData = [
        'topic' => 'Consulta programada con paciente',
        'type' => 2,
        'start_time' => $fechaUTC,
        'duration' => 30,
        'timezone' => 'America/Mexico_City',
        'settings' => [
            'host_video' => true,
            'participant_video' => true,
            'join_before_host' => true
        ]
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.zoom.us/v2/users/$hostEmail/meetings");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($meetingData));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 201) {
        return false;
    } else {
        $responseData = json_decode($response, true);
        $link = $responseData['join_url'];
        return $link;
    }
}
function validardisponibilidad($con, $fecha, $idMedico)
{
    $sql = "SELECT * FROM citasform WHERE idmedico = ? AND fechayhora = ? ";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "is", $idMedico, $fecha);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    if ($num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
function Registercita($con, $cita)
{
    $sql = "INSERT INTO citasform ( dni,email,idmedico,motivo,nombre,telefono,fechayhora) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssissis", $cita['dni'], $cita['email'], $cita['idMedico'], $cita['motivo'], $cita['nombre'], $cita['telefono'], $cita['fecha']);
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
                $response = Registercita($conexion, $data);

                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'registro exitoso', 'id' => $conexion->insert_id]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'registro fallido']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        case 'validarFechayhora':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = validardisponibilidad($conexion, $data['fecha'], $data['idMedico']);
                if ($response) {
                    echo json_encode(['success' => false, 'message' => 'el medico no esta disponible para ese horario, por favor elija otro horario']);
                } else {
                    echo json_encode(['success' => true, 'message' => 'el medico esta disponible para ese horario']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        case 'crearlinkdezoom':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = crearlinkdezoom($data);
                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'registro exitoso', 'link' => $response]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'registro fallido']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        case 'guardarlinkenreunion':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = guardarlink($conexion, $data);
                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'registro exitoso']);
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
