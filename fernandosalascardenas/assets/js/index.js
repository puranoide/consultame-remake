var horarioDoctor = {"inicio": "18:30", "fin": "19:00"}; // Horario en zona española
var diasDisponibles = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

// Zona horaria del doctor (España)

const zonaHorarioDoctor = 'Europe/Madrid';

// Zona horaria del usuario (detectada automáticamente)
const zonaHorarioUsuario = Intl.DateTimeFormat().resolvedOptions().timeZone;

console.log("=== INFORMACIÓN DE ZONAS HORARIAS ===");
console.log("Zona horaria del doctor:", zonaHorarioDoctor);
console.log("Zona horaria del usuario:", zonaHorarioUsuario);

// Función para convertir horario de una zona a otra
function convertirHorarioAZonaLocal(horarioEspanol, zonaOrigen, zonaDestino) {
    // Crear una fecha arbitraria (hoy) con la hora del doctor en España
    const fechaHoy = new Date();
    const [horas, minutos] = horarioEspanol.split(':').map(Number);
    
    // Crear fecha en la zona horaria del doctor
    const fechaEnEspana = new Date();
    fechaEnEspana.setHours(horas, minutos, 0, 0);
    
    // Convertir a string en zona española y luego crear nueva fecha
    const fechaEspanaString = fechaEnEspana.toLocaleString("en-US", {
        timeZone: zonaOrigen,
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });
    
    // Crear fecha base para hoy en España
    const fechaBase = new Date();
    const ano = fechaBase.getFullYear();
    const mes = (fechaBase.getMonth() + 1).toString().padStart(2, '0');
    const dia = fechaBase.getDate().toString().padStart(2, '0');
    
    // Crear fecha completa en zona española
    const fechaCompletaEspana = new Date(`${ano}-${mes}-${dia}T${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:00`);
    
    // Ajustar para zona horaria española
    const offsetEspana = -fechaCompletaEspana.getTimezoneOffset() + (60 * 2); // España es UTC+1 (UTC+2 en verano)
    const fechaAjustadaEspana = new Date(fechaCompletaEspana.getTime() - (offsetEspana * 60000));
    
    // Obtener la hora equivalente en la zona local
    const horaEnZonaLocal = new Date(fechaAjustadaEspana.toLocaleString("en-US", {timeZone: zonaDestino}));
    
    // Método más simple y confiable
    const fechaReferencia = new Date(`2024-01-15T${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:00.000Z`);
    
    // Obtener diferencia de zona horaria
    const horaEspana = new Date(fechaReferencia.toLocaleString("en-US", {timeZone: zonaOrigen}));
    const horaLocal = new Date(fechaReferencia.toLocaleString("en-US", {timeZone: zonaDestino}));
    
    const diferencia = horaLocal.getTime() - horaEspana.getTime();
    
    // Crear fecha con la hora del doctor en España
    const fechaDoctor = new Date();
    fechaDoctor.setHours(horas, minutos, 0, 0);
    
    // Aplicar la diferencia
    const fechaLocalConvertida = new Date(fechaDoctor.getTime() + diferencia);
    
    // Formatear resultado
    const horaLocal_formatted = fechaLocalConvertida.getHours().toString().padStart(2, '0');
    const minutosLocal_formatted = fechaLocalConvertida.getMinutes().toString().padStart(2, '0');
    
    return `${horaLocal_formatted}:${minutosLocal_formatted}`;
}

// Método más preciso usando Intl
function convertirHorarioPreciso(horarioEspanol, zonaDestino) {
    const [horas, minutos] = horarioEspanol.split(':').map(Number);
    
    // Crear fecha para hoy con la hora específica
    const hoy = new Date();
    const fechaEspana = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), horas, minutos);
    
    // Simular que esta hora es en España
    const horaEnEspana = new Date(fechaEspana.toLocaleString("en-US", {timeZone: "Europe/Madrid"}));
    const horaEnLocal = new Date(fechaEspana.toLocaleString("en-US", {timeZone: zonaDestino}));
    
    // Calcular diferencia
    const diferenciaTiempo = fechaEspana.getTime() - horaEnEspana.getTime() + horaEnLocal.getTime();
    const fechaConvertida = new Date(diferenciaTiempo);
    
    const horaFinal = fechaConvertida.getHours().toString().padStart(2, '0');
    const minutosFinal = fechaConvertida.getMinutes().toString().padStart(2, '0');
    
    return `${horaFinal}:${minutosFinal}`;
}

// Método más simple y efectivo
function convertirHorarioSimple(horarioEspanol) {
    const [horas, minutos] = horarioEspanol.split(':').map(Number);
    
    // Crear una fecha ficticia para hoy con la hora del doctor en España
    const fechaEspana = new Date();
    fechaEspana.setHours(horas, minutos, 0, 0);
    
    // Obtener esta misma hora pero interpretada como si fuera hora española
    const formatter = new Intl.DateTimeFormat('es-ES', {
        timeZone: 'Europe/Madrid',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });
    
    // Obtener la misma fecha/hora pero en la zona local del usuario
    const formatterLocal = new Intl.DateTimeFormat('es-ES', {
        timeZone: zonaHorarioUsuario,
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });
    
    // Para obtener la conversión correcta, creamos una fecha específica
    const hoy = new Date();
    const fechaConHoraEspana = new Date(
        hoy.getFullYear(),
        hoy.getMonth(), 
        hoy.getDate(),
        horas,
        minutos
    );
    
    // Obtener offset de España
    const offsetEspana = new Date().toLocaleString("en-US", {timeZone: "Europe/Madrid"});
    const offsetLocal = new Date().toLocaleString("en-US", {timeZone: zonaHorarioUsuario});
    
    // Método definitivo usando UTC
    const fechaUTC = new Date(`${hoy.getFullYear()}-${(hoy.getMonth()+1).toString().padStart(2,'0')}-${hoy.getDate().toString().padStart(2,'0')}T${horas.toString().padStart(2,'0')}:${minutos.toString().padStart(2,'0')}:00`);
    
    // Interpretar como hora española y convertir a local
    const horaEspanaComoLocal = new Date(fechaUTC.toLocaleString("sv-SE", {timeZone: "Europe/Madrid"}));
    const diferencia = fechaUTC.getTime() - horaEspanaComoLocal.getTime();
    
    const horaConvertidaLocal = new Date(fechaUTC.getTime() - diferencia);
    const horaLocalFinal = new Date(horaConvertidaLocal.toLocaleString("sv-SE", {timeZone: zonaHorarioUsuario}));
    
    return horaLocalFinal.toTimeString().slice(0,5);
}

