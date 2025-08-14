<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/panel.css">
    <link rel="icon" href="assets/imagenes/consultamelogosolo.webp">
    <title>Panel</title>
</head>
<body>
    <!-- inicio header -->
    <ul class="nav justify-content-center bg-primary">
        <li class="nav-item">
            <a href="login.php" class="nav-link active" aria-current="page"><img src="assets/imagenes/consultamelogosolo.webp" alt=""></a>
        </li>
        <li class="nav-item tituloCabcera">
            <a href="login.php" class="fs-3 text-white" style="text-decoration: none;">CONSÚLTAME.PE</a>
        </li>
    </ul>

    <nav class="nav justify-content-center bg-body-tertiary mt-5">
        <h1 class="navbar-brand">Bienvenido doctor/a : <?php echo $_SESSION['NombreMedico']; ?></h1>
    </nav>
    <!-- fin header-->

    <!-- inicio consultas usuario
    <div class="d-flex">
        <form action="" class="w-25 p-3">
        <label class="form-label text-dark" for="reseniaDoctor">Ingrese DNI del paciente</label>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Ingrese DNI del paciente" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-primary" type="button" id="button-addon2">buscar</button>
        </div>
        </form>

           <form action="" class="w-25 p-3 ">
           <label class="form-label text-dark" for="reseniaDoctor"> &nbsp;</label>
           <div class="input-group">
          
            <button class="btn btn-success" type="button" id="button-addon2">Agregar Datos</button>
        </div>
            </form>
    </div>
    -->

    <div class="conteiner-formularios mt-5">
        <form action="php/busquedaPaciente.php" method="post">
           
            <input type="text" name="dniPaciente" id="dniPaciente" placeholder="Ingrese DNI del paciente">
            <button class="btn btn-primary">Buscar paciente</button>
        </form>
        <form action="php/addHistoria.php" method="post">
            <input type="hidden" value="" name="IdPaciente">
            <button class="btn btn-success">Agregar datos del paciente</button>
        </form>
    </div>

            <!-- fin consultas usuario-->
                <h4 class="mt-5 nombrePaciente" >Nombre del paciente :</h4>
            <!-- inicio datos paciente-->

            <!-- fin datos paciente-->
            <!-- inicio Tablas-->
            <nav class="nav justify-content-center bg-body-tertiary mt-5">
                <h1 class="navbar-brand">Datos del Paciente</h1>
            </nav>
            <!--
            <table class="table table-bordered border-primary mt-2 w-75 p-3 table-fechas" >
                <tbody>
                    <tr>
                    <th scope="row">
                        <form action="" class="d-flex justify-content-between">
                            <label for="">29-06-2024</label>
                            <button class="btn btn-primary">Ver</button>
                        </form>
                    </th>
                    </tr>
                </tbody>
            </table>
            -->
            <!-- fin tablas-->



            <script>
    document.addEventListener('DOMContentLoaded', function(event) {
        var value = localStorage.getItem('pacienteBuscado');
        if (value) {
            var dniPacienteInput = document.getElementById('dniPaciente');
            if (dniPacienteInput) {
                dniPacienteInput.value = value;
            } else {
                console.error('Elemento con ID "dniPaciente" no encontrado');
            }
        }
    });

</script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
