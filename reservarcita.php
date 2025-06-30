<?php
$idMedico = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio| Consúltame.pe</title>
    <link rel="stylesheet" href="assets/css/register.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <img src="assets/img/logoconsultame01.avif" alt="logo" />
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

<div class="container py-5">
  <div class="row g-4">
    <!-- Formulario -->
    <div class="col-md-6">
      <div class="card shadow-sm p-4">
        <h4 class="fw-bold mb-2">Completa tus datos</h4>
        <p class="text-muted mb-4">
          Completa tus datos para que un asesor de Consúltame.pe programe una cita con tu médico de confianza.
        </p>
        <form id="post-form-register">
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

          <button type="submit" class="btn btn-primary w-100">Enviar</button>
        </form>
      </div>
    </div>

    <!-- Fechas disponibles -->
    <div class="col-md-4">
      <h4 class="fw-bold mb-3">Fechas disponibles</h4>
      <div id="fechasDisponibles" class="d-flex flex-wrap gap-2"></div>
    </div>
  </div>
</div>






    <footer>
        <div class="cntfooter">
            <div>
                <img src="assets/img/logoconsultame02.avif" alt="" />
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

    <script src="assets/js/citasv01.js"></script>
</body>

</html>