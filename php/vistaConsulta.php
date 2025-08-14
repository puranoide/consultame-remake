<?php

include_once('../controllers/db.php');
$idConsulta = $_POST['id_consulta'];


$sql="
SELECT*FROM Consulta JOIN Paciente on Consulta.id_paciente=Paciente.id_paciente join Medico on Consulta.id_medico=Medico.idMedico WHERE Consulta.id_consulta='$idConsulta';
";
$result_consultas = $conexion->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Historia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/panel.css">
    <link rel="icon" href="../assets/imagenes/consultamelogosolo.webp">
    <style>
        .custom-width {
            width: 80%;
            max-width: 100%;
        }
        .btn-top-left {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>

    <!-- inicio header -->
    <ul class="nav justify-content-center bg-primary">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"><img src="../assets/imagenes/consultamelogosolo.webp" alt=""></a>
        </li>
        <li class="nav-item mt-1">
        <a href="../login.php" class="fs-3 text-white" style="text-decoration: none;" class="fs-3 text-white mt-1">CONSÚLTAME.PE</a>
        </li>
    </ul>
    <!-- fin header-->


    <form action="../panel.php" method="post">
    <?php
            if ($result_consultas->num_rows > 0) {
                while ($row = $result_consultas->fetch_assoc()) {
                    echo '
                        
                            <section class="vh-100 gradient-custom">
                                <div class="container py-5 h-100">
                                    <div class="row d-flex justify-content-center align-items-center h-100">
                                        <div class="col-12 col-md-8 col-lg-6 col-xl-5 custom-width">
                                            <div class="card bg-white text-white" style="border-radius: 1rem;">
                                                <div class="card-body p-5 text-center">
                                                <div class="row mb-4">
                                                            <div class="col-md-6 mt-5">
                                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger btn-lg px-5 btn-top-left" type="submit">VOLVER</button>
                                                            </div>
                                                        </div>
                                                    <div class="md-5 mt-md-4 mb-4">
                                                        <h2 class="fw-bold mb-2 text-uppercase text-dark mb-5">Ingreso de datos Pacientes</h2>
                                                        <input type="hidden" name="idPaciente" value="<?php echo $idP;?>">
                                                        
                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <div data-mdb-input-init class="form-outline form-white">
                                                                    <label class="form-label text-dark" for="dni">DNI/Pasaporte</label>
                                                                    <input type="text" id="dni" class="form-control form-control-lg" name="dni" value="'.$row['dni_paciente'].'"  readonly/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div data-mdb-input-init class="form-outline form-white">
                                                                    <label class="form-label text-dark" for="nombreP">Nombre del paciente</label>
                                                                    <input type="text" readonly id="nombreP" class="form-control form-control-lg" name="nombreP" value="'.$row['nombre_paciente'].'" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div data-mdb-input-init class="form-outline form-white mb-4">
                                                            <label class="form-label text-dark" for="antecedentes">Antecedentes/Diagnóstico</label>
                                                            <textarea type="text" id="antecedentes" class="form-control form-control-lg" name="antecedentes" placeholder="" readonly>'.$row['antecedente'].'</textarea>
                                                        </div>

                                                        <div data-mdb-input-init class="form-outline form-white mb-4">
                                                            <label class="form-label text-dark" for="receta">Receta médica</label>
                                                            <textarea type="text" id="receta" class="form-control form-control-lg" name="receta" placeholder="" readonly >'.$row['receta'].'</textarea>
                                                        </div>
                                                        
                                                        <div class="row mb-5">
                                                            <div class="col-md-6">
                                                                <div data-mdb-input-init class="form-outline form-white">
                                                                    <label class="form-label text-dark" for="cmp">CMP</label>
                                                                    <input type="number" id="cmp" class="form-control form-control-lg" name="cmp" value="'.$row['cmp'].'" readonly/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div data-mdb-input-init class="form-outline form-white">
                                                                    <label class="form-label text-dark" for="fecha">Fecha</label>
                                                                    <input type="date" id="fecha" class="form-control form-control-lg" name="fecha" value="'.$row['fechaconsulta'].'" readonly/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        

                                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger btn-lg px-5 mt-5" type="submit">VOLVER</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                    ';
                }
            }
            ?>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
