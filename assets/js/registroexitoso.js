// Obtener parámetros de la URL
const params = new URLSearchParams(window.location.search);
const data = params.get("data");

// Decodificar y convertir a objeto
const doctor = JSON.parse(decodeURIComponent(data));

// Usar el objeto
console.log(doctor)

const nombrecomponente=document.getElementById("nombreDoctor");
const emailcomponente=document.getElementById("emailDoctor");

nombrecomponente.innerHTML=doctor.Name || "";
emailcomponente.innerHTML=doctor.email  || "";