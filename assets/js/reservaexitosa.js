// Obtener parámetros de la URL
const params = new URLSearchParams(window.location.search);
const data = params.get("data");

// Decodificar y convertir a objeto
const { action, ...cita } = JSON.parse(decodeURIComponent(data));
//const horario= JSON.parse(decodeURIComponent(data.horarios));
// Usar el objeto
console.log(cita)
//console.log(doctor.horarios)
//console.log(horario)
//const horarios = JSON.parse(doctor.horarios);
//console.log(horarios)
const nombrecomponente = document.getElementById("nombres");
const emailcomponente = document.getElementById("email");

nombrecomponente.innerHTML = cita.nombre || "";
emailcomponente.innerHTML = cita.email || "";



function generarCorreo(cita) {
    const datos = {
        action: "enviarcorreo",
        ...cita,
    };
    console.log(datos);
    fetch("/controllers/citas.php", {
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
    generarCorreo(cita);
    console.log(cita);

}
