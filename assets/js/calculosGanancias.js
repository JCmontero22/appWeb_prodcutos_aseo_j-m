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

            $('#gananciasNetas').text('$ ' + gananciasTotales);
            $('#totalVendido').text('$ ' + (response.data[0].totalVendido != null ? response.data[0].totalVendido : '0'));
            $('#costoVendido').text('$ ' + (response.data[0].totalCostoVendido != null ? response.data[0].totalCostoVendido : '0'));
            
            
        }
    });
}


init();