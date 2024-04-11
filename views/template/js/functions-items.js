//// FUNCIONES PARA OBTENER VALOR CORTINA ////
// Valor CR //
document.addEventListener("DOMContentLoaded", function() {
    traerItems();
    var select = document.getElementById("selTela");
    var inputAnchoCR = document.getElementById("ancho");
    var inputAltoCR= document.getElementById("alto");
    var selCadCR= document.getElementById("selCadena");
    var selectSop = document.getElementById("selSoporte");
    var selectMR = document.getElementById("selMR");
    var selectMot = document.getElementById("selMotor");
    var checkbox1 = document.getElementById("zocalo");
    var checkbox2 = document.getElementById("termofusion");
    var checkbox3 = document.getElementById("mecCol");
    var checkbox4 = document.getElementById("contrapeso");
    var selectDup = document.getElementById("selDuplica");
    var inputCantidad = document.getElementById("cantidad");
    
    var inputPrecio = document.getElementById("valor");
    var valorCadenaCR;
    var valorTotalCR = 0;
    
      

    function actualizarValorTotalCR() {
        // Obtiene el valor seleccionado de cada select y los suma al valor total
        valorTotalCR = 0.00;
        var areaCR;
        
    
        var selectedOption = select.options[select.selectedIndex];
        if (selectedOption.disabled === false){
            precioTelaCR = parseFloat(selectedOption.getAttribute("data-precio"));
            console.log(precioTelaCR);
            if (inputAnchoCR!== 0) {
                anchoCR = parseFloat(inputAnchoCR.value);
                // console.log(anchoCR);
            }
    
            if (inputAltoCR!== 0) {
                altoCR = parseFloat(inputAltoCR.value);
                // console.log(altoCR);
            }
            areaCR = anchoCR*altoCR;
            
            if(areaCR < 1){
                valorTotalCR = precioTelaCR;
            }else{
                valorTotalCR = precioTelaCR*areaCR;
            }
        } 
    
        var selectedOptionCad = selCadCR.options[selCadCR.selectedIndex];
        if (selectedOptionCad.disabled === false){
            valorCadenaCR = parseFloat(selectedOptionCad.getAttribute("data-precioCad"));      
            // console.log(valorCadenaCR);
            valorTotalCR += valorCadenaCR;
        }
        
        var selectedOptinSop = selectSop.options[selectSop.selectedIndex];
        if (selectedOptinSop.disabled === false){
            valorTotalCR += parseFloat(selectedOptinSop.getAttribute("data-precioSop"));      
        }

        var selectedOptionMR = selectMR.options[selectMR.selectedIndex];
        if (selectedOptionMR.disabled === false){
            valorParcial = parseFloat(selectedOptionMR.getAttribute("data-precioMR"));
            if (inputAnchoCR!== 0) {
                anchoCR = parseFloat(inputAnchoCR.value);
            }
            // el valor lo multiplicamos por el ancho de la cortina
            // pero si el ancho es menor a 1mt debe ser el valor del mecanismo
            if (anchoCR < 1) {
                valorTotalCR += valorParcial;
            } else {
                valorTotalCR += valorParcial * anchoCR;
                console.log(valorParcial * anchoCR);
            }      
        }

        var selectedOptionMot = selectMot.options[selectMot.selectedIndex];
        if (selectedOptionMot.disabled === false){
            valorTotalCR += parseFloat(selectedOptionMot.getAttribute("data-precioMCR"));      
        }

        // var selectedOptionDup = selectDup.options[selectDup.selectedIndex];
        // if (selectedOptionDup.value == "Si") {
        //     valorTotalCR = valorTotalCR*2;
        //     // console.log(selectedOptionDup.value);
        // } else {
        //     valorTotalCR = valorTotalCR*1;
        // }

        if (checkbox1.checked) {
            valorTotalCR += parseFloat(checkbox1.getAttribute("data-precio"));
        }
        if (checkbox2.checked) {
            valorTotalCR += parseFloat(checkbox2.getAttribute("data-precio"));
        }
        if (checkbox3.checked) {
            valorTotalCR += parseFloat(checkbox3.getAttribute("data-precio"));
        }
        if (checkbox4.checked) {
            valorTotalCR += parseFloat(checkbox4.getAttribute("data-precio"));
        }

       valorTotalCR = valorTotalCR.toFixed(2);
    //    // Separar la parte entera y la parte decimal
    //    let partes = valorTotalCR.split('.');
    //    let parteEntera = partes[0];
    //    let parteDecimal = partes[1];
    //    // Agregar puntos como separadores de miles
    //    parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    //    // Unir las partes con una coma como separador decimal
    //    valorTotalCR = parteEntera + ',' + parteDecimal;
    //     console.log(valorTotalCR);
        // Actualiza el input con el nuevo valor total
        inputPrecio.value = valorTotalCR;
    }

    verificarAncho = () => {
        let ancho = parseFloat(inputAnchoCR.value);
    
        if(ancho <= 0.50){ 
            swal("Garantia!", 'El ANCHO de la cortina inferior a 0.50 mts. no tendra GARANTIA.', "info");
        }
    
    }

    actualizarDuplicado = () => {
        var duplicar = selectDup.value == 'Si';
        var cantidad = parseInt(inputCantidad.value);
    
        if (duplicar) {
          cantidad *= 2; 
        }else{
            cantidad != 1 ? cantidad/=2 : cantidad = 1;
        }
        inputCantidad.value = cantidad;
    }

    actualizarCantidad = () => {
        duplicar = selectDup.value == 'Si';
        cantidad = parseInt(inputCantidad.value);
        if (duplicar) {
            cantidad *= 2;
        }
        inputCantidad.value = cantidad;
    }

    // Agrega controladores de eventos a los tres select
    select.addEventListener("change", actualizarValorTotalCR);
    inputAnchoCR.addEventListener("input", actualizarValorTotalCR);
    inputAnchoCR.addEventListener("change", verificarAncho);
    inputAltoCR.addEventListener("input", actualizarValorTotalCR);
    selCadCR.addEventListener("change", actualizarValorTotalCR);
    selectSop.addEventListener("change", actualizarValorTotalCR);
    selectMR.addEventListener("change", actualizarValorTotalCR);
    selectMot.addEventListener("change", actualizarValorTotalCR);
    checkbox1.addEventListener("change", actualizarValorTotalCR);
    checkbox2.addEventListener("change", actualizarValorTotalCR);
    checkbox3.addEventListener("change", actualizarValorTotalCR);
    checkbox4.addEventListener("change", actualizarValorTotalCR);
    selectDup.addEventListener("change", actualizarValorTotalCR);
    selectDup.addEventListener("change", actualizarDuplicado);
    inputCantidad.addEventListener("change", actualizarCantidad);
    
});

