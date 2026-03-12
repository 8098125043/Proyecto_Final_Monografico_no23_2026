// UNIVERSIAD AUTONOMA DE SATO DOMINGO UASD MONOGRAFICO.
// PROYECTO FINAL DE DESARROLLO DE APICACIONES MOVILES

document.addEventListener("DOMContentLoaded", function () {

  
    // INICIO 
  
    const formInicio = document.getElementById("inicioForm");

    if (formInicio) {

        formInicio.addEventListener("submit", function (e) {
            e.preventDefault();

            const nombre = document.getElementById("nombre").value.trim();
            const balanceInicial = parseFloat(document.getElementById("balanceInicial").value);

            if (nombre === "" || isNaN(balanceInicial) || balanceInicial < 0) {
                alert("Complete todos los campos correctamente");
                return;
            }

            localStorage.setItem("nombre", nombre);
            localStorage.setItem("balance", balanceInicial);
            localStorage.setItem("historial", JSON.stringify([]));

            window.location.href = "menu.html";
        });

    }



    // MOSTRAR BALANCE 
    const balanceSpan = document.getElementById("balanceActual");

    if (balanceSpan) {

        const balance = parseFloat(localStorage.getItem("balance")) || 0;
        balanceSpan.textContent = balance.toFixed(2);

    }


   
    // TRANSACCIONES (transaccion.html)
    
    const transForm = document.getElementById("transaccionForm");

    if (transForm) {

        const params = new URLSearchParams(window.location.search);
        const tipo = params.get("tipo");

        const titulo = document.getElementById("tituloTransaccion");

        const nombres = {
            deposito: "Depósito",
            retiro: "Retiro",
            gasto: "Gasto",
            cheque: "Cheque"
        };

        if (titulo && tipo) {
            titulo.textContent = nombres[tipo] || "Transacción";
        }

        transForm.addEventListener("submit", function (e) {

            e.preventDefault();

            const fecha = document.getElementById("fecha").value;
            const concepto = document.getElementById("concepto").value.trim();
            const monto = parseFloat(document.getElementById("monto").value);

            let balance = parseFloat(localStorage.getItem("balance")) || 0;
            let historial = JSON.parse(localStorage.getItem("historial")) || [];

            if (!fecha || concepto === "" || isNaN(monto) || monto <= 0) {
                alert("Complete todos los campos correctamente");
                return;
            }

           
            // LÓGICA DE TRANSACCIÓN
          

            if (tipo === "deposito") {

                balance += monto;

            } else if (tipo === "retiro" || tipo === "gasto" || tipo === "cheque") {

                if (monto > balance) {
                    alert("Fondos insuficientes");
                    return;
                }

                balance -= monto;
            }

            const nuevaTransaccion = {
                fecha: fecha,
                tipo: tipo,
                concepto: concepto,
                monto: monto,
                balance: balance
            };

            historial.push(nuevaTransaccion);

            localStorage.setItem("balance", balance);
            localStorage.setItem("historial", JSON.stringify(historial));

            alert("Transacción guardada correctamente");

            window.location.href = "historial.html";

        });

    }


   
    // MOSTRAR HISTORIAL 
   
    const tabla = document.querySelector("tbody");

    if (tabla) {

        const historial = JSON.parse(localStorage.getItem("historial")) || [];

        tabla.innerHTML = "";

        historial.forEach(trans => {

            const clase = trans.tipo === "deposito" ? "ingreso" : "egreso";

            tabla.innerHTML += `
                <tr>
                    <td>${trans.fecha}</td>
                    <td>${trans.tipo}</td>
                    <td>${trans.concepto}</td>
                    <td class="${clase}">RD$ ${trans.monto.toFixed(2)}</td>
                    <td>RD$ ${trans.balance.toFixed(2)}</td>
                </tr>
            `;

        });

    }

});