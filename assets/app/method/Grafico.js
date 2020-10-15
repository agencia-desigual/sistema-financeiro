import Global from "../global.js"


/**
 * Método responsável por buscar os dados na api
 * e retornar em forma de grafico na view.
 */
function graficoMeses() {

    // Id
    var id = $("#idMes").val();

    // Recupera os dados necessarios
    var url = Global.config.urlApi + "grafico/meses";
    var token = Global.session.get("token");

    if(id !== undefined && id !== "" && id !== null)
    {
        url = url + "/" + id;
    }

    // Realiza a requisição
    Global.enviaApi("GET", url,null, token.token)
        .then((data) => {

            Morris.Area({
                element: "graficoMeses",
                pointSize: 0,
                lineWidth: 0,
                data: data.objeto,
                xkey: "periodo",
                ykeys: ['entrada','saida'],
                labels: ['Entrada','Saída'],
                resize: true,
                parseTime:false,
                gridLineColor: '#eef0f2',
                hideHover: 'auto',
                lineColors: ['#30419b', '#ea5858'],
                fillOpacity: .9,
                behaveLikeLine: true
            });

        });

}



// Retorno para os demais arquivos
export default (() => {

    return {
        graficoMeses: graficoMeses(),
    };

})();