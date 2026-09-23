// Neutralizar cualquier remanente de la extensión Responsive de DataTables en memoria
if (window.jQuery && jQuery.fn) {
    if (jQuery.fn.dataTable && jQuery.fn.dataTable.Responsive) {
        try { delete jQuery.fn.dataTable.Responsive; } catch(e) {}
    }
    if (jQuery.fn.DataTable && jQuery.fn.DataTable.Responsive) {
        try { delete jQuery.fn.DataTable.Responsive; } catch(e) {}
    }
}

function init() {
    $("#form-login").submit(function(e) {
        e.preventDefault();
        login();
    });

    /* Desplazar inputs encima del teclado en móviles (solo inputs nativos) */
    if (window.innerWidth <= 480) {
        $(document).on('focus', 'input:not([type="hidden"]):not(.select2-search__field), textarea', function() {
            var $this = $(this);
            setTimeout(function() {
                if ($this.length && $this.is(':visible')) {
                    $this.get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
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

// ============================================================
// MEJORAS GLOBALES PARA TODOS LOS SELECT2 DEL SISTEMA
// ============================================================

// 1. Manejo táctil y de clic en la 'X' (allowClear): detener propagación para que NO abra el desplegable
$(document).on('mousedown touchstart pointerdown', '.select2-selection__clear', function(e) {
    e.stopPropagation();
});

$(document).on('click touchend', '.select2-selection__clear', function(e) {
    e.preventDefault();
    e.stopPropagation();

    let $container = $(this).closest('.select2-container');
    let $select = $container.prev('select');

    if (!$select.length) {
        let selectId = $container.attr('id');
        if (selectId) {
            let origId = selectId.replace(/^select2-/, '').replace(/-container$/, '');
            $select = $('#' + origId);
        }
    }

    if ($select.length) {
        $select.val(null).trigger('change');
        if ($select.data('select2')) {
            $select.select2('close');
        }
    }
});

// 2. Prevenir que al deseleccionar se abra automáticamente el menú desplegable
$(document).on('select2:unselecting', 'select', function(e) {
    $(this).data('unselecting', true);
});

$(document).on('select2:opening', 'select', function(e) {
    if ($(this).data('unselecting')) {
        $(this).removeData('unselecting');
        e.preventDefault();
        return;
    }

    // En móviles: si el select está en la parte inferior de la pantalla, hacer scroll suave para darle espacio
    let isMobile = window.innerWidth <= 768;
    if (isMobile) {
        let $container = $(this).next('.select2-container');
        if ($container.length) {
            let rect = $container[0].getBoundingClientRect();
            if (rect.top > window.innerHeight * 0.65) {
                $container[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }
});

// 3. En móviles: evitar que el teclado virtual se abra automáticamente al tocar el select
$(document).on('select2:open', function() {
    let isMobile = window.innerWidth <= 768 || ('ontouchstart' in window);
    let searchField = document.querySelector('.select2-container--open .select2-search__field');
    if (searchField) {
        if (isMobile) {
            searchField.setAttribute('readonly', 'readonly');
            searchField.setAttribute('placeholder', 'Toca aquí para buscar...');
            setTimeout(() => {
                searchField.removeAttribute('readonly');
            }, 200);
        } else {
            searchField.focus();
        }
    }
});

init();