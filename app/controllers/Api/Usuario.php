<?php

// NameSpace
namespace Controller\Api;

// Importações
use Model\Movimentacao;
use Sistema\Controller;
use Sistema\Helper\Seguranca;

// Inicia a Classe
class Usuario extends Controller
{
    // Objeto
    private $objModelUsuario;
    private $objModelMovimentacao;
    private $objSeguranca;

    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia os objetos
        $this->objModelUsuario = new \Model\Usuario();
        $this->objModelMovimentacao = new Movimentacao();
        $this->objSeguranca = new Seguranca();

    } // End >> fun::__construct()


    /**
     * Método responsável por realizar o login de um
     * determinado usuário, independente do seu nivel.
     * -----------------------------------------------
     * @url api/usuario/login
     * @method POST
     */
    public function login()
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $token = null;
        $dadosLogin = null;

        // Recupera os dados de login
        $dadosLogin = $this->objSeguranca->getDadosLogin();

        // Criptografa a senha
        $dadosLogin["senha"] = md5($dadosLogin["senha"]);

        // Busca o usuário
        $usuario = $this->objModelUsuario
            ->get(["email" => $dadosLogin["usuario"], "senha" => $dadosLogin["senha"]])
            ->fetch(\PDO::FETCH_OBJ);

        // Verifica se encontrou o usuário
        if(!empty($usuario))
        {
            // Verifica se está ativo
            if($usuario->status == true)
            {
                // Gera um token
                $token = $this->objSeguranca->getToken($usuario->id_usuario);

                // Verifica se gerou o token
                if($token != false)
                {
                    // Remove a senha
                    unset($usuario->senha);

                    // Salva a session
                    $_SESSION["usuario"] = $usuario;
                    $_SESSION["token"] = $token;

                    // Array de retorno
                    $dados = [
                        "tipo" => true,
                        "code" => 200,
                        "mensagem" => "Sucesso! Aguarde...",
                        "objeto" => [
                            "usuario" => $usuario,
                            "token" => $token
                        ]
                    ];
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Ocorre um erro ao conceder um token de acesso."];
                } // Error >> Ocorre um erro ao conceder um token de acesso.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Sua conta está desativada, entre em contato com o suporte para mais informações"];
            } // Error >> Conta desativada.
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "E-mail ou senha informados estão incorretos."];

        } // Error >> Dados de login estão incorretos.

        // Retorno
        $this->api($dados);

    } // End >> fun::login()



    /**
     * Método responsável por buscar os dados atualizados
     * de um usuário logado e atualizar a session do mesmo.
     * -----------------------------------------------------
     * @author igorcacerez
     * -----------------------------------------------------
     * @method POST
     * @url api/usuario/session-refresh
     */
    public function sessionRefresh()
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $usuarioAtualiza = null;

        // Recupera o usuário logado
        $usuario = $this->objSeguranca->security();

        // Deleta as sessions existentes
        unset($_SESSION["usuario"]);

        // Busca os dados atualizados do usuário
        $usuarioAtualiza = $this->objModelUsuario
            ->get(["id_usuario" => $usuario->id_usuario])
            ->fetch(\PDO::FETCH_OBJ);

        // Remove a senha
        unset($usuarioAtualiza->senha);

        // Atualiza os dados na session
        $_SESSION["usuario"] = $usuarioAtualiza;

        // Array de retorno
        $dados = [
            "tipo" => true,
            "code" => 200,
            "objeto" => [
                "usuario" => $usuarioAtualiza
            ]
        ];

        // Retorno
        $this->api($dados);

    } // End >> fun::sessionRefresh()



    /**
     * Método responsável por adicionar um novo usuário no banco
     * de dados, verificando se todos os campos obrigatórios
     * foram informados.
     * --------------------------------------------------------------
     * @url api/usuario/insert
     * @url POST
     */
    public function insert()
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $obj = null;
        $post = null;

        // Recupera os dados post
        $post = $_POST;

        // Recupera o usuário cadastrado
        $usuario = $this->objSeguranca->security();

        // Verifica se o usuário possui permissão
        if($usuario->nivel == "admin")
        {
            // Verifica se informou os dados obrigatórios
            if(!empty($post["nome"]) &&
                !empty($post["email"]) &&
                !empty($post["senha"]) &&
                !empty($post["nivel"]))
            {
                // Criptografa a senha
                $post["senha"] = md5($post["senha"]);

                // Insere o usuário
                $obj = $this->objModelUsuario
                    ->insert($post);

                // Verifica se inseriu
                if(!empty($obj))
                {
                    // Busca o usuário inserido
                    $obj = $this->objModelUsuario
                        ->get(["id_usuario" => $obj])
                        ->fetch(\PDO::FETCH_OBJ);

                    // Retorno
                    $dados = [
                        "tipo" => true,
                        "code" => 200,
                        "mensagem" => "Usuário cadastrado com sucesso.",
                        "objeto" => $obj
                    ];
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Ocorreu um erro ao cadastrar usuário."];
                } // Error >> Ocorreu um erro ao cadastrar usuário.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Dados obrigátorios não informados."];
            } // Error >> Dados obrigátorios não informados.
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Usuário sem permissão."];
        } // Error >> Usuário sem permissão.

        // Retorno
        $this->api($dados);

    } // End >> fun::insert()



    /**
     * Método responsável por alterar as informações de um determinado
     * usuário já cadastrado no banco de dados.
     * -----------------------------------------------------------------
     * @param $id [Id do usuário]
     * -----------------------------------------------------------------
     * @url api/usuario/update/[ID]
     * @method POST
     */
    public function update($id)
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $put = null;
        $obj = null;
        $objAlterado = null;

        // Seguranca
        $usuario = $this->objSeguranca->security();

        // Recupera os dados put
        $post = $_POST;

        // Busca o usuário a ser alterado
        $obj = $this->objModelUsuario
            ->get(["id_usuario" => $id])
            ->fetch(\PDO::FETCH_OBJ);

        // Verifica se encontrou o usuário
        if(!empty($obj))
        {
            // Verifica se o usuário possui permissão
            if($usuario->nivel == "admin" || $obj->id_usuario == $usuario->id_usuario)
            {
                // Verifica se não é admin
                if($usuario->nivel != "admin")
                {
                    // Deleta as informações que não podem ser alteradas
                    unset($post["status"]);
                    unset($post["nivel"]);
                }

                // Verifica se vai alterar a senha
                if(!empty($post["senha"]) && !empty($post["repete_senha"]))
                {
                    // Verifica se não são parecidos
                    if($post["senha"] != $post["repete_senha"])
                    {
                        // Avisa que não são identicas
                        $this->api(["mensagem" => "Senhas informadas não são idênticas."]);
                    }

                    // Criptografa a senha
                    $post["senha"] = md5($post["senha"]);
                }

                // Remove o repete senha
                unset($post["repete_senha"]);


                // Altera e verifica
                if($this->objModelUsuario->update($post, ["id_usuario" => $id]) != false)
                {
                    // Busca o objeto alterado
                    $objAlterado = $this->objModelUsuario
                        ->get(["id_usuario" => $id])
                        ->fetch(\PDO::FETCH_OBJ);

                    // Retorno sucesso
                    $dados = [
                        "tipo" => true,
                        "code" => 200,
                        "mensgaem" => "Informações alteradas com sucesso.",
                        "objeto" => [
                            "antes" => $obj,
                            "atual" => $objAlterado
                        ]
                    ];
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Ocorreu um erro ao alterar as informações."];

                } // Error >> Ocorreu um erro ao alterar as informações.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Você não possui permissão para essa ação."];
            } // Error >> Verifica se o usuário possui permissão
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Usuário informado não encontrado."];
        } // Error >> Usuário informado não encontrado.

        // Retorno
        $this->api($dados);

    } // End >> fun::update()



    /**
     * Método responsável por deletar um usuário cujo seu nivel seja
     * admin ou ativar/desativar cujo seu nivel seja diferente.
     * ----------------------------------------------------------------
     * @param $id [Id do usuário]
     * -----------------------------------------------------------------
     * @url api/usuario/delete/[ID]
     * @method DELETE
     */
    public function delete($id)
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $obj = null;

        // Seguranca
        $usuario = $this->objSeguranca->security();

        // Busca o usuário a ser deletado
        $obj = $this->objModelUsuario
            ->get(["id_usuario" => $id])
            ->fetch(\PDO::FETCH_OBJ);

        // Verifica se o usuário existe
        if(!empty($obj))
        {
            // Verifica se o usuário possui permissão para deletar
            if($usuario->nivel == "admin")
            {
                // Verifica se possui movimentação
                if($this->objModelMovimentacao->get(["id_usuario" => $id])->rowCount() == 0)
                {
                    // Deleta
                    if($this->objModelUsuario->delete(["id_usuario" => $id]) != false)
                    {
                        // Array de sucesso
                        $dados = [
                            "tipo" => true,
                            "code" => 200,
                            "mensagem" => "Usuário deletado com sucesso.",
                            "objeto" => $obj
                        ];
                    }
                    else
                    {
                        // Msg
                        $dados = ["mensagem" => "Ocorreu um erro ao deletar o usuário."];
                    } // Error >> Ocorreu um erro ao deletar o usuário.
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Impossivel deletar, esse usuário possui vinculações."];
                } // Error >> Impossivel deletar, esse usuário possui vinculações.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Usuário sem permissão"];
            } // Error >> Usuário sem permissão
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Usuário informado não existe"];
        } // Error >> Usuário informado não existe

        // Retorno
        $this->api($dados);

    } // End >> fun::delete()



} // End >> Class::Usuario