$(document).ready(function() {
    $("body").on("click", ".preguntar", function(e) {
        e.preventDefault();
        const link = $(this).attr("href");
        const dataMensaje = $(this).attr("data-mensaje");
        let dataColor = $(this).attr("data-color");
        if(typeof dataColor === undefined)
        {
            dataColor = '#dc3545';
        }
        Swal.fire({
            title: `<b>${dataMensaje}</b>`,
            type: 'warning',
            text: `En verdad desea ${dataMensaje.toLowerCase()}?`,
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: dataColor
        }).then((result) => {
            if (result.value) {
                const form = document.createElement("form");
                form.setAttribute("id", "autoSubmitForm");
                form.setAttribute("action", link);
                form.setAttribute("method", "POST");
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const token = document.createElement("input");
                token.setAttribute("type", "hidden");
                token.setAttribute("name", "_token");
                token.setAttribute("value", csrfToken);
                form.appendChild(token);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
function alertaSwal(mensaje){
    Swal.fire({
        title: `<b>${mensaje}</b>`,
        type: 'info',
        text: `${mensaje}`,
        showCloseButton: true,
        confirmButtonText: 'Aceptar'
    });
}

function errorSwal(titulo, mensaje){
    Swal.fire({
        title: `<b>${titulo}</b>`,
        type: 'warning',
        text: `${mensaje}`,
        showCloseButton: true,
        confirmButtonText: 'Aceptar'
    });
}