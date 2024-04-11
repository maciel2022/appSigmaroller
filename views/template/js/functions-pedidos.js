// FUNCIONES VER TODOS PEDIDOS   //

async function getPedidos() {
    fechaDesdeInput.style.display = 'block';
    fechaHastaInput.style.display = 'block';
    fechaDesdeLabel.style.display = 'block';
    fechaHastaLabel.style.display = 'block';
    try {
        let resp = await fetch(base_url + "controllers/pedido.php?op=listpedidos");
        json = await resp.json();

        if (json.status) {
            let data = json.data;
            if(json.user == 'administrador'){
                data =data.filter(item=>item.estadoPedido != 'Borrador');
            }
            // Mostrar la primera página por defecto
            mostrarPagina(1, data);
            
        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

async function getPedidosFecha(desde, hasta) {  
    // Verificar si ambas fechas están seleccionadas
    if (desde && hasta) {
        // Limpiamos la tabla
        document.querySelector("#tblBodyPedidos").innerHTML = "";
        // Realizar una segunda búsqueda con restricciones de fechas
        const data = new FormData();
        data.append('fechaDesde', desde);
        data.append('fechaHasta', hasta);
        try {
            let resp = await fetch(base_url + "controllers/pedido.php?op=listpedidosFecha", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });

            json = await resp.json();

            if (json.status) {
                let data = json.data;
                if(json.user == 'administrador'){
                    data =data.filter(item=>item.estadoPedido != 'Borrador');
                }
                mostrarPaginaFecha(1, data);  
            }
        }catch (err) {
            console.log("Ocurrio un error" + err);
        }

    }
}


function filtrarPedidos(data, usuario) {
    if (usuario === 'administrador') {
        return data.filter(item => item.estadoPedido !== 'Borrador');
    } else {
        return data;
    }
}

let fechaDesdeInput = document.querySelector("#desde");
let fechaHastaInput = document.querySelector("#hasta");
let fechaDesdeLabel = document.querySelector("#desdeLabel");
let fechaHastaLabel = document.querySelector("#hastaLabel");
// Función para ejecutar cuando se cambia la fecha
function onChangeFecha() {
    const fechaDesde = fechaDesdeInput.value;
    const fechaHasta = fechaHastaInput.value;

    if (document.querySelector("#tblBodyPedidos")) {
        getPedidosFecha(fechaDesde, fechaHasta);
    }
}

// Verificar si existe tblBodyPedidos al cargar la página
if (document.querySelector("#tblBodyPedidos")) {
    // Ejecutar funciones iniciales
    getPedidos();

    // Agregar eventos de escucha para cambios en las fechas
    fechaDesdeInput.addEventListener('change', onChangeFecha);
    fechaHastaInput.addEventListener('change', onChangeFecha);
}



//Validacion de para utilizar getPedidos
// if (document.querySelector("#tblBodyPedidos")) {
//     getPedidos();
// }

// Supongamos que tienes un select con ID 'filtro'
const filtro = document.getElementById('filtro');

// Creo una variable global de funcion buscar para separar el filtro
let funcionBuscar = false; 
let funcionFecha = false;

// Agregar un evento 'change' al select
filtro.addEventListener('change', () => {
    const estadoSeleccionado = filtro.value;
    if (funcionBuscar == false) {
        mostrarPagina(1, filtrarPedidos(json.data, json.user), estadoSeleccionado);
    } else {
        mostrarPaginaBuscador(1, filtrarPedidos(json.data, json.user), estadoSeleccionado);
    }
});

//Funciones para paginar//
// Función para mostrar una página de la tabla
function mostrarPagina(pagina, datos, estadoFiltro) {
    const elementosPorPagina = 20;
    const inicio = (pagina - 1) * elementosPorPagina;
    const fin = inicio + elementosPorPagina;

    document.querySelector("#tblBodyPedidos").innerHTML = "";

    // Filtrar datos según el estado seleccionado
    const datosFiltrados = estadoFiltro && estadoFiltro !== 'Todo'
        ? datos.filter(item => item.estadoFiltro === estadoFiltro)
        : datos;

    // Agrega filas a la tabla según la página actual
    for (let i = inicio; i < fin && i < datosFiltrados.length; i++) {
      const item = datosFiltrados[i];
      // Formateo de fecha
    //   const fecha = new Date(item.fecha);
    //   const dia = fecha.getDate() + 1;
    //   const mes = fecha.getMonth() + 1; // se suma 1 ya que los meses comienzan desde 0
    //   const anio = fecha.getFullYear();
    //   const diaStr = (dia < 10) ? "0" + dia : dia.toString();
    //   const mesStr = (mes < 10) ? "0" + mes : mes.toString();
    //   const anioStr = (anio < 10) ? "0" + anio : anio.toString();
    //   const fechaFormateada = `${diaStr}-${mesStr}-${anioStr}`;
      const fechaFormateada = convertirFecha(item.fecha);

      // Pasar a decimal el valor total  
      let valorTotal = item.valorTotal;
      valorTotal = parseFloat(valorTotal);
      valorTotal = valorTotal.toFixed(2);
      
      // Separar la parte entera y la parte decimal
      let partes = valorTotal.split('.');
      let parteEntera = partes[0];
      let parteDecimal = partes[1];

      // Agregar puntos como separadores de miles
      parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      // Unir las partes con una coma como separador decimal
      valorTotal = parteEntera + ',' + parteDecimal;

              let newtr = document.createElement("tr");
              newtr.id = "row_ " + item.idPedido;
              newtr.innerHTML = `<tr>
                      <th scope="row" style="display: none;">${item.idPedido}</th>
                      <td style="text-align: center;">${item.nombreCliente}</td>
                      <td style="text-align: center;">${item.idPedido}</td>
                      <td style="text-align: center;">${fechaFormateada}</td>
                      <td style="text-align: center;">$ ${valorTotal}</td>
                      <td style="text-align: center;">${item.estadoPedido}</td>
                      <td style="text-align: center;">${item.options}</td>`;
              document.querySelector("#tblBodyPedidos").appendChild(newtr);
      
    }
    
    mostrarPaginador(pagina, datosFiltrados.length);
}

function mostrarPaginaFecha(pagina, datos, estadoFiltro) {
    const elementosPorPagina = 20;
    const inicio = (pagina - 1) * elementosPorPagina;
    const fin = inicio + elementosPorPagina;

    document.querySelector("#tblBodyPedidos").innerHTML = "";

    // Filtrar datos según el estado seleccionado
    const datosFiltrados = estadoFiltro && estadoFiltro !== 'Todo'
        ? datos.filter(item => item.estadoFiltro === estadoFiltro)
        : datos;

    // Agrega filas a la tabla según la página actual
    for (let i = inicio; i < fin && i < datosFiltrados.length; i++) {
      const item = datosFiltrados[i];
      // Formateo de fecha
    //   const fecha = new Date(item.fecha);
    //   const dia = fecha.getDate() + 1;
    //   const mes = fecha.getMonth() + 1; // se suma 1 ya que los meses comienzan desde 0
    //   const anio = fecha.getFullYear();
    //   const diaStr = (dia < 10) ? "0" + dia : dia.toString();
    //   const mesStr = (mes < 10) ? "0" + mes : mes.toString();
    //   const anioStr = (anio < 10) ? "0" + anio : anio.toString();
    //   const fechaFormateada = `${diaStr}-${mesStr}-${anioStr}`;
      const fechaFormateada = convertirFecha(item.fecha);

      // Pasar a decimal el valor total  
      let valorTotal = item.valorTotal;
      valorTotal = parseFloat(valorTotal);
      valorTotal = valorTotal.toFixed(2);
      
      // Separar la parte entera y la parte decimal
      let partes = valorTotal.split('.');
      let parteEntera = partes[0];
      let parteDecimal = partes[1];

      // Agregar puntos como separadores de miles
      parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      // Unir las partes con una coma como separador decimal
      valorTotal = parteEntera + ',' + parteDecimal;

              let newtr = document.createElement("tr");
              newtr.id = "row_ " + item.idPedido;
              newtr.innerHTML = `<tr>
                      <th scope="row" style="display: none;">${item.idPedido}</th>
                      <td style="text-align: center;">${item.nombreCliente}</td>
                      <td style="text-align: center;">${item.idPedido}</td>
                      <td style="text-align: center;">${fechaFormateada}</td>
                      <td style="text-align: center;">$ ${valorTotal}</td>
                      <td style="text-align: center;">${item.estadoPedido}</td>
                      <td style="text-align: center;">${item.options}</td>`;
              document.querySelector("#tblBodyPedidos").appendChild(newtr);
      
    }
    
    mostrarPaginador(pagina, datosFiltrados.length);
}

//// Funcion para covertir fecha /////
function convertirFecha(fecha){
    nuevaFecha = fecha.split("-").reverse().join("-");
    return nuevaFecha;
}

// Función para mostrar el paginador
function mostrarPaginador(paginaActual, totalFilas) {    
    const paginador = document.getElementById("paginador");
    paginador.innerHTML = "";

    const numeroTotalDePaginas = Math.ceil(totalFilas / 20);

    const botonAnterior = document.createElement("button");
    botonAnterior.innerText = "Anterior";
    botonAnterior.classList.add("btn", "btn-sm", "btn-secondary");
    botonAnterior.addEventListener("click", () => {
        if (paginaActual > 1) {
            mostrarPagina(paginaActual - 1, filtrarPedidos(json.data, json.user));
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
        botonPagina.addEventListener("click", () => mostrarPagina(i, filtrarPedidos(json.data, json.user)));
        paginador.appendChild(botonPagina);
    }

    const botonSiguiente = document.createElement("button");
    botonSiguiente.innerText = "Siguiente";
    botonSiguiente.classList.add("btn", "btn-sm", "btn-secondary");
    botonSiguiente.addEventListener("click", () => {
        if (paginaActual < numeroTotalDePaginas) {
            mostrarPagina(paginaActual + 1, filtrarPedidos(json.data, json.user));
        }
    });
    paginador.appendChild(botonSiguiente);
}

// Variable para rastrear el orden actual
let ordenAscendente = true; 
// Función para convertir la cadena de fecha al formato esperado (DD-MM-YYYY)
function convertirFechaStringADate(fechaString) {
    const partes = fechaString.split("-");
    return new Date(partes[2], partes[1] - 1, partes[0]);
}
// Función para ordenar la tabla por la columna de fechas
function ordenarPorFecha() {
    // Obtener la tabla y las filas
    const tabla = document.querySelector("#tblBodyPedidos");
    const filas = Array.from(tabla.getElementsByTagName("tr"));

    // Obtener la columna de fechas (columna índice 1)
    const colFecha = 3;

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

//////// FUNCIONES NUEVO PEDIDO  //////

if (document.querySelector("#frmNuevoPedido")) {
    let frmNewPedido = document.querySelector("#frmNuevoPedido");
    frmNewPedido.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardar();
    }

    async function fntGuardar() {

        try {
            const data = new FormData(frmNewPedido);
            let resp = await fetch(base_url + "controllers/pedido.php?op=guardar", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status) {

                let data = json.data;

                window.location = base_url + 'views/pedidos/nuevo-pedido.php?p=' + data;



            } else {
                swal("Guardar", json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: " + er);
        }
    }
}
// Funcion de guardar pedido de un cliente

async function fntGuardarPed(id) {

    try {
        const data = new FormData();
        data.append('txtIdCliente', id);
        let resp = await fetch(base_url + "controllers/pedido.php?op=guardar", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {

            let data = json.data;

            window.location = base_url + 'views/pedidos/nuevo-pedido.php?p=' + data;



        } else {
            swal("Guardar", json.msg, "error");
        }

    } catch (err) {
        console.log("Ocurrio un error: " + er);
    }
}

//// FUNCION PARA ELIMINAR PEDIDOS /////
function fntEliminarPedido(id) {

    swal({
        title: "Queres eliminar el Pedido?",
        text: "Eliminar el pedido, borrara de la base de datos el Pedido!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                fntDeletePedido(id);
            }
        });

}

async function fntDeletePedido(id) {
    try {
        let formData = new FormData();
        formData.append('id', id);
        let resp = await fetch(base_url + "controllers/pedido.php?op=eliminar", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            swal("Eliminar", json.msg, "success")
                .then(() => {
                    location.reload();
                });
        } else {
            swal("Eliminar", json.msg, "error")
                .then(() => {
                    location.reload();
                });
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }
}


////////// FUNCIONES DE BUSCADOR /////////////
if (document.querySelector("#frmBuscarPed")) {
    let frmBuscarPed = document.querySelector("#frmBuscarPed");
    frmBuscarPed.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina

        let buscador = document.querySelector("#searchPedido").value;
        if (buscador == "") {
            getPedidos();
        } else {
            fntBuscarPedidos();
        }
    }

    let textoBuscador = document.querySelector("#searchPedido");
    textoBuscador.addEventListener("keyup", fntSearchPedidos, true);

   
    async function fntBuscarPedidos() {
        document.querySelector("#tblBodyPedidos").innerHTML = "";
        try {

            let formData = new FormData(frmBuscarPed);
            let resp = await fetch(base_url + "controllers/pedido.php?op=buscador", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });

            json = await resp.json();
            if (json.status) {
                let data = json.data;
                // Mostrar la primera página por defecto
                mostrarPaginaBuscador(1, data);
                funcionBuscar = true;
                
                fechaDesdeInput.style.display = 'none';
                fechaHastaInput.style.display = 'none';
                fechaDesdeLabel.style.display = 'none';
                fechaHastaLabel.style.display = 'none';

            }

        } catch (err) {
            console.log("Ocurrio un error: " + err);
        }
    }

    function fntSearchPedidos() {
        let inputBusqueda = document.querySelector("#searchPedido").value;
        if (inputBusqueda == "") {
            getPedidos();
        } else {
            fntBuscarPedidos();
        }

    }
}

// Función para mostrar una página de la tabla buscador
function mostrarPaginaBuscador(pagina, datos, estadoFiltro) {
    const elementosPorPagina = 40;
    const inicio = (pagina - 1) * elementosPorPagina;
    const fin = inicio + elementosPorPagina;

    document.querySelector("#tblBodyPedidos").innerHTML = "";
    
    // Filtrar datos según el estado seleccionado
    const datosFiltrados = estadoFiltro && estadoFiltro !== 'Todo'
        ? datos.filter(item => item.estadoPedido === estadoFiltro)
        : datos;

    // Agrega filas a la tabla según la página actual
    for (let i = inicio; i < fin && i < datosFiltrados.length; i++) {
        const item = datosFiltrados[i];
        // Funciones de opciones y de botones de cambio de estado
        const cambiarEstadoPedido = (estadoActual, id) => {
            if (json.user == 'administrador') {
                switch (estadoActual) {
                    case "Creado":
                        return `<button class="btn btn-success btn-sm" title="Estado" onclick="fntCambiarCreado(` + id + `)"><i class="bi bi-check-circle"></i> Creado</button>`;
                    case "En Proceso":
                        return `<button class="btn btn-info btn-sm" title="Estado" onclick="fntCambiarEnProceso(` + id + `)"><i class="bi bi-play-circle"></i> En Proceso</button>`;
                    case "Finalizado":
                        return `<button class="btn btn-warning btn-sm" title="Estado" onclick="fntCambiarFinalizado(` + id + `)"><i class="bi bi-x-circle"></i> Finalizado</button>`;
                    default:
                        return `<button class="btn btn-danger btn-sm" title="Estado"><i class="bi bi-truck"></i> Entregado</button>`;
                }
            } else {
                switch (estadoActual) {
                    case "Borrador":
                        return `<button class="btn btn-secondary btn-sm" title="Estado"><i class="bi bi-pencil"></i> Borrador</button>`;
                    case "Creado":
                        return `<button class="btn btn-success btn-sm" title="Estado"><i class="bi bi-check-circle"></i> Creado</button>`;
                    case "En Proceso":
                        return `<button class="btn btn-info btn-sm" title="Estado"><i class="bi bi-play-circle"></i> En Proceso</button>`;
                    case "Finalizado":
                        return `<button class="btn btn-warning btn-sm" title="Estado"><i class="bi bi-x-circle"></i> Finalizado</button>`;
                    default:
                        return `<button class="btn btn-danger btn-sm" title="Estado"><i class="bi bi-truck"></i> Entregado</button>`;
                }
            }

        };


        const mostrarOpciones = (estadoActual, id) => {
            if (json.user == 'administrador') {
                switch (estadoActual) {
                    case "Borrador":
                        return `<a href="` + base_url + `/views/pedidos/nuevo-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                            <a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(` + id + `)"><i class="bi bi-trash"></i></button>`;
                    case "Creado":
                        return `<a href="` + base_url + `/views/pedidos/nuevo-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                            <a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(` + id + `)"><i class="bi bi-trash"></i></button>`;
                    case "En Proceso":
                        return `<a href="` + base_url + `/views/pedidos/nuevo-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                            <a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(` + id + `)"><i class="bi bi-trash"></i></button>
                            <a href="` + base_url + `/views/pedidos/print-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-info btn-sm" title="Imprimir pedido"><i class="bi bi-printer"></i></a>`;
                    case "Finalizado":
                        return `<a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(` + id + `)"><i class="bi bi-trash"></i></button>`;
                    default:
                        return `<a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(` + id + `)"><i class="bi bi-trash"></i></button>`;
                }
            } else {
                switch (estadoActual) {
                    case "Borrador":
                        return `<a href="` + base_url + `/views/pedidos/nuevo-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                            <a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(` + id + `)"><i class="bi bi-trash"></i></button>`;
                    case "Creado":
                        return `<a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>`;
                    case "En Proceso":
                        return `<a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>`;
                    case "Finalizado":
                        return `<a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>`;
                    default:
                        return `<a href="` + base_url + `/views/pedidos/ver-pedido.php?p=` + id + `"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>`;
                }
            }
        }
      // Formateo de fecha
    //   const fecha = new Date(item.fecha);
    //   const dia = fecha.getDate() + 1;
    //   const mes = fecha.getMonth() + 1; // se suma 1 ya que los meses comienzan desde 0
    //   const anio = fecha.getFullYear(); 
    //   const diaStr = (dia < 10) ? "0" + dia : dia.toString();
    //   const mesStr = (mes < 10) ? "0" + mes : mes.toString();
    //   const anioStr = (anio < 10) ? "0" + anio : anio.toString();
    //   const fechaFormateada = `${diaStr}-${mesStr}-${anioStr}`;
      const fechaFormateada = convertirFecha(item.fecha);

      // cinvertir a fdecimal el valor total
      let valorTotal = item.valorTotal;
      valorTotal = parseFloat(valorTotal);
      valorTotal = valorTotal.toFixed(2);

      // Separar la parte entera y la parte decimal
      let partes = valorTotal.split('.');
      let parteEntera = partes[0];
      let parteDecimal = partes[1];
      
      // Agregar puntos como separadores de miles
      parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      
      // Unir las partes con una coma como separador decimal
      valorTotal = parteEntera + ',' + parteDecimal;

      if(json.user == 'cliente'){ 
          if(json.nombreCliente == item.nombreCliente){
              let newtr = document.createElement("tr");
              newtr.id = "row_ " + item.idPedido;
              newtr.innerHTML = `<tr>
                              <th scope="row" style="display: none;">${item.idPedido}</th>
                              <td style="text-align: center;">${item.nombreCliente}</td>
                              <td style="text-align: center;">${item.idPedido}</td>
                              <td style="text-align: center;">${fechaFormateada}</td>
                              <td style="text-align: center;">$ ${valorTotal}</td>
                              <td style="text-align: center;">
                              ${cambiarEstadoPedido(item.estadoPedido, item.idPedido)}
                              </td>
                              <td style="text-align: center;">
                              ${mostrarOpciones(item.estadoPedido, item.idPedido)}
                              </td>`;
              document.querySelector("#tblBodyPedidos").appendChild(newtr);
          }  
      } else {
          if (item.estadoPedido !== 'Borrador') {
              let newtr = document.createElement("tr");
              newtr.id = "row_ " + item.idPedido;
              newtr.innerHTML = `<tr>
                              <th scope="row" style="display: none;">${item.idPedido}</th>
                              <td style="text-align: center;">${item.nombreCliente}</td>
                              <td style="text-align: center;">${item.idPedido}</td>
                              <td style="text-align: center;">${fechaFormateada}</td>
                              <td style="text-align: center;">$ ${valorTotal}</td>
                              <td style="text-align: center;">
                              ${cambiarEstadoPedido(item.estadoPedido, item.idPedido)}
                              </td>
                              <td style="text-align: center;">
                              ${mostrarOpciones(item.estadoPedido, item.idPedido)}
                              </td>`;
              document.querySelector("#tblBodyPedidos").appendChild(newtr);
          }
      }
      
    }
    
    mostrarPaginador(pagina, datosFiltrados.length);
}

///////// FUNCIONES DE CAMBIO DE ESTADO ///////////
// Cambiar Creado //
function fntCambiarCreado(id){
    swal({
        title: "Deseas cambiar el estado del pedido a En Proceso?",
        text: "Este cambio de estado enviara tu pedido a Produccion.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((cambiarEstado) => {
            if (cambiarEstado) {
                changeCreado(id);
                generarDebitoAutomatico(id);
            }
        });
}

// Cambiar En Proceso //
function fntCambiarEnProceso(id){
    swal({
        title: "Deseas cambiar el estado del pedido a Finalizado?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((cambiarEstado) => {
            if (cambiarEstado) {
                changeEnProceso(id);
                async function changeEnProceso(id){
                    let formData = new FormData();
                    formData.append('id', id);
                    try {
                        let resp = await fetch(base_url + "controllers/pedido.php?op=cambiarEnProceso", {
                            method: 'POST',
                            mode: 'cors',
                            cache: 'no-cache',
                            body: formData 
                        });
                        json = await resp.json();
                        if (json.status) {
                            swal("Modificar", json.msg, "success")
                                .then(() => {
                                    location.reload();
                                });
                        } else {
                            swal("Modificar", json.msg, "error");
                        }
                    } catch (err) {
                        console.log("Ocurrio un error" + err);
                    }
                }
            }
        });
}

// Cambiar Finalizado //
function fntCambiarFinalizado(id){
    swal({
        title: "Deseas cambiar el estado del pedido a Entregado?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((cambiarEstado) => {
            if (cambiarEstado) {
                changeFinalizado(id);
                async function changeFinalizado(id){
                    let formData = new FormData();
                    formData.append('id', id);
                    try {
                        let resp = await fetch(base_url + "controllers/pedido.php?op=cambiarFinalizado", {
                            method: 'POST',
                            mode: 'cors',
                            cache: 'no-cache',
                            body: formData 
                        });
                        json = await resp.json();
                        if (json.status) {
                            swal("Modificar", json.msg, "success")
                                .then(() => {
                                    location.reload();
                                });
                        } else {
                            swal("Modificar", json.msg, "error");
                        }
                    } catch (err) {
                        console.log("Ocurrio un error" + err);
                    }
                }
            }
        });
}

// Funcion de cambio de estado Creado

async function changeCreado(id){
    let formData = new FormData();
    formData.append('id', id);
    try {
        let resp = await fetch(base_url + "controllers/pedido.php?op=cambiarCreado", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData 
        });
        json = await resp.json();
        if (json.status) {
            swal("Modificar", json.msg, "success")
                .then(() => {
                    location.reload();
                });
        } else {
            swal("Modificar", json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

// GENERAR DEBITO AUTOMATICO EN CAMBIO DE ESTADO DEL  PEDIDO //

async function generarDebitoAutomatico(id){
    try {
        const data = new FormData();
        data.append('idPedido', id);
        let resp = await fetch(base_url + "controllers/comprobante.php?op=debitoPorId", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            console.log("Débito ok");
        } else {
            console.log("Débito error");
        }
    } catch (err) {
        console.log("Ocurrio un error: " + er);
    }
}

// ELIMINAR TODOS LOS BORRADORES DE CLIENTES
function eliminarBorradores(){
    swal({
        title: "Queres eliminar todos los Borradores?",
        text: "Se eliminaran los pedidos en estado 'Borrador' de todos tus clientes",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                eliminarBorrador();
            }
        });
}

async function eliminarBorrador(){
    try {
        let resp = await fetch(base_url + "controllers/pedido.php?op=eliminarBorrador", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache'
        });
        json = await resp.json();
        if (json.status) {
            swal("Eliminar", json.msg, "success");
        } else {
            swal("Eliminar", json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: " + er);
    }
}



