<?php

// NameSpace
namespace Controller;

// NameSpace
use Helper\Apoio;
use Model\Categoria;
use Sistema\Controller;

// Inicia a Classe
class Movimentacao extends Controller
{
    // Objetos
    private $objModelMovimentacao;
    private $objModelCategoria;
    private $objHelperApoio;

    // Chama o construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia os objetos
        $this->objModelMovimentacao = new \Model\Movimentacao();
        $this->objModelCategoria = new Categoria();
        $this->objHelperApoio = new Apoio();

    } // End >> fun::__construct()


    /**
     * Método responsável por listar todas as movimentações de
     * todas as categorias ou de uma especifica.
     * ----------------------------------------------------------
     * @param null $id [Id da Categoria]
     * ----------------------------------------------------------
     * @url movimentacoes/[Id]
     */
    public function listar($id = null)
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $movimentacoes = null;
        $categorias = null;
        $where = null;
        $cat = [];

        // Seguranca
        $usuario = $this->objHelperApoio->seguranca();

        // Verifica se possui where
        if(!empty($id))
        {
            // Where
            $where = ["id_categoria" => $id];
        }

        if($usuario->nivel == "usuario")
        {
            // Where
            $where["id_usuario"] = $usuario->id_usuario;
        }


        // Busca todas as categorias
        $categorias = $this->objModelCategoria
            ->get(null, "nome ASC")
            ->fetchAll(\PDO::FETCH_OBJ);

        // Percorre as categorias
        foreach ($categorias as $categoria)
        {
            // Preenche o array auxiliar
            $cat[$categoria->id_categoria] = $categoria;
        }


        // Busca as movimentações
        $movimentacoes = $this->objModelMovimentacao
            ->get($where, "id_movimentacao DESC")
            ->fetchAll(\PDO::FETCH_OBJ);

        // Percorre as movimentações
        foreach ($movimentacoes as $movi)
        {
            // Adiciona a categoria
            $movi->categoria = $cat[$movi->id_categoria];
        }

        // Where
        $where["vencimento >="] = date("Y-m-") . "01";

        // Busca as movimentações
        $numMovimentacao = $this->objModelMovimentacao
            ->get($where)
            ->rowCount();

        // Busca os valores de entrada
        $where["tipo"] = "entrada";

        $numEntrada = $this->objModelMovimentacao
            ->get($where, null, null, "SUM(valor) as total")
            ->fetch(\PDO::FETCH_OBJ);

        // Busca os valores de saida
        $where["tipo"] = "saida";

        $numSaida = $this->objModelMovimentacao
            ->get($where, null, null, "SUM(valor) as total")
            ->fetch(\PDO::FETCH_OBJ);


        if($usuario->nivel == "admin")
        {
            $js = [
                "modulos" => ["Movimentacao","Grafico"]
            ];
        }
        else
        {
            $js = [
                "modulos" => ["Movimentacao"]
            ];
        }


        // Dados a serem exibidos
        $dados = [
            "numMovimentacao" => $numMovimentacao,
            "numEntrada" => $numEntrada->total,
            "numSaida" => $numSaida->total,

            "pag" => $id,
            "movimentacoes" => $movimentacoes,
            "usuario" => $usuario,
            "categorias" => $categorias,
            "js" => $js
        ];

        // Chama a view
        $this->view("app/movimentacoes/listar", $dados);

    } // End >> fun::listar


    /**
     * Método responsável por criar a página com o formulário de
     * adição de uma nova movimentação.
     * ----------------------------------------------------------
     * @url movimentacao/adicionar
     */
    public function adicionar()
    {
        // Variaveis
        $usuario = null;
        $dados = null;
        $categorias = null;

        // Recupera o usuário logado
        $usuario = $this->objHelperApoio->seguranca();

        // Busca as categorias
        $categorias = $this->objModelCategoria
            ->get(null, "nome ASC")
            ->fetchAll(\PDO::FETCH_OBJ);

        // Retorno
        $dados = [
            "usuario" => $usuario,
            "categorias" => $categorias,
            "js" => [
                "modulos" => ["Movimentacao"]
            ]
        ];

        // View
        $this->view("app/movimentacoes/adicionar", $dados);

    } // End >> fun::adicionar()


    public function editar($id)
    {
        // Variaveis
        $usuario = null;
        $dados = null;
        $categorias = null;

        // Recupera o usuário logado
        $usuario = $this->objHelperApoio->seguranca();

        // Busca as categorias
        $categorias = $this->objModelCategoria
            ->get(null, "nome ASC")
            ->fetchAll(\PDO::FETCH_OBJ);

        $movimentacao = $this->objModelMovimentacao
            ->get(["id_movimentacao" => $id])
            ->fetch(\PDO::FETCH_OBJ);

        // Retorno
        $dados = [
            "movimentacao" => $movimentacao,
            "usuario" => $usuario,
            "categorias" => $categorias,
            "js" => [
                "modulos" => ["Movimentacao"]
            ]
        ];

        // View
        $this->view("app/movimentacoes/editar", $dados);
    }

} // End >> Class::Movimentacao