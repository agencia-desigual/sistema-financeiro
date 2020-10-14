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


        // Dados a serem exibidos
        $dados = [
            "numMovimentacao" => $numMovimentacao,
            "numEntrada" => $numEntrada->total,
            "numSaida" => $numSaida->total,

            "pag" => $id,
            "movimentacoes" => $movimentacoes,
            "usuario" => $usuario,
            "categorias" => $categorias,
            "js" => [
                "modulos" => ["Movimentacao"]
            ]
        ];

        // Chama a view
        $this->view("app/movimentacoes/listar", $dados);

    } // End >> fun::listar


} // End >> Class::Movimentacao