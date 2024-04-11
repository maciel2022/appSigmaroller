//////////////// Mecanismo Banda Vertical ///////////////////

// FUNCIONES VER TODAS LAS CONFIGURACIONES Mecanismo Banda Vertical //
async function getMecanismoBV() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listMecanismoBV");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let valor = item.precioBV;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;
                
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idMecanismoBandaVertical;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idMecanismoBandaVertical}</th>
                                    <td class="text-center">${item.nomMecBanVer}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="text-center">${item.estado}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyMecanismoBV").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getMecanismoBV
if (document.querySelector("#tblBodyMecanismoBV")) {
    getMecanismoBV();
}

// FUNCIONES NUEVO MECANISMO //
if(document.querySelector("#frmNuevoMecanismoBV")){
    let frmNewMecanismoBV = document.querySelector("#frmNuevoMecanismoBV");
    frmNewMecanismoBV.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarMecanismoBV();
    } 

    async function fntGuardarMecanismoBV(){
       
        try {
            const data =  new FormData(frmNewMecanismoBV);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarMecanismoBV", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewMecanismoBV.reset();
                    window.location = base_url+'views/productos/configuracion-cbv.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR MECANMISMO//
function fntVerModificarMecanismoBV(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarMecanismoBV'));
    modal.show();
    fntMostrarMecanismoBV(id);

    async function fntMostrarMecanismoBV(id){
        let formData = new FormData();
        formData.append('idMecanismoBandaVertical', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verMecanismoBV", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#modalIdMecanismoBandaVertical").value = json.data.idMecanismoBandaVertical;
                document.querySelector("#txtModalNombreMecanismoBV").value = json.data.nomMecBanVer; 
                document.querySelector("#selEstadoMoMe").value = json.data.estado; 
                document.querySelector("#modalNumPrecioMBV").value = json.data.precioBV;
            }else{
                window.location = base_url+'views/productos/configuracion-cbv.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarMecanismoBV")){
    let frmModificarMecanismoBV = document.querySelector("#frmModificarMecanismoBV");
    frmModificarMecanismoBV.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarMecanismoBV();
    } 

    async function fntModificarMecanismoBV(){
        
        let intId = document.querySelector("#modalIdMecanismoBandaVertical").value;  
        let strNombreMecanismoBV = document.querySelector("#txtModalNombreMecanismoBV").value;
        let strEstado = document.querySelector("#selEstadoMoMe").value;
        let intPrecioBV = document.querySelector("#modalNumPrecioMBV").value;
       

        if(intId == ""  || strNombreMecanismoBV == "" || intPrecioBV == "" || strEstado == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarMecanismoBV);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarMecanismoBV", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cbv.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}
// async function fntDelMec(id){
//     try {
//         let formData = new FormData();
//         formData.append('idMecanismoBandaVertical', id);
//         let resp = await fetch(base_url+"controllers/configuracion.php?op=delMecBV", {
//             method: 'POST',
//             mode: 'cors',
//             cache: 'no-cache',
//             body: formData
//         });
//         json = await resp.json();
//         if (json.status){
//             swal("Eliminar",json.msg, "success")
//             .then(()=>{
//                 window.location = base_url+'views/productos/configuracion-cbv.php';
//             });
//         }else{
//             swal("Eliminar",json.msg, "error");
//         }
//     } catch (err) {
//         console.log("Ocurrio un error: "+err);
//     }
// }
// //////////////// MECANISMO BANDA VERTICAL FIN ///////////////////

// FUNCIONES VER TODAS LAS CONFIGURACIONES Motor Banda Vertical //
async function getMotorMBV() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listMotorMBV");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let valor = item.precioMBV;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;
                
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idMotorBandaVertical;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idMotorBandaVertical}</th>
                                    <td class="text-center">${item.nombreMotorBV}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="text-center">${item.estado}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyMotorBV").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getMecanismoBV
if (document.querySelector("#tblBodyMotorBV")) {
    getMotorMBV();
}


// FUNCIONES NUEVO MOTOR //
if(document.querySelector("#frmNuevoMotorBV")){
    let frmNewMotorBV = document.querySelector("#frmNuevoMotorBV");
    frmNewMotorBV.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarMotorBV();
    } 

    async function fntGuardarMotorBV(){
       
        try {
            const data =  new FormData(frmNewMotorBV);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarMotorBV", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewMotorBV.reset();
                    window.location = base_url+'views/productos/configuracion-cbv.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR MOTOR //
function fntVerModificarMotorBV(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarMotorBV'));
    modal.show();
    fntMostrarMotor(id);

    async function fntMostrarMotor(id){
        let formData = new FormData();
        formData.append('idMotorBandaVertical', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verMotorBV", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#modalIdMotorBandaVertical").value = json.data.idMotorBandaVertical;
                document.querySelector("#txtModalNombreMotorBV").value = json.data.nombreMotorBV; 
                document.querySelector("#numModalPrecioMotorBV").value = json.data.precioMBV;
                document.querySelector("#selEstadoMo").value = json.data.estado;
            }else{
                window.location = base_url+'views/productos/configuracion-cbv.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarMotorBV")){
    let frmModificarMotorBV = document.querySelector("#frmModificarMotorBV");
    frmModificarMotorBV.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarMotorBV();
    } 

    async function fntModificarMotorBV(){
        
        let intId = document.querySelector("#modalIdMotorBandaVertical").value;  
        let strNombreMotorBV = document.querySelector("#txtModalNombreMotorBV").value;
        let intPrecioMBV = document.querySelector("#numModalPrecioMotorBV").value;
        let strEstado = document.querySelector("#selEstadoMoMo").value;
       

        if(intId == ""  || strNombreMotorBV == "" || intPrecioMBV == "" || strEstado == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarMotorBV);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarMotorBV", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cbv.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}
// async function fntDelMot(id){
//     try {
//         let formData = new FormData();
//         formData.append('idMotorBandaVertical', id);
//         let resp = await fetch(base_url+"controllers/configuracion.php?op=delMotBV", {
//             method: 'POST',
//             mode: 'cors',
//             cache: 'no-cache',
//             body: formData
//         });
//         json = await resp.json();
//         if (json.status){
//             swal("Eliminar",json.msg, "success")
//             .then(()=>{
//                 window.location = base_url+'views/productos/configuracion-cbv.php';
//             });
//         }else{
//             swal("Eliminar",json.msg, "error");
//         }
//     } catch (err) {
//         console.log("Ocurrio un error: "+err);
//     }
// }
//////////////// Motor Banda Vertical  FIN ///////////////////

// //////////////// APERTURA BANDA VERTICAL ///////////////////

// FUNCIONES VER TODAS LAS CONFIGURACIONES Apertura Banda Vertical //
async function getApertura() {
    try {
        let resp = await fetch(base_url + "controllers/configuracion.php?op=listApertura");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let valor = item.precioA;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;
                
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idApertura;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idApertura}</th>
                                    <td class="text-center">${item.tipoApertura}</td>
                                    <td class="text-center">$ ${valor}</td>
                                    <td class="text-center">${item.estado}</td>
                                    <td class="d-flex justify-content-center">${item.options}</td>`;
                document.querySelector("#tblBodyA").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getApertura
if (document.querySelector("#tblBodyA")) {
    getApertura();
}

// FUNCIONES NUEVA APERTURA //
if(document.querySelector("#frmNuevaA")){
    let frmNuevaA = document.querySelector("#frmNuevaA");
    frmNuevaA.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarApertura();
    } 

    async function fntGuardarApertura(){
       
        try {
            const data =  new FormData(frmNuevaA);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=guardarApertura", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNuevaA.reset();
                    window.location = base_url+'views/productos/configuracion-cbv.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

 /////FUNCIONES MODIFICAR APERTURA //
function fntVerModificarApertura(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarA'));
    modal.show();
    fntMostrarApertura(id);

    async function fntMostrarApertura(id){
        let formData = new FormData();
        formData.append('idApertura', id);
        try{
            let resp = await fetch(base_url+"controllers/configuracion.php?op=verApertura", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdA").value = json.data.idApertura;
                document.querySelector("#txtModalNombreA").value = json.data.tipoApertura; 
                document.querySelector("#txtModalPrecioA").value = json.data.precioA;
                document.querySelector("#selEstadoAp").value = json.data.estado;
            }else{
                window.location = base_url+'views/productos/configuracion-cbv.php';
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarA")){
    let frmModificarA = document.querySelector("#frmModificarA");
    frmModificarA.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarApertura();
    } 

    async function fntModificarApertura(){
        try {
            const data =  new FormData(frmModificarA);
            let resp = await fetch(base_url+"controllers/configuracion.php?op=modificarApertura", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/productos/configuracion-cbv.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// async function fntDelApertura(id){
//     try {
//         let formData = new FormData();
//         formData.append('idApertura', id);
//         let resp = await fetch(base_url+"controllers/configuracion.php?op=delApertura", {
//             method: 'POST',
//             mode: 'cors',
//             cache: 'no-cache',
//             body: formData
//         });
//         json = await resp.json();
//         if (json.status){
//             swal("Eliminar",json.msg, "success")
//             .then(()=>{
//                 window.location = base_url+'views/productos/configuracion-cbv.php';
//             });
//         }else{
//             swal("Eliminar",json.msg, "error");
//         }
//     } catch (err) {
//         console.log("Ocurrio un error: "+err);
//     }
// }