// Valor CBV //
document.addEventListener("DOMContentLoaded", function() {
    var select1 = document.getElementById("selTela1");
    var inputAnchoBV = document.getElementById("numAnchoCBV");
    var inputAltoBV= document.getElementById("numAltoCBV");
    var selMecBV= document.getElementById("selMecCBV");
    var selMotBV= document.getElementById("selMotCBV");
    var selApBV= document.getElementById("selAperCBV");
    var selectDupBV = document.getElementById("selDupCBV");
    var inputCantidadCBV = document.getElementById("numCantCBV");

    var inputPrecioBV = document.getElementById("numValorCBV");
    var areaBV;
    var valorTotalBV = 0;

    function actualizarValorTotalBV() {
        // Obtiene el valor seleccionado de cada select y los suma al valor total
        valorTotalBV = 0.00;
        
        var selectedOptionTela = select1.options[select1.selectedIndex];
        if (selectedOptionTela.disabled === false){
            precioTelaBV = parseFloat(selectedOptionTela.getAttribute("data-precio"));
            // console.log(precioTelaBV);
            if (inputAnchoBV !== 0) {
                anchoBV = parseFloat(inputAnchoBV.value);
                // console.log(anchoBV);
            }
    
            if (inputAltoBV !== 0) {
                altoBV = parseFloat(inputAltoBV.value);
                // console.log(altoBV);
            }
            areaBV = anchoBV*altoBV;
            if(areaBV < 1){
                valorTotalBV = precioTelaBV;
            }else{
                valorTotalBV = precioTelaBV*areaBV;
            }
            
        } 

        var selOptionMecBV = selMecBV.options[selMecBV.selectedIndex];
        if (selOptionMecBV.disabled === false){
            valorParcialBV = parseFloat(selOptionMecBV.getAttribute("data-precio"));
            if (inputAnchoBV !== 0) {
                anchoBV = parseFloat(inputAnchoBV.value);
            }
            // el valor lo multiplicamos por el ancho de la cortina
            // pero si el ancho es menor a 1mt debe ser el valor del mecanismo
            if(anchoBV < 1){
                valorTotalBV += valorParcialBV;
            }else{
                valorTotalBV += valorParcialBV * anchoBV;
                console.log(valorParcialBV * anchoBV);
            }         
        }

        var selOptionMotBV = selMotBV.options[selMotBV.selectedIndex];
        if (selOptionMotBV.disabled === false){
            valorTotalBV += parseFloat(selOptionMotBV.getAttribute("data-precio"));      
        }

        var selOptionApBV = selApBV.options[selApBV.selectedIndex];
        if (selOptionApBV.disabled === false){
            valorTotalBV += parseFloat(selOptionApBV.getAttribute("data-precio"));      
        }

        // var selectedOptionDupBV = selectDupBV.options[selectDupBV.selectedIndex];
        // if (selectedOptionDupBV.value == "Si") {
        //     valorTotalBV = valorTotalBV*2;
        //     // console.log(selectedOptionDup.value);
        // } else {
        //     valorTotalBV = valorTotalBV*1;
        // }


        // Actualiza el input con el nuevo valor total
        inputPrecioBV.value = valorTotalBV.toFixed(2);
    }  

    actualizarDuplicado = () => {
        var duplicarCBV = selectDupBV.value == 'Si';
        var cantidadCBV = parseInt(inputCantidadCBV.value);
    
        if (duplicarCBV) {
          cantidadCBV *= 2; 
        }else{
            cantidadCBV != 1 ? cantidadCBV/=2 : cantidadCBV = 1;
        }
        inputCantidadCBV.value = cantidadCBV;
    }

    actualizarCantidad = () => {
        duplicarCBV = selectDupBV.value == 'Si';
        cantidadCBV = parseInt(inputCantidadCBV.value);
        if (duplicarCBV) {
            cantidadCBV *= 2;
        }
        inputCantidadCBV.value = cantidadCBV;
    }

    select1.addEventListener("change", actualizarValorTotalBV);
    inputAnchoBV.addEventListener("input", actualizarValorTotalBV);
    inputAltoBV.addEventListener("input", actualizarValorTotalBV);
    selMecBV.addEventListener("change", actualizarValorTotalBV);
    selMotBV.addEventListener("change", actualizarValorTotalBV);
    selApBV.addEventListener("change", actualizarValorTotalBV);
    selectDupBV.addEventListener("change", actualizarValorTotalBV);
    selectDupBV.addEventListener("change", actualizarDuplicado);
    inputCantidadCBV.addEventListener("change", actualizarCantidad);

});

// Valor CC //
document.addEventListener("DOMContentLoaded", function() {
    var select2 = document.getElementById("selTela2");
    var inputAnchoCC = document.getElementById("numAnchoCC");
    var inputAltoCC= document.getElementById("numAltoCC");

    var inputPrecioCC = document.getElementById("numValorCC");
    var areaCC;
    var valorTotalCC = 0;

    function actualizarValorTotalCC() {
        // Obtiene el valor seleccionado de cada select y los suma al valor total
        valorTotalCC = 0.00;
        
        var selectedOptionTela = select2.options[select2.selectedIndex];
        if (selectedOptionTela.disabled === false){
            precioTelaCC = parseFloat(selectedOptionTela.getAttribute("data-precio"));
            // console.log(precioTelaCC);
            if (inputAnchoCC !== 0) {
                anchoCC = parseFloat(inputAnchoCC.value);
                // console.log(anchoCC);
            }
    
            if (inputAltoCC !== 0) {
                altoCC = parseFloat(inputAltoCC.value);
                // console.log(altoCC);
            }
            areaCC = anchoCC*altoCC;
            if(areaCC < 1){
                valorTotalCC = precioTelaCC;
            }else{
                valorTotalCC = precioTelaCC*areaCC;
            }
            
        } 

        // Actualiza el input con el nuevo valor total
        inputPrecioCC.value = valorTotalCC.toFixed(2);
    }  

    select2.addEventListener("change", actualizarValorTotalCC);
    inputAnchoCC.addEventListener("input", actualizarValorTotalCC);
    inputAltoCC.addEventListener("input", actualizarValorTotalCC);

});



