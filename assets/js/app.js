function init() {
    

    $("#form-login").submit(function(e) {
        e.preventDefault();
        login();
    });
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



function redireccionar(vista) {
    window.location.href = vista;
}




init();