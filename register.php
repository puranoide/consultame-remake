<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="assets/img/consultamelogosolo.webp">
    <title>Consúltame.pe</title>
    <style>
        /* Estilo para reducir el tamaño del texto del placeholder */
        .custom-placeholder::placeholder {
            font-size: 0.8rem;
            /* Cambia el tamaño según tu preferencia */
        }

        #tablaHorarios table {
            font-size: 12px;
            /* Tamaño más pequeño de texto */
        }

        #tablaHorarios th,
        #tablaHorarios td {
            padding: 0.25rem !important;
            /* Menor espaciado */
        }

        .celda-cita {
            min-width: 50px;
            /* Tamaño mínimo de celda */
            height: 30px;
            line-height: 1.2;
        }

        .celda-cita:hover {
            background-color: #e9ecef;
        }

        .celda-cita.bg-success:hover {
            background-color: #157347 !important;
        }
    </style>
</head>

<body id="body">
    <!--header-->
    <ul class="nav justify-content-center bg-primary">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page"><img src="assets/img/Consultame-Logo-blanco.png" style="width: 200px;margin-top:40px;" alt=""></a>
        </li>
    </ul>

    <!-- Loader -->
    <div id="loader">

    </div>

    <!--contenido-->
    <form action="#" method="post" enctype="multipart/form-data" id="post-form-register">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-white text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase text-dark">registro médico consúltame.pe</h2>
                                    <p class="text-dark mb-5 mt-5">Al dejar tus datos, recibirás un contacto personalizado de nuestro equipo para validar tu perfil, este servicio es exclusivo para profesionales de la salud.</p>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="seleccionHoras">Prefijo</label>
                                        <select class="form-select custom-placeholder" aria-label="Default select example" name="prefijo" required>
                                            <option value="" selected>Seleccione un prefijo</option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Dra.">Dra.</option>
                                            <option value="Lic.">Lic.</option>
                                            <option value="PsyD.">PsyD.</option>
                                            <option value="">Ninguno</option>
                                        </select>
                                    </div>
                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="completeName">Nombres</label>
                                        <input type="text" id="completeName" class="form-control form-control-lg custom-placeholder" name="Name" placeholder="Nombres" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="lastName">Apellidos</label>
                                        <input type="text" id="lastName" class="form-control form-control-lg custom-placeholder" name="apellidos" placeholder="Apellidos" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="cmp">CMP</label>
                                        <input type="number" id="cmp" class="form-control form-control-lg custom-placeholder" name="cmp" placeholder="CMP" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="rne">RNE</label>
                                        <input type="number" id="rne" class="form-control form-control-lg custom-placeholder" name="rne" placeholder="RNE" />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="especialidad">Especialidad</label>
                                        <input type="text" id="especialidad" class="form-control form-control-lg custom-placeholder" name="especialidad" placeholder="Especialidad" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="email">Email</label>
                                        <input type="email" id="email" class="form-control form-control-lg custom-placeholder" name="email" placeholder="Email" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="telefono">Teléfono</label>
                                        <input type="number" id="telefono" class="form-control form-control-lg custom-placeholder" name="telefono" placeholder="Teléfono" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="metodoPago">Método de pago para pacientes</label>
                                        <textarea required id="metodoPago" class="form-control form-control-lg custom-placeholder" name="metodoPago" placeholder="TITULAR Y DNI + CUENTAS BANCARIAS
            YAPE / PLIN / OTRO"></textarea>
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="tarifa">Tarifa de consulta</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">S/.</span>
                                            <input type="number" class="form-control custom-placeholder" name="tarifa" placeholder="Tarifa" required>
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="tiempoConsulta">Tiempo de consulta</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control custom-placeholder" name="tiempoConsulta" placeholder="Tiempo de consulta" required>
                                            <span class="input-group-text">minutos</span>
                                        </div>
                                    </div>
                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="horarios">Horario de consulta</label>
                                        <div id="tablaHorarios"></div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="linkFoto">Tu fotografía</label>
                                        <input type="file" id="linkFoto" class="form-control form-control-lg custom-placeholder" name="linkFoto" placeholder="Enlace de fotografía en buena resolución" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="seleccionHoras">Frecuencia de atenciones a la semana</label>
                                        <select class="form-select custom-placeholder" aria-label="Default select example" name="seleccionHoras" required>
                                            <option value="" selected>Número de atenciones por semana</option>
                                            <option value="uno o menos">Uno o menos</option>
                                            <option value="dos a cuatro">2 a 4</option>
                                            <option value="mas de 5">Más de 5</option>
                                            <option value="mas de 10">Más de 10</option>
                                        </select>
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="reseniaDoctor">Reseña</label>
                                        <textarea id="reseniaDoctor" class="form-control form-control-lg custom-placeholder" name="reseniaDoctor" placeholder="Texto de 2 párrafos máximo de experiencia profesional"></textarea>
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label text-dark fw-bold" for="mensajeFpaciente">Mensaje a sus pacientes</label>
                                        <textarea id="mensajeFpaciente" class="form-control form-control-lg custom-placeholder" name="mensajeFpaciente" placeholder="Texto corto de 2 oraciones" required></textarea>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                        <label class="form-check-label text-dark" for="flexCheckDefault">
                                            He leído y acepto el <a target="_blank" href="https://docs.google.com/document/d/1Qa_ff76yand9wnVRDgEDA_zNyUO1EptRvaMFObQX148/edit#heading=h.lmk3ft8mctiu">Contrato de Secretariado Médico Digital-Consúltame.pe</a>
                                        </label>
                                    </div>
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-dark btn-lg px-5" type="submit">Registrarme</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <script src="assets/js/register.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>