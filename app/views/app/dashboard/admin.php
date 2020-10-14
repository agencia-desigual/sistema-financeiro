<?php $this->view("app/include/header"); ?>

    <div class="wrapper">
        <div class="container-fluid">

            <div class="row pt-4">

                <div class="col-sm-6 col-xl-3">
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


                <div class="col-sm-6 col-xl-3">
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


                <div class="col-sm-6 col-xl-3">
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


                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-buffer bg-info text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Categorias</h5>
                            </div>
                            <h3 class="mt-4"><?= $numCategoria; ?></h3>
                            <p class="text-muted mt-2 mb-0">Ativas</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title mb-4">Movimentações</h4>

                            <div id="morris-area-example" class="morris-charts morris-chart-height"></div>

                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Entrada e Saída</h4>

                            <div id="morris-donut-example" class="morris-charts morris-chart-height"></div>

                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row">

                <div class="col-xl-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">
                                Categorias
                            </h4>

                            <div class="friends-suggestions">

                                <?php if(!empty($categorias)): ?>
                                    <?php foreach ($categorias as $cat): ?>
                                        <a href="<?= BASE_URL; ?>categoria/alterar/<?= $cat->id_categoria; ?>" class="friends-suggestions-list">
                                            <div class="border-bottom position-relative">
                                                <div class="suggestion-icon float-right mt-2 pt-1">
                                                    <i class="mdi mdi-plus"></i>
                                                </div>

                                                <div class="desc">
                                                    <h5 class="font-14 mb-1 pt-2 text-dark"><?= $cat->nome; ?></h5>
                                                    <p class="text-muted"><?= $cat->movimentacao; ?> movimentações esse mês</p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Nunhuma categoria cadastrada.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <h4 class="mt-0 header-title mb-4">Movimentações</h4>

                            <?php if(!empty($movimentacoes)): ?>
                                <ol class="activity-feed mb-0">
                                    <?php foreach ($movimentacoes as $movi): ?>
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <p class="text-muted mb-1"><?= date("d/m/Y", strtotime($movi->cadastro)); ?></p>
                                                <p class="font-15 mt-0 mb-0">
                                                    <?= ($movi->tipo == "entrada") ? "Entrada no valor de " : "Saída no valor de "; ?>
                                                    <b class="text-primary">R$ <?= number_format($movi->valor, 2, ",", "."); ?></b>
                                                </p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ol>
                            <?php else: ?>
                                <p>Nunhuma movimentação cadastrada.</p>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->


<!-- Inclui o Footer =================================== -->
<?php $this->view("app/include/footer"); ?>


</body>
</html>