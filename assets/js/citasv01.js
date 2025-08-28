var formulariocita = document.getElementById("post-form-register");
var fechasDisponibles = document.getElementById("fechasDisponibles");
var fechaseleccionada = document.getElementById("fechaSeleccionada");
var urlParams = new URLSearchParams(window.location.search);
var idmedico = urlParams.get('id');
console.log(idmedico);
var horariosdeldoctor = {};


formulariocita.addEventListener("submit", function (event) {
  event.preventDefault();
  console.log("submit");
  const formData = new FormData(this);
  const inputarchivo = document.getElementById("linkFoto");
  const archivo = inputarchivo.files[0]; // archivo real
  objetoCita = {};
  const inputs = document.querySelectorAll(
    "#post-form-register input, #post-form-register textarea"
  );
  inputs.forEach((input) => {
    let key = input.id ? input.id : input.name;
    console.log(key, input.value);
    if (input.type === "datetime-local") {
      objetoCita[key] = new Date(input.value).toLocaleString();
    } else {
      objetoCita[key] = input.value;
    }
  });

  //console.log(objetoCita);
  var fecha = document.getElementById("fechaSeleccionada").value;
  var hora = localStorage.getItem("horaCita");
  // Concatena la fecha y la hora en un solo string
  var fechaHora = fecha + ' ' + hora;

  // Formatea la fecha y hora en un formato compatible con MySQL
  var fechaHoraFormateada = fechaHora.replace(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2})/, '$1-$2-$3 $4:$5:00');
  console.log(fechaHoraFormateada, objetoCita, archivo);
  validarFechayhora(fechaHoraFormateada, objetoCita, archivo);
  //regitrarcita(objetoCita);
});


function validarFechayhora(fecha, objetoCita, archivo) {

  fetch("controllers/citas.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      action: "validarFechayhora",
      fecha: fecha,
      ...objetoCita,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("respuesta :el medico esta disponible", data);
        citaaguardar = { fecha, archivo, ...objetoCita }
        regitrarcita(citaaguardar);
      } else {
        console.log("respuesta :el medico no esta disponible", data);
        alert("el medico no esta disponible, por favor elija otra fecha o hora");

      }
    })
    .catch((error) => {
      console.log("error", error);
    });

}

function regitrarcita(objcita) {
  console.log("enviando a backend");
  const formData = new FormData();
  formData.append("action", "registrarCita");

  // agregar todos los datos del objeto
  for (const [key, value] of Object.entries(objcita)) {
    // si es archivo lo agregamos tal cual
    if (key === "archivo") {
      formData.append("archivo", value); // 👈 este debe coincidir con el name del input
    } else {
      formData.append(key, value);
    }
  }
  fetch("controllers/citas.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("respuesta al guardar cita sin link :", data);
        crearlinkzoom(objcita, data.id);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
function crearlinkzoom(objcita, id) {
  console.log("enviando a backend");
  const datos = {
    action: "crearlinkdezoom",
    ...objcita,
  };
  fetch("controllers/citas.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(datos),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("respuesta al momento de actualizar la cita para agregar el link :", data);
        alert("Cita agendada con exito");
        guardarlinkenreunion(id, data.link, datos);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
function guardarlinkenreunion(id, link, datosdereunion) {
  console.log("enviando a backend");
  const datos = {
    action: "guardarlinkenreunion",
    id: id,
    link: link,
  };
  fetch("controllers/citas.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(datos),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("respuesta al guardar link:", data, datosdereunion);
        const linkparajson = link;
        const datosdereunionjson = encodeURIComponent(JSON.stringify({ ...datosdereunion, linkparajson }));
        console.log(datosdereunionjson);
        window.location.href = `reservaexitosa.html?data=${datosdereunionjson}`;
      }
    })

}
function crearHorarios() {
  let hora = 9;
  let minuto = 0;
  const inputdate = document.createElement("input");
  inputdate.type = "date";
  inputdate.className = "form-control";
  inputdate.id = "fechaCita";
  fechasDisponibles.appendChild(inputdate);
  for (let i = 0; i < 24; i++) {
    const div = document.createElement("div");
    div.textContent = hora + ":" + (minuto === 0 ? "00" : minuto);
    div.className = "btn btn-outline-secondary btn-lg";
    fechasDisponibles.appendChild(div);

    minuto += 30;
    if (minuto === 60) {
      minuto = 0;
      hora++;
    }
    div.addEventListener("click", function () {
      localStorage.setItem("horaCita", div.textContent);
      alert("hora seleccionada: " + div.textContent + "\nenvie los datos ");
      console.log("click", div.textContent);
      console.log(inputdate.value);
    })
  }
}

function ObtenerHorariosDisponibles(idmedico) {
  fetch("controllers/citas.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      action: "obtenerHorariosdoctor",
      idMedico: idmedico
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("respuesta :el medico tiene estos horarios", data);
        var horarios = JSON.parse(data.horarios[0].horariosemanal);
        console.log("variable horarios", horarios);
        console.log("tipo horarios", typeof horarios);

        /*
        if (typeof horarios === "object" && horarios !== null) {
          for (const horario of Object.values(horarios)) {
            console.log(horario.dia);
          }
        } else {
          console.log("horarios no es un objeto");
        }
        */

        horariosdeldoctor = horarios;

      } else {
        console.log("el medico no tiene horarios", data);

      }
    })
    .catch((error) => {
      console.log(error);
    });
}

fechaseleccionada.addEventListener("change", function () {
  //console.log(fechaseleccionada.value);
  var fecha = new Date(fechaseleccionada.value);
  //console.log(fecha.getDay());
  var dia = fecha.getDay();
  //console.log(dia);
  var horariosdeldoctorpordia = [];

  for (const horariodia of Object.values(horariosdeldoctor)) {
    if (horariodia.dia == dia) {
      horariosdeldoctorpordia.push(horariodia);
    }
  }

  if (horariosdeldoctorpordia.length > 0) {
    console.log("hay horarios disponibles", horariosdeldoctorpordia);
    let hora = 9;
    let minuto = 0;
    fechasDisponibles.innerHTML = "";
    for (const horario of horariosdeldoctorpordia) {
      const div = document.createElement("div");
      let primeraHora = horario.hora.split(" - ")[0];
      div.textContent = primeraHora;
      div.className = "btn btn-outline-secondary btn-lg";
      fechasDisponibles.appendChild(div);

      div.addEventListener("click", function () {
        localStorage.setItem("horaCita", div.textContent);
        alert("hora seleccionada: " + div.textContent + "\nenvie los datos ");
        console.log("click", div.textContent);
        console.log(fechaseleccionada.value);
      })
    }
  } else {
    fechasDisponibles.innerHTML = "";
    console.log("no hay horarios disponibles");
    fechasDisponibles.innerHTML = "El medico no tiene horarios disponibles para la fecha seleccionada";

  }

});

document.addEventListener("DOMContentLoaded", function () {
  //crearHorarios();
  ObtenerHorariosDisponibles(idmedico);
});