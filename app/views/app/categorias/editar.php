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
                            <h4 class="page-title">Editar Categoria</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><?= SITE_NOME ?></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>categorias">Categorias</a></li>
                                <li class="breadcrumb-item active">Editar</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- FIM BREADCUMP -->

                <?php if(!empty($categoria)) : ?>

                  <div class="row">
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Editar Categoria</h4>
                                <p class="sub-title">Edite uma categoria</p>

                                <form id="formAlteraCategoria" data-alerta="swal" data-id="<?= $categoria->id_categoria ?>">

                                    <!-- NOME -->
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <label>Nome Completo</label>
                                                <input type="text" class="form-control" name="nome" value="<?= $categoria->nome ?>" required/>
                                            </div>

                                        </div>
                                    </div>

                                   <!-- DESCRIÇÃO -->
                                   <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <label>Descrição</label>
                                                <textarea class="form-control" name="descricao" rows="3"><?= $categoria->descricao ?></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary float-right">Alterar</button>

                                </form>

                            </div>
                        </div>
                    </div>
                  </div>

                <?php endif; ?>

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