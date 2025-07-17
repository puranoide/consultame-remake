// Obtener parámetros de la URL
const params = new URLSearchParams(window.location.search);
const data = params.get("data");

// Decodificar y convertir a objeto
const doctor = JSON.parse(decodeURIComponent(data));

// Usar el objeto
console.log(doctor)

const nombrecomponente=document.getElementById("consulta_nombre");
const emailcomponente=document.getElementById("consulta_email");
const telefonocomponente=document.getElementById("consulta_telefono");
const consultacomponente=document.getElementById("consulta_consulta");

nombrecomponente.innerHTML=doctor.name || "";
emailcomponente.innerHTML=doctor.email  || "";
telefonocomponente.innerHTML=doctor.telefono || "";
consultacomponente.innerHTML=doctor.contenidomensaje    || "";
