import Global from "../global.js"

/**
 * Método responsável por deletar uma determinada
 * categoria.Enviando a solicitação para a API
 */
$(".deletarCategoria").on("click", function () {

    // Não atualiza a página
    event.preventDefault();

    // Recupera as informações
    var id = $(this).data("id");

    // Url e Token
    var url = Global.config.urlApi + "categoria/delete/" + id;
    var token = Global.session.get("token");

    // Pergunta se realmente quer deletar
    Swal.fire({
        title: 'Deletar Categoria',
        text: 'Deseja realmente deletar essa categoria?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, delete!'
    }).then((result) => {
        if (result.value)
        {
            // Realiza a solicitação
            Global.enviaApi("DELETE", url, null, token.token)
                .then((data) => {

                    // Avisa que deu certo
                    Global.setSuccess(data.mensagem);

                    // Remove da tabela
                    $('#datatable-buttons')
                        .DataTable()
                        .row("#tb_" + id)
                        .remove()
                        .draw(false);


                });
        }
    });


    // Não atualiza mesmo
    return false;
});


/**
 * Método responsável por recuperar os dados do
 * formulário e realizar uma requisição para que os
 * dados sejam atualizado no banco.
 */
$("#formAlteraCategoria").on("submit", function () {

    // Não atualiza a página
    event.preventDefault();

    // Recupera os dados importantes
    var form = new FormData(this);
    var id = $(this).data("id");

    // Bloqueia o Form
    $(this).addClass("bloqueiaForm");

    // Url e token
    var url = Global.config.urlApi + "categoria/update/" + id;
    var token = Global.session.get("token");

    // Realiza a requisição
    Global.enviaApi("POST", url, form, token.token)
        .then((data) => {
            // Avisa que deu certo
            Global.setSuccess(data.mensagem);

            // Desbloqueia o Form
            $(this).removeClass("bloqueiaForm");

        })
        .catch((error) => {
            // Desbloqueia o Form
            $(this).removeClass("bloqueiaForm");
        });

    // Não atualiza mesmo
    return false;
});


/**
 * Método responsável por recuperar os dados do
 * formulário e realizar uma requisição para que os
 * dados sejam cadastrados no banco.
 */
$("#formInserirCategoria").on("submit", function () {

    // Não atualiza a página
    event.preventDefault();

    // Recupera os dados importantes
    var form = new FormData(this);

    // Bloqueia o Form
    $(this).addClass("bloqueiaForm");

    // Url e token
    var url = Global.config.urlApi + "categoria/insert";
    var token = Global.session.get("token");

    // Realiza a requisição
    Global.enviaApi("POST", url, form, token.token)
        .then((data) => {

            // Avisa que deu certo
            Global.setSuccess(data.mensagem);

            // Limpa o formulário
            Global.limparFormulario("#formInserirCategoria");

            // Desbloqueia o Form
            $(this).removeClass("bloqueiaForm");

        })
        .catch((error) => {
            // Desbloqueia o Form
            $(this).removeClass("bloqueiaForm");
        });

    // Não atualiza mesmo
    return false;
});