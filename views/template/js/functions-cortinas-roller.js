//////////////// CORTINAS ROLLER  ///////////////////

// FUNCIONES VER TODAS LAS CONFIGURACIONES CORTINAS ROLLER //
async function getMecR() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listMecR");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let valor = item.precioMR;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;

                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idMecanismoRoller;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idMecanismoRoller}</th>
                                    <td class="text-center">${item.tipoMecanismoRollr}</td>
                                    <td class="text-center">${item.largo}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="text-center">${item.estado}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyMecR").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getMecanismoBV
if (document.querySelector("#tblBodyMecR")) {
    getMecR();
}

// FUNCIONES NUEVO MECANISMO ROLLER//
if(document.querySelector("#frmNuevoMecR")){
    let frmNuevoMecR = document.querySelector("#frmNuevoMecR");
    frmNuevoMecR.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarMecR();
    } 

    async function fntGuardarMecR(){
       
        try {
            const data =  new FormData(frmNuevoMecR);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarMecR", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNuevoMecR.reset();
                    window.location = base_url+'views/productos/configuracion-cr.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR MECANISMO ROLLER //
function fntVerModificarMecR(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarMecR'));
    modal.show();
    fntMostrarMecR(id);

    async function fntMostrarMecR(id){
        let formData = new FormData();
        formData.append('idMecanismoRoller', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verMecR", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdMecR").value = json.data.idMecanismoRoller;
                document.querySelector("#txtModalNombreMecR").value = json.data.tipoMecanismoRollr; 
                document.querySelector("#numModalLarMecR").value = json.data.largo;
                document.querySelector("#txtModalPrecioMecR").value = json.data.precioMR;
                document.querySelector("#selEstadoMeMo").value = json.data.estado;
            }else{
                window.location = base_url+'views/productos/configuracion-cr.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarMecR")){
    let frmModificarMecR = document.querySelector("#frmModificarMecR");
    frmModificarMecR.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarMecR();
    } 

    async function fntModificarMecR(){
      
        try {
            const data =  new FormData(frmModificarMecR);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarMecR", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cr.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// async function fntDelMecCR(id){
//     try {
//         let formData = new FormData();
//         formData.append('idMecanismoRoller', id);
//         let resp = await fetch(base_url+"controllers/configuracion.php?op=delMecCR", {
//             method: 'POST',
//             mode: 'cors',
//             cache: 'no-cache',
//             body: formData
//         });
//         json = await resp.json();
//         if (json.status){
//             swal("Eliminar",json.msg, "success")
//             .then(()=>{
//                 window.location = base_url+'views/productos/configuracion-cr.php';
//             });
//         }else{
//             swal("Eliminar",json.msg, "error");
//         }
//     } catch (err) {
//         console.log("Ocurrio un error: "+err);
//     }
// }

// //////////////// MECANISMO ROLLER FIN ///////////////////


// //////////////// MOTOR ROLLER ///////////////////

async function getMotR() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listMotR");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let valor = item.precioMCR;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;
                
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idMotorCR;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idMotorCR}</th>
                                    <td class="text-center">${item.tipoMotorCR}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="text-center">${item.estado}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyMotR").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getMecanismoBV
if (document.querySelector("#tblBodyMotR")) {
    getMotR();
}

 //////FUNCIONES NUEVO MECANISMO ROLLER//
if(document.querySelector("#frmNuevoMotR")){
    let frmNuevoMotR = document.querySelector("#frmNuevoMotR");
    frmNuevoMotR.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarMotR();
    } 

    async function fntGuardarMotR(){
       
        try {
            const data =  new FormData(frmNuevoMotR);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarMotR", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNuevoMotR.reset();
                    window.location = base_url+'views/productos/configuracion-cr.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

function fntVerModificarMotR(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModMotR'));
    modal.show();
    fntMostrarMotR(id);

    async function fntMostrarMotR(id){
        let formData = new FormData();
        formData.append('idMotorCR', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verMotR", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdMotR").value = json.data.idMotorCR;
                document.querySelector("#txtModalNombMotR").value = json.data.tipoMotorCR;
                document.querySelector("#numModalMotR").value = json.data.precioMCR;
                document.querySelector("#selEstadoMoMe").value = json.data.estado;
            }else{
                window.location = base_url+'views/productos/configuracion-cr.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModMotR")){
    let frmModMotR = document.querySelector("#frmModMotR");
    frmModMotR.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarMotR();
    } 

    async function fntModificarMotR(){
      
        try {
            const data =  new FormData(frmModMotR);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarMotR", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cr.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}
async function fntDelMotCR(id){
    try {
        let formData = new FormData();
        formData.append('idMotorCR', id);
        let resp = await fetch(base_url+"controllers/configuracion.php?op=delMotCR", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/productos/configuracion-cr.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}

// //////////////// MOTOR ROLLER FIN ///////////////////


// //////////////// ZOCALO ROLLER  ///////////////////

// async function getZ() {
//     try {
//         let resp = await fetch(base_url + "controllers/configuracion.php?op=listZ");
//         json = await resp.json();
//         if (json.status) {
//             let data = json.data;
//             data.forEach(item => {
//                 let newtr = document.createElement("tr");
//                 newtr.id = "row_ " + item.idZocalo;
//                 newtr.innerHTML = `<tr>
//                                     <th scope="row" style="display: none;">${item.idZocalo}</th>
//                                     <td>${item.tipoZocalo}</td>
//                                     <td>${item.precioZ}</td>
//                                     <td>${item.options}</td>`;
//                 document.querySelector("#tblBodyZ").appendChild(newtr);
//             });

//         }
//     } catch (err) {
//         console.log("Ocurrio un error" + err);
//     }
// }
// //Validacion de para utilizar getMecanismoBV
// if (document.querySelector("#tblBodyZ")) {
//     getZ();
// }

// //////FUNCIONES NUEVO ZOCALO ROLLER//
// if(document.querySelector("#frmNuevoZ")){
//     let frmNuevoZ = document.querySelector("#frmNuevoZ");
//     frmNuevoZ.onsubmit = function(e){
//         e.preventDefault(); // para que no se recargue la pagina
//         fntGuardarZ();
//     } 

//     async function fntGuardarZ(){
       
//         try {
//             const data =  new FormData(frmNuevoZ);
//             let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarZ", {
//                 method: 'POST',
//                 mode: 'cors',
//                 cache: 'no-cache',
//                 body: data
//             });
//             json = await resp.json();
//             if (json.status){
//                 swal("Guardar",json.msg, "success")
//                 .then(()=>{
//                     frmNuevoZ.reset();
//                     window.location = base_url+'views/productos/configuracion-cr.php';
//                 });
//             }else{
//                 swal("Guardar",json.msg, "error");
//             }

//         } catch (err) {
//             console.log("Ocurrio un error: "+er);
//         }
//     }
// }

// //////FUNCIONES MODIFICAR MECANISMO ROLLER //
// function fntVerModificarZ(id){
//     let modal = new bootstrap.Modal(document.getElementById('modalModificarZ'));
//     modal.show();
//     fntMostrarZ(id);

//     async function fntMostrarZ(id){
//         let formData = new FormData();
//         formData.append('idZocalo', id);
//         try{
//             let resp = await fetch(base_url+"controllers/configuracion.php?op=verZ", {
//                 method: 'POST',
//                 mode: 'cors',
//                 cache: 'no-cache',
//                 body: formData
//             });
//             json = await resp.json();
//             if(json.status){
//                 document.querySelector("#txtModalIdZ").value = json.data.idZocalo;
//                 document.querySelector("#txtModalNombreZ").value = json.data.tipoZocalo;
//                 document.querySelector("#txtModalPrecioZ").value = json.data.precioZ;
//             }else{
//                 window.location = base_url+'views/productos/configuracion-cr.php';
//             }
//         }catch (err) {
//             console.log("Ocurrio un error: "+err);
//         }
//     }
// }
// if(document.querySelector("#frmModificarZ")){
//     let frmModificarZ = document.querySelector("#frmModificarZ");
//     frmModificarZ.onsubmit = function(e){
//         e.preventDefault(); // para que no se recargue la pagina
//         fntModificarZoc();
//     } 

//     async function fntModificarZoc(){
      
//         try {
//             const data =  new FormData(frmModificarZ);
//             let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarZ", {
//                 method: 'POST',
//                 mode: 'cors',
//                 cache: 'no-cache',
//                 body: data
//             });
//             json = await resp.json();
//             if (json.status){
//                 swal("Modificar",json.msg, "success")
//                 .then(()=>{
//                         window.location = base_url+'views/productos/configuracion-cr.php';
//                 })

//             }else{
//                 swal("Modificar",json.msg, "error");
//             }

//         } catch (err) {
//             console.log("Ocurrio un error: "+err);
//         }
//     }
// }


// // //////////////// ZOCALO ROLLER FIN ///////////////////


// //////////////// SOPORTE ROLLER FIN ///////////////////


async function getS() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listS");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let valor = item.precioSCR;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;
                
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idSoporte;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idSoporte}</th>
                                    <td class="text-center">${item.tipoSoporte}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="text-center">${item.estado}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyS").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getMecanismoBV
if (document.querySelector("#tblBodyS")) {
    getS();
}
//////FUNCIONES NUEVO SOPORTE ROLLER//
if(document.querySelector("#frmNuevoS")){
    let frmNuevoS = document.querySelector("#frmNuevoS");
    frmNuevoS.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarS();
    } 

    async function fntGuardarS(){
       
        try {
            const data =  new FormData(frmNuevoS);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarS", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNuevoS.reset();
                    window.location = base_url+'views/productos/configuracion-cr.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

//////FUNCIONES MODIFICAR soporte ROLLER //
function fntVerModificarS(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModS'));
    modal.show();
    fntMostrarS(id);

    async function fntMostrarS(id){
        let formData = new FormData();
        formData.append('idSoporte', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verS", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdS").value = json.data.idSoporte;
                document.querySelector("#txtModalNombS").value = json.data.tipoSoporte;
                document.querySelector("#numModalS").value = json.data.precioSCR;
                document.querySelector("#selEstadoMoS").value = json.data.estado;
            }else{
                window.location = base_url+'views/productos/configuracion-cr.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}
if(document.querySelector("#frmModS")){
    let frmModS = document.querySelector("#frmModS");
    frmModS.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarZoc();
    } 

    async function fntModificarZoc(){
      
        try {
            const data =  new FormData(frmModS);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarS", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cr.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// async function fntDelSoporte(id){
//     try {
//         let formData = new FormData();
//         formData.append('idSoporte', id);
//         let resp = await fetch(base_url+"controllers/configuracion.php?op=delSoporte", {
//             method: 'POST',
//             mode: 'cors',
//             cache: 'no-cache',
//             body: formData
//         });
//         json = await resp.json();
//         if (json.status){
//             swal("Eliminar",json.msg, "success")
//             .then(()=>{
//                 window.location = base_url+'views/productos/configuracion-cr.php';
//             });
//         }else{
//             swal("Eliminar",json.msg, "error");
//         }
//     } catch (err) {
//         console.log("Ocurrio un error: "+err);
//     }
// }
async function getExtras() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listExtras");
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
                newtr.id = "row_ " + item.idExtras;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idExtras}</th>
                                    <td class="text-center">${item.tipo}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyExtras").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getMecanismoBV
if (document.querySelector("#tblBodyExtras")) {
    getExtras();
}

// FUNCIONES MODIFICAR EXTRAS//
function fntVerModificarExtra(id){
    let modal = new bootstrap.Modal(document.getElementById('modalExtras'));
    modal.show();
    fntMostrarExtra(id);

    async function fntMostrarExtra(id){
        let formData = new FormData();
        formData.append('idExtras', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verExtra", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                console.log(json.data);
                document.querySelector("#txtModIdE").value = json.data.idExtras;
                document.querySelector("#numModalExtra").value = json.data.precio;
               
            }else{
                window.location = base_url+'views/productos/configuracion-cr.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmExtras")){
    let frmExtras= document.querySelector("#frmExtras");
    frmExtras.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarExtras();
    } 

    async function fntModificarExtras(){
      
        try {
            const data =  new FormData(frmExtras);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modPrecio", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cr.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}