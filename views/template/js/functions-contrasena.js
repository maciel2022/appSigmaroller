// FUNCIONES MODIFICAR MECANMISMO//


if(document.querySelector("#frmCambioContra")){
    let frmCambioContra = document.querySelector("#frmCambioContra");
    frmCambioContra.onsubmit = function(e){
        e.preventDefault(); // para que no se recargue la pagina
        fntModContra();
    } 

    async function fntModContra(){
         
        let strNuevaContra = document.querySelector("#txtNuevaContra").value;
        let strRepNueCont = document.querySelector("#txtRepNuevaContra").value;

        if(strNuevaContra != strRepNueCont){
            swal("Atencion...", "Las contraseñas ingresadas no coinciden!", "warning");
            return;
        }

        try {
            const data =  new FormData(frmCambioContra);
            let resp = await fetch(base_url+"controllers/legajo.php?op=modContra", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data
            });
            json = await resp.json();
            if (json.status){
                swal("Modificar",json.msg, "success")
                .then(()=>{
                        location.reload();
                })

            }else{
                swal("Modificar",json.msg, "error");
            }

        } catch (err) {
            console.log("Ocurrio un error: "+err);
        }
    }
}