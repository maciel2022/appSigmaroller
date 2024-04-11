
//////////////// PRODCUTOS ///////////////////

// FUNCIONES VER TODOS LOS PRODCUTOS //
async function getAreas() {
    try {
        let resp = await fetch(base_url + "controllers/clasificacion.php?op=listaAreas");
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
                newtr.id = "row_ " + item.idProducto;
                newtr.innerHTML = `<tr>
                                    <th scope="row" style="display: none;">${item.idProducto}</th>
                                    <td class="text-center">${item.codArticulo}</td>
                                    <td class="text-center"><div class="overflow-auto" style="white-space: nowrap;">${item.nombre}</div></td>
                                    <td class="text-center"><div class="overflow-auto" style="white-space: nowrap;">$ ${valor}</div></td>                                   
                                    <td class="text-center"><div class="overflow-auto" style="white-space: nowrap;">${item.observaciones}</div></td>
                                    <td class="text-center">${item.imagen}</td>
                                    <td class="text-center"><div class="overflow-auto" style="white-space: nowrap;">${item.options}</div></td>`;
                document.querySelector("#tblBodyAreas").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

//Validacion de para utilizar getProductos
if (document.querySelector("#tblBodyAreas")) {
    getAreas();
}

// FUNCIONES NUEVO PRODUCTO //
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
                    window.location = base_url+'views/productos/productos.php';
                });
            }else{
                swal("Guardar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+er);
        }
    }
}

// FUNCIONES MODIFICAR PRODCUTO //
function fntVerModificarArea(id){
    let modal = new bootstrap.Modal(document.getElementById('modalModificarAreas'));
    modal.show();
    fntMostrarAreas(id);

    async function fntMostrarAreas(id){
        let formData = new FormData();
        formData.append('idProducto', id);
        try{
            let resp = await fetch(base_url+"controllers/clasificacion.php?op=verArea", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            json = await resp.json();
            if(json.status){
                document.querySelector("#txtModalIdAreas").value = json.data.idProducto;
                document.querySelector("#txtModalNombreAreas").value = json.data.nombre; 
                document.querySelector("#numModalModificarPrecio").value = json.data.precio; 
                document.querySelector("#numModalModificarCodigo").value = json.data.codArticulo; 
                document.querySelector("#txtModalModificarObservaciones").value = json.data.observaciones; 
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
        let intPrecio = document.querySelector("#numModalModificarPrecio").value;
        let intCodigo = document.querySelector("#numModalModificarCodigo").value;
        let strObservaciones = document.querySelector("#txtModalModificarObservaciones").value;

        if(intId == ""  || strNombreArea == "" || intPrecio == "" || intCodigo == "" || strObservaciones == ""){
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
                        window.location = base_url+'views/productos/productos.php';
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}

// FUNCIONES ELIMINAR PRODUCTO //
function fntEliminarArea(id){

    swal({
        title: "Quieres eliminar el Producto?",
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
        formData.append('idProducto', id);
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
                window.location = base_url+'views/productos/productos.php';
            });
        }else{
            swal("Eliminar",json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: "+err);
    }
}
