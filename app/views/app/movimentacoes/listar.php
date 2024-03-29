<?php $this->view("app/include/header"); ?>

<div class="wrapper">
    <div class="container-fluid">

        <div class="row pt-4 pb-4">
            <div class="col-sm-12 col-md-7 col-lg-4">
                <label>Selecione a categoria que deseja administrar</label>
                <select id="selectCategoria" class="form-control">
                    <option <?= empty($pag) ? "selected" : ""; ?> value="<?= BASE_URL; ?>movimentacoes">Todas as Categorias</option>

                    <?php foreach ($categorias as $cat): ?>
                        <option <?= ($cat->id_categoria == $pag) ? "selected" : ""; ?> value="<?= BASE_URL; ?>movimentacoes/<?= $cat->id_categoria; ?>"><?= $cat->nome; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if($usuario->nivel == "admin"): ?>
            <input id="idMes" value="<?= $pag; ?>" type="hidden" />

            <div class="row">

                <div class="col-sm-6 col-xl-4">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-cash-multiple bg-success text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Entradas</h5>
                            </div>
                            <h3 class="mt-4">R$ <?= number_format($numEntrada, 2, ",", "."); ?></h3>
                            <p class="text-muted mt-2 mb-0">Apenas esse mês</p>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-xl-4">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-cash-multiple bg-danger text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Saídas</h5>
                            </div>
                            <h3 class="mt-4">R$ <?= number_format($numSaida, 2, ",", "."); ?></h3>
                            <p class="text-muted mt-2 mb-0">Apenas esse mês</p>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-xl-4">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-chart-line  bg-primary text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Movimentações</h5>
                            </div>
                            <h3 class="mt-4"><?= $numMovimentacao; ?></h3>
                            <p class="text-muted mt-2 mb-0">Apenas esse mês</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title mb-4">Resumo Anual</h4>

                            <div id="graficoMeses" class="morris-charts morris-chart-height"></div>

                        </div>
                    </div>
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        <?php endif; ?>

        <!-- START ROW -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-4">Movimentações</h4>
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Pago</th>
                                        <th scope="col">Vencimento</th>
                                        <th scope="col">Comprovante</th>
                                        <th scope="col">Açao</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($movimentacoes)): ?>
                                        <?php foreach ($movimentacoes as $movi): ?>
                                            <tr id="tb_<?= $movi->id_movimentacao; ?>">
                                                <td><?= $movi->nome; ?></td>
                                                <td><?= $movi->categoria->nome; ?></td>
                                                <td>R$ <?= number_format($movi->valor, 2, ",", ".") ?></td>
                                                <td>
                                                    <?php if($movi->tipo == "entrada"): ?>
                                                        <span class="badge badge-success">ENTRADA</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">SAÍDA</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php if($movi->pago == true): ?>
                                                        <span class="badge badge-success">PAGO</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-warning">AGUARDANDO PAGAMENTO</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= date("d/m/Y", strtotime($movi->vencimento)); ?></td>

                                                <td>
                                                    <?php if(!empty($movi->comprovante)): ?>
                                                        <a href="<?= $movi->comprovante; ?>" download class="btn btn-primary btn-sm">Download</a>
                                                    <?php else: ?>
                                                        Não possui
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <a href="<?= BASE_URL; ?>movimentacao/editar/<?= $movi->id_movimentacao; ?>" class="btn btn-primary btn-sm">Alterar</a>
                                                    <a href="#" data-id="<?= $movi->id_movimentacao; ?>" class="deletarMovimentacao btn btn-danger btn-sm">Excluir</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- END ROW -->

    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->


<!-- Inclui o Footer =================================== -->
<?php $this->view("app/include/footer"); ?>


</body>
</html>