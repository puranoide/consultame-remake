<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/panel.css">
    <link rel="icon" href="assets/imagenes/consultamelogosolo.webp">
    <title>Login médico consúltame.pe</title>
</head>
<body>
<!--header-->
<ul class="nav justify-content-center bg-primary">
        <li class="nav-item">
            <a href="login.php" class="nav-link active" aria-current="page"><img src="assets/imagenes/consultamelogosolo.webp" alt=""></a>
        </li>
        <li class="nav-item tituloCabcera">
            <a href="login.php" class="fs-3 text-white" style="text-decoration: none;">CONSÚLTAME.PE</a>
        </li>
    </ul>

<!--contenido-->
<form action="php/loginDoc.php" method="post">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-white text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2  text-dark mb-5">Ingreso a la plataforma médica Consúltame.pe</h2>

                                <div data-mdb-input-init class="form-outline form-white mb-4">
                                    <label class="form-label text-dark" for="cmp">CMP</label>    
                                    <input type="number" id="cmp" class="form-control form-control-lg" name="cmp" required />
                                    
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-dark btn-lg px-5" type="submit">Ingresar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
