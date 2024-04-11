async function obtenerTela(num) {
    let selTela = document.querySelector("#selTela");
    selTela = selTela.value;
    try {
        let data = new FormData();
        //envio el idTela para hacer la busqueda de colores para esa tela
        data.append('idTela', selTela);
        let resp = await fetch(base_url + "controllers/agregarProducto.php?op=obtenerColor", { // ver la ruta correcta....
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            let data = json.data;

            let selColor = document.getElementById("selColor");

            while (selColor.firstChild) {
                selColor.removeChild(selColor.firstChild);
            }

            data.forEach(item => {
                if(item.activo == 'Activo'){
                let newOption = document.createElement("option");
                newOption.value = item.idColor;
                newOption.textContent = `${item.nombreColor}`;
                selColor.appendChild(newOption);
                // Si se proporciona un número (num), seleccionar la opción correspondiente
                if (num != null && item.idColor == num) {
                newOption.selected = true;
                }
                }
            });
            
        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

async function obtenerTela1(num) {
    let selTela1 = document.querySelector("#selTela1");
    selTela1 = selTela1.value;
    try {
        let data = new FormData();
        //envio el idTela para hacer la busqueda de colores para esa tela
        data.append('idTela', selTela1);
        let resp = await fetch(base_url + "controllers/agregarProducto.php?op=obtenerColor", { // ver la ruta correcta....
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            let data = json.data;

            let selColor1 = document.getElementById("selColor1");

            while (selColor1.firstChild) {
                selColor1.removeChild(selColor1.firstChild);
            }

            data.forEach(item => {
                if(item.activo == "Activo"){
                let newOption = document.createElement("option");
                newOption.value = item.idColor;
                newOption.textContent = `${item.nombreColor}`;
                selColor1.appendChild(newOption);
                if (num != null && item.idColor == num) {
                    newOption.selected = true;
                } 
                }
                         
            });
        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

async function obtenerTela2(num) {
    let selTela2 = document.querySelector("#selTela2");
    selTela2 = selTela2.value;
    try {
        let data = new FormData();
        //envio el idTela para hacer la busqueda de colores para esa tela
        data.append('idTela', selTela2);
        let resp = await fetch(base_url + "controllers/agregarProducto.php?op=obtenerColor", { // ver la ruta correcta....
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            let data = json.data;

            let selColor1 = document.getElementById("selColor2");

            while (selColor1.firstChild) {
                selColor1.removeChild(selColor1.firstChild);
            }
            
            data.forEach(item => {
                if(item.activo == "Activo") {
                    let newOption = document.createElement("option");
                    newOption.value = item.idColor;
                    newOption.textContent = `${item.nombreColor}`;
                    selColor1.appendChild(newOption);
                    if (num != null && item.idColor == num) {
                        newOption.selected = true;
                    }
                }
            });
        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}



async function agregarProducto() {
    try {
        let resp = await fetch(base_url + "controllers/agregarProducto.php?op=agregarProducto");
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
                                        <th scope="row" style="display: none;">
                                        <div id="idProduc" name="idProduc">   
                                            ${item.idProducto}
                                        </div> 
                                        </th>
                                        
                                        <td style="text-align: center;">
                                            <img src="../../assets/img/logoSigmaroller.jpg" alt="product-img" title="product-img" style="height: 35px; width: 35px;">
                                        </td>
                                        <td style="text-align: center;">
                                            <div id="nombreProd" name="nombreProd">    
                                                <h5 class="font-size-14 text-truncate mt-1"><a href="" class="text-dark">${item.nombre}</a></h5>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="mt-1" id="precio-unitario_${item.idProducto}" name="precio-unitario">$ ${valor}</div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div>
                                                <input id="cantSel_${item.idProducto}" name="cantSel" type="number" min="0.01" step="0.01" class="form-control cantidad" required value="1">
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-success" onclick="fntGuardarItemProd(${item.idProducto})">Agregar Producto</button>
                                            </div>
                                        </td>`;
                document.querySelector("#agregarProducto").appendChild(newtr);
            });

        }
    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

if (document.querySelector("#agregarProducto")) {
    agregarProducto();
}


function resetFrmCR(){
    let form = document.getElementById("frmCortinaRoller");
    form.reset();
    let selColor = document.getElementById("selColor");
    // Obtiene el número de opciones del select
    let optionCount = selColor.options.length;

    // Elimina todas las opciones del select
    for (let i = 0; i < optionCount; i++) {
    selColor.removeChild(selColor.options[0]);
    }
    // Crea la opción
    let newOption = document.createElement("option");
    newOption.value = "";
    newOption.textContent = "--Seleccionar color--";
    newOption.disabled = true;
    newOption.selected = true;

    // Agrega la opción al select
    selColor.appendChild(newOption);
    
    //Habilitar todas las etiquetas y btn de terminar
    let btn = document.querySelector("#btnFinCR");
    btn.style.display = "block";
    // Habilitar todos los elementos de formulario
    let formElements = document.querySelectorAll("#cortinaRoller input, #cortinaRoller select, #cortinaRoller textarea");
    formElements.forEach(element => {
        element.disabled = false;
    });
}

function resetFrmCBV(){
    let form = document.getElementById("frmCortinaBV");
    form.reset();
    let selColor = document.getElementById("selColor1");
    // Obtiene el número de opciones del select
    let optionCount = selColor.options.length;

    // Elimina todas las opciones del select
    for (let i = 0; i < optionCount; i++) {
    selColor.removeChild(selColor.options[0]);
    }
    // Crea la opción
    let newOption = document.createElement("option");
    newOption.value = "";
    newOption.textContent = "--Seleccionar color--";
    newOption.disabled = true;
    newOption.selected = true;

    // Agrega la opción al select
    selColor.appendChild(newOption);

    //Habilitar todas las etiquetas y btn de terminar
    let btn = document.querySelector("#btnFinCBV");
    btn.style.display = "block";

    // Habilitar todos los elementos de formulario
    let formElements = document.querySelectorAll("#CortinaBV input, #CortinaBV select, #CortinaBV textarea");
    formElements.forEach(element => {
        element.disabled = false;
    });
}

function resetFrmCC(){
    let form = document.getElementById("frmCortinaConfec");
    form.reset();
    let selColor = document.getElementById("selColor2");
    // Obtiene el número de opciones del select
    let optionCount = selColor.options.length;

    // Elimina todas las opciones del select
    for (let i = 0; i < optionCount; i++) {
    selColor.removeChild(selColor.options[0]);
    }
    // Crea la opción
    let newOption = document.createElement("option");
    newOption.value = "";
    newOption.textContent = "--Seleccionar color--";
    newOption.disabled = true;
    newOption.selected = true;

    // Agrega la opción al select
    selColor.appendChild(newOption);

    //Habilitar todas las etiquetas y btn de terminar
    let btn = document.querySelector("#btnFinCC");
    btn.style.display = "block";
    // Habilitar todos los elementos de formulario
    let formElements = document.querySelectorAll("#CortinaConfeccion input, #CortinaConfeccion select, #CortinaConfeccion textarea");
    formElements.forEach(element => {
        element.disabled = false;
    });
}

// Funcion de cambio de estado del pedido cliente
cambioACreado =  (id)  => {
    cambiarEstado();
    async function cambiarEstado () {
        
        try {
            let data = new FormData();
            data.append('idPedido', id);
            let resp = await fetch(base_url + "controllers/pedido.php?op=cambiarEstadoCliente", { 
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status) {
                swal("Modificar", json.msg, "success")
                    .then(() => {
                        window.location = base_url + 'views/pedidos/pedido.php';
                    })
                    ;
            } else {
                swal("Modificar", json.msg, "error");
            }
        } catch (e) {
            console.log("Ocurrio un error" + e);
        }
    }
}