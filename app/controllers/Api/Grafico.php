<?php

// NameSpace
namespace Controller\Api;

// Importação
use Sistema\Controller;
use Sistema\Helper\Seguranca;

// Classe
class Grafico extends Controller
{
    // Objeto
    private $objModelCategoria;
    private $objModelMovimentacao;
    private $objSeguranca;

    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia objetos
        $this->objModelCategoria = new \Model\Categoria();
        $this->objModelMovimentacao = new \Model\Movimentacao();
        $this->objSeguranca = new Seguranca();

    } // End >> fun::__construct()


    // grafico mes
    public function graficoMes($id = null)
    {
        // Variaveis
        $dados = null;
        $grafico = null;
        $usuario = null;
        $where = null;
        $arrayData = null;

        // Recupera o usuário
        $usuario = $this->objSeguranca->security();

        // Veja se tem permissão
        if($usuario->nivel == "admin")
        {
            // Configura o array de meses
            $arrayMesses = [
                1 => "Jan",
                2 => "Fev",
                3 => "Mar",
                4 => "Abr",
                5 => "Mai",
                6 => "Jun",
                7 => "Jul",
                8 => "Ago",
                9 => "Set",
                10 => "Out",
                11 => "Nov",
                12 => "Dez"
            ];

            // Where
            if(!empty($id))
            {
                // Monta o where
                $where = ["id_categoria" => $id];
            }

            // Percorre os 12 messes
            for ($i = 1; $i <= 12; $i++)
            {
                $where["YEAR(vencimento)"] = date("Y");
                $where["MONTH(vencimento)"] = $i;
                $where["tipo"] = "entrada";

                // Zera o auxiliar
                $arrayAux = null;

                // Busca as vendas desse mes
                $entrada = $this->objModelMovimentacao
                    ->get(
                        $where,
                        null,
                        null,
                        "SUM(valor) as total"
                    )
                    ->fetch(\PDO::FETCH_OBJ);

                // Where
                $where["tipo"] = "saida";

                $saida = $this->objModelMovimentacao
                    ->get(
                        $where,
                        null,
                        null,
                        "SUM(valor) as total"
                    )
                    ->fetch(\PDO::FETCH_OBJ);

                // Add o valor como 0
                $arrayAux["entrada"] = (!empty($entrada->total)) ? $entrada->total : 0;
                $arrayAux["saida"] = (!empty($saida->total)) ? $saida->total : 0;

                // Adiciona o periodo
                $arrayAux["periodo"] = $arrayMesses[$i];

                // Add ao array oficial
                $arrayData[] = $arrayAux;
            }


            // Monta o array de retorno
            $dados = [
                "tipo" => true,
                "code" => 200,
                "objeto" => $arrayData
            ];

        }
        else
        {
            // Msg
            $dados = ["mensagem" => "Usuário sem permissão."];

        } // Error >> Usuário sem permissão.

        // Retorno
        $this->api($dados);

    } // End >> fun::graficoMes()

} // End >> Class::Grafico