<?php $this->view("app/include/header"); ?>

    <!-- ============================================================== -->
    <!-- INICIO adicionar categoria -->
    <!-- ============================================================== -->
    <div style="margin-top:150px" class="content-page">
        <div class="content">
            <div class="container-fluid">

                <!-- BREADCUMP -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">Adicionar Categoria</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><?= SITE_NOME ?></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>categorias">Categorias</a></li>
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

                                <h4 class="mt-0 header-title">Cadastrar Categoria</h4>
                                <p class="sub-title">Cadastre uma novo categoria, e vincule ela nas suas contas.</p>

                                <form id="formInserirCategoria" data-alerta="swal">

                                    <!-- NOME -->
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <label>Nome</label>
                                                <input type="text" class="form-control" name="nome" value="" required/>
                                            </div>

                                        </div>
                                    </div> 

                                    <!-- DESCRIÇÃO -->
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <label>Descrição</label>
                                                <textarea name="descricao" rows="3" class="form-control"></textarea>
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
    <!-- FIM adicionar categoria -->
    <!-- ============================================================== -->

<?php $this->view("app/include/footer"); ?>

<script>

    $(document).ready(function(){

        // Basic
        $('.dropify').dropify();

    });

</script>