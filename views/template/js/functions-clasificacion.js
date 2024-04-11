//////////////// AGRUPAMIENTOS ///////////////////
// FUNCIONES VER TODOS AGRUPAMIENTOS //
async function getAgrupamientos() {
    try {
        let resp = await fetch(base_url + "controllers/clasificacion.php?op=listaAgrupamientos");
        json = await resp.json();

        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idAgrupamientos;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idAgrupamientos}</th>
                                    <td>${item.nombreAgrupamiento}</td>
                                    <td>${item.francoPredeterminado}</td>
                                    <td>${item.options}</td>`;
                document.querySelector("#tblBodyAgrupamientos").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getLegajos
if (document.querySelector("#tblBodyAgrupamientos")) {
    getAgrupamientos();
}

// FUNCIONES NUEVO AGRUPAMIENTO //
if(document.querySelector("#frmNuevoAgrupamiento")){
    let frmNewAgrupamiento = document.querySelector("#frmNuevoAgrupamiento");
    frmNewAgrupamiento.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarAgrupamiento();
    } 

    async function fntGuardarAgrupamiento(){
        let strNombre = document.querySelector("#txtNombre").value;
        let strDiaFranco = document.querySelector("#txtDiaFranco").value;
        if(strNombre == "" || strDiaFranco == ""){
            alert("Todos los campos son obligatorios");
            return;
        }
        try {
            const data =  new FormData(frmNewAgrupamiento);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=guardarAgrupamiento", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewAgrupamiento.reset();
                    window.location = base_url+'views/legajos/clasificacion.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR AGRUPAMIENTO //
function fntVerModificarAgrupamiento(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarAgrupamientos'));
    modal.show();
    fntMostrarAgrupamiento(id);

    async function fntMostrarAgrupamiento(id){
        let formData = new FormData();
        formData.append('idAgrupamientos', id);
        try{
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=verAgrupamiento", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdAgrupamiento").value = json.data.idAgrupamientos;
                document.querySelector("#txtModalNombreAgrupamiento").value = json.data.nombreAgrupamiento; 
                document.querySelector("#txtModalDiaFranco").value = json.data.francoPredeterminado; 
            }else{
                window.location = base_url+'views/legajos/clasificacion.php'
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarAgrupamiento")){
    let frmModificarAgrupamiento = document.querySelector("#frmModificarAgrupamiento");
    frmModificarAgrupamiento.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarAgrupamiento();
    } 

    async function fntModificarAgrupamiento(){
        
        let intId = document.querySelector("#txtModalIdAgrupamiento").value;;  
        let strNombreAgrupamiento = document.querySelector("#txtModalNombreAgrupamiento").value;
        let strDiaFranco = document.querySelector("#txtModalDiaFranco").value;
        
        if(intId == ""  || strNombreAgrupamiento == "" || strDiaFranco == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarAgrupamiento);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=modificarAgrupamiento", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/legajos/clasificacion.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// FUNCIONES ELIMINAR AGRUPAMIENTO //
function fntEliminarAgrupamiento(id){

    swal({
        title: "Quieres eliminar el Agrupamiento?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          fntDeleteAgrupamiento(id);
          }
      });

}

async function fntDeleteAgrupamiento(id){
    try {
        let formData = new FormData();
        formData.append('idAgrupamiento', id);
        let resp = await fetch(base_url+"controllers/clasificacion.php?op=eliminarAgrupamiento", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/legajos/clasificacion.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}
//////////////// AREAS ///////////////////

// FUNCIONES VER TODOS AREAS //
async function getAreas() {
    try {
        let resp = await fetch(base_url + "controllers/clasificacion.php?op=listaAreas");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idAreas;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idAreas}</th>
                                    <td>${item.nombreArea}</td>
                                    <td>${item.options}</td>`;
                document.querySelector("#tblBodyAreas").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getLegajos
if (document.querySelector("#tblBodyAreas")) {
    getAreas();
}

// FUNCIONES NUEVO AREA //
if(document.querySelector("#frmNuevoArea")){
    let frmNewArea = document.querySelector("#frmNuevoArea");
    frmNewArea.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarArea();
    } 

    async function fntGuardarArea(){
        let strNombre = document.querySelector("#txtNombreArea").value;
        if(strNombre == ""){
            swal("Todos los campos son obligatorios");
            return;
        }
        try {
            const data =  new FormData(frmNewArea);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=guardarArea", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewArea.reset();
                    window.location = base_url+'views/legajos/clasificacion.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR AREA //
function fntVerModificarArea(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarAreas'));
    modal.show();
    fntMostrarAreas(id);

    async function fntMostrarAreas(id){
        let formData = new FormData();
        formData.append('idAreas', id);
        try{
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=verArea", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdAreas").value = json.data.idAreas;
                document.querySelector("#txtModalNombreAreas").value = json.data.nombreArea; 
            }else{
                window.location = base_url+'views/legajos/clasificacion.php'
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarAreas")){
    let frmModificarAreas = document.querySelector("#frmModificarAreas");
    frmModificarAreas.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarArea();
    } 

    async function fntModificarArea(){
        
        let intId = document.querySelector("#txtModalIdAreas").value;  
        let strNombreArea = document.querySelector("#txtModalNombreAreas").value;

        if(intId == ""  || strNombreArea == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarAreas);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=modificarArea", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/legajos/clasificacion.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// FUNCIONES ELIMINAR AREA //
function fntEliminarArea(id){

    swal({
        title: "Quieres eliminar el Area?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          fntDeleteArea(id);
          }
      });

}

async function fntDeleteArea(id){
    try {
        let formData = new FormData();
        formData.append('idArea', id);
        let resp = await fetch(base_url+"controllers/clasificacion.php?op=eliminarArea", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/legajos/clasificacion.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}
//////////////// CATEGORIZACIONES ///////////////////
// FUNCIONES VER TODOS CATEGORIZACIONES //

async function getCategorizaciones() {
    try {
        let resp = await fetch(base_url + "controllers/clasificacion.php?op=listaCategorizaciones");
        json = await resp.json();

        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idCategorizaciones;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idCategorizaciones}</th>
                                    <td>${item.nombreCategorizacion}</td>
                                    <td>${item.options}</td>`;
                document.querySelector("#tblBodyCategorizaciones").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getLegajos
if (document.querySelector("#tblBodyCategorizaciones")) {
    getCategorizaciones();
}
// FUNCIONES NUEVO CATEGORIZACION //
if(document.querySelector("#frmNuevoCategorizacion")){
    let frmNewCategorizacion = document.querySelector("#frmNuevoCategorizacion");
    frmNewCategorizacion.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarCategorizacion();
    } 

    async function fntGuardarCategorizacion(){
        let strNombre = document.querySelector("#txtNombreCategorizacion").value;
        if(strNombre == ""){
            alert("Todos los campos son obligatorios");
            return;
        }
        try {
            const data =  new FormData(frmNewCategorizacion);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=guardarCategorizacion", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewCategorizacion.reset();
                    window.location = base_url+'views/legajos/clasificacion.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR CATEGORIZACION //
function fntVerModificarCategorizacion(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarCategorizaciones'));
    modal.show();
    fntMostrarCategorizacion(id);

    async function fntMostrarCategorizacion(id){
        let formData = new FormData();
        formData.append('idCategorizaciones', id);
        try{
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=verCategorizacion", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdCategorizaciones").value = json.data.idCategorizaciones;
                document.querySelector("#txtModalNombreCategorizaciones").value = json.data.nombreCategorizacion;
            }else{
                window.location = base_url+'views/legajos/clasificacion.php'
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarCategorizaciones")){
    let frmModificarCategorizacion = document.querySelector("#frmModificarCategorizaciones");
    frmModificarCategorizacion.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarCategorizacion();
    } 

    async function fntModificarCategorizacion(){
        
        let intId = document.querySelector("#txtModalIdCategorizaciones").value;;  
        let strNombreCategorizacion = document.querySelector("#txtModalNombreCategorizaciones").value;
        
        if(intId == ""  || strNombreCategorizacion == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarCategorizacion);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=modificarCategorizacion", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/legajos/clasificacion.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}
// FUNCIONES ELIMINAR CATEGORIZACION //
function fntEliminarCategorizacion(id){

    swal({
        title: "Quieres eliminar la categorizacion?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          fntDeleteCategorizacion(id);
          }
      });

}

async function fntDeleteCategorizacion(id){
    try {
        let formData = new FormData();
        formData.append('idCategorizacion', id);
        let resp = await fetch(base_url+"controllers/clasificacion.php?op=eliminarCategorizacion", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/legajos/clasificacion.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}
//////////////// CATEGORIAS ///////////////////
// FUNCIONES VER TODOS CATEGORIAS //

async function getCategorias() {
    try {
        let resp = await fetch(base_url + "controllers/clasificacion.php?op=listaCategorias");
        json = await resp.json();

        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idCategorizaciones;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idCategorias}</th>
                                    <td>${item.nombreCategoria}</td>
                                    <td>${item.options}</td>`;
                document.querySelector("#tblBodyCategorias").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}
//Validacion de para utilizar getLegajos
if (document.querySelector("#tblBodyCategorias")) {
    getCategorias();
}
// FUNCION NUEVA CATEGORIA //
if(document.querySelector("#frmNuevoCategoria")){
    let frmNewCategoria = document.querySelector("#frmNuevoCategoria");
    frmNewCategoria.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarCategoria();
    } 

    async function fntGuardarCategoria(){
        let strNombre = document.querySelector("#txtNombreCategoria").value;
        if(strNombre == ""){
            alert("Todos los campos son obligatorios");
            return;
        }
        try {
            const data =  new FormData(frmNewCategoria);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=guardarCategoria", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewCategoria.reset();
                    window.location = base_url+'views/legajos/clasificacion.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}
// FUNCIONES MODIFICAR CATEGORIA //
function fntVerModificarCategoria(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarCategorias'));
    modal.show();
    fntMostrarCategoria(id);

    async function fntMostrarCategoria(id){
        let formData = new FormData();
        formData.append('idCategorias', id);
        try{
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=verCategoria", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdCategorias").value = json.data.idCategorias;
                document.querySelector("#txtModalNombreCategorias").value = json.data.nombreCategoria; 
            }else{
                window.location = base_url+'views/legajos/clasificacion.php'
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarCategorias")){
    let frmModificarCategorias = document.querySelector("#frmModificarCategorias");
    frmModificarCategorias.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarCategoria();
    } 

    async function fntModificarCategoria(){
        
        let intId = document.querySelector("#txtModalIdCategorias").value;;  
        let strNombreCategoria = document.querySelector("#txtModalNombreCategorias").value;
        
        if(intId == ""  || strNombreCategoria == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarCategorias);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=modificarCategoria", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/legajos/clasificacion.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// FUNCIONES ELIMINAR CATEGORIA //
function fntEliminarCategoria(id){

    swal({
        title: "Quieres eliminar la categoria?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          fntDeleteCategoria(id);
          }
      });

}
async function fntDeleteCategoria(id){
    try {
        let formData = new FormData();
        formData.append('idCategoria', id);
        let resp = await fetch(base_url+"controllers/clasificacion.php?op=eliminarCategoria", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/legajos/clasificacion.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}

//////////////// OBRA SOCIAL ///////////////////
// FUNCIONES VER TODOS OBRA SOCIAL //

async function getObraSocial() {
    try {
        let resp = await fetch(base_url + "controllers/clasificacion.php?op=listaObraSocial");
        json = await resp.json();

        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idObraSocial;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idObraSocial}</th>
                                    <td>${item.nombreObraSocial}</td>
                                    <td>${item.options}</td>`;
                document.querySelector("#tblBodyObraSocial").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

//Validacion de para utilizar getLegajos

if (document.querySelector("#tblBodyObraSocial")) {
    getObraSocial();
}

// FUNCIONES NUEVO OBRA SOCIAL //
if(document.querySelector("#frmNuevoObraSocial")){
    let frmNewObraSocial = document.querySelector("#frmNuevoObraSocial");
    frmNewObraSocial.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarObraSocial();
    } 

    async function fntGuardarObraSocial(){
        let strNombre = document.querySelector("#txtNombreObraSocial").value;
        if(strNombre == ""){
            alert("Todos los campos son obligatorios");
            return;
        }
        try {
            const data =  new FormData(frmNewObraSocial);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=guardarObraSocial", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Guardar",json.msg, "success")
                .then(()=>{
                    frmNewObraSocial.reset();
                    window.location = base_url+'views/legajos/clasificacion.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR OBRA SOCIAL //
function fntVerModificarObraSocial(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarObraSocial'));
    modal.show();
    fntMostrarObraSocial(id);

    async function fntMostrarObraSocial(id){
        let formData = new FormData();
        formData.append('idObraSocial', id);
        try{
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=verObraSocial", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdObraSocial").value = json.data.idObraSocial;
                document.querySelector("#txtModalNombreObraSocial").value = json.data.nombreObraSocial; 
            }else{
                window.location = base_url+'views/legajos/clasificacion.php'
            }
        }catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

if(document.querySelector("#frmModificarObraSocial")){
    let frmModificarObraSocial = document.querySelector("#frmModificarObraSocial");
    frmModificarObraSocial.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModificarObraSocial();
    } 

    async function fntModificarObraSocial(){
        
        let intId = document.querySelector("#txtModalIdObraSocial").value;;  
        let strNombreObraSocial = document.querySelector("#txtModalNombreObraSocial").value;
        
        if(intId == ""  || strNombreObraSocial == ""){
            swal("Atencion...", "Todos los campos son obligatorios!", "warning");
            return;
        }
        try {
            const data =  new FormData(frmModificarObraSocial);
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=modificarObraSocial", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        window.location = base_url+'views/legajos/clasificacion.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// FUNCIONES ELIMINAR OBRA SOCIAL //
function fntEliminarObraSocial(id){

    swal({
        title: "Quieres eliminar la Obra Social?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          fntDeleteObraSocial(id);
          }
      });

}

async function fntDeleteObraSocial(id){
    try {
        let formData = new FormData();
        formData.append('idObraSocial', id);
        let resp = await fetch(base_url+"controllers/clasificacion.php?op=eliminarObraSocial", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status){
            swal("Eliminar",json.msg, "success")
            .then(()=>{
                window.location = base_url+'views/legajos/clasificacion.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}