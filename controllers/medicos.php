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
        //$medico = $data['medico'];
        $nombres = $data['Name'];
        $apellidos = $data['apellidos'];
        $nombres_separados = explode(" ", $nombres);
        $apellidos_separados = explode(" ", $apellidos);
        /*
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
                    src="' . $medico['LinkFoto'] . '"
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
                  <h2 class="nombredoctor01">Dr. ' . $nombres_separados[0] . ' ' . $apellidos_separados[0] . '</h2>
                  <p class="cpm">CPM:' . $medico['cmp'] . ' / ' . $medico['especialidad'] . '</p>
                  <p class="resenia">reseña:</p>
                  <p class="txtresenia">
                    ' . $medico['Resenia'] . '
                  </p>
                  <div class="ctnbotones">
                    <a href="../reservarcita.php?id=' . $medico['idMedico'] . '" class="btnreservar">RESERVAR CITA</a>
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
                  <h2>DR ' . $nombres_separados[0] . ' ' . $apellidos_separados[0] . '</h2>
                  <p>CMP: ' . $medico['cmp'] . ' / ' . $medico['especialidad'] . '</p>
                  <hr/>
                  <a href="../reservarcita.php?id=' . $medico['idMedico'] . '" class="btnreservar2">RESERVAR CITA</a>
                </div>
              </div>
              <div class="postreserva">
                  <p>*Las citas deben ser agendadas con 24 hrs de anticipación.</p>
                  <p>*La disponibilidad del horario del doctor está sujeta a la demanda de su servicio.</p>
              </div>

              <div class="resena">
                <p class="tituloreseña"> <span>Un mensaje de</span> tu médico...</p>
                <p class="reseña">"' . $medico['mensajePacientes'] . '"</p>
                <p class="autoreseña">Dr.' . $nombres_separados[0] . ' ' . $apellidos_separados[0] . '</p>
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
</html>';
*/
        $htmlvs2 = '
        <!DOCTYPE html>
        <html lang="en">

          <head>
              <meta charset="UTF-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <title>Inicio| Consúltame.pe</title>
              <link rel="stylesheet" href="../assets/css/demoperfilmedico.css" />
          </head>

          <body>
                <header>
                    <img src="../assets/img/logoconsultame01.avif" alt="logo" />
                    <nav>
                        <ul>
                            <li><a href="../index.html#comofunciona" id="botoncomofunciona">¿Cómo funciona?</a></li>
                            <li><a href="../index.html#serviciosBeneficiosCostos" id="botonpostpago">Servicio post-pago</a></li>
                            <li><a href="../perfilmedicodemo.html">Obtén un Perfil médico</a></li>
                            <li><a href="../recomendacionesapacientes.html">Recomendaciones a pacientes</a></li>
                            <li><a href="../index.html#contacto">Contacto</a></li>
                        </ul>
                    </nav>
                </header>
              <input type="hidden" id="idMedico" value="'.$data['idMedico'].'"> 
              <div class="doctor-card">
                  <div class="doctor-image">
                      <img src="' . $data['linkimgurl'] . '" alt="" class="doctor-photo">
                      <img src="../assets/img/logoconsultame01.avif" alt="consultame.pe" class="brand-logo">
                  </div>
                  <div class="doctor-info">
                        <!--<div class="medicgo">
                              <img src="assets/img/medigologocompleto.avif" alt="">
                              <p></p>
                          </div>
                          -->
                      <h2>'.$data['prefijo']. $nombres_separados[0] . ' ' . $apellidos_separados[0] . '</h2>
                      <p class="specialty">CPM:' . $data['cmp'] . ' / <span>' . $data['especialidad'] . '</span></p>
                      <p class="specialty">RNE:' . $data['rne'] . '</p>
                      <p class="title">reseña:</p>
                      <p class="description">
                          ' . $data['reseniaDoctor'] . '
                      </p>
                      <div class="actions">
                          <a href="../reservarcita.php?id=' . $data['idMedico'] . '&nombreruta=' . strtolower($nombres_separados[0] . $apellidos_separados[0]) . '" class="btn-primary">RESERVAR CITA</a>
                          <a href="#" class="btn-secondary">Contactar soporte</a>
                      </div>
                  </div>
              </div>

              <div class="info-container">
                  <!-- Card 1: Costos -->
                  <div class="info-card white-card">
                      <div class="info-item">
                          <img src="../assets/img/CostoConsulta.png" alt="Icono tarjeta" class="info-icon">
                          <p><strong>Costo de la consulta virtual:</strong><br>S/' . $data['tarifa'] . '.00</p>
                      </div>
                      <div class="info-item">
                          <div class="info-icon-placeholder"></div>
                          <p><strong>Costo de la consulta presencial:</strong><br>S/' . $data['tarifa'] . '.00</p>
                      </div>

                      <div class="info-item">
                          <img src="../assets/img/DuracionConsulta.avif" alt="Icono reloj" class="info-icon">
                          <p><strong>Duracion de la consulta:</strong><br>' . $data['tiempoConsulta'] . ' minutos</p>
                      </div>
                  </div>

                  <!-- Card 2: Horarios -->
                  <div class="info-card blue-card" id="horarios">
                      <!-- 
                      <p class="title">Horarios de atención:</p>
                      <p><strong>Lunes a Domingo presencial:</strong><br>9 AM - 8 PM</p>
                      <p><strong>Lunes a Domingo virtual:</strong><br>9 AM - 8 PM</p>
                      -->
                  </div>
              </div>

              <!-- Sección de pagos -->
              <section class="payment-section">
                  <h2 class="payment-title">Métodos de pago disponibles</h2>
                  <p class="payment-subtitle">
                      Las transferencias van directo a las cuentas de tu médico de confianza.<br>
                      Usa estos datos para hacer el pago adelantado de tu consulta.
                  </p>
                  <!--<h3 class="payment-company">CORPORACION MEDICGO PERU</h3>-->

                  <div class="payment-container">
                      <!-- Tarjeta 2 -->
                      <div class="payment-card">
                          <p><strong>' . $data['metodoPago'] . '</strong></p>
                      </div>
                  </div>
              </section>

              <section class="container">

                  <!-- Card Doctor -->
                  <div class="card">
                      <div class="logo">
                          <img src="../assets/img/logoconsultame03.webp" alt="Logo Consultame">
                      </div>
                      <div class="info">
                          <h3>' .$data['prefijo']. $nombres_separados[0] . ' ' . $apellidos_separados[0] . '</h3>
                          <p class="subtitle">CMP:' . $data['cmp'] . ' / ' . $data['especialidad'] . '</p>
                          <hr>
                          <a href="../reservarcita.php?id=' . $data['idMedico'] . '&nombreruta=' . strtolower($nombres_separados[0] . $apellidos_separados[0]) . '" class="btn">RESERVAR CITA</a>
                      </div>
                  </div>

                  <!-- Aviso azul -->
                  <div class="notice">
                      <p>* Las citas deben ser agendadas con 24 hrs de anticipación.</p>
                      <p>* La disponibilidad del horario del doctor está sujeta a la demanda de su servicio.</p>
                  </div>

                  <!-- Mensaje del médico -->
                  <div class="mensaje">
                      <h2>Un mensaje de <span>tu médico...</span></h2>
                      <p class="quote">"' . $data['mensajeFpaciente'] . '"</p>
                      <p class="firma">Dr.' . $nombres_separados[0] . ' ' . $apellidos_separados[0] . '</p>
                  </div>

              </section>




          <footer>
                  <div class="cntfooter">
                      <div>
                          <img src="../assets/img/logoconsultame_version01.png" alt="">
                          <a href="https://docs.google.com/document/d/1mxUfgXMDaNDW1YPfTAkC4mSphEhJa8yg-PzceSktccU/edit?tab=t.0" target="_blank">Términos y condiciones</a>
                          <a href="https://docs.google.com/document/d/16AzRutt9CnHTavX5Sn1i6M12zJCDU4tFBS6yIVl-tQ4/edit?tab=t.0" target="_blank">Aviso legal</a>
                          <a href="https://docs.google.com/document/d/1x8aWmnJFxrs601J4qNp4g63CZAZiMwvieSHtERsSTuA/edit?tab=t.0">Impressum</a>
                      </div>
                      <div>
                          <a href="https://www.faro.pe" target="_blank" class="tittlefooter">Uso de Consúltame.pe</a>
                          <a href="../register.php" target="_blank">Obtener un perfil</a>
                          <a href="../index.html#quees">¿Qué es?</a>
                          <a href="../index.html#comofunciona">¿Cómo funciona?</a>
                          <a href="../index.html#serviciosBeneficiosCostos">Servicio post-pago</a>
                      </div>
                      <div>
                          <a href="https://www.faro.pe" target="_blank" class="tittlefooter">Atención al paciente</a>
                          <a href="../recomendacionesapacientes.html#preguntasfrecuentes">Preguntas frecuentes</a>
                          <a href="https://docs.google.com/document/d/1Xgto7pQQDGnkGsGWGuBivip1nDr-nNfX6G8ziDKeG4Y/edit?tab=t.0" target="_blank">Política de privacidad</a>
                          <a href="https://docs.google.com/document/d/1Xgto7pQQDGnkGsGWGuBivip1nDr-nNfX6G8ziDKeG4Y/edit?tab=t.0" target="_blank">Protección de datos</a>
                          <a href="../recomendacionesapacientes.html#contacto">Envía un mensaje</a>
                      </div>
                      <div>
                          <a href="https://www.faro.pe" target="_blank" class="tittlefooter">Únase a Consúltame.pe</a>
                          <a href="../recomendacionesapacientes.html#contacto">Trabajar con nosotros</a>
                          <a href="../recomendacionesapacientes.html#contacto">Recomendar a un médico</a>
                          <a href="../recomendacionesapacientes.html#contacto">Adquirir planes de empresa</a>
                          <a href="../register.php" target="_blank">Registrarse como médico</a>
                      </div>
                  </div>



                  <div class="cntfooter2">
                      <p>©2021-2025 Consúltame.pe - Powered by Faro Medic</p>
                  </div>
              </footer>

              <script src="../assets/js/perfilmedicodemo.js"></script>
          </body>

        </html>
                    ';
        $nombredoctorruta = strtolower($nombres_separados[0] . $apellidos_separados[0]);
        $dir = '../' . $nombredoctorruta . '/';
        if (!file_exists($dir)) {
          mkdir($dir, 0777, true);
        }
        $file = '../' . $nombredoctorruta . '/index.html';
        if (file_put_contents($file, $htmlvs2) !== false) {
          echo json_encode(['success' => true, 'message' => 'perfil de medico creado en ' . $file]);
        } else {
          echo json_encode(['success' => false, 'message' => 'no se pudo crear el archivo ' . $file]);
        }
      } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
      }

      break;
    default:
      echo json_encode(['success' => false, 'message' => 'Acción no reconocida']);
      break;
  }
}