// CONVERSIÓN FINAL - Método más directo
function convertirHorario(horarioEspanol) {
    const [horas, minutos] = horarioEspanol.split(':').map(Number);
    
    // Crear fecha con la hora en España (como si fuera UTC)
    const fechaEspana = new Date();
    fechaEspana.setUTCHours(horas, minutos, 0, 0);
    
    // Obtener offsets
    const offsetEspana = -new Date().toLocaleString('en', {timeZone: 'Europe/Madrid'}).match(/GMT([+-]\d{4})/)?.[1] || '+0200';
    const offsetLocal = new Date().getTimezoneOffset();
    
    // Crear fecha representando la hora en España
    const ahora = new Date();
    const fechaCompleta = new Date(ahora.getFullYear(), ahora.getMonth(), ahora.getDate(), horas, minutos);
    
    // Convertir considerando que la hora original está en España
    const fechaEspanaCompleta = new Date(fechaCompleta.toLocaleString("en-US", {timeZone: "Europe/Madrid"}));
    const fechaLocalCompleta = new Date(fechaCompleta.toLocaleString("en-US", {timeZone: zonaHorarioUsuario}));
    
    const diferencia = fechaLocalCompleta.getTime() - fechaEspanaCompleta.getTime();
    const resultado = new Date(fechaCompleta.getTime() + diferencia);
    
    return `${resultado.getHours().toString().padStart(2, '0')}:${resultado.getMinutes().toString().padStart(2, '0')}`;
}

// VERSIÓN FINAL SIMPLIFICADA
function convertirDeEspanaALocal(horarioEspanol) {
    const [horas, minutos] = horarioEspanol.split(':').map(Number);
    
    // Crear fecha base para hoy
    const hoy = new Date();
    
    // Crear la hora en España
    const fechaEspana = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate(), horas, minutos);
    
    // Obtener la diferencia de zonas horarias
    const offsetEspana = new Date(fechaEspana).toLocaleString('sv-SE', {timeZone: 'Europe/Madrid'});
    const offsetLocal = new Date(fechaEspana).toLocaleString('sv-SE', {timeZone: zonaHorarioUsuario});
    
    // Parsear las fechas
    const fechaEnEspana = new Date(offsetEspana);
    const fechaEnLocal = new Date(offsetLocal);
    
    // La diferencia nos da cuántas horas debemos ajustar
    const diferenciasHoras = (fechaEnLocal.getTime() - fechaEnEspana.getTime()) / (1000 * 60 * 60);
    
    // Aplicar la diferencia a la hora original
    const fechaResultado = new Date(fechaEspana.getTime() + (diferenciasHoras * 1000 * 60 * 60));
    
    return `${fechaResultado.getHours().toString().padStart(2, '0')}:${fechaResultado.getMinutes().toString().padStart(2, '0')}`;
}

// Crear las variables con los horarios convertidos
const horarioInicioLocal = convertirDeEspanaALocal(horarioDoctor.inicio);
const horarioFinLocal = convertirDeEspanaALocal(horarioDoctor.fin);

// Variables finales con los horarios en zona local del usuario
var horarioDoctorLocal = {
    "inicio": horarioInicioLocal,
    "fin": horarioFinLocal
};

console.log("\n=== CONVERSIÓN DE HORARIOS ===");
console.log("Horario del doctor en España:", horarioDoctor);
console.log("Horario del doctor en tu zona local:", horarioDoctorLocal);

console.log("\n=== DETALLES DE CONVERSIÓN ===");
console.log(`Inicio: ${horarioDoctor.inicio} (España) → ${horarioInicioLocal} (Local)`);
console.log(`Fin: ${horarioDoctor.fin} (España) → ${horarioFinLocal} (Local)`);

// Mostrar ejemplo práctico
const ejemploHora = new Date();
const horaEspanaEjemplo = ejemploHora.toLocaleString('es-ES', {
    timeZone: 'Europe/Madrid',
    hour: '2-digit',
    minute: '2-digit'
});
const horaLocalEjemplo = ejemploHora.toLocaleString('es-ES', {
    timeZone: zonaHorarioUsuario,
    hour: '2-digit',
    minute: '2-digit'
});

console.log("\n=== EJEMPLO EN TIEMPO REAL ===");
console.log(`Ahora en España: ${horaEspanaEjemplo}`);
console.log(`Ahora en tu zona: ${horaLocalEjemplo}`);

console.log("\n=== VARIABLES CREADAS ===");
console.log("horarioDoctor (España):", horarioDoctor);
console.log("horarioDoctorLocal (Tu zona):", horarioDoctorLocal);

const horariosdiv = document.getElementById("horarios");

horariosdiv.innerHTML = "";
horariosdiv.textContent = "Lunes a Viernes: " + horarioDoctorLocal.inicio + " a " + horarioDoctorLocal.fin;