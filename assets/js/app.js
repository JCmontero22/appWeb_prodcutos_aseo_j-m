function init() {
    $("#form-login").submit(function(e) {
        e.preventDefault();
        login();
    });

    /* Desplazar inputs/selects encima del teclado en móviles */
    if (window.innerWidth <= 480) {
        $(document).on('focus', 'input, textarea, select, .select2-search__field', function() {
            var $this = $(this);
            setTimeout(function() {
                $this.get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        });
    }
}


function login() {
    if ($("#user").val() && $("#pass").val()) {
        
        $.ajax({
            url: 'ajax/loginAjax.php',
            type: 'POST',
            data: {
                user: $("#user").val(),
                pass: $("#pass").val()
            },
            success: function(response) {
                response = JSON.parse(response);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                if (response.status === "success") {
                    setTimeout(function() {
                        window.location.href = "home";
                    }, 1500);
                }
            }
        });
    }else{
        alert("Por favor, complete todos los campos.");
    }
}

function logout() {
    $.ajax({
        url: 'ajax/logoutAjax.php',
        type: 'POST',
        success: function(response) {
            if (response == true) {
                window.location.href = "login";
            }
        }
    });
}



function redireccionar(vista, parametroBusqueda = null) {

    if (parametroBusqueda == null) {
        window.location.href = vista;    
        return;
    }
    
    window.location.href = vista + "?search=" + parametroBusqueda;
}




init();