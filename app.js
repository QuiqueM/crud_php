$(document).ready(function(){
    let ACCION = 'create'
    const getAllClients = () => {
        $.ajax({
            url: "index.php",
            method: "GET",
            data: {
                accion: "getClients"
            },
            success: function(clients){
                let template = "";
                for(c of JSON.parse(clients)){
                    template += `<tr clientId="${c.id}">
                                  <td>${c.id}</td>
                                  <td>${c.nombres}</td>
                                  <td>${c.ape_paterno}</td>
                                  <td>${c.ape_materno}</td>
                                  <td>${c.direccion}</td>
                                  <td>${c.correo}</td>
                                  <td>
                                    <button class="btn btn-warning btn-update" type="button">Actualizar</button>
                                    <button class="btn btn-danger btn-delete" type="button">Eliminar</button>
                                  </td>  `
                }
                $('#clients').append(template)
            }
        })
    }

    //capturar el evento del formulario
    $('#formCliente').submit(function(e){
        e.preventDefault()

        if(ACCION == 'create'){
            let clientData = {
                nombres: $('#nombres').val(),
                ape_paterno: $('#ape_paterno').val(),
                ape_materno: $('#ape_materno').val(),
                direccion: $('#direccion').val(),
                correo: $('#correo').val(),
                accion: "create" 
            }
            
            $.ajax({
                url: "index.php",
                method: "POST",
                data: clientData,
                success: function(){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success', 
                        title: 'Se creo correctamente',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    $("#newClient").modal('hide')
                    $("#newClient").find('form')[0].reset()
                    //location.reload()
                    //crear notificacion
                }
            })
            
            
        } else {
            //actualizar un producto
            let clientData = {
                id : $('#id').val(),
                nombres: $('#nombres').val(),
                ape_paterno: $('#ape_paterno').val(),
                ape_materno: $('#ape_materno').val(),
                direccion: $('#direccion').val(),
                correo: $('#correo').val(),
                accion: "update" 
            }
            //console.log(clientData);
            $.ajax({
                url: "index.php",
                method: "POST",
                data: clientData,
                success: function(){
                    //crear notificacion
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se elimino correctamente',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    $("#newClient").modal('hide')
                    $("#newClient").find('form')[0].reset()
                    location.reload()
                }
            })
        }
        
    })

    //Eliminar un registro
    $(document).on('click', '.btn-delete', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('clientId');
        console.log(id);
        Swal.fire({
            title: 'Estas seguro?',
            text: "La accion no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Continuar!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "index.php",
                    method: "GET",
                    data: {
                        id: id,
                        accion: "delete"
                    },
                    success: function(){
                        Swal.fire(
                            'Eliminado!',
                            'Se elimino correctamente.',
                            'success'
                          )
                        location.reload()
                    }
                })
            }
          })
        
        
    });

    $(document).on('click', '.btn-update', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('clientId');
        console.log(id);
        $.ajax({
            url: "index.php",
            method: "GET",
            data: {
                id: id,
                accion: "getClientByID"
            },
            success: function(client){
                let c = JSON.parse(client)
                let template=""
                console.log(c);
                $('#nombres').val(c.nombres),
                $('#ape_paterno').val(c.ape_paterno),
                $('#ape_materno').val(c.ape_materno),
                $('#direccion').val(c.direccion),
                $('#correo').val(c.correo)
                ACCION = 'update'
                template = `<input type="hidden" class="form-control" id="id" value="${c.id}">`
                $("#formCliente").append(template)
                $("#newClient").modal('show')
            }
        })
        
    });
    

    getAllClients()
})