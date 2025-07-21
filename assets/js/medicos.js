function obtenerMedicos() {
  fetch("../controllers/medicos.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      action: "obtenerMedicos",
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      //console.log(data);
      if (data.success) {
        console.log("respuesta :", data);
        //alert("post exitoso");
        //window.location.href = "gestionPosts.php";
        llenarTabla(data.medicos);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

function llenarTabla(medicos) {
  medicos.forEach((medico) => {
    var tr = document.createElement("tr");
    tr.classList = "border-b border-gray-200 hover:bg-gray-100";
    var tdid = document.createElement("td");
    tdid.classList = "py-3 px-6 text-left";
    tdid.textContent = medico.idMedico;
    var tdname = document.createElement("td");
    tdname.classList = "py-3 px-6 text-left";
    tdname.textContent = medico.completename;
    var tdemail = document.createElement("td");
    tdemail.classList = "py-3 px-6 text-left";
    tdemail.textContent = medico.email;
    var tdlink = document.createElement("td");
    tdlink.classList = "py-3 px-6 text-left";
    tdlink.textContent = medico.urlLink || "sin link";
    var tdacciones = document.createElement("td");
    tdacciones.classList = "py-3 px-6 text-center";
    var divbuton = document.createElement("div");
    divbuton.classList = "flex items-center justify-center";
    var button = document.createElement("button");
    button.classList =
      "bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded";
    button.textContent = "generar link";
    divbuton.appendChild(button);
    tdacciones.appendChild(divbuton);

    button.addEventListener("click", function () {
      //alert("generar link de id: "+medico.idMedico);
      //var ruta = "medicos/medico" + medico.completename + ".html";
      generarPerfilMedico(medico);
    });

    tr.appendChild(tdid);
    tr.appendChild(tdname);
    tr.appendChild(tdemail);
    tr.appendChild(tdlink);
    tr.appendChild(tdacciones);

    document.getElementById("medicos").appendChild(tr);
  });
}
obtenerMedicos();

function generarPerfilMedico(medicoObj) {
  const datos = {
    action: "crearPerfil",
    ...medicoObj,
  };
  console.log(datos);
  fetch("../controllers/medicos.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(datos),
  })
    .then((response) => response.json())
    .then((data) => console.log(data))
    .catch((error) => console.error(error));
}
