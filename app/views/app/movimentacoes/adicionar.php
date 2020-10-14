<?php $this->view("app/include/header"); ?>

    <!-- ============================================================== -->
    <!-- INICIO adicionar usuario -->
    <!-- ============================================================== -->
    <div style="margin-top:150px" class="content-page">
        <div class="content">
            <div class="container-fluid">

                <!-- BREADCUMP -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">Adicionar Movimentação</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><?= SITE_NOME ?></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>movimentacoes">Movimentações</a></li>
                                <li class="breadcrumb-item active">Adicionar</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- FIM BREADCUMP -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Cadastrar uma Movimentação</h4>
                                <p class="sub-title">Cadastre uma movimentação de entrada ou saída.</p>

                                <form id="formInserirMovimentacao" data-alerta="swal">

                                    <!-- NOME E EMAIL -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Categoria</label>
                                                <select class="form-control" required name="id_categoria">
                                                    <option selected disabled>Selecione</option>
                                                    <?php foreach ($categorias as $cat): ?>
                                                        <option value="<?= $cat->id_categoria; ?>">
                                                            <?= $cat->nome; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>


                                            <div class="col-md-6">
                                                <label>Tipo</label>
                                                <select class="form-control" required name="tipo">
                                                    <option selected disabled>Selecione</option>
                                                    <option value="entrada">Entrada</option>
                                                    <option value="saida">Saída</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- NOME E VALOR -->
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <label>Nome da Movimentação</label>
                                                <input type="text" class="form-control" placeholder="Ex: Aluguel" name="nome" required/>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Valor</label>
                                                <input type="text" class="form-control maskValor" name="valor" required />
                                            </div>
                                        </div>
                                    </div>


                                    <!-- VENCIMENTO E SITUAÇÃO -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Data de Vencimento</label>
                                                <input type="date" class="form-control" name="vencimento" required/>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Situação</label>
                                                <select name="pago" class="form-control">
                                                    <option value="1">Pago</option>
                                                    <option value="0">Aguardando Pagamento</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- RECORRENTE E COMPROVANTE -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Recorrência</label>
                                                <select name="recorrente" required class="form-control">
                                                    <option selected disabled>Selecione</option>
                                                    <option value="1">Sim</option>
                                                    <option value="0">Não</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Comprovante</label>
                                                <input type="file" name="arquivo" class="form-control" />
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-primary float-right">Cadastrar</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- FIM adicionar usuario -->
    <!-- ============================================================== -->

<?php $this->view("app/include/footer"); ?>

<script>

    $(document).ready(function(){

        // Basic
        $('.dropify').dropify();

    });

</script>