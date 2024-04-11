// FUNCIONES NUEVO CREDITO//

if (document.querySelector("#frmNuevoCredito")) {
    let frmNewCredito = document.querySelector("#frmNuevoCredito");
    frmNewCredito.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarCredito();
    }

    async function fntGuardarCredito() {

        try {
            const data = new FormData(frmNewCredito);
            let resp = await fetch(base_url + "controllers/comprobante.php?op=guardarCredito", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status) {
                swal("Crédito", json.msg, "success")
                .then(() => {
                    frmNewCredito.reset();
                    location.reload();
                });
            } else {
                swal("Crédito", json.msg, "error");
            }
        } catch (err) {
            console.log("Ocurrio un error: " + er);
        }
    }
}

// FUNCIONES NUEVO DEBITO//

if (document.querySelector("#frmNuevoDebito")) {
    let frmNewDebito = document.querySelector("#frmNuevoDebito");
    frmNewDebito.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarDebito();
    }

    async function fntGuardarDebito() {

        try {
            const data = new FormData(frmNewDebito);
            let resp = await fetch(base_url + "controllers/comprobante.php?op=guardarDebito", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status) {
                swal("Débito", json.msg, "success")
                .then(() => {
                    frmNewDebito.reset();
                    location.reload();
                });
            } else {
                swal("Débito", json.msg, "error");
            }
        } catch (err) {
            console.log("Ocurrio un error: " + er);
        }
    }
}

// FUNCIONES PARA LISTAR COMPROBANTES Y COMPROBANTES CON FECHA DESDE Y HASTA// 

