const formrcontacto = document.getElementById("formularioconsulta");

formrcontacto.addEventListener("submit", function (event) {
  event.preventDefault();
  const formData = new FormData(this);
  objetoRegistro = {};
  const inputs = document.querySelectorAll(
    "#formularioconsulta input, #formularioconsulta textarea, #formularioconsulta radio"
  );
  inputs.forEach((input) => {
    console.log(input.name, input.value);
    objetoRegistro[input.name] = input.value;
  });
  console.log(objetoRegistro);
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
      if (data.success) {
        console.log(data.data.link);
        registrarConsulta(objetoRegistro, data.data.link);
      }
    })
    .catch(error => {
      console.log(error);
    });

}

function registrarConsulta(consultaobj, linkimgurl) {
  const data = {
    action: "consulta",
    linkimgurl: linkimgurl,
    ...consultaobj,
  };
  console.log(data);
  fetch("controllers/contacto.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      //console.log(data);
      if (data.success) {
        console.log("respuesta :", data);
        //alert("Tu registro a sido exitoso");
        //window.location.href = "gestionPosts.php";
        const dataconsulta = encodeURIComponent(JSON.stringify(consultaobj));

        // Redirigir a otra página con el objeto en la URL
        window.location.href = `consultaenviada.html?data=${dataconsulta}`;
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
