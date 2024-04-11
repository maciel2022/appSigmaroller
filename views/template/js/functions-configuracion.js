//////////////// TELAS ///////////////////

// FUNCIONES VER TODAS LAS CONFIGURACIONES TELAS //
async function getTelas() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listTelas");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let valor = item.precio;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;

                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idTela;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idTela}</th>
                                    <td class="text-center">${item.nombre}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="text-center">${item.estado}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyTela").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getTelas
if (document.querySelector("#tblBodyTela")) {
    getTelas();
}

// FUNCIONES NUEVA TELA //
if(document.querySelector("#frmNuevaTela")){
    let frmNewTela = document.querySelector("#frmNuevaTela");
    frmNewTela.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarTela();
    } 

    async function fntGuardarTela(){
       
        try {
            const data =  new FormData(frmNewTela);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarTela", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewTela.reset();
                    window.location = base_url+'views/productos/configuracion-cortinas.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR TELA //
function fntVerModificarTela(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarTelas'));
    modal.show();
    fntMostrarTelas(id);

    async function fntMostrarTelas(id){
        let formData = new FormData();
        formData.append('idTela', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verTela", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#intModalIdTelas").value = json.data.idTela;
                document.querySelector("#txtModalModificarNombre").value = json.data.nombre; 
                document.querySelector("#numModificarPrecio").value = json.data.precio; 
                document.querySelector("#selModificarEstado").value = json.data.estado; 
            }else{
                window.location = base_url+'views/productos/configuracion-cortinas.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarTelas")){
    let frmModificarTelas = document.querySelector("#frmModificarTelas");
    frmModificarTelas.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarTela();
    } 

    async function fntModificarTela(){
        
        let intId = document.querySelector("#intModalIdTelas").value;  
        let strNombreTela = document.querySelector("#txtModalModificarNombre").value;
        let intPrecio = document.querySelector("#numModificarPrecio").value;
        let intActivo = document.querySelector("#selModificarEstado").value;
       

        if(intId == ""  || strNombreTela == "" || intPrecio == "" || intActivo == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarTelas);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarTelas", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cortinas.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}


async function fntDelTela(id){
    try {
        let formData = new FormData();
        formData.append('idTela', id);
        let resp = await fetch(base_url+"controllers/configuracion.php?op=delTela", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/productos/configuracion-cortinas.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}

//////////////// TELAS FIN ///////////////////

//////////////// COLORES ///////////////////

// FUNCIONES VER TODAS LAS CONFIGURACIONES COLORES //
async function getColores() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listColores");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idColor;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idColor}</th>
                                    <td class="text-center">${item.nombreColor}</td>
                                    <td class="text-center">${item.nombre}</td>
                                    <td class="text-center">${item.activo}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyColor").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getTelas
if (document.querySelector("#tblBodyColor")) {
    getColores();
}

// FUNCIONES NUEVO COLOR //
if(document.querySelector("#frmNuevoColor")){
    let frmNewColor = document.querySelector("#frmNuevoColor");
    frmNewColor.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarColor();
    } 

    async function fntGuardarColor(){
       
        try {
            const data =  new FormData(frmNewColor);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarColor", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewColor.reset();
                    window.location = base_url+'views/productos/configuracion-cortinas.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR COLOR //
function fntVerModificarColor(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarColor'));
    modal.show();
    fntMostrarColor(id);

    async function fntMostrarColor(id){
        let formData = new FormData();
        formData.append('idColor', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verColor", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#intModalIdColor").value = json.data.idColor;
                document.querySelector("#txtModalModificarColorNombre").value = json.data.nombreColor; 
                document.querySelector("#selModTelaColor").value = json.data.idTela; 
                document.querySelector("#selModificarColorEstado").value = json.data.activo; 
            }else{
                window.location = base_url+'views/productos/configuracion-cortinas.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarColor")){
    let frmModificarColor = document.querySelector("#frmModificarColor");
    frmModificarColor.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarColor();
    } 

    async function fntModificarColor(){
    
        try {
            const data =  new FormData(frmModificarColor);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarColor", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cortinas.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

async function fntDelColor(id){
    try {
        let formData = new FormData();
        formData.append('idColor', id);
        let resp = await fetch(base_url+"controllers/configuracion.php?op=delColor", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/productos/configuracion-cortinas.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}

//////////////// COLORES FIN ///////////////////

///// FUNCIONES PARA MAXIMIZAR-MINIMIZAR /////
// Función para minimizar/maximizar la tabla
function toggleTableTela() {
    var tblBody = document.getElementById('tblBodyTela');

    // Verifica si la tabla está actualmente minimizada
    var isMinimized = tblBody.style.display === 'none';

    // Cambia el estilo de la tabla para mostrarla/ocultarla
    tblBody.style.display = isMinimized ? 'table-row-group' : 'none';
}

function toggleTableColor() {
    var tblBody = document.getElementById('tblBodyColor');

    // Verifica si la tabla está actualmente minimizada
    var isMinimized = tblBody.style.display === 'none';

    // Cambia el estilo de la tabla para mostrarla/ocultarla
    tblBody.style.display = isMinimized ? 'table-row-group' : 'none';
}