<?php

// NameSpace
namespace Controller;

// Importações
use Helper\Apoio;
use Model\Categoria;
use Model\Movimentacao;
use Sistema\Controller as CI_controller;

// Inicia a Classe
class Principal extends CI_controller
{
    // Objetos
    private $objModelCategoria;
    private $objModelMovimentacao;
    private $objHelperApoio;

    // Método construtor
    function __construct()
    {
        // Carrega o contrutor da classe pai
        parent::__construct();

        // Instancia os objetos
        $this->objModelCategoria = new Categoria();
        $this->objModelMovimentacao = new Movimentacao();
        $this->objHelperApoio = new Apoio();

    } // End >> fun::__construct();


    /**
     * Método responsável por configurar a tela de
     * login, caso o usuário estéja logado, manda
     * para a dashboard.
     * ----------------------------------------------
     * @url login
     */
    public function login()
    {
        // Dados
        $dados = null;

        // Recupera os dados da sessao
        $user = (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"] : null;

        // Verifica se o usuário está logado
        if(!empty($user))
        {
            // Redireciona para a tela principal
            header("Location: " . BASE_URL);
        }
        else
        {
            // Js
            $dados["js"] = ["modulos" => ["Usuario"]];

            // Chama a view
            $this->view("app/externo/login", $dados);
        }

    } // End >> fun::login()


    /**
     * Método responsável por chama a dashboard correta
     * de acordo com o nivel do usuário logado.
     * -------------------------------------------------
     * @url BASE_URL
     */
    public function dashboard()
    {
        // Variaveis
        $usuario = null;

        // Recupera o usuário
        $usuario = $this->objHelperApoio->seguranca();

        // Verifica se é admin
        if($usuario->nivel == "admin")
        {
            // Chama o método admin
            $this->dashboardAdmin($usuario);
        }
        else
        {
            // Chama o método usuário
            $this->dashboardUser($usuario);
        }

    } // End >> fun::dashboard()


    /**
     * Método responsável por buscar todas as informações
     * necessárias para configurar a dashboard do admin.
     * --------------------------------------------------
     * @param $usuario
     */
    public function dashboardAdmin($usuario)
    {
        // Variaveis
        $dados = null;
        $cateogrias = null;
        $movimentacoes = null;

        // Esse mes
        $data = date("Y-m-") . "01";

        // CONTADORES -----------------------

        // Entradas de dinheito -----
        $auxEntradas = $this->objModelMovimentacao
            ->get(
                ["vencimento >=" => $data, "tipo" => "entrada"],
                null,
                null,
                "SUM(valor) as total"
            )
            ->fetch(\PDO::FETCH_OBJ);

        $numEntrada = $auxEntradas->total;


        // Saidas de dinheiro -------
        $auxSaida = $this->objModelMovimentacao
            ->get(
                ["vencimento >=" => $data, "tipo" => "saida"],
                null,
                null,
                "SUM(valor) as total"
            )
            ->fetch(\PDO::FETCH_OBJ);

        $numSaida = $auxSaida->total;


        // Movimentações apenas esse mes
        $numMovimentacao = $this->objModelMovimentacao
            ->get(["vencimento >=" => $data])
            ->rowCount();


        // Categoria ativas
        $numCategoria = $this->objModelCategoria
            ->get()
            ->rowCount();

        // ----------------------------------

        // Busca as ultimas 6 categorias
        $categorias = $this->objModelCategoria
            ->get(null, "id_categoria DESC", 6)
            ->fetchAll(\PDO::FETCH_OBJ);

        // Percorre as categorias
        foreach ($categorias as $categoria)
        {
            // Busca movimentações desse mes
            $aux = $this->objModelMovimentacao
                ->get(["vencimento" >= $data])
                ->rowCount();

            // Add a categoria
            $categoria->movimentacao = $aux;
        }

        // Verifica se encontrou alguma categoria
        if(!empty($categorias))
        {
            // Busca as ultimas 5 movimentacoes
            $movimentacoes = $this->objModelMovimentacao
                ->get(null, "id_movimentacao DESC", 5)
                ->fetchAll(\PDO::FETCH_OBJ);
        }

        // Dados a serem exibidos
        $dados = [
            "numEntrada" => $numEntrada,
            "numSaida" => $numSaida,
            "numMovimentacao" => $numMovimentacao,
            "numCategoria" => $numCategoria,

            "movimentacoes" => $movimentacoes,
            "categorias" => $categorias,
            "usuario" => $usuario
        ];

        // Chama a view
        $this->view("app/dashboard/admin", $dados);

    } // End >> fun::dashboardAdmin()



    /**
     * Método responsável por chamar a view de listagem
     * de movimentações e exibir como dashboard.
     * --------------------------------------------------
     * @param $usuario
     */
    public function dashboardUser($usuario)
    {
        // Exibe a dashboard
        $aux = new \Controller\Movimentacao();
        $aux->listar();

    } // End >> fun::dashboardUser()



    /**
     * Método responsável por montar a página de sair para a
     * loja e o administrador.
     * ------------------------------------------------------
     * @url /sair
     */
    public function sair()
    {
        // Destroi a session
        session_destroy();

        // Chama a página de sair
        $this->view("app/externo/sair");

    }// End >> fun::sair()


    /**
     * Método responsável por montar uma página de erro
     * 404. Buscando os dados necessários para montar
     * a exibição da mesma.
     */
    public function error404()
    {
        // View
        $this->view("error/404");

    } // End >> fun::erro404()

} // END::Class Principal