<?php

// NameSpace
namespace Controller;

// Importações
use Sistema\Controller;
use Model\Usuario;
use Helper\Apoio;

// Inicia a Classe
class Usuarios extends Controller
{
    private $objModelUsuario;

    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        $this->objModelUsuario = new Usuario();
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
        $usuarios = $this->objModelUsuario
            ->get(null, "id_usuario DESC")
            ->fetchAll(\PDO::FETCH_OBJ);
            
        // Dados a serem exibidos
        $dados = [
            "usuarios" => $usuarios,
            "usuario" => $usuario,
            "js" => ["modulos" => ["Usuario"]]
        ];

        // Chama a view
        $this->view("app/usuarios/listar", $dados);

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
        $usuarios = $this->objModelUsuario
            ->get(["id_usuario" => $id])
            ->fetch(\PDO::FETCH_OBJ);

            
        // Dados a serem exibidos
        $dados = [
            "usuarios" => $usuarios,
            "usuario" => $usuario,
            "js" => ["modulos" => ["Usuario"]]
        ];

        // Chama a view
        $this->view("app/usuarios/editar", $dados);

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
            "js" => ["modulos" => ["Usuario"]]
        ];

        // Chama a view
        $this->view("app/usuarios/adicionar", $dados);

    } // End >> fun::listar()


} // End >> class::Usuario