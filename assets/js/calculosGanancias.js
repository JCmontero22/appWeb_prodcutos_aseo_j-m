function init() {
    this.realizarCalculos(pantalla);
}

function realizarCalculos(pantalla) {
    $.ajax({
        url: 'ajax/calculoVentasAjax.php',
        type: 'GET',
        data: {pantalla: pantalla},
        success: function(response){
            response = JSON.parse(response);
            
            let gananciasTotales = (response.data[0].gananciasPorJM != null | response.data[0].gananciasDeVentas != null) ? (parseInt(response.data[0].gananciasPorJM) + parseInt(response.data[0].gananciasDeVentas)) : '0';

            $('#gananciasNetas').text('$ ' + separarMiles(gananciasTotales));
            $('#totalVendido').text('$ ' + (response.data[0].totalVendido != null ? separarMiles(response.data[0].totalVendido) : '0'));
            $('#costoVendido').text('$ ' + (response.data[0].totalCostoVendido != null ? separarMiles(response.data[0].totalCostoVendido) : '0'));
            $('#dineroRecaudado').text('$ ' + (response.data[0].total != null ? separarMiles(response.data[0].total) : '0'));
            
            
        }
    });
}

function separarMiles(numero) {
    numero = Number(numero); // convierte a número (acepta enteros y decimales)
    return new Intl.NumberFormat("es-CO").format(numero);
}

init();