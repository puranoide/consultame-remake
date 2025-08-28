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
function Registercita($con, $cita, $rutaarchivo)
{
    $sql = "INSERT INTO citasform ( dni,email,idmedico,motivo,nombre,telefono,fechayhora,rutaarchivo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssississ", $cita['dni'], $cita['email'], $cita['idMedico'], $cita['motivo'], $cita['nombre'], $cita['telefono'], $cita['fecha'], $rutaarchivo);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}
function obtenerHorariosdoctor($con, $id)
{
    $sql = "SELECT horariosemanal FROM medico WHERE idMedico = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $horarios = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $horarios[] = $row;
        }
        return $horarios;
    } else {
        return false;
    }
}

function enviarcorreo($data)
{
    $email = $data['email'];
    $nombres = $data['nombre'];
    $mensaje = "Hola " . $nombres . ",\n\nHemos recibido tus datos para tu cita medica con fecha: " . $data['fecha'] . ".\n\nPodras unirte a tu cita mediante zoom en el siguiente link: " . $data['linkparajson'];
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
    $asunto = "Cita medica Consultame.pe";
    $cabecera = "From: no-reply@consultame.pe";
    $mail = mail($para, $asunto, $mensaje, $cabecera);

    // Enviar el correo
    if ($mail) {
        return true;
    } else {
        return false;
    }
}

function obtenermedico($con, $id)
{
    $sql = "SELECT*FROM medico WHERE idMedico = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}


function guardarArchivo($con, $archivo, $datoscita)
{

    $carpetadestino = "../vouchers/";

    $namearchivo = basename($archivo['name']);

    // Verificar si la carpeta existe, si no, crearla
    if (!file_exists($carpetadestino)) {
        mkdir($carpetadestino, 0777, true);
    }

    if (!$con) {
        return false;
    }
    try {
        $medico = obtenermedico($con, $datoscita['idMedico']);
        if ($medico) {
            $nombreDoctor = $medico['completename'];

            // Formatear la fecha para que sea válida en el nombre del archivo
            $fechaOriginal = $datoscita['fecha'];
            $fechaFormateada = str_replace([':', ' '], ['-', '_'], $fechaOriginal);

            // Construir el nombre del archivo
            $extension = pathinfo($namearchivo, PATHINFO_EXTENSION);
            $nombreArchivo = $nombreDoctor . "_" . $fechaFormateada . "." . $extension;

            // Ruta completa
            $rutaArchivo = $carpetadestino . $nombreArchivo;

            // Crear la carpeta si no existe
            if (!is_dir($carpetadestino)) {
                mkdir($carpetadestino, 0777, true);
            }

            // Mover el archivo
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                return $rutaArchivo;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (\Throwable $th) {
        return false;
    }
}


// Verify if receiving POST request with JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set response header as JSON
    header('Content-Type: application/json');

    include_once('db.php');
    // Si viene multipart/form-data (con archivos)
    if (isset($_POST['action']) && $_POST['action'] === 'registrarCita') {
        $action = $_POST['action'];
        switch ($action) {
            case 'registrarCita':
                if (!$conexion) {
                    echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                    exit;
                }
                if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                    $guardararchivo = guardarArchivo($conexion, $_FILES['archivo'], $_POST);
                    if ($guardararchivo) {
                        $response = Registercita($conexion, $_POST, $guardararchivo);
                        if ($response) {
                            echo json_encode([
                                'success' => true,
                                'message' => 'registro exitoso',
                                'id' => $conexion->insert_id
                            ]);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'registro fallido']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'fallo en guardar el archivo']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se recibió archivo']);
                }
                break;
        }
        exit; // 👈 MUY IMPORTANTE, para que no intente decodificar JSON más abajo
    }
    // Validate received data    
    // Si no es registrarCita, entonces sí espero JSON
    $data = json_decode(file_get_contents("php://input"), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    switch ($data['action']) {
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
        case 'obtenerHorariosdoctor':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = obtenerHorariosdoctor($conexion, $data['idMedico']);
                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'horarios obtenidos', 'horarios' => $response, 'id' => $data['idMedico']]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo obtener los horarios', "response" => $response, 'id' => $data['idMedico']]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        case 'enviarcorreo':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = enviarcorreo($data);
                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'correo enviado']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'correo no enviado']);
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
