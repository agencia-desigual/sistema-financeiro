<?php

// NameSpace
namespace Controller\Api;

// Importações
use Sistema\Controller;
use Sistema\Helper\File;
use Sistema\Helper\Seguranca;

// Inicia a Categoria
class Movimentacao extends Controller
{
    // Objetos
    private $objModelMovimentacao;
    private $objModelCategoria;
    private $objSeguranca;


    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia os objetos
        $this->objModelMovimentacao = new \Model\Movimentacao();
        $this->objModelCategoria = new \Model\Categoria();
        $this->objSeguranca = new Seguranca();

    } // End >> fun::__construct()


    /**
     * Método responsável por inserir uma nova
     * movimentação financeira no sistema.
     * ---------------------------------------------------
     * @url api/movimentacao/insert
     * @method POST
     */
    public function insert()
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $salva = null;
        $usuario = null;
        $categoria = null;
        $arquivo = null;
        $post = null;
        $objeto = null;
        $caminho = "./storage/comprovante/";

        // Recupera o usuário logado
        $usuario = $this->objSeguranca->security();

        // Recupera os dados post
        $post = $_POST;

        // Verifica se informou os dados obrigatórios
        if(!empty($post["id_categoria"]) &&
            !empty($post["nome"]) &&
            !empty($post["tipo"]) &&
            !empty($post["valor"]) &&
            !empty($post["vencimento"]))
        {
            // Busca a categoria
            $categoria = $this->objModelCategoria
                ->get(["id_categoria" => $post["id_categoria"]])
                ->fetch(\PDO::FETCH_OBJ);

            // Verifica se a categoria existe
            if(!empty($categoria))
            {
                // Verifica se possui comprovante -----------
                if($_FILES["arquivo"]["size"] > 0)
                {
                    // Chama o objeto
                    $objFiles = new File();

                    // Seta as configurações
                    $objFiles->setExtensaoValida(["pdf","jpg","jpeg","png","doc","docx"]);
                    $objFiles->setMaxSize(3 * MB);
                    $objFiles->setFile($_FILES["arquivo"]);
                    $objFiles->setStorange($caminho);

                    // Verifica se a extensão é válida
                    if($objFiles->validaExtensao())
                    {
                        // Verifica se o tamanho é aceitavel
                        if($objFiles->validaSize())
                        {
                            // Realiza o upload
                            $arquivo = $objFiles->upload();

                            // Verifica se deu erro
                            if(empty($arquivo))
                            {
                                // Msg e encerra
                                $this->api(["mensagem" => "Ocorreu um erro ao fazer o upload do comprovante."]);
                            }
                        }
                        else
                        {
                            // Msg e encerra
                            $this->api(["mensagem" => "O arquivo do comprovante ultrapassa o limite de 3MB."]);

                        } // Error >> O arquivo do comprovante ultrapassa o limite de 3MB.
                    }
                    else
                    {
                        // Msg e encerra
                        $this->api(["mensagem" => "Extensão do comprovante é inválida."]);

                    } // Error >> Extensão do comprovante é inválida.
                }
                // ------------------------------------------

                // Limpa o valor
                $post["valor"] = str_replace(".","", $post["valor"]);
                $post["valor"] = str_replace(",",".", $post["valor"]);

                // Monta o array de insersão
                $salva = [
                    "id_categoria" => $categoria->id_categoria,
                    "id_usuario" => $usuario->id_usuario,
                    "nome" => $post["nome"],
                    "tipo" => $post["tipo"],
                    "valor" => $post["valor"],
                    "recorrente" => (!empty($post["recorrente"]) ? true : false),
                    "vencimento" => date("Y-m-d", strtotime($post["vencimento"])),
                    "cadastro" => date("Y-m-d H:i:s")
                ];

                // Verifica se está pago
                if(!empty($post["pago"]))
                {
                    // Informa que está pago
                    $salva["pago"] = true;
                    $salva["dataPagamento"] = (!empty($post["dataPagamento"]) ? date("Y-m-d", strtotime($post["dataPagamento"])) : date("Y-m-d"));
                }

                // Verifica se informou a descricao
                if(!empty($post["descricao"]))
                {
                    // Add ao insert
                    $salva["descricao"] = $post["descricao"];
                }

                // Verifica se informou o comprovante
                if(!empty($arquivo))
                {
                    // Adiciona ao array de insert
                    $post["comprovante"] = $arquivo;
                }


                // Insere o objeto
                $objeto = $this->objModelMovimentacao
                    ->insert($salva);

                // Verifica se inseriu
                if(!empty($objeto))
                {
                    // Busca o objeto
                    $objeto = $this->objModelMovimentacao
                        ->get(["id_movimentacao" => $objeto])
                        ->fetch(\PDO::FETCH_OBJ);

                    // Retorno de sucesso
                    $dados = [
                        "tipo" => true,
                        "code" => 200,
                        "mensagem" => "Movimentação adicionada com sucesso.",
                        "objeto" => $objeto
                    ];
                }
                else
                {
                    // Msg
                    $dados = ["mensagem" => "Ocorreu um erro ao inserir a movimentação."];
                } // Error >> Ocorreu um erro ao inserir a movimentação.
            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Categoria não existente."];

            } // Error >> Categoria não existente.
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Dados obrigatórios não informados."];

        } // Error >> Dados obrigatórios não informados.

        // Retorno
        $this->api($dados);

    } // End >> fun::insert()



    /**
     * Método responsável por alterar as informações de
     * uma movimentação financeira.
     * ---------------------------------------------------
     * @param $id [Id da movimentação]
     * ---------------------------------------------------
     * @method POST
     * @url api/movimentacao/update/[ID]
     */
    public function update($id)
    {
        // Variaveis
        $dados = null;
        $obj = null;
        $objAlterado = null;
        $post = null;
        $altera = null;
        $arquivo = null;
        $caminho = "./storage/comprovante/";

        // Recupera o usuário logado
        $this->objSeguranca->security();

        // Recupera os dados post
        $post = $_POST;

        // Recupera o item a ser alterado
        $obj = $this->objModelMovimentacao
            ->get(["id_movimentacao" => $id])
            ->fetch(\PDO::FETCH_OBJ);

        // Verifica se o item existe
        if(!empty($obj))
        {
            // Verifica se possui comprovante -----------
            if($_FILES["arquivo"]["size"] > 0)
            {
                // Chama o objeto
                $objFiles = new File();

                // Seta as configurações
                $objFiles->setExtensaoValida(["pdf","jpg","jpeg","png","doc","docx"]);
                $objFiles->setMaxSize(3 * MB);
                $objFiles->setFile($_FILES["arquivo"]);
                $objFiles->setStorange($caminho);

                // Verifica se a extensão é válida
                if($objFiles->validaExtensao())
                {
                    // Verifica se o tamanho é aceitavel
                    if($objFiles->validaSize())
                    {
                        // Realiza o upload
                        $arquivo = $objFiles->upload();

                        // Verifica se deu erro
                        if(empty($arquivo))
                        {
                            // Msg e encerra
                            $this->api(["mensagem" => "Ocorreu um erro ao fazer o upload do comprovante."]);
                        }
                    }
                    else
                    {
                        // Msg e encerra
                        $this->api(["mensagem" => "O arquivo do comprovante ultrapassa o limite de 3MB."]);

                    } // Error >> O arquivo do comprovante ultrapassa o limite de 3MB.
                }
                else
                {
                    // Msg e encerra
                    $this->api(["mensagem" => "Extensão do comprovante é inválida."]);

                } // Error >> Extensão do comprovante é inválida.
            }
            // ------------------------------------------

            // Remove dados inalteraveis
            unset($post["id_usuario"]);
            unset($post["cadastro"]);

            // Verifica se possui comprovante
            if(!empty($arquivo))
            {
                // Adiciona a alteração
                $post["comprovante"] = $arquivo;
            }

            // Altera
            if($this->objModelMovimentacao->update($post, ["id_movimentacao" => $id]) != false)
            {
                // Busca o objeto alterado
                $objAlterado = $this->objModelMovimentacao
                    ->get(["id_movimentacao" => $id])
                    ->fetch(\PDO::FETCH_OBJ);

                // Verifica se alterou o comprovante
                if(!empty($arquivo))
                {
                    // Verifica se possuia comprovante antes
                    if(!empty($obj->comprovante))
                    {
                        // Deleta o antigo
                        unlink($caminho . $obj->comprovante);
                    }
                }

                // Retorno
                $dados = [
                    "tipo" => true,
                    "code" => 200,
                    "mensagem" => "Informações atualizadas com sucesso.",
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
            $dados = ["mensagem" => "A movimentação informada não existe."];

        } // Error >> A movimentação informada não existe.

        // Retorno
        $this->api($dados);

    } // End >> fun::update()



    /**
     * Método responsável por deletar uma determinada
     * movimentação e seu respectivo comprovante.
     * ---------------------------------------------------
     * @param $id [Id da movimentação]
     * ---------------------------------------------------
     * @method POST
     * @url api/movimentacao/delete/[ID]
     */
    public function delete($id)
    {
        // Variaveis
        $dados = null;
        $obj = null;

        // Seguranca
        $this->objSeguranca->security();

        // Busca o objeto
        $obj = $this->objModelMovimentacao
            ->get(["id_movimentacao" => $id])
            ->fetch(\PDO::FETCH_OBJ);

        // Verifica se encontrou
        if(!empty($obj))
        {
            // Deleta
            if($this->objModelMovimentacao->delete(["id_movimentacao" => $id]) != false)
            {
                // Verifica se possuia comprovante
                if(!empty($obj->comprovante))
                {
                    // deleta o comprovante
                    unlink("./storage/comprovante/" . $obj->comprovante);
                }

                // Retorno
                $dados = [
                    "tipo" => true,
                    "code" => 200,
                    "mensagem" => "Item deletado com sucesso."
                ];

            }
            else
            {
                // Msg
                $dados = ["mensagem" => "Ocorreu um erro ao deletar movimentação."];

            } // Error >> Ocorreu um erro ao deletar movimentação
        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Movimentação informada não foi encontrada."];

        } // Error >> Movimentação informada não foi encontrada.

        // Api
        $this->api($dados);

    } // End >> fun::delete()

} // End >> Class::Movimentacao