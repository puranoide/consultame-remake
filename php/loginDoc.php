<?php
include_once('../controllers/db.php');
session_start();
$cmp = $_POST['cmp'];

// Buscar el usuario por el cmp
$consulta_usuario = mysqli_query($conexion, "SELECT * FROM medico WHERE cmp='$cmp'");

if ($consulta_usuario) {
    if (mysqli_num_rows($consulta_usuario) > 0) {
        $usuario = mysqli_fetch_assoc($consulta_usuario);

        $_SESSION['id_medico'] = $usuario['idMedico'];
        $_SESSION['NombreMedico'] = $usuario['completename'];
        $_SESSION['apellidosDoctores'] = $usuario['apellidosDoctores']; // Esto estaba faltando
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['cmp'] = $usuario['cmp'];
        header('location:../Panel.php');
        exit();
    } else {
        echo '
            <script>
                alert("No se encontró el médico con el cmp proporcionado, verifique los datos y vuelva a intentarlo");
                window.location="../login.php";
            </script>
        ';
        exit();
    }
} else {
    echo '
        <script>
            alert("Error en la consulta a la base de datos");
            window.location="../login.php";
        </script>
    ';
    exit();
}
?>
