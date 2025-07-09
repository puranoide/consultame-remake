var formulariocita = document.getElementById("post-form-register");
var fechasDisponibles = document.getElementById("fechasDisponibles");
formulariocita.addEventListener("submit", function (event) {
  event.preventDefault();
  console.log("submit");
  const formData = new FormData(this);
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

  console.log(objetoCita);
  var fecha = document.getElementById("fechaCita").value;
  var hora = localStorage.getItem("horaCita");
  // Concatena la fecha y la hora en un solo string
  var fechaHora = fecha + ' ' + hora;

  // Formatea la fecha y hora en un formato compatible con MySQL
  var fechaHoraFormateada = fechaHora.replace(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2})/, '$1-$2-$3 $4:$5:00');
  console.log(fechaHoraFormateada);
  validarFechayhora(fechaHoraFormateada, objetoCita);
  //regitrarcita(objetoCita);
});


function validarFechayhora(fecha, objetoCita) {

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
        citaaguardar = { fecha, ...objetoCita }
        regitrarcita(citaaguardar);
      }else{
        console.log("respuesta :el medico no esta disponible",data);  
        
      }
    })
    .catch((error) => {
      console.log(error);
    });

}

function regitrarcita(objcita) {
  console.log("enviando a backend");
  const datos = {
    action: "registrarCita",
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
        console.log("respuesta :", data);
        crearlinkzoom(objcita,data.id);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
function crearlinkzoom(objcita,id) {
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
        console.log("respuesta :", data);
        alert("Cita agendada con exito");
        guardarlinkenreunion(id,data.link);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
function guardarlinkenreunion(id, link) {
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
        console.log("respuesta al guardar link:", data);
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


document.addEventListener("DOMContentLoaded", function () {
  crearHorarios();
  localStorage.removeItem("horaCita");
});