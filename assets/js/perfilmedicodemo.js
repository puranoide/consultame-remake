const horariosdiv = document.getElementById("horarios");
const idDoctor = document.getElementById("idMedico").value;
console.log(idDoctor);
function ObtenerHorariosDisponibles(idmedico) {
    fetch("../controllers/citas.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "obtenerHorariosdoctor",
            idMedico: idmedico
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                console.log("respuesta :el medico tiene estos horarios", data);
                var horarios = JSON.parse(data.horarios[0].horariosemanal);
                console.log("variable horarios", horarios);
                console.log("tipo horarios", typeof horarios);

                /*
                if (typeof horarios === "object" && horarios !== null) {
                  for (const horario of Object.values(horarios)) {
                    console.log(horario.dia);
                  }
                } else {
                  console.log("horarios no es un objeto");
                }
                */

                horariosdeldoctor = horarios;

                var horariosdeldoctorpordia = [];

                horariosdeldoctorpordia = Object.values(horariosdeldoctor).sort((a, b) => a.dia - b.dia);

                const diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                const horariosAgrupados = {};

                horariosdeldoctorpordia.forEach(horario => {
                    const diaNombre = diasSemana[horario.dia] || "Día desconocido";
                    horario.diaNombre = diaNombre;

                    if (!horariosAgrupados[diaNombre]) {
                        horariosAgrupados[diaNombre] = [];
                    }
                    const primeraHora = horario.hora.split(" - ")[0];
                    horariosAgrupados[diaNombre].push(primeraHora);
                });

                console.log(horariosAgrupados);

                console.log(horariosdeldoctorpordia);

                horariosdiv.innerHTML = "";
                const ptitulo = document.createElement("p");
                ptitulo.className = "title";
                ptitulo.textContent = "Horarios de atención:";
                horariosdiv.appendChild(ptitulo);
                for (const diaNombre in horariosAgrupados) {
                    const pHorario = document.createElement("p");
                    pHorario.innerHTML = `<strong>${diaNombre}:</strong> ${horariosAgrupados[diaNombre].join(", ")}`;
                    horariosdiv.appendChild(pHorario);
                }


            } else {
                console.log("el medico no tiene horarios", data);

            }
        })
        .catch((error) => {
            console.log(error);
        });
}


document.addEventListener("DOMContentLoaded", function () {
    //crearHorarios();
    ObtenerHorariosDisponibles(idDoctor);
});