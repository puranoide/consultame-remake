// Obtener parámetros de la URL
const params = new URLSearchParams(window.location.search);
const data = params.get("data");

// Decodificar y convertir a objeto
const doctor = JSON.parse(decodeURIComponent(data));
//const horario= JSON.parse(decodeURIComponent(data.horarios));
// Usar el objeto
console.log(doctor)
console.log(doctor.horarios)
//console.log(horario)
const horarios = JSON.parse(doctor.horarios);
console.log(horarios)
const prefijo = document.getElementById("prefijo");
const nombrecomponente = document.getElementById("nombreDoctor");
const emailcomponente = document.getElementById("emailDoctor");

nombrecomponente.innerHTML = doctor.Name || "";
emailcomponente.innerHTML = doctor.email || "";
prefijo.innerHTML = doctor.prefijo || "";

function generarPerfilMedico(medicoObj) {
    const datos = {
        action: "crearPerfil",
        ...medicoObj,
    };
    console.log(datos);
    fetch("controllers/medicos.php", {
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


function generarCorreo(medicoObj) {
    const datos = {
        action: "enviarcorreo",
        ...medicoObj,
    };
    console.log(datos);
    fetch("/controllers/medicRegister.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(datos),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            alert("Registro exitoso, revise su correo electronico para confirmar su registro");
        })
        .catch((error) => console.error(error));
}

window.onload = function () {
    const doctorSinAction = { ...doctor };
    delete doctorSinAction.action;
    generarPerfilMedico(doctorSinAction);
    generarCorreo(doctorSinAction);

}