async function getComprobantes(id) {  
    document.querySelector("#tblBodyComprobantes").innerHTML = "";
    try {
        const data = new FormData();
        data.append('id', id);
        let resp = await fetch(base_url + "controllers/comprobante.php?op=listaComprobantes", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            let datos = json.datos;
    
            // Iterar sobre cada objeto en el arreglo
            datos.forEach(objeto => {
                // Agregar la nueva clave 'idCliente' y asignarle el valor de la clave 'id'
                objeto.idCliente = id;
            });

            // Mostrar la primera página por defecto
            mostrarPagina(1, datos);

            // data.forEach(item => {
            //     var fecha = convertirFecha(item.fecha);
            //     let valorTotal = item.valor;
            //     // Separar la parte entera y la parte decimal
            //     let partes = valorTotal.split('.');
            //     let parteEntera = partes[0];
            //     let parteDecimal = partes[1];
            //     // Agregar puntos como separadores de miles
            //     parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            //     // Unir las partes con una coma como separador decimal
            //     valorTotal = parteEntera + ',' + parteDecimal;

            //     // Segun el tipo de comprobante separamos el valor
            //     let valorDebito = '-';
            //     let valorCredito = '-';
            //     if(item.tipoComprobante == 'Débito'){
            //         valorDebito = '$ ' + valorTotal;
            //     } else if(item.tipoComprobante == 'Crédito'){
            //         valorCredito = '$ ' + valorTotal;
            //     }

            //     // Quitar null de estado pedido
            //     let estadoPedido;
            //     if(item.estadoPedido == null){
            //         estadoPedido = '-';
            //     }else{
            //         estadoPedido = item.estadoPedido;
            //     }

            //     let newtr = document.createElement("tr");
            //     newtr.id = "row_ " + item.id;
            //     newtr.innerHTML = `<tr>
            //                         <th scope="row" style="display: none;">${item.id}</th>
            //                         <td style="text-align: center;">${fecha}</td>
            //                         <td style="text-align: center;">${item.descripcion}</td>
            //                         <td style="text-align: center;">${estadoPedido}</td>
            //                         <td style="text-align: center;">${valorDebito}</td>
            //                         <td style="text-align: center;">${valorCredito}</td>`;
            //     document.querySelector("#tblBodyComprobantes").appendChild(newtr);
            // });
        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

async function getComprobantesFecha(id, desde, hasta) {  
    // Verificar si ambas fechas están seleccionadas
    if (desde && hasta) {
        // Limpiamos la tabla
        document.querySelector("#tblBodyComprobantes").innerHTML = "";
        // Realizar una segunda búsqueda con restricciones de fechas
        const data = new FormData();
        data.append('id', id);
        data.append('fechaDesde', desde);
        data.append('fechaHasta', hasta);
        try {
            let resp = await fetch(base_url + "controllers/comprobante.php?op=listaComproFecha", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });

            json = await resp.json();

            if (json.status) {
                let datos = json.datos;

                // Iterar sobre cada objeto en el arreglo
                datos.forEach(objeto => {
                    // Agregar la nueva clave 'idCliente' y asignarle el valor de la clave 'id'
                    objeto.idCliente = objeto.id;
                });

                mostrarPagina(1, datos);  
            }
        }catch (err) {
            console.log("Ocurrio un error" + err);
        }

    }
}

// Supongamos que tienes un select con ID 'filtro'
const filtro = document.getElementById('filtro');

// Agregar un evento 'change' al select
filtro.addEventListener('change', () => {
    const estadoSeleccionado = filtro.value;
    mostrarPagina(1, json.datos, estadoSeleccionado);
});

// Función para mostrar una página de la tabla
function mostrarPagina(pagina, datos, estadoFiltro) {
    const elementosPorPagina = 10;
    const inicio = (pagina - 1) * elementosPorPagina;
    const fin = inicio + elementosPorPagina;

    document.querySelector("#tblBodyComprobantes").innerHTML = "";

    // Filtrar datos según el estado seleccionado
    const datosFiltrados = estadoFiltro && estadoFiltro !== 'Todo'
        ? datos.filter(item => item.estadoPedido === estadoFiltro)
        : datos;

    // Agrega filas a la tabla según la página actual
    for (let i = inicio; i < fin && i < datosFiltrados.length; i++) {
      const item = datosFiltrados[i];
      var fecha = convertirFecha(item.fecha);
      let valorTotal = item.valor;
      // Separar la parte entera y la parte decimal
      let partes = valorTotal.split('.');
      let parteEntera = partes[0];
      let parteDecimal = partes[1];
      // Agregar puntos como separadores de miles
      parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      // Unir las partes con una coma como separador decimal
      valorTotal = parteEntera + ',' + parteDecimal;

      // Segun el tipo de comprobante separamos el valor
      let valorDebito = '-';
      let valorCredito = '-';
      if(item.tipoComprobante == 'Débito'){
          valorDebito = '$ ' + valorTotal;
      } else if(item.tipoComprobante == 'Crédito'){
          valorCredito = '$ ' + valorTotal;
      }

      // Quitar null de estado pedido
      let estadoPedido;
      let descripcion;
      if(item.estadoPedido == null){
          estadoPedido = '-';
          descripcion = item.descripcion;
      }else{
          estadoPedido = item.estadoPedido;
          descripcion = `<a href="${base_url}/views/pedidos/ver-pedido.php?p=${item.idPedido}&vuelta=${item.idCliente}" target="_blank">${item.descripcion}</a>`;
      }

      // Quitar null de saldoComprobante
      let saldoComprobante;
      if (item.saldoComprobante == null) {
          saldoComprobante = '-';
      } else {
          saldoComprobante = item.saldoComprobante;
          // Separar la parte entera y la parte decimal
          let partesC = saldoComprobante.split('.');
          let parteEnteraC = partesC[0];
          let parteDecimalC = partesC[1];
          // Agregar puntos como separadores de miles
          parteEnteraC = parteEnteraC.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          // Unir las partes con una coma como separador decimal
          saldoComprobante = '$ ' + parteEnteraC + ',' + parteDecimalC;
      }

      let newtr = document.createElement("tr");
      newtr.id = "row_ " + item.id;
      newtr.innerHTML = `<tr>
                          <th scope="row" style="display: none;">${item.id}</th>
                          <td style="text-align: center;">${fecha}</td>
                          <td style="text-align: center;">${descripcion}</td>
                          <td style="text-align: center;">${estadoPedido}</td>
                          <td style="text-align: center;">${valorDebito}</td>
                          <td style="text-align: center;">${valorCredito}</td>
                          <td style="text-align: center;">${saldoComprobante}</td>`;
      document.querySelector("#tblBodyComprobantes").appendChild(newtr);
      
    }
    
    mostrarPaginador(pagina, datosFiltrados.length);
}

// Función para mostrar el paginador
function mostrarPaginador(paginaActual, totalFilas) {
    const paginador = document.getElementById("paginador");
    paginador.innerHTML = "";

    const numeroTotalDePaginas = Math.ceil(totalFilas / 10);

    const botonAnterior = document.createElement("button");
    botonAnterior.innerText = "Anterior";
    botonAnterior.classList.add("btn", "btn-sm", "btn-secondary");
    botonAnterior.addEventListener("click", () => {
        if (paginaActual > 1) {
            mostrarPagina(paginaActual - 1, json.datos);
        }
    });
    paginador.appendChild(botonAnterior);

    for (let i = 1; i <= numeroTotalDePaginas; i++) {
        const botonPagina = document.createElement("button");
        botonPagina.innerText = i;
        botonPagina.classList.add("btn", "btn-sm", "btn-ligth");
        if(paginaActual === i){
            botonPagina.classList.add("btn", "btn-sm", "btn-success"); 
        } 
        botonPagina.addEventListener("click", () => mostrarPagina(i, json.datos));
        paginador.appendChild(botonPagina);
    }

    const botonSiguiente = document.createElement("button");
    botonSiguiente.innerText = "Siguiente";
    botonSiguiente.classList.add("btn", "btn-sm", "btn-secondary");
    botonSiguiente.addEventListener("click", () => {
        if (paginaActual < numeroTotalDePaginas) {
            mostrarPagina(paginaActual + 1, json.datos);
        }
    });
    paginador.appendChild(botonSiguiente);
}


//// Funcion para convertir datos de fecha
function convertirFecha(fecha){
    // Dividir la cadena de fecha y hora
    var partes = fecha.split(" ");
    var fechaParte = partes[0];
    var horaParte = partes[1];

    var fechaFormateada = fechaParte.split("-").reverse().join("-");
    fecha = fechaFormateada + ' ' + horaParte;
    return fecha;
}

async function getCuentaCorriente(id) {
   
    try {
        const data = new FormData();
        data.append('id', id);
        let resp = await fetch(base_url + "controllers/comprobante.php?op=listaCuentaCorriente", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json1 = await resp.json();
        if (json1.status) {
            document.querySelector("#tblBodyCtaCorriente").innerHTML = "";
            let data = json1.data;
            let valorTotal = data.saldo;
            // Separar la parte entera y la parte decimal
            let partes = valorTotal.split('.');
            let parteEntera = partes[0];
            let parteDecimal = partes[1];
            // Agregar puntos como separadores de miles
            parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            // Unir las partes con una coma como separador decimal
            valorTotal = parteEntera + ',' + parteDecimal;
           
            let newtr = document.createElement("tr");
            newtr.id = "row_ " + data.id;
            fecha =convertirFecha(data.fecha);
            newtr.innerHTML = `<tr>
                                <th scope="row" style="display: none;">${data.id}</th>
                                <td style="text-align: center;"><strong>$ ${valorTotal}</strong></td>
                                <td style="text-align: center;">${data.tipoComprobante} - ${data.descripcion}</td>
                                <td style="text-align: center;">${fecha}</td>`;
            document.querySelector("#tblBodyCtaCorriente").appendChild(newtr);

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}


// Función para convertir la cadena de fecha y hora al formato esperado (DD-MM-YYYY HH:mm:ss)
let ordenAscendente = true;  // Variable para rastrear el orden actual
function convertirFechaStringADate(fechaHoraString) {
    const [fechaString, horaString] = fechaHoraString.split(" ");
    const [dia, mes, anio] = fechaString.split("-");
    const [hora, minutos, segundos] = horaString.split(":");
    return new Date(anio, mes - 1, dia, hora, minutos, segundos);
}
// Función para ordenar la tabla por la columna de fechas
function ordenarPorFecha() {
    // Obtener la tabla y las filas
    const tabla = document.querySelector("#tblBodyComprobantes");
    const filas = Array.from(tabla.getElementsByTagName("tr"));

    // Obtener la columna de fechas (columna índice 1)
    const colFecha = 1;

    // Ordenar las filas según la fecha como objeto Date
    filas.sort((a, b) => {
        const fechaA = convertirFechaStringADate(a.cells[colFecha].innerText);
        const fechaB = convertirFechaStringADate(b.cells[colFecha].innerText);

        if (ordenAscendente) {
            return fechaA - fechaB;
        } else {
            return fechaB - fechaA;
        }
    });

    // Eliminar las filas existentes de la tabla
    filas.forEach(fila => tabla.removeChild(fila));

    // Agregar las filas ordenadas a la tabla
    filas.forEach(fila => tabla.appendChild(fila));

    // Cambiar el orden actual para la próxima vez
    ordenAscendente = !ordenAscendente;
}