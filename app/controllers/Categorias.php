<?php

// NameSpace
namespace Controller;

// Importações
use Sistema\Controller;
use Model\Categoria;
use Helper\Apoio;

// Inicia a Classe
class Categorias extends Controller
{
    private $objModelUsuario;

    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        $this->objModelCategoria = new Categoria();
        $this->objHelperApoio = new Apoio();

    } // End >> fun::__construct()



     /**
     * Método responsável por buscar todas os usuarios
     * e fazer a listagem deles para a data table.
     * --------------------------------------------------
     */
    public function listar()
    {
        // Variaveis
        $dados = null;
        $usuarios = null;

        // Recupera o usuário
        $usuario = $this->objHelperApoio->seguranca();

        // Busca todos os usuários
        $categorias = $this->objModelCategoria
            ->get(null, "id_categoria DESC")
            ->fetchAll(\PDO::FETCH_OBJ);

        // Dados a serem exibidos
        $dados = [
            "categorias" => $categorias,
            "usuario" => $usuario,
            "js" => ["modulos" => ["Categoria"]]
        ];

        // Chama a view
        $this->view("app/categorias/listar", $dados);

    } // End >> fun::listar()



     /**
     * Método responsável por buscar o usuario
     * selecionado e buscar a informações dele
     * --------------------------------------------------
     */
    public function editar($id)
    {
        // Variaveis
        $dados = null;
        $usuario = null;

        // Recupera o usuário
        $usuario = $this->objHelperApoio->seguranca();

        // Busca todos o usuário
        $categoria = $this->objModelCategoria
            ->get(["id_categoria" => $id])
            ->fetch(\PDO::FETCH_OBJ);

            
        // Dados a serem exibidos
        $dados = [
            "categoria" => $categoria,
            "usuario" => $usuario,
            "js" => ["modulos" => ["Categoria"]]
        ];

        // Chama a view
        $this->view("app/categorias/editar", $dados);

    } // End >> fun::listar()



     /**
     * Método responsável por carregar a view
     * de adicionar
     * --------------------------------------------------
     */
    public function adicionar()
    {
        // Variaveis
        $dados = null;
        
        // Recupera o usuário
        $usuario = $this->objHelperApoio->seguranca();

        // Dados a serem exibidos
        $dados = [
            "usuario" => $usuario,
            "js" => ["modulos" => ["Categoria"]]
        ];

        // Chama a view
        $this->view("app/categorias/adicionar", $dados);

    } // End >> fun::adicionar()


} // End >> class::Usuario