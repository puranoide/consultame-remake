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

    <div class="container">
        <div class="form-container">
            <div class="form-title">Completa tus datos</div>
            <p class="small-note">Completa tus datos para que un asesor de Consúltame.pe programe una cita con tu médico de confianza.</p>
            <form class="form" id="post-form-register">
                <div class="row mb-3">
                    <input type="hidden" name="idMedico" value="<?php echo $idMedico; ?>">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombres y apellidos *</label>
                        <input type="text" name="name" class="form-control" id="nombre" maxlength="100" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo electrónico / E-mail *</label>
                        <input name="email" type="email" class="form-control" id="email" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono *</label>
                        <input name="telefono" type="tel" class="form-control" id="telefono" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dni" class="form-label">DNI / Pasaporte / ID *</label>
                        <input name="dni" type="text" class="form-control" id="dni" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="motivo" class="form-label">Explica el motivo de tu consulta *</label>
                    <textarea name="motivo" class="form-control" id="motivo" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
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