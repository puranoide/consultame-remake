<?php
function obtenerdoctor($con, $id)
{
    $sql = "SELECT horariosemanal FROM medico WHERE idMedico = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}

include_once('db.php');
$result = obtenerdoctor($conexion, 61);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
    }
} else {
    echo "Error: " . mysqli_error($conexion);
}
/*


function enviarCorreoInteresado() {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Validación básica
    if(empty($nombre) || empty($email) || empty($mensaje)) {
        echo '<script>alert("Todos los campos son obligatorios."); window.location="index.html";</script>';
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Correo electrónico no válido."); window.location="index.html";</script>';
        exit;
    }

    // Sanitizar el correo electrónico
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Datos del correo
    $para = "acostasanchezangelgabriel@gmail.com";
    $asunto = "NUEVO INTERESADO DE '".htmlspecialchars($nombre)."' : '".htmlspecialchars($email)."'";
    $cabecera = "From: no-reply@jcfrancais.com";
    $mail = mail($para, $asunto, $mensaje, $cabecera);
    
    // Enviar el correo
    if($mail){
        echo '
        <script>
            alert("Correo enviado correctamente");
            window.location="index.html";
        </script>';
    } else {
        echo '
        <script>
            alert("Correo no enviado correctamente, inténtelo de nuevo.");
            window.location="index.html";
        </script>';
    }
}


*/
?>


