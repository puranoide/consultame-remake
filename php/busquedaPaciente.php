<?php
session_start();
include_once('../controllers/db.php');

// Variable dummy para testing
$value = "This is the value that will be stored in local storage";



$dni = $_POST['dniPaciente'];
$consulta_Paciente = mysqli_query($conexion, "SELECT * FROM Paciente WHERE dni_paciente='$dni'");
$sql_consultasPaciente = "SELECT Consulta.id_consulta, Consulta.antecedente, Consulta.diagnostico, Consulta.receta, Consulta.fechaconsulta 
                         FROM Consulta 
                         JOIN Paciente ON Consulta.id_paciente = Paciente.id_paciente 
                         WHERE Paciente.dni_paciente = '$dni' 
                         ORDER BY Consulta.fechaconsulta DESC";

if (mysqli_num_rows($consulta_Paciente) > 0) {
    $paciente = mysqli_fetch_assoc($consulta_Paciente);
    $componente = '
    <h4 class="mt-5 nombrePaciente2" style="color:green;">Nombre del paciente : ' . $paciente['nombre_paciente'] . '</h4>
    ';
    echo "<script>
    localStorage.setItem('pacienteBuscado', '" . $paciente['dni_paciente'] . "');
</script>";
} else {
    $componente = '
    <h4 class="mt-5 nombrePaciente2" style="color:red;">No se encuentra el paciente</h4>
    ';
}

$result_consultas = $conexion->query($sql_consultasPaciente);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/panel.css">
    <link rel="icon" href="../assets/imagenes/consultamelogosolo.webp">
    <title>Panel</title>
</head>
<body>
    <!-- inicio header -->
    <ul class="nav justify-content-center bg-primary">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"><img src="../assets/imagenes/consultamelogosolo.webp" alt=""></a>
        </li>
        <li class="nav-item tituloCabcera">
            <a href="../login.php" class="fs-3 text-white" style="text-decoration: none;" class="fs-3 text-white mt-1" onclick="eliminarPaciente()">CONSÚLTAME.PE</a>
        </li>
    </ul>

    <nav class="nav justify-content-center bg-body-tertiary mt-5">
        <h1 class="navbar-brand">Bienvenido doctor/a : <?php echo $_SESSION['NombreMedico']; ?></h1>
    </nav>
    <!-- fin header-->

    <div class="conteiner-formularios mt-5">
        <form action="busquedaPaciente.php" method="post">
            <input type="text" name="dniPaciente" id="dniPaciente" placeholder="Ingrese DNI del paciente">
            <button class="btn btn-primary">Buscar paciente</button>
        </form>
        <form action="addHistoria.php" method="post">
            <?php
            if (isset($paciente['dni_paciente'])) {
                echo '<input type="hidden" name="dniPaciente" value="' . $paciente['dni_paciente'] . '">';
                echo '<input type="hidden" name="nombrePaciente" value="' . $paciente['nombre_paciente'] . '">';
                echo '<input type="hidden" name="IdPaciente" value="' . $paciente['id_paciente'] . '">';
            }
            ?>
            <button class="btn btn-success">Agregar datos del paciente</button>
        </form>
    </div>

    <?php
    echo $componente;
    ?>

    <nav class="nav justify-content-center bg-body-tertiary mt-5">
        <h1 class="navbar-brand">Datos del Paciente</h1>
    </nav>
    <table class="table table-bordered border-primary mt-2 w-75 p-3 table-fechas">
        <tbody>
            <?php
            if ($result_consultas->num_rows > 0) {
                while ($row = $result_consultas->fetch_assoc()) {
                    echo '
                    <tr>
                    <th scope="row">
                    <form action="vistaConsulta.php" method="POST" class="d-flex justify-content-between">
                        <input type="hidden" value="'.$row['id_consulta'].'" name="id_consulta">
                        <label for="">' . $row['fechaconsulta']. '</label>
                        <button class="btn btn-primary">ver</button>

                    </form>
                    </th>
                    </tr>
                    ';
                }
            }
            ?>
        </tbody>
    </table>
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
    function eliminarPaciente(){
    localStorage.removeItem('pacienteBuscado');

   };
</script>


    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
