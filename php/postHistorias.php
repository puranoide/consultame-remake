<?php
session_start();
$cmp = $_SESSION['cmp'];
$idM = $_SESSION['id_medico'];
$date = date("Y-m-d");

// Establecer conexión a la base de datos
include_once('../controllers/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dniPaciente = $_POST['dni'] ?? '';
    $nombrePaciente = $_POST['nombreP'] ?? '';
    $idP = !empty($_POST["idPaciente"]) ? $_POST["idPaciente"] : 0;
    $fechaConsulta = $_POST['fecha'];
    $receta = $_POST['receta'];
    $antecedente = $_POST['antecedentes'];

    if ($idP == 0) {
        echo "ID Medico: $idM<br>";
        echo "ID Paciente el paciente es nuevo: $idP<br>";
        echo "DNI del Paciente: " . $dniPaciente . "<br>";
        echo "Nombre del Paciente: " . $nombrePaciente . "<br>";
        echo "Fecha de la Consulta: " . $fechaConsulta . "<br>";
        echo "Receta: " . $receta . "<br>";
        echo "Antecedentes: " . $antecedente . "<br>";

        // Insertar nuevo paciente
        $addPacienteQuery = "INSERT INTO `Paciente`(`nombre_paciente`, `dni_paciente`) VALUES ('$nombrePaciente', '$dniPaciente')";
        if ($conexion->query($addPacienteQuery) === TRUE) {
            $idP = $conexion->insert_id; // Obtener el ID del nuevo paciente insertado

            // Insertar nueva consulta
            $addConsultaQuery = "INSERT INTO `Consulta`(`antecedente`, `fechaconsulta`, `id_medico`, `id_paciente`, `receta`) VALUES ('$antecedente', '$fechaConsulta', '$idM', '$idP', '$receta')";
            if ($conexion->query($addConsultaQuery) === TRUE) {
                echo '<script>
                        alert("Usuario y consulta registrados correctamente");
                        window.location="../Panel.php";
                    </script>';
            } else {
                echo '<script>
                        alert("Usuario registrado correctamente, pero no se pudo registrar la consulta");
                        window.location="../Panel.php";
                    </script>';
            }
        } else {
            echo '<script>
                    alert("Error al agregar usuario");
                    window.location="../Panel.php";
                </script>';
        }
    } else {
        echo "ID Medico: $idM<br>";
        echo "ID Paciente existe: $idP<br>";
        echo "DNI del Paciente: " . $dniPaciente . "<br>";
        echo "Nombre del Paciente: " . $nombrePaciente . "<br>";
        echo "Fecha de la Consulta: " . $fechaConsulta . "<br>";
        echo "Receta: " . $receta . "<br>";
        echo "Antecedentes: " . $antecedente . "<br>";

        // Insertar nueva consulta
        $addConsultaQuery = "INSERT INTO `Consulta`(`antecedente`, `fechaconsulta`, `id_medico`, `id_paciente`, `receta`) VALUES ('$antecedente', '$fechaConsulta', '$idM', '$idP', '$receta')";
        if ($conexion->query($addConsultaQuery) === TRUE) {
            echo '<script>
                    alert("Consulta registrada correctamente");
                    window.location="../Panel.php";
                </script>';
        } else {
            echo '<script>
                    alert("Error al registrar la consulta");
                    window.location="../Panel.php";
                </script>';
        }
    }
}

$conexion->close();
?>