////  FUNCIONES NUEVO PEDIDO  ////

// Agregar CR //
if (document.querySelector("#frmCortinaRoller")) {
    let frmCortinaRoller = document.querySelector("#frmCortinaRoller");
    frmCortinaRoller.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarCR();
    }

    async function fntGuardarCR() {
        let inputAncho = document.querySelector("#ancho");
        let ancho = parseFloat(inputAncho.value);
        var selAnchoMR= document.getElementById("selMR");
        var anchoMR;
        var selectedOptionAncho = selAnchoMR.options[selAnchoMR.selectedIndex];
        if (selectedOptionAncho.disabled === false){
            anchoMR = parseFloat(selectedOptionAncho.getAttribute("data-ancho"));      
        }

        if (anchoMR >= ancho){
            try {
                const data = new FormData(frmCortinaRoller);
                let resp = await fetch(base_url + "controllers/agregarProducto.php?op=guardarCR", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                });
                json = await resp.json();
                if (json.status) {
                    swal("Item", json.msg, "success")
                        .then(() => {
                            frmCortinaRoller.reset();
                            location.reload();
                        });
    
                } else {
                    swal("Item", json.msg, "error");
                }
    
            } catch (err) {
                console.log("Ocurrio un error: " + er);
            }
            
        }else{
            swal("Error de Mecanismo", 'El ancho max. del Mecanismo Roller debe ser superior al ANCHO ingresado', "error");
        }
    }
}

// Agregar CBV //

