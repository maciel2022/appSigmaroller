// FUNCIONES VER TODOS LEGAJOS //

async function getLegajos() {
    document.querySelector("#tblBodyLegajos").innerHTML = "";
    try {
        let resp = await fetch(base_url + "controllers/legajo.php?op=listregistros");
        json = await resp.json();

        if (json.status) {
            let data = json.data;
        
            data.forEach(item => {
                if(item.estado == 1){
                    return;
                }

                if(item.saldo == null){
                    item.saldo = '0.00';
                }

                let valorTotal = item.saldo;
                // Separar la parte entera y la parte decimal
                let partes = valorTotal.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valorTotal = parteEntera + ',' + parteDecimal;

                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idCliente;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idCliente}</th>
                                    <td style="text-align: center;">${item.idCliente} - ${item.nombreCliente}</td>
                                    <td style="text-align: center;">${item.razonSocial}</td>
                                    <td style="text-align: center;"><a href="${base_url}/views/comprobantes/comprobantes.php?p=${item.idCliente}">$ ${valorTotal}</a></td>
                                    <td style="text-align: center;">${item.estadoActual}</td>
                                    <td style="text-align: center;">${item.options}</td>`;
                document.querySelector("#tblBodyLegajos").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

//Validacion de para utilizar getLegajos

if (document.querySelector("#tblBodyLegajos")) {
    getLegajos();
}

// FUNCIONES NUEVO LEGAJO //

if (document.querySelector("#frmNuevoLegajo")) {
    let frmNewLegajo = document.querySelector("#frmNuevoLegajo");
    frmNewLegajo.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardar();
    }

    async function fntGuardar() {

        try {
            const data = new FormData(frmNewLegajo);
            let resp = await fetch(base_url + "controllers/legajo.php?op=guardar", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status) {
                swal("Guardar", json.msg, "success")
                .then(() => {
                    window.location = base_url + 'views/legajos/ver-todos.php';
                });

                frmNewLegajo.reset();
            

            } else {
                swal("Guardar", json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: " + er);
        }
    }
}

// FUNCIONES MODIFICAR LEGAJO //
async function fntMostrar(id) {
    let formData = new FormData();
    formData.append('idCliente', id);
    try {
        let resp = await fetch(base_url + "controllers/legajo.php?op=verlegajo", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            console.log(json.data);
            document.querySelector("#txtId").value = json.data.idCliente;
            document.querySelector("#numCuil").value = json.data.cuit;
            document.querySelector("#txtNombre").value = json.data.nombreCliente;
            document.querySelector("#txtApellido").value = json.data.razonSocial;
            document.querySelector("#emailEmail").value = json.data.email;
            document.querySelector("#numTelefono").value = json.data.telefono;
            document.querySelector("#txtDomicilio").value = json.data.domicilio;
            document.querySelector("#txtLocalidad").value = json.data.domicilioEntrega;
            document.querySelector("#txtLocalidadEntrega").value = json.data.localidad;           
            document.querySelector("#selEstado").value = json.data.estadoActual;
            document.querySelector("#txtAreaObservaciones").value = json.data.notasFacturacion;
            document.querySelector("#txtUsuario").value = json.data.usuario;
            
        } else {
            window.location = base_url + 'views/legajos/ver-todos.php'
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }
}

if (document.querySelector("#frmModificar")) {
    let frmModificar = document.querySelector("#frmModificar");
    frmModificar.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntModificar();
    }

    async function fntModificar() {
        try {
            const data = new FormData(frmModificar);
            let resp = await fetch(base_url + "controllers/legajo.php?op=modificar", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status) {
                swal("Modificar", json.msg, "success")
                    .then(() => {
                        window.location = base_url + 'views/legajos/ver-todos.php';
                    })

            } else {
                swal("Modificar", json.msg, "error");
            }


        } catch (err) {
            console.log("Ocurrio un error: " + err);
        }
    }
}

function fntEliminarCliente(id) {

    swal({
        title: "Quieres eliminar el Cliente?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                fntDelete(id);
            }
        });

}

async function fntDelete(id) {
    try {
        let formData = new FormData();
        formData.append('idCliente', id);
        let resp = await fetch(base_url + "controllers/legajo.php?op=eliminar", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            swal("Eliminar Cliente", json.msg, "success")
                .then(() => {
                    window.location = base_url + 'views/legajos/ver-todos.php';
                });
        } else {
            swal("Eliminar Cliente", json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }
}


// FUNCIONES CANCELAR //

function fntCancelarNuevoLeg() {
    window.location = base_url + 'views/legajos/ver-todos.php';
}


function fntCancelarModificarLeg() {
    window.location = base_url + 'views/legajos/ver-todos.php';
}

async function obtenerValor(){
    let selCategoriaAgrupamiento = document.querySelector("#selCategoriaAgrupamiento");
    selCategoriaAgrupamiento = selCategoriaAgrupamiento.value;
    try {
        let formData = new FormData();
        formData.append('nombreAgrupamiento', selCategoriaAgrupamiento);
        let resp = await fetch(base_url + "controllers/legajo.php?op=obtenerFranco", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        
        json = await resp.json();
        if (json.status) {
            document.querySelector("#selDiaFranco").value = json.data.francoPredeterminado;
        } else {
            swal("Error", json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }
}

async function fntVerLegajo(id) {
    let formData = new FormData();
    formData.append('idCliente', id);
    try {
        let resp = await fetch(base_url + "controllers/legajo.php?op=verlegajo", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            let cuil = document.querySelector("#numVerCuil");
            cuil.textContent = json.data.cuit;
            let nombre = document.querySelector("#txtVerNombre");
            nombre.textContent = json.data.nombreCliente;
            let apellido = document.querySelector("#txtVerApellido");
            apellido.textContent = json.data.razonSocial;
            let email = document.querySelector("#txtVerEmail");
            email.textContent = json.data.email;
            let numTelefono = document.querySelector("#numVerNumTelefono");
            numTelefono.textContent = json.data.telefono;
            let domicilio = document.querySelector("#txtVerDomicilio");
            domicilio.textContent = json.data.domicilio;
            let localidad = document.querySelector("#txtVerLocalidad");
            localidad.textContent = json.data.domicilioEntrega;
            let localidadEntrega = document.querySelector("#txtVerLocalidadEntrega");
            localidadEntrega.textContent = json.data.localidad;
            let estado = document.querySelector("#txtVerEstado");
            estado.textContent = json.data.estadoActual; 
            let observaciones = document.querySelector("#txtVerObservaciones");
            observaciones.textContent = json.data.notasFacturacion;        
           
        } 
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }
}

//////////FUNCIONES DE BUSCADOR//////////////
if(document.querySelector("#frmBuscador")){
    let frmBuscador = document.querySelector("#frmBuscador");
    frmBuscador.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina

        let buscador = document.querySelector("#txtBuscador").value;
        if(buscador == ""){
            getLegajos();
        }else{
            fntBuscarClientes();
        }
    }
   
    let textoBuscador = document.querySelector("#txtBuscador");
    textoBuscador.addEventListener("keyup",fntTextoBuscador,true);

    async function fntBuscarClientes(){
        document.querySelector("#tblBodyLegajos").innerHTML = "";
        try {
           
            let formData = new FormData(frmBuscador);
            let resp = await fetch(base_url+"controllers/legajo.php?op=buscador", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });

            const cambiarEstado = (estadoActual) => {
                switch (estadoActual) {
                  case "Al Dia":
                    return `<button class="btn btn-success btn-sm" title="Estado" onclick="fntCambioEstado()"><i class="bi bi-check-circle"></i> Al Día</button>`;
                  case "Suspendido":
                    return `<button class="btn btn-danger btn-sm" title="Estado" onclick="fntCambioEstado()"><i class="bi bi-x-circle"></i> Suspendido</button>`;
                  default:
                    return `<button class="btn btn-warning btn-sm" title="Estado" onclick="fntCambioEstado()"><i class="bi bi-x-circle"></i> Moroso</button>`;
                }
            };

            json = await resp.json();
            if (json.status){
                let data = json.data;
                data.forEach(item => {
                    if(item.estado == 1){
                        return;
                    }
    
                    if(item.saldo == null){
                        item.saldo = '0.00';
                    }
    
                    let valorTotal = item.saldo;
                    // Separar la parte entera y la parte decimal
                    let partes = valorTotal.split('.');
                    let parteEntera = partes[0];
                    let parteDecimal = partes[1];
                    // Agregar puntos como separadores de miles
                    parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    // Unir las partes con una coma como separador decimal
                    valorTotal = parteEntera + ',' + parteDecimal;

                    let newtr = document.createElement("tr");
                    newtr.id = "row_ " + item.idCliente;
                    newtr.innerHTML = `<tr>
                                        <th scope="row" style="display: none;">${item.idCliente}</th>
                                        <td style="text-align: center;">${item.idCliente} - ${item.nombreCliente}</td>
                                        <td style="text-align: center;">${item.razonSocial}</td>
                                        <td style="text-align: center;"><a href="${base_url}/views/comprobantes/comprobantes.php?p=${item.idCliente}">$ ${valorTotal}</a></td>
                                        <td style="text-align: center;">${cambiarEstado(item.estadoActual)}</td>
                                        <td style="text-align: center;">
                                            <a href="${base_url}/views/legajos/modificar.php?p=${item.idCliente}"  class="btn me-1 btn-outline-primary btn-sm" title="Modificar Cliente"><i class="bi bi-pencil-square"></i></a>
                                            <a href="${base_url}/views/legajos/ver-legajo.php?p=${item.idCliente}"  class="btn me-1 btn-outline-warning btn-sm" title="Ver Cliente"><i class="bi bi-eye"></i></a>
                                            <button class="btn  btn-outline-danger btn-sm " title="Eliminar Cliente" onclick="fntEliminarCliente(${item.idCliente})" ><i class="bi bi-trash"></i></button>
                                        </td>`;
                    document.querySelector("#tblBodyLegajos").appendChild(newtr);
                });
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }

    function fntTextoBuscador(){
        let inputBusqueda = document.querySelector("#txtBuscador").value;
        if(inputBusqueda == ""){
            getLegajos();
        }else{
            fntBuscarClientes();
        }
    
     }
}
 
