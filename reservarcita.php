<?php
$idMedico = $_GET['id'];
$rutamedico = $_GET['nombreruta'];
//print_r($rutamedico);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio| Consúltame.pe</title>
  <link rel="stylesheet" href="assets/css/index02.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</head>

<body>

  <header>
    <img src="assets/img/logoconsultame01.avif" alt="logo" />
    <nav>
      <ul>
        <li><a href="index.html#comofunciona" id="botoncomofunciona">¿Cómo funciona?</a></li>
        <li><a href="index.html#serviciosBeneficiosCostos" id="botonpostpago">Servicio post-pago</a></li>
        <li><a href="perfilmedicodemo.html">Obtén un Perfil médico</a></li>
        <li><a href="recomendacionesapacientes.html">Recomendaciones a pacientes</a></li>
        <li><a href="index.html#contacto">Contacto</a></li>
      </ul>
    </nav>
  </header>

  <div class="container text-center py-5">
    <a href="<?php echo $rutamedico; ?>" class="btn btn-primary w-100 w-md-auto">Volver al perfil de tu medico</a>
  </div>

  <div class="container py-5">
    <div class="row g-4">
      <!-- Formulario -->
      <div class="col-md-6">
        <div class="card shadow-sm p-4">
          <h4 class="fw-bold mb-2">Completa tus datos</h4>
          <p class="text-muted mb-4">
            Completa tus datos para que un asesor de Consúltame.pe programe una cita con tu médico de confianza.
          </p>
          <form id="post-form-register" enctype="multipart/form-data"  method="POST">
            <input type="hidden" name="idMedico" value="<?php echo $idMedico; ?>">

            <div class="mb-3">
              <label for="nombre" class="form-label">Nombres y apellidos *</label>
              <input type="text" name="name" class="form-control" id="nombre" maxlength="100" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico / E-mail *</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono *</label>
              <input type="tel" name="telefono" class="form-control" id="telefono" required>
            </div>

            <div class="mb-3">
              <label for="dni" class="form-label">DNI / Pasaporte / ID *</label>
              <input type="text" name="dni" class="form-control" id="dni" required>
            </div>

            <div class="mb-3">
              <label for="motivo" class="form-label">Explica el motivo de tu consulta *</label>
              <textarea name="motivo" class="form-control" id="motivo" rows="3" required></textarea>
            </div>
            <div data-mdb-input-init class="mb-3">
              <label class="form-label" for="linkFoto">Tu fotografía</label>
              <input type="file" id="linkFoto" class="form-control form-control-lg custom-placeholder" name="linkFoto" placeholder="Enlace de fotografía en buena resolución" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar</button>
          </form>
        </div>
      </div>

      <!-- Fechas disponibles -->
      <div class="col-md-4">
        <h4 class="fw-bold mb-3">Fechas disponibles</h4>
        <input type="date" class="form-control" id="fechaSeleccionada">
        <div id="fechasDisponibles" class="d-flex flex-wrap gap-2 mt-3 text-dark">

        </div>
      </div>
    </div>
  </div>






  <footer>
    <div class="cntfooter">
      <div>
        <img src="assets/img/logoconsultame_version01.png" alt="">
        <a href="https://docs.google.com/document/d/1mxUfgXMDaNDW1YPfTAkC4mSphEhJa8yg-PzceSktccU/edit?tab=t.0"
          target="_blank">Términos y condiciones</a>
        <a href="https://docs.google.com/document/d/16AzRutt9CnHTavX5Sn1i6M12zJCDU4tFBS6yIVl-tQ4/edit?tab=t.0"
          target="_blank">Aviso legal</a>
        <a
          href="https://docs.google.com/document/d/1x8aWmnJFxrs601J4qNp4g63CZAZiMwvieSHtERsSTuA/edit?tab=t.0">Impressum</a>
      </div>
      <div>
        <a href="https://www.faro.pe" target="_blank" class="tittlefooter">Uso de Consúltame.pe</a>
        <a href="register.php" target="_blank">Obtener un perfil</a>
        <a href="index.html#quees">¿Qué es?</a>
        <a href="index.html#comofunciona">¿Cómo funciona?</a>
        <a href="index.html#serviciosBeneficiosCostos">Servicio post-pago</a>
      </div>
      <div>
        <a href="https://www.faro.pe" target="_blank" class="tittlefooter">Atención al paciente</a>
        <a href="recomendacionesapacientes.html#preguntasfrecuentes">Preguntas frecuentes</a>
        <a href="https://docs.google.com/document/d/1Xgto7pQQDGnkGsGWGuBivip1nDr-nNfX6G8ziDKeG4Y/edit?tab=t.0"
          target="_blank">Política de privacidad</a>
        <a href="https://docs.google.com/document/d/1Xgto7pQQDGnkGsGWGuBivip1nDr-nNfX6G8ziDKeG4Y/edit?tab=t.0"
          target="_blank">Protección de datos</a>
        <a href="recomendacionesapacientes.html#contacto">Envía un mensaje</a>
      </div>
      <div>
        <a href="https://www.faro.pe" target="_blank" class="tittlefooter">Únase a Consúltame.pe</a>
        <a href="recomendacionesapacientes.html#contacto">Trabajar con nosotros</a>
        <a href="recomendacionesapacientes.html#contacto">Recomendar a un médico</a>
        <a href="recomendacionesapacientes.html#contacto">Adquirir planes de empresa</a>
        <a href="register.php" target="_blank">Registrarse como médico</a>
      </div>
    </div>



    <div class="cntfooter2">
      <p>©2021-2025 Consúltame.pe - Powered by Faro Medic</p>
    </div>
  </footer>

  <script src="assets/js/citasv01.js"></script>
</body>

</html>