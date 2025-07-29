const formAddPost = document.getElementById("post-form-register");
const horariosSeleccionados = {};
formAddPost.addEventListener("submit", function (event) {
  event.preventDefault();
  console.log("submit");
  const formData = new FormData(this);
  objetoRegistro = {};
  const inputs = document.querySelectorAll(
    "#post-form-register input, #post-form-register textarea, #post-form-register select"
  );
  inputs.forEach((input) => {
    console.log(input.name, input.value);
    objetoRegistro[input.name] = input.value;
  });

  objetoRegistro.horarios = JSON.stringify(horariosSeleccionados);
  console.log(objetoRegistro);
  console.log(typeof objetoRegistro);
  //console.log(horariosSeleccionados);
  //registrarMedico(objetoRegistro);
  //addPostApi(formData.get("title"), formData.get("content"), formData.get("enlace"), formData.get("image"));
  const loader = document.getElementById("loader");
  loader.className = "position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-25 show";
  loader.style.zIndex = "1050";
  loader.innerHTML =
    `<div class="text-center">
      <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
      </div>
      <p class="text-light mt-3">Por favor, espere mientras procesamos su solicitud...</p>
    </div>`
  saveImageImgur("bac59c579ba9db1", objetoRegistro, formData.get("linkFoto"));
});


function saveImageImgur(idClient, objetoRegistro, linkFoto) {

  const formData = new FormData();
  formData.append('image', linkFoto);

  fetch(`https://api.imgur.com/3/image`, {
    method: 'POST',
    headers: {
      Authorization: `Client-ID ${idClient}`
    },
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      //console.log(data);
      if (data.success) {
        console.log(data.data.link);
        console.log(objetoRegistro);
        //console.log(data);
        registrarMedico(objetoRegistro, data.data.link);
      }
    })
    .catch(error => {
      console.log(error);
    });

}

function registrarMedico(medicoObj, linkimgurl) {
  const datamedico = {
    action: "register",
    linkimgurl: linkimgurl,
    ...medicoObj,
  };
  console.log(datamedico);
  fetch("controllers/medicRegister.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(datamedico),
  })
    .then((response) => response.json())
    .then((data) => {
      //console.log(data);
      if (data.success) {
        console.log("respuesta :", data);

        const dataconfirmarvista = encodeURIComponent(JSON.stringify({...datamedico, idMedico: data.id}));
        console.log(dataconfirmarvista);
        alert("Tu registro a sido exitoso");
        window.location.href = `registroexitoso.html?data=${dataconfirmarvista}`;
        //window.location.href = "gestionPosts.php";
      }
    })
    .catch((error) => {
      console.log(error);
    });
}


function generarTablaHorarios(duracion, contenedorId = "tablaHorarios") {
  const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
  const inicio = 8 * 60;
  const fin = 20 * 60;
  //const horariosSeleccionados = {};

  const contenedor = document.getElementById(contenedorId);
  contenedor.innerHTML = ""; // Limpiar antes de regenerar

  const tablaWrapper = document.createElement("div");
  tablaWrapper.className = "table-responsive"; // IMPORTANTE para scroll horizontal

  const tabla = document.createElement("table");
  tabla.className = "table table-bordered text-center table-sm";


  // Encabezado
  const thead = document.createElement("thead");
  thead.className = "table-light text-dark"; // Mejor contraste
  const filaEncabezado = document.createElement("tr");

  const thHora = document.createElement("th");
  thHora.textContent = "Hora";
  thHora.className = "text-center small"; // Bootstrap class 'small' for smaller font size
  filaEncabezado.appendChild(thHora);

  dias.forEach(dia => {
    const th = document.createElement("th");
    th.className = "text-center small"; // Bootstrap class 'small' for smaller font size
    th.textContent = dia;
    filaEncabezado.appendChild(th);
  });

  thead.appendChild(filaEncabezado);
  tabla.appendChild(thead);

  // Cuerpo
  const tbody = document.createElement("tbody");
  for (let t = inicio; t + duracion <= fin; t += duracion) {
    const hInicio = Math.floor(t / 60);
    const mInicio = t % 60;
    const hFin = Math.floor((t + duracion) / 60);
    const mFin = (t + duracion) % 60;
    const labelHora = `${String(hInicio).padStart(2, '0')}:${String(mInicio).padStart(2, '0')} - ${String(hFin).padStart(2, '0')}:${String(mFin).padStart(2, '0')}`;

    const fila = document.createElement("tr");
    const celdaHora = document.createElement("td");
    celdaHora.classList.add("p-1", "small");
    celdaHora.style.fontSize = "0.8rem"; // Reduce the font size
    celdaHora.textContent = labelHora;
    fila.appendChild(celdaHora);

    dias.forEach(dia => {
      const celda = document.createElement("td");
      celda.classList.add("p-1", "small");
      celda.className = "celda-cita";
      celda.style.cursor = "pointer";
      celda.dataset.dia = dia;
      celda.dataset.hora = labelHora;

      celda.addEventListener("click", () => {
        const clave = `${dia}|${labelHora}`;
        const diaSeleccionado = dias.indexOf(dia);
        const horaSeleccionada = labelHora;
        celda.classList.toggle("bg-success"); // Cambia color al seleccionar
        celda.classList.toggle("text-white");
        if (celda.classList.contains("bg-success")) {
          //horariosSeleccionados[clave] = true;
          horariosSeleccionados[clave] = { dia: diaSeleccionado, hora: horaSeleccionada };
        } else {
          delete horariosSeleccionados[clave];
        }
        // Guardar en textarea
        console.log(horariosSeleccionados);
        //console.log("Horarios seleccionados:", Object.keys(horariosSeleccionados).join(", "));
      });

      fila.appendChild(celda);
    });

    tbody.appendChild(fila);
  }

  tabla.appendChild(tbody);
  tablaWrapper.appendChild(tabla);
  contenedor.appendChild(tablaWrapper);
}

document.querySelector('input[name="tiempoConsulta"]').addEventListener("change", function () {
  const duracion = parseInt(this.value);
  if (!isNaN(duracion) && duracion > 0) {
    generarTablaHorarios(duracion);
  }
});

