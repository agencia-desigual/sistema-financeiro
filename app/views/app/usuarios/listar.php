<?php $this->view('app/include/header'); ?>

    <!-- ============================================================== -->
    <!-- INICIO da listagem de administradores -->
    <!-- ============================================================== -->
    <div style="margin-top: 150px" class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- BREADCUMP -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">Usuários</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><?= SITE_NOME ?></a></li>
                                <li class="breadcrumb-item active">Usuários</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- FIM BREADCUMP -->

                <!-- ADMINISTRADORES -->
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">TODOS OS USUÁRIOS</h4>
                                <p class="sub-title../plugins">Gerencie todos os usuários.
                                </p>

                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th scope="col">NOME</th>
                                        <th scope="col">EMAIL</th>
                                        <th class="text-center" scope="col">NÍVEL</th>
                                        <th class="text-center" scope="col">STATUS</th>
                                        <th class="text-center" scope="col">AÇÕES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($usuarios as $admin) : ?>
                                        <tr id="tb_<?= $admin->id_usuario ?>">
                                            <td><?= $admin->nome ?></td>
                                            <td><?= $admin->email ?></td>
                                            <td class="text-center">
                                                <?php if($admin->nivel == "admin"): ?>
                                                    <span class="badge badge-primary p-2 font-12">ADMINISTRADOR</span>
                                                <?php else: ?>
                                                    <span class="badge badge-primary p-2 font-12">USUÁRIO</span>
                                                <?php endif; ?>
                                            </td>

                                            <?php if ($admin->status == 1) : ?>
                                                <td class="text-center"><span class="badge badge-success p-2 font-12">ATIVO</span></td>
                                            <?php else: ?>
                                                <td class="text-center"><span class="badge badge-danger p-2 font-12">INATIVO</span></td>
                                            <?php endif; ?>

                                            <td class="text-center">
                                                <button <?= ($usuario->id_usuario == $admin->id_usuario) ? 'style="display:none;"' : ''?>
                                                        data-id="<?= $admin->id_usuario; ?>"
                                                        data-titulo="Deletar Administrador"
                                                        data-texto="Caso esse administrador seja deletado o seu histórico será deletado também."
                                                        class="deletarUsuario btn btn-danger btn-icon btn-sm mr-2"
                                                        data-toggle="tooltip" data-original-title="Deletar">
                                                    <i class="fas fa-window-close"></i>
                                                </button>
                                                <a href="<?= BASE_URL; ?>usuario/editar/<?= $admin->id_usuario; ?>" class="btn btn-primary btn-icon btn-sm" data-toggle="tooltip" data-original-title="Alterar">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM CLIENTES -->

            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->


    </div>
    <!-- ============================================================== -->
    <!-- FIM da listagem -->
    <!-- ============================================================== -->

<?php $this->view('app/include/footer'); ?>
