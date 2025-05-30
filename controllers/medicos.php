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
                    $nombres = $medico['completename'];
                    $apellidos = $medico['apellidosDoctores'];
                    $nombres_separados = explode(" ", $nombres);
                    $apellidos_separados = explode(" ", $apellidos);

                    $html = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio| Consúltame.pe</title>
    <link rel="stylesheet" href="../assets/css/perfilmedico.css" />
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

    <div class="container-info-doctor">
      <div class="cntimagenmedico">
        <img
          class="imagenmedico"
          src="'.$medico['LinkFoto'].'"
          alt=""
          srcset=""
        />
        <img
          class="logoconsultamemedico"
          src="../assets/img/logoconsultame02.avif"
          alt=""
        />
      </div>
      <div class="ctninfomedico">
        <h2 class="nombredoctor01">Dr. '.$nombres_separados[0].' '.$apellidos_separados[0].'</h2>
        <p class="cpm">CPM:'.$medico['cmp'].' / '.$medico['especialidad'].'</p>
        <p class="resenia">reseña:</p>
        <p class="txtresenia">
          '.$medico['Resenia'].'
        </p>
        <div class="ctnbotones">
          <a href="../reservarcita.php?id='.$medico['idMedico'].'" class="btnreservar">RESERVAR CITA</a>
          <a href="#" class="btncontactar">Contactar soporte</a>
        </div>
      </div>
    </div>

    <div class="conteinerhorariosyprecios">
      <div class="ctnprecios">
        <div class="precio01">
          <img src="../assets/img/CostoConsulta.png" alt="" />
          <p class="txtcosto01">Costo de la consulta virtual: <br />S/100.00</p>
        </div>
        <div class="precio02">
          <img src="" alt="" />
          <p class="txtcosto02">
            Costo de la consulta presencial: <br />S/250.00
          </p>
        </div>
        <div class="precio03">
          <img src="../assets/img/DuracionConsulta.avif" alt="" />
          <p class="txtcosto03">
            Costo de la consulta presencial: <br />S/250.00
          </p>
        </div>
      </div>
      <div class="ctnhorarios">
        <h2 class="tittlehorarios">Horarios de atencion:</h2>
        <p class="txtlunesdomingo">Lunes a Domingo presencial:</p>
        <p class="txthoras">9 AM - 8 PM</p>
        <p class="txtlunesdomingo">Lunes a Domingo virtual :</p>
        <p class="txthoras">9 AM - 8 PM</p>
      </div>
    </div>

    <div class="ctn-precuentas">
      <h2>Métodos de pago disponibles</h2>
      <p class="txttransferencia">
        Las transferencias van directo a las cuentas de tu médico de confianza.
      </p>
      <p class="txttransferencia">
        Usa estos datos para hacer el pago adelantado de tu consulta.
      </p>
      <p class="txtcorporacionmedicgo">CORPORACION MEDICGO PERU</p>
    </div>
    <div class="ctn-cuentas">
      <div class="ctninfocuentas">
        <p class="tituloinfo">DEPÓSITO EN CUENTA</p>
        <p class="nombrebanco">Banco INTERBANK</p>

        <p class="titulotipodecuenta">Cuenta Corriente Soles</p>
        <p class="titulotipodecuenta">2003002552440</p>
        <p class="titulotipodecuenta">Cuenta interbancaria</p>
        <p class="titulotipodecuenta">00320000300255244033</p>
      </div>
      <div class="ctninfocuentas">
        <p class="tituloinfo">TRANSFERENCIA / YAPE / PLIN</p>
        <p class="titulotipodecuenta"># de contacto</p>
        <p class="titulotipodecuenta">953562310</p>
      </div>
    </div>

    <div class="cntreservas01">
      <div class="logoconsultamereservas01">
        <img src="../assets/img/logoconsultame03.webp" alt="logo">
      </div>
      <div>
        <h2>DR '.$nombres_separados[0].' '.$apellidos_separados[0].'</h2>
        <p>CMP: '.$medico['cmp'].' / '.$medico['especialidad'].'</p>
        <hr/>
        <a href="../reservarcita.php?id='.$medico['idMedico'].'" class="btnreservar2">RESERVAR CITA</a>
      </div>
    </div>
    <div class="postreserva">
        <p>*Las citas deben ser agendadas con 24 hrs de anticipación.</p>
        <p>*La disponibilidad del horario del doctor está sujeta a la demanda de su servicio.</p>
    </div>

    <div class="resena">
      <p class="tituloreseña"> <span>Un mensaje de</span> tu médico...</p>
      <p class="reseña">"'.$medico['mensajePacientes'].'"</p>
      <p class="autoreseña">Dr.'.$nombres_separados[0].' '.$apellidos_separados[0].'</p>
    </div>



    <footer>
      <div class="cntfooter">
        <div>
          <img src="../assets/img/logoconsultame02.avif" alt="logo02" />
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
                    $nombredoctorruta=strtolower($nombres_separados[0].$apellidos_separados[0]);
                    $dir = '../'.$nombredoctorruta.'/'; 
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                     $file = '../'.$nombredoctorruta.'/index.html';
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
