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
  console.log(document.getElementById("fechaCita").value);
  var hora=localStorage.getItem("horaCita");
  console.log(hora);
  //regitrarcita(objetoCita);
});


function validarFechayhora(fecha){

  fetch("controllers/citas.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      action: "validarFechayhora",
      fecha: fecha,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("respuesta :", data);
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
    cita: objcita,
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
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

function crearHorarios() {
    let hora = 9;
    let minuto = 0;
    const inputdate=document.createElement("input");
    inputdate.type="date";
    inputdate.className="form-control";
    inputdate.id="fechaCita";
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
            alert("hora seleccionada: " + div.textContent+"envie los datos ");
            console.log("click", div.textContent);
            console.log(inputdate.value);
        })
    }
}


document.addEventListener("DOMContentLoaded", function () {
    crearHorarios();
    localStorage.removeItem("horaCita");
});