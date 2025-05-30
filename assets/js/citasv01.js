var formulariocita = document.getElementById("post-form-register");

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
    objetoCita[key] = input.value;
  });
  console.log(objetoCita);
  regitrarcita(objetoCita);
});


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
      //console.log(data);
      if (data.success) {
        console.log("respuesta :", data);
        //alert("post exitoso");
        //window.location.href = "gestionPosts.php";
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