if (document.querySelector("#frmCortinaBV")) {
    let frmCortinaBV = document.querySelector("#frmCortinaBV");
    frmCortinaBV.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarCBV();
    }

    async function fntGuardarCBV() {

        try {
            const data = new FormData(frmCortinaBV);
            let resp = await fetch(base_url + "controllers/agregarProducto.php?op=guardarCBV", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status) {
                swal("Item", json.msg, "success")
                    .then(() => {
                        frmCortinaBV.reset();
                        location.reload();
                    });

            } else {
                swal("Item", json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: " + er);
        }
    }
}

// Agregar CC //

if (document.querySelector("#frmCortinaConfec")) {
    let frmCortinaConfec = document.querySelector("#frmCortinaConfec");
    frmCortinaConfec.onsubmit = function (e) {
        e.preventDefault(); // para que no se recargue la pagina
        fntGuardarCC();
    }

    async function fntGuardarCC() {

        try {
            const data = new FormData(frmCortinaConfec);
            let resp = await fetch(base_url + "controllers/agregarProducto.php?op=guardarCC", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();

            if (json.status) {
                swal("Item", json.msg, "success")
                    .then(() => {
                        frmCortinaConfec.reset();
                        location.reload();
                    });



            } else {
                swal("Item", json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: " + er);
        }
    }
}

// FUNCIONES GUARDAR ITEM PRODUCTO SELECCIONADO  //
async function fntGuardarItemProd(idProducto) {
    let idPed = document.querySelector("#idPedidoPro");
    idPed = idPed.value;
    var sel1 = "#precio-unitario_" + idProducto;
    let valorUni = document.querySelector(sel1);
    valorUni = valorUni.textContent;
    valorUni = valorUni.replace(/\D/g, '');
    var sel2 = "#cantSel_" + idProducto;
    let cantidad = document.querySelector(sel2);
    cantidad = cantidad.value;

    try {
        const data = new FormData();
        data.append('idPro', idProducto);
        data.append('idPed', idPed);
        data.append('valorUni', valorUni);
        data.append('cantidad', cantidad);

        let resp = await fetch(base_url + "controllers/agregarProducto.php?op=guardarItemProd", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();

        if (json.status) {
            swal("Agregar Producto", json.msg, "success")
                .then(() => {
                    location.reload();
                });



        } else {
            swal("Agregar cortina", json.msg, "error");
        }

    } catch (err) {
        console.log("Ocurrio un error: " + er);
    }
}

// function fntACR(id) {
//     var sel2 = "cantSelCR_" + id;
//     let cantidad = document.getElementById(sel2);
//     cantidad = cantidad.value;
//     console.log(cantidad);
     
// }


////CREAR TABLA DE ITEMS POR NRO DE PEDIDO///
async function traerItems() {

    try {
        let obId = document.querySelector("#obtenerId");
        let idPedido = obId.value;
        const data = new FormData();
        data.append('id', idPedido);
        let resp = await fetch(base_url + "controllers/items.php?op=listItems", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach(item => {
                console.log(item);
                let valor = item.valorTotal;
                // Separar la parte entera y la parte decimal
                let partes = valor.split('.');
                let parteEntera = partes[0];
                let parteDecimal = partes[1];
                // Agregar puntos como separadores de miles
                parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valor = parteEntera + ',' + parteDecimal;
                
                let valorU = item.valorUnitario;
                // Separar la parte entera y la parte decimal
                let partesU = valorU.split('.');
                let parteEnteraU = partesU[0];
                let parteDecimalU = partesU[1];
                // Agregar puntos como separadores de miles
                parteEnteraU = parteEnteraU.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Unir las partes con una coma como separador decimal
                valorU = parteEnteraU + ',' + parteDecimalU;
                
                let cantidad = item.cantidad;
                if(item.tipo == 'producto'){
                    cantidad = item.cantidadProducto;
                    // Separar la parte entera y la parte decimal
                    let partesC = cantidad.split('.');
                    let parteEnteraC = partesC[0];
                    let parteDecimalC = partesC[1];
                    if(parteDecimalC == 0){
                        cantidad = parteEnteraC;
                    }
                }
                
                let newtr = document.createElement("tr");
                newtr.id = "row_ " + item.idItem;
                newtr.innerHTML = `<tr>
                                                <th scope="row" style="display: none;">${item.idItem}</th>
                                                <td style="text-align: center">${item.itemSelec}</td>
                                                <td style="text-align: center">${cantidad}</td>
                                                <td style="text-align: center">$ ${valorU}</td>
                                                <td style="text-align: center">$ ${valor}</td>
                                                <td style="text-align: center">${item.options}</td>`;
                document.querySelector("#tblBodyItems").appendChild(newtr);
            });
        }
        let valorTotal = json.valorTotal.toFixed(2);
        // Separar la parte entera y la parte decimal
        let partes = valorTotal.split('.');
        let parteEntera = partes[0];
        let parteDecimal = partes[1];
        // Agregar puntos como separadores de miles
        parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        // Unir las partes con una coma como separador decimal
        valorTotal = parteEntera + ',' + parteDecimal;

        let inputvalorTotal = document.querySelector("#valorTotal");
        inputvalorTotal.value = valorTotal ;

    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

async function traerValorTotal(){
    try {
        
    } catch (error) {
        console.log("Ocurrio un error" + error);
    }
}


///////////  FUNCIONES DE MODIFICAR y VER ////////////////
// Funcion modificar Cortina Roller
async function fntModCR(id, idItem){
    let formData = new FormData();
    formData.append('idCR', id);
    try {
        let resp = await fetch(base_url + "controllers/items.php?op=modItemCR", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            //aca copiar datos en modal
            let idCR = document.querySelector("#idCR");
            idCR.value = id;
            let idCRItem = document.querySelector("#idCRItem");
            idCRItem.value = idItem;
            let nombre = document.querySelector("#nombre");
            nombre.value = json.data.nombre;
            let selTela = document.querySelector("#selTela");
            selTela.value = json.data.tela;
            selColor = json.data.color;
            obtenerTela(selColor);
            let ancho = document.querySelector("#ancho");
            ancho.value = json.data.ancho;
            let alto = document.querySelector("#alto");
            alto.value = json.data.alto;
            let selCadena = document.querySelector("#selCadena");
            selCadena.value = json.data.cadena;
           
            let selComando = document.querySelector("#selComando");
            selComando.value = json.data.comando;
            let selCaida = document.querySelector("#selCaida");
            selCaida.value = json.data.caida;
            let selMR = document.querySelector("#selMR");
            selMR.value = json.data.idMecanismoRoller;
            let selSoporte = document.querySelector("#selSoporte");
            selSoporte.value = json.data.idSoporte;
            let selMotor = document.querySelector("#selMotor");
            selMotor.value = json.data.idMotorCR;
            let selDuplica = document.querySelector("#selDuplica");
            selDuplica.value = json.data.duplica;
            let cantidad = document.querySelector("#cantidad");
            cantidad.value = json.data.cantidad;
            let observaciones = document.querySelector("#observaciones");
            observaciones.value = json.data.observaciones;
            let valor = document.querySelector("#valor");
            valor.value = json.data.valor;
            if(json.data.zocalo == "1"){
                let zocalo = document.querySelector("#zocalo");
                zocalo.checked = true;
            }
            if(json.data.termofusion == "1"){
                let termofusion = document.querySelector("#termofusion");
                termofusion.checked = true;
            }
            if(json.data.mecanismoColor == "1"){
                let mecanismoColor = document.querySelector("#mecCol");
                mecanismoColor.checked = true;
            }
            if(json.data.contrapesoCadena == "1"){
                let contrapeso = document.querySelector("#contrapeso");
                contrapeso.checked = true;
            }

            let modal = new bootstrap.Modal(document.getElementById('cortinaRoller'));
            modal.show(); 
        } else {
            location.reload();
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }

}
// Funcion Ver Cortina Roller
async function fntVerCR(id, idItem){
    let formData = new FormData();
    formData.append('idCR', id);
    try {
        let resp = await fetch(base_url + "controllers/items.php?op=modItemCR", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            //aca copiar datos en modal
            let idCR = document.querySelector("#idCR");
            idCR.value = id;
            let idCRItem = document.querySelector("#idCRItem");
            idCRItem.value = idItem;
            let nombre = document.querySelector("#nombre");
            nombre.value = json.data.nombre;
            let selTela = document.querySelector("#selTela");
            selTela.value = json.data.tela;
            selColor = json.data.color;
            obtenerTela(selColor);
            let ancho = document.querySelector("#ancho");
            ancho.value = json.data.ancho;
            let alto = document.querySelector("#alto");
            alto.value = json.data.alto;
            let selCadena = document.querySelector("#selCadena");
            selCadena.value = json.data.cadena;
           
            let selComando = document.querySelector("#selComando");
            selComando.value = json.data.comando;
            let selCaida = document.querySelector("#selCaida");
            selCaida.value = json.data.caida;
            let selMR = document.querySelector("#selMR");
            selMR.value = json.data.idMecanismoRoller;
            let selSoporte = document.querySelector("#selSoporte");
            selSoporte.value = json.data.idSoporte;
            let selMotor = document.querySelector("#selMotor");
            selMotor.value = json.data.idMotorCR;
            let selDuplica = document.querySelector("#selDuplica");
            selDuplica.value = json.data.duplica;
            let cantidad = document.querySelector("#cantidad");
            cantidad.value = json.data.cantidad;
            let observaciones = document.querySelector("#observaciones");
            observaciones.value = json.data.observaciones;
            let valor = document.querySelector("#valor");
            valor.value = json.data.valor;
            if(json.data.zocalo == "1"){
                let zocalo = document.querySelector("#zocalo");
                zocalo.checked = true;
            }
            if(json.data.termofusion == "1"){
                let termofusion = document.querySelector("#termofusion");
                termofusion.checked = true;
            }
            if(json.data.mecanismoColor == "1"){
                let mecanismoColor = document.querySelector("#mecCol");
                mecanismoColor.checked = true;
            }
            if(json.data.contrapesoCadena == "1"){
                let contrapeso = document.querySelector("#contrapeso");
                contrapeso.checked = true;
            }
            //Para deshabilitar todas las etiquetas y btn de terminar
            let btn = document.querySelector("#btnFinCR");
            btn.style.display = "none";
            // Deshabilitar todos los elementos de formulario
            let formElements = document.querySelectorAll("#cortinaRoller input, #cortinaRoller select, #cortinaRoller textarea");
            formElements.forEach(element => {
                element.disabled = true;
            });

            let modal = new bootstrap.Modal(document.getElementById('cortinaRoller'));
            modal.show(); 
        } else {
            location.reload();
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }

}

// Funcion modificar Cortina Banda Vertical
async function fntModCBV(id, idItem){
    let formData = new FormData();
    formData.append('idCBV', id);
    try {
        let resp = await fetch(base_url + "controllers/items.php?op=modItemCBV", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            //aca copiar datos en modal
            let idCBV = document.querySelector("#idCBV");
            idCBV.value = id;
            let idCBVItem = document.querySelector("#idCBVItem");
            idCBVItem.value = idItem;
            let nombre = document.querySelector("#nombreCBV");
            nombre.value = json.data.nombre;
            let selTela = document.querySelector("#selTela1");
            selTela.value = json.data.tela;
            selColor1 = json.data.color;
            obtenerTela1(selColor1);
            let ancho = document.querySelector("#numAnchoCBV");
            ancho.value = json.data.ancho;
            let alto = document.querySelector("#numAltoCBV");
            alto.value = json.data.alto;
            let selComando = document.querySelector("#selComandoCBV");
            selComando.value = json.data.comando;
            let selMecCBV = document.querySelector("#selMecCBV");
            selMecCBV.value = json.data.idMecanismoBandaVertical;
            let selMen = document.querySelector("#selMenCBV");
            selMen.value = json.data.mensulas;
            let selMotorCBV = document.querySelector("#selMotCBV");
            selMotorCBV.value = json.data.idMotorBandaVertical;
            let selAperCBV = document.querySelector("#selAperCBV");
            selAperCBV.value = json.data.idApertura;
            let selValorCBV = document.querySelector("#numValorCBV");
            selValorCBV.value = json.data.valor;
            let cantidadCBV = document.querySelector("#numCantCBV");
            cantidadCBV.value = json.data.cantidad;
            let duplicaCBV = document.querySelector("#selDupCBV");
            duplicaCBV.value = json.data.duplica;
            let txtObsCBV = document.querySelector("#txtObsCBV");
            txtObsCBV.value = json.data.observacion;

            let modal = new bootstrap.Modal(document.getElementById('CortinaBV'));
            modal.show();
        } else {
            location.reload();
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }

}
// Funcion ver Cortina Banda Vertical
async function fntVerCBV(id, idItem){
    let formData = new FormData();
    formData.append('idCBV', id);
    try {
        let resp = await fetch(base_url + "controllers/items.php?op=modItemCBV", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            //aca copiar datos en modal
            let idCBV = document.querySelector("#idCBV");
            idCBV.value = id;
            let idCBVItem = document.querySelector("#idCBVItem");
            idCBVItem.value = idItem;
            let nombre = document.querySelector("#nombreCBV");
            nombre.value = json.data.nombre;
            let selTela = document.querySelector("#selTela1");
            selTela.value = json.data.tela;
            selColor1 = json.data.color;
            obtenerTela1(selColor1);
            let ancho = document.querySelector("#numAnchoCBV");
            ancho.value = json.data.ancho;
            let alto = document.querySelector("#numAltoCBV");
            alto.value = json.data.alto;
            let selComando = document.querySelector("#selComandoCBV");
            selComando.value = json.data.comando;
            let selMecCBV = document.querySelector("#selMecCBV");
            selMecCBV.value = json.data.idMecanismoBandaVertical;
            let selMen = document.querySelector("#selMenCBV");
            selMen.value = json.data.mensulas;
            let selMotorCBV = document.querySelector("#selMotCBV");
            selMotorCBV.value = json.data.idMotorBandaVertical;
            let selAperCBV = document.querySelector("#selAperCBV");
            selAperCBV.value = json.data.idApertura;
            let selValorCBV = document.querySelector("#numValorCBV");
            selValorCBV.value = json.data.valor;
            let cantidadCBV = document.querySelector("#numCantCBV");
            cantidadCBV.value = json.data.cantidad;
            let duplicaCBV = document.querySelector("#selDupCBV");
            duplicaCBV.value = json.data.duplica;
            let txtObsCBV = document.querySelector("#txtObsCBV");
            txtObsCBV.value = json.data.observacion;

             //Para deshabilitar todas las etiquetas y btn de terminar
             let btnBV = document.querySelector("#btnFinCBV");
             btnBV.style.display = "none";
             // Deshabilitar todos los elementos de formulario
             let formElements = document.querySelectorAll("#CortinaBV input, #CortinaBV select, #CortinaBV textarea");
             formElements.forEach(element => {
                 element.disabled = true;
             });

            let modal = new bootstrap.Modal(document.getElementById('CortinaBV'));
            modal.show();
        } else {
            location.reload();
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }

}

// Funcion modificar Cortina Confeccion
async function fntModCC(id, idItem){
    let formData = new FormData();
    formData.append('idCC', id);
    try {
        let resp = await fetch(base_url + "controllers/items.php?op=modItemCC", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            //aca copiar datos en modal
            let idCC = document.querySelector("#idCC");
            idCC.value = id;
            let idCCItem = document.querySelector("#idCCItem");
            idCCItem.value = idItem;
            let nombre = document.querySelector("#nombreCC");
            nombre.value = json.data.nombre;
            let selTela = document.querySelector("#selTela2");
            selTela.value = json.data.tela;
            selColor2 = json.data.color;
            obtenerTela2(selColor2);            
            let ancho = document.querySelector("#numAnchoCC");
            ancho.value = json.data.ancho;
            let alto = document.querySelector("#numAltoCC");
            alto.value = json.data.alto;
            let numValorCC = document.querySelector("#numValorCC");
            numValorCC.value = json.data.valor;
            let txtObsCC = document.querySelector("#txtObsCC");
            txtObsCC.value = json.data.observacion;

            let modal = new bootstrap.Modal(document.getElementById('CortinaConfeccion'));
            modal.show();
        } else {
            location.reload();
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }

}
// Funcion Ver Cortina Confeccion
async function fntVerCC(id, idItem){
    let formData = new FormData();
    formData.append('idCC', id);
    try {
        let resp = await fetch(base_url + "controllers/items.php?op=modItemCC", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            //aca copiar datos en modal
            let idCC = document.querySelector("#idCC");
            idCC.value = id;
            let idCCItem = document.querySelector("#idCCItem");
            idCCItem.value = idItem;
            let nombre = document.querySelector("#nombreCC");
            nombre.value = json.data.nombre;
            let selTela = document.querySelector("#selTela2");
            selTela.value = json.data.tela;
            selColor2 = json.data.color;
            obtenerTela2(selColor2);
            let ancho = document.querySelector("#numAnchoCC");
            ancho.value = json.data.ancho;
            let alto = document.querySelector("#numAltoCC");
            alto.value = json.data.alto;
            let numValorCC = document.querySelector("#numValorCC");
            numValorCC.value = json.data.valor;
            let txtObsCC = document.querySelector("#txtObsCC");
            txtObsCC.value = json.data.observacion;

            //Para deshabilitar todas las etiquetas y btn de terminar
            let btnCC = document.querySelector("#btnFinCC");
            btnCC.style.display = "none";
            // Deshabilitar todos los elementos de formulario
            let formElements = document.querySelectorAll("#CortinaConfeccion input, #CortinaConfeccion select, #CortinaConfeccion textarea");
            formElements.forEach(element => {
                element.disabled = true;
            });

            let modal = new bootstrap.Modal(document.getElementById('CortinaConfeccion'));
            modal.show();
        } else {
            location.reload();
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }

}

///////// FUNCION PARA ELIMINAR ITEMS
function fntEliminarItem(id) {

    swal({
        title: "Queres eliminar el Item?",
        text: "Se eliminara el item del Pedido",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                fntDeleteItem(id);
            }
        });

}

async function fntDeleteItem(id) {
    try {
        let formData = new FormData();
        formData.append('id', id);
        let resp = await fetch(base_url + "controllers/items.php?op=eliminar", {
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
            swal("Eliminar", json.msg, "error");
        }
    } catch (err) {
        console.log("Ocurrio un error: " + err);
    }
}


////// FUNCIONES DE VER PEDIDO E IMPRIMIR PEDIDO ////

async function getItemsPedido() {
    let obId = document.querySelector("#nroPedido");
    let idPedido = obId.value;
    try {
        
        // console.log(idPedido);
        const data = new FormData();
        data.append('id', idPedido);
        let resp = await fetch(base_url + "controllers/items.php?op=verItems", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            // Encabezado de Ver Pedido
            let datos = json.datos;
            const divOrdenPedido = document.getElementById("ordenPedido");
            const h5Cliente = document.createElement("h5");
            h5Cliente.innerHTML = `<strong>Cliente: ${datos.nombreCliente}</strong>`;
            const h5NumeroPedido = document.createElement("h5");
            h5NumeroPedido.innerHTML = `<strong>Nro. Pedido: ${datos.idPedido}</strong>`;
            const h5Fecha = document.createElement("h5");
            const fecha = convertirFecha(datos.fecha);
            h5Fecha.innerHTML = `<strong>Fecha: ${fecha}</strong>`;
            divOrdenPedido.appendChild(h5Cliente);
            divOrdenPedido.appendChild(h5NumeroPedido);
            divOrdenPedido.appendChild(h5Fecha);
            // detalle de los productos
            let data = json.data;
            data.forEach(item => {
                if(item.itemSelec.tipo== 'producto'){
                    cantidad = item.cantidadProducto;
                    // Separar la parte entera y la parte decimal
                    let partesC = cantidad.split('.');
                    let parteEnteraC = partesC[0];
                    let parteDecimalC = partesC[1];
                    if(parteDecimalC == 0){
                        cantidad = parteEnteraC + " Unid ";
                    }else{
                        cantidad = cantidad + " mts. ";
                    }
                    
                    // creo etiqueta 'li'
                    const listItem = document.createElement('li');
                    //creo etiqueta 'p'
                    const paragraph = document.createElement('p');
                    // Agrega el contenido al 'p'
                    paragraph.innerHTML = `<strong>${cantidad} - ${item.itemSelec.nombre}</strong> <br>`;                                            
                    // Agrega el 'p' al 'li'
                    listItem.appendChild(paragraph);
                    document.getElementById('detallesOrden').appendChild(listItem);
                }else if(item.itemSelec.tipo== 'cortinaR'){
                    // console.log(item.itemSelec);
                    // Convertir datos de etiqueta select
                    let comando;
                    let caida;
                    let cadena;
                    let cantidad = item.cantidad;
                    if(item.itemSelec.comando == 1){
                        comando = 'Derecho';
                    }else{
                        comando = 'Izquierdo';
                    }
                    if(item.itemSelec.caida == 1){
                        caida = 'Normal';
                    }else{
                        caida = 'Invertida';
                    }
                    if(item.itemSelec.cadena == 1){
                        cadena = 'Metal';
                    }else if(item.itemSelec.cadena == 2){
                        cadena = 'Plastico';
                    }else{
                        cadena = 'Otro';
                    }
					
					if(item.itemSelec.tipoMotorCR == "Sin Motor"){
                        item.itemSelec.tipoMotorCR ="";
                    }
                    
					if(item.itemSelec.duplica == 'Si'){
                        cantidad = cantidad / 2;
                    }
					               
                    const listItem = document.createElement('li');
                    const paragraph = document.createElement('p');
                    paragraph.innerHTML =`<strong>${item.itemSelec.tela} | ${item.itemSelec.color} <br>
											${cantidad} x ${item.itemSelec.ancho} x ${item.itemSelec.alto} ${comando}-${caida} | Cadena: ${cadena} <br>
											${item.itemSelec.tipoMecanismoRollr} | Soporte: ${item.itemSelec.tipoSoporte}</strong> <br>
											${item.itemSelec.contrapesoCadena === '1' ? `<strong>Con Contrapeso Cadena</strong>` : ''}
											${item.itemSelec.zocalo === '1' ? `<strong>- Con Zocalo Enfundado</strong>` : ''}
											${item.itemSelec.mecanismoColor === '1' ? `<strong>- Con Mecanismo Color</strong>` : ''}
											${item.itemSelec.termofusion === '1' ? `<strong>- Con Termofusion</strong>` : ''}
											${item.itemSelec.tipoMotorCR !== '' ? `<strong>- Motor: ${item.itemSelec.tipoMotorCR}</strong>` : ''}
											${item.itemSelec.observaciones !== "" ? `<br><strong>Observaciónes de la Cortina: ${item.itemSelec.observaciones}</strong> ` : ''} `;    
                    listItem.appendChild(paragraph);
                    document.getElementById('detallesOrden').appendChild(listItem);

                    if(item.itemSelec.duplica == 'Si'){
                        if(item.itemSelec.comando == 1){
                            comando = 'Izquierdo';
                        }else{
                            comando = 'Derecho';
                        }
                        const listItem2 = document.createElement('li');
                        const paragraph2 = document.createElement('p');
                        paragraph2.innerHTML =`<strong>${item.itemSelec.tela} | ${item.itemSelec.color} <br>
                                                ${cantidad} x ${item.itemSelec.ancho} x ${item.itemSelec.alto} ${comando}-${caida} | Cadena: ${cadena} <br>
                                                ${item.itemSelec.tipoMecanismoRollr} | Soporte: ${item.itemSelec.tipoSoporte}</strong> <br>
                                                ${item.itemSelec.contrapesoCadena === '1' ? `<strong>Con Contrapeso Cadena</strong>` : ''}
                                                ${item.itemSelec.zocalo === '1' ? `<strong>- Con Zocalo Enfundado</strong>` : ''}
                                                ${item.itemSelec.mecanismoColor === '1' ? `<strong>- Con Mecanismo Color</strong>` : ''}
                                                ${item.itemSelec.termofusion === '1' ? `<strong>- Con Termofusion</strong>` : ''}
                                                ${item.itemSelec.tipoMotorCR !== '' ? `<strong>- Motor: ${item.itemSelec.tipoMotorCR}</strong>` : ''}
                                                ${item.itemSelec.observaciones !== "" ? `<br><strong>Observaciónes de la Cortina: ${item.itemSelec.observaciones}</strong> ` : ''} `;    
                        listItem2.appendChild(paragraph2);
                        document.getElementById('detallesOrden').appendChild(listItem2);
                    }
                    
                }else if(item.itemSelec.tipo== 'cortinaBV'){
                    console.log(item.itemSelec);
                     // Convertir datos de etiqueta select
                     let comando;
                     let cantidadBV = item.cantidad;
                
                     if(item.itemSelec.comando == 1){
                         comando = 'Derecho';
                     }else{
                         comando = 'Izquierdo';
                     }

                     if(item.itemSelec.duplica == 'Si'){
                        cantidadBV = cantidadBV / 2;
                     }

                     const listItem = document.createElement('li');
                     const paragraph = document.createElement('p');
                     paragraph.innerHTML = `
											<strong>${item.itemSelec.tela} | ${item.itemSelec.color} | ${cantidadBV} x ${item.itemSelec.ancho} x ${item.itemSelec.alto} <br>
											${comando} - ${item.itemSelec.tipoApertura} / ${item.itemSelec.nomMecBanVer}</strong> <br>
											${item.itemSelec.observacion !== "" ? `<strong>Observación: ${item.itemSelec.observacion}</strong>` : ''} `;
                    listItem.appendChild(paragraph);
                    document.getElementById('detallesOrden').appendChild(listItem);

                    if(item.itemSelec.duplica == 'Si'){
                        if(item.itemSelec.comando == 1){
                            comando = 'Izquierdo';
                        }else{
                            comando = 'Derecho';
                        }
                        const listItem2 = document.createElement('li');
                        const paragraph2 = document.createElement('p');
                        paragraph2.innerHTML = `
                                               <strong>${item.itemSelec.tela} | ${item.itemSelec.color} | ${cantidadBV} x ${item.itemSelec.ancho} x ${item.itemSelec.alto} <br>
                                               ${comando} - ${item.itemSelec.tipoApertura} / ${item.itemSelec.nomMecBanVer}</strong> <br>
                                               ${item.itemSelec.observacion !== "" ? `<strong>Observación: ${item.itemSelec.observacion}</strong> ` : ''} `;
                       listItem2.appendChild(paragraph2);
                       document.getElementById('detallesOrden').appendChild(listItem2);

                    }

                }else if(item.itemSelec.tipo== 'cortinaC'){
                    
                    const listItem = document.createElement('li');
                    const paragraph = document.createElement('p');
                    paragraph.innerHTML = `<strong>${item.itemSelec.tela} | Color: ${item.itemSelec.color}
                                        ${item.itemSelec.ancho} x ${item.itemSelec.alto}</strong> <br>
                                        ${item.itemSelec.observacion !== "" ? `<strong>Observación: ${item.itemSelec.observacion}</strong> ` : ''} `;
                    listItem.appendChild(paragraph);
                    document.getElementById('detallesOrden').appendChild(listItem);

                }
                // console.log(item);
                // if(item.itemSelec.tipo== 'producto'){
                //     // creo etiqueta 'li'
                //     const listItem = document.createElement('li');
                //     //creo etiqueta 'p'
                //     const paragraph = document.createElement('p');
                //     // Agrega el contenido al 'p'
                //     paragraph.innerHTML = `<strong>Producto:</strong> ${item.itemSelec.nombre} , 
                //                         <strong>Cod. Art.:</strong> ${item.itemSelec.codArticulo} , 
                //                         <strong>Cantidad:</strong> ${item.cantidad}`;
                //     // Agrega el 'p' al 'li'
                //     listItem.appendChild(paragraph);
                //     document.getElementById('detallesOrden').appendChild(listItem);
                // }else if(item.itemSelec.tipo== 'cortinaR'){
                //     console.log(item.itemSelec);
                //     // Convertir datos de etiqueta select
                //     let comando;
                //     let caida;
                //     let cadena;
                //     if(item.itemSelec.comando == 1){
                //         comando = 'Derecho';
                //     }else{
                //         comando = 'Izquierdo';
                //     }
                //     if(item.itemSelec.caida == 1){
                //         caida = 'Normal';
                //     }else{
                //         caida = 'Invertida';
                //     }
                //     if(item.itemSelec.cadena == 1){
                //         cadena = 'Metal';
                //     }else if(item.itemSelec.cadena == 2){
                //         cadena = 'Plastico';
                //     }else{
                //         cadena = 'Otro';
                //     }
                
                //     const listItem = document.createElement('li');
                //     const paragraph = document.createElement('p');
                //     paragraph.innerHTML = `<strong>Producto:</strong> ${item.itemSelec.nombre} ,
                //                         <strong>Cantidad:</strong> ${item.cantidad} ,
                //                         <strong>Tela:</strong> ${item.itemSelec.tela} ,
                //                         <strong>Color:</strong> ${item.itemSelec.color} ,
                //                         <strong>Ancho:</strong> ${item.itemSelec.ancho} ,
                //                         <strong>Alto:</strong> ${item.itemSelec.alto} ,
                //                         <strong>Comando:</strong> ${comando} ,
                //                         <strong>Cadena:</strong> ${cadena} ,
                //                         <strong>Caida:</strong> ${caida} ,
                //                         ${item.itemSelec.contrapesoCadena === '1' ? `<strong>Contrapeso Cadena:</strong> Si ,` : ''}
                //                         ${item.itemSelec.zocalo === '1' ? `<strong>Zocalo:</strong> Si ,` : ''}
                //                         ${item.itemSelec.mecanismoColor === '1' ? `<strong>Mecanismo Color:</strong> Si ,` : ''}
                //                         ${item.itemSelec.termofusion === '1' ? `<strong>Termofusion:</strong> Si ,` : ''}
                //                         <strong>Tipo Mecanismo:</strong> ${item.itemSelec.tipoMecanismoRollr} ,
                //                         <strong>Largo:</strong> ${item.itemSelec.largo} ,
                //                         <strong>Motor:</strong> ${item.itemSelec.tipoMotorCR} ,
                //                         <strong>Soporte:</strong> ${item.itemSelec.tipoSoporte} ,
                //                         <strong>Duplica:</strong> ${item.itemSelec.duplica} , 
                //                         ${item.itemSelec.observaciones !== "" ? `<strong>Observación:</strong> ${item.itemSelec.observaciones} ` : ''} 
                //                         `;
                //     listItem.appendChild(paragraph);
                //     document.getElementById('detallesOrden').appendChild(listItem);
                    
                // }else if(item.itemSelec.tipo== 'cortinaBV'){
                //     console.log(item.itemSelec);
                //      // Convertir datos de etiqueta select
                //      let comando;
                
                //      if(item.itemSelec.comando == 1){
                //          comando = 'Derecho';
                //      }else{
                //          comando = 'Izquierdo';
                //      }

                //      const listItem = document.createElement('li');
                //      const paragraph = document.createElement('p');
                //      paragraph.innerHTML = `<strong>Producto:</strong> ${item.itemSelec.nombre} ,
                //                          <strong>Cantidad:</strong> ${item.cantidad} ,
                //                          <strong>Tela:</strong> ${item.itemSelec.tela} ,
                //                          <strong>Color:</strong> ${item.itemSelec.color} ,
                //                          <strong>Ancho:</strong> ${item.itemSelec.ancho} ,
                //                          <strong>Alto:</strong> ${item.itemSelec.alto} ,
                //                          <strong>Comando:</strong> ${comando} ,
                //                          <strong>Mecanismo Banda Vertical:</strong> ${item.itemSelec.nomMecBanVer} ,
                //                          <strong>Cantidad de Mensulas:</strong> ${item.itemSelec.mensulas} ,
                //                          <strong>Motor:</strong> ${item.itemSelec.nombreMotorBV} ,
                //                          <strong>Apertura:</strong> ${item.itemSelec.tipoApertura} ,
                //                          <strong>Duplica:</strong> ${item.itemSelec.duplica} , 
                //                          ${item.itemSelec.observacion !== "" ? `<strong>Observación:</strong> ${item.itemSelec.observacion} ` : ''} 
                //                          `;
                //     listItem.appendChild(paragraph);
                //     document.getElementById('detallesOrden').appendChild(listItem);

                // }else if(item.itemSelec.tipo== 'cortinaC'){
                //     const listItem = document.createElement('li');
                //     const paragraph = document.createElement('p');
                //     paragraph.innerHTML = `<strong>Producto:</strong> ${item.itemSelec.nombre} ,
                //                         <strong>Tela:</strong> ${item.itemSelec.tela} ,
                //                         <strong>Color:</strong> ${item.itemSelec.color} ,
                //                         <strong>Ancho:</strong> ${item.itemSelec.ancho} ,
                //                         <strong>Alto:</strong> ${item.itemSelec.alto} ,
                //                         ${item.itemSelec.observacion !== "" ? `<strong>Observación:</strong> ${item.itemSelec.observacion} ` : ''}
                //                         `;
                //     listItem.appendChild(paragraph);
                //     document.getElementById('detallesOrden').appendChild(listItem);

                // }
            });
        }
        

    } catch (err) {
        console.log("Ocurrio un error" + err);
    }
}

if (document.querySelector("#detallesOrden")) {
    getItemsPedido();
}

//// Funcion para covertir fecha /////
function convertirFecha(fecha){
    nuevaFecha = fecha.split("-").reverse().join("-");
    return nuevaFecha;
}