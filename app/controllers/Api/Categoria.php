<?php

// NameSpace
namespace Controller\Api;

// Importações
use Model\Movimentacao;
use Sistema\Controller;
use Sistema\Helper\Seguranca;

// Inicia a Classe
class Categoria extends Controller
{
    // Variaveis
    private $objModelCategoria;
    private $objModelMovimentacao;
    private $objSeguranca;

    // Método construtor
    public function __construct()
    {
        // Inicia o pai
        parent::__construct();

        // Instancia os objetos
        $this->objModelCategoria = new \Model\Categoria();
        $this->objModelMovimentacao = new Movimentacao();
        $this->objSeguranca = new Seguranca();

    } // End >> fun::__construct()



    /**
     * Método responsável por inserir uma nova categoria
     * no sistema, verificando se o usuário está logado e
     * seja admin.
     * ----------------------------------------------------
     * @url api/categoria/insert
     * @method POST
     */
    public function insert()
    {
        // Variaveis
        $salva = null;
        $post = null;
        $obj = null;
        $usuario = null;

        // Recupera o usuário logado
        $usuario = $this->objSeguranca->security();

        // Recupera os dados post
        $post = $_POST;

        // Verifica se informou os dados obrigatórios
        if(!empty($post["nome"]) &&
            !empty($post["descricao"]))
        {
            // Verifica se possui permissão
            if($usuario->nivel == "admin")
            {
                // Cria o array de inserção
                $salva = [
                    "nome" => $post["nome"],
                    "descricao" => $post["descricao"]
                ];

                // Insere
                $obj = $this->objModelCategoria
                    ->insert($salva);

                // Verifica se inseriu
                if(!empty($obj))
                {
                    // Busca o objeto
                    $obj = $this->objModelCategoria
                        ->get(["id_categoria" => $obj])
                        ->fetch(\PDO::FETCH_OBJ);

                    // Retorno
                    $dados = [
                        "tipo" => true,
                        "code" => 200,
                        "mensagem" => "Categoria inserida com sucesso.",
                        "objeto" => $obj
                    ];
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Ocorreu um erro ao inserir a categoria."];

                } // Error >> Ocorreu um erro ao inserir a categoria.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Usuário sem permissão."];

            } // Error >> Usuário sem permissão.
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Campos obrigatórios não informados."];

        } // Error >> Campos obrigatórios não informados.

        // Retorno
        $this->api($dados);

    } // End >> fun::insert()



    /**
     * Método responsável por alterar as informações de
     * uma categoria já existente no sistema.
     * ----------------------------------------------------
     * @param $id [Id da Categoria]
     * ----------------------------------------------------
     * @url api/categoria/update/[ID]
     * @method POST
     */
    public function update($id)
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $obj = null;
        $objAlterado = null;
        $post = null;

        // Recupera o usuário
        $usuario = $this->objSeguranca->security();

        // Recupera os dados post
        $post = $_POST;

        // Verifica se possui permissão
        if($usuario->nivel == "admin")
        {
            // Busca o objeto
            $obj = $this->objModelCategoria
                ->get(["id_categoria" => $id])
                ->fetch(\PDO::FETCH_OBJ);

            // Verifica se encontrou
            if(!empty($obj))
            {
                // Verifica se vai alterar algo
                if(!empty($post))
                {
                    // Altera
                    if($this->objModelCategoria->update($post, ["id_categoria" => $id]) != false)
                    {
                        // Busca o objeto alterado
                        $objAlterado = $this->objModelCategoria
                            ->get(["id_categoria" => $id])
                            ->fetch(\PDO::FETCH_OBJ);

                        // Retorno
                        $dados = [
                            "tipo" => true,
                            "code" => 200,
                            "mensagem" => "Categoria alterada com sucesso.",
                            "objeto" => [
                                "antes" => $obj,
                                "atual" => $objAlterado
                            ]
                        ];
                    }
                    else
                    {
                        // Msg
                        $dados = ["mensagem" => "Ocorreu um erro ao alterar a categoria."];
                    } // Error >> Ocorreu um erro ao alterar a categoria.
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Nada está sendo alterado."];

                } // Error >> Nada está sendo alterado.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Categoria informada não foi encontrada."];

            } // Error >> Categoria informada não foi encontrada.
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Usuário sem permissão."];

        } // Error >> Usuário sem permissão.

        // retorno
        $this->api($dados);

    } // End >> fun::update()



    /**
     * Método responsável por deletar uma determinada
     * categoria do sistema, Apenas admins podem
     * realizar essa ação.
     * ----------------------------------------------------
     * @param $id [Id categoria]
     * ----------------------------------------------------
     * @url api/categoria/delete/[ID]
     * @method DELETE
     */
    public function delete($id)
    {
        // Veriaveis
        $dados = null;
        $usuario = null;
        $obj = null;

        // Recupera o usuário
        $usuario = $this->objSeguranca->security();

        // Verifica se possui permissão
        if($usuario->nivel == "admin")
        {
            // Busca o objeto
            $obj = $this->objModelCategoria
                ->get(["id_categoria" => $id])
                ->fetch(\PDO::FETCH_OBJ);

            // Verifica se encontrou
            if(!empty($obj))
            {
                // Verifica se possui vinculações
                if($this->objModelMovimentacao->get(["id_categoria" => $id])->rowCount() == 0)
                {
                    // Deleta
                    if($this->objModelCategoria->delete(["id_categoria" => $id]) != false)
                    {
                        // Retorno
                        $dados = [
                            "tipo" => true,
                            "code" => 200,
                            "mensagem" => "Categoria deletada com sucesso.",
                            "objeto" => $obj
                        ];
                    }
                    else
                    {
                        // Msg
                        $dados = ["mensagem" => "Ocorreu um erro ao deletar a categoria."];
                    } // Error >> Ocorreu um erro ao deletar a categoria.
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Impossível deletar, essa categoria possui movimentações."];
                } // Error >> Impossível deletar, essa categoria possui movimentações.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Categoria não encontrada."];

            } // Error >> Categoria não encontrada.
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Usuário sem permissão."];

        } // Error >> Usuário sem permissão.

        // Retorno
        $this->api($dados);

    } // End >> fun::delete()


} // End >> class::Categoria