<?php

function selectmedicos($cn)
{
    $sql = "SELECT * FROM medico";
    $result = mysqli_query($cn, $sql);
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
        case 'obtenerMedicos':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = selectmedicos($conexion);

                if ($response) {
                    $medicos = [];
                    while ($row = $response->fetch_assoc()) {
                        $medicos[] = $row;
                    }
                    echo json_encode(['success' => true, 'medicos' => $medicos, 'message' => 'medicos encontrados']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'no se encontraton medicos']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        case 'crearPerfil':
                try {
                    $medico = $data['medico'];
                    $html = '
                    <!DOCTYPE html>
                    <html lang="en">
                        <head>
                        <meta charset="UTF-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <title>Inicio| Consúltame.pe</title>
                        <link rel="stylesheet" href="../assets/css/index.css" />
                        </head>
                    <body>

                    <header>
                        <img src="../assets/img/logoconsultame01.avif" alt="logo" />
                        <nav>
                            <ul>
                                <li><a href="#">¿Cómo funciona?</a></li>
                                <li><a href="#">Servicio post-pago</a></li>
                                <li><a href="#">Obtén un Perfil médico</a></li>
                                <li><a href="#">Recomendaciones a pacientes</a></li>
                                <li><a href="#contacto">Contacto</a></li>
                            </ul>
                        </nav>
                    </header>

                    <div class="medico">
                        <h2>' . $medico['completename'] . '</h2>
                        <p>Apellidos: ' . $medico['apellidosDoctores'] . '</p>
                        <p>CMP: ' . $medico['cmp'] . '</p>
                    </div>


                    <footer>
                    <div class="cntfooter">
                        <div>
                            <img src="../assets/img/logoconsultame02.avif" alt="">
                            <a href="#">Términos y condiciones</a>
                            <a href="#">Aviso legal</a>
                            <a href="#">Impressum</a>
                        </div>
                        <div>
                            <a href="#" class="tittlefooter">Uso de Consúltame.pe</a>
                            <a href="#">Obtener un perfil</a>
                            <a href="#">¿Qué es?</a>
                            <a href="#">¿Cómo funciona?</a>
                            <a href="#">Servicio post-pago</a>
                        </div>
                        <div>
                            <a href="#" class="tittlefooter">Atención al paciente</a>
                            <a href="#">Preguntas frecuentes</a>
                            <a href="#">Política de privacidad</a>
                            <a href="#">Protección de datos</a>
                            <a href="#">Envía un mensaje</a>          
                        </div>
                        <div>
                            <a href="#" class="tittlefooter">Únase a Consúltame.pe</a>
                            <a href="#">Trabajar con nosotros</a>
                            <a href="#">Recomendar a un médico</a>
                            <a href="#">Adquirir planes de empresa</a>
                            <a href="#">Registrarse como médico</a>             
                        </div>
                    </div>
                    <div class="cntfooter2">
                        <p>©2021-2023 Consúltame.pe - Powered by Faro Medic</p>
                    </div>
                    </footer>

                    </body>
                    </html>
                    ';
                     $file = '../medicos/' . $medico['cmp'] . '.html';
                    if (file_put_contents($file, $html) !== false) {
                        echo json_encode(['success' => true, 'message' => 'perfil de medico creado en ' . $file]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'no se pudo crear el archivo ' . $file]);
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
