<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?= SITE_NOME; ?> - Sistema Financeiro</title>
    <link rel="shortcut icon" href="<?= BASE_URL; ?>assets/theme/painel/images/favicon.ico">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/theme/painel/plugins/morris/morris.css">

    <link href="<?= BASE_URL; ?>assets/theme/painel/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= BASE_URL; ?>assets/theme/painel/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="<?= BASE_URL; ?>assets/theme/painel/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= BASE_URL; ?>assets/theme/painel/css/style.css" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link href="<?= BASE_URL; ?>assets/theme/painel/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= BASE_URL; ?>assets/theme/painel/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= BASE_URL; ?>assets/theme/painel/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />


    <!-- Autoload CSS ================================= -->
    <?php $this->view("autoload/css"); ?>

</head>

<body>

    <div class="header-bg">
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo-->
                    <div>
                        <a href="<?= BASE_URL; ?>" class="logo">
                            <span class="logo-light">
                                <img src="<?= BASE_URL; ?>assets/custom/img/logo.png" />
                            </span>
                        </a>
                    </div>
                    <!-- End Logo-->

                    <div class="menu-extras topbar-custom navbar p-0">

                        <ul class="navbar-right ml-auto list-inline float-right mb-0">

                            <!-- full screen -->
                            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                                <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                    <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                                </a>
                            </li>

                            <!-- Menu user -->
                            <li class="dropdown notification-list list-inline-item">
                                <div class="dropdown notification-list nav-pro-img">
                                    <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="<?= BASE_URL; ?>" role="button" aria-haspopup="false" aria-expanded="false">
                                        <img src="<?= BASE_URL; ?>assets/custom/img/user.png" alt="user" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        <a class="dropdown-item" href="<?= BASE_URL; ?>usuario/editar/<?= $usuario->id_usuario; ?>">
                                            <i class="mdi mdi-account-circle"></i> Meus Dados
                                        </a>

                                        <a class="dropdown-item text-danger" href="<?= BASE_URL; ?>sair">
                                            <i class="mdi mdi-power text-danger"></i> Sair
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item dropdown notification-list list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>

                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">

                    <div id="navigation">

                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                            <!-- Dashboard -->
                            <li class="has-submenu">
                                <a href="<?= BASE_URL; ?>">
                                    <i class="icon-accelerator"></i> Dashboard
                                </a>
                            </li>


                            <?php if($usuario->nivel == "admin"): ?>

                                <li class="has-submenu">
                                    <a href="#">
                                        <i class="icon-pencil-ruler"></i> Usuários
                                        <i class="mdi mdi-chevron-down mdi-drop"></i>
                                    </a>
                                    <ul class="submenu megamenu">
                                        <li>
                                            <ul>
                                                <li><a href="<?= BASE_URL; ?>usuarios">Listar Todas</a></li>
                                                <li><a href="<?= BASE_URL; ?>usuario/adicionar">Novo Usuário</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#">
                                        <i class="icon-pencil-ruler"></i> Categorias
                                        <i class="mdi mdi-chevron-down mdi-drop"></i>
                                    </a>
                                    <ul class="submenu megamenu">
                                        <li>
                                            <ul>
                                                <li><a href="<?= BASE_URL; ?>categorias">Listar Todas</a></li>
                                                <li><a href="<?= BASE_URL; ?>categoria/adicionar">Nova Categoria</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                            <?php endif; ?>


                            <li class="has-submenu">
                                <a href="#">
                                    <i class="icon-pencil-ruler"></i> Movimentações
                                    <i class="mdi mdi-chevron-down mdi-drop"></i>
                                </a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <li><a href="<?= BASE_URL; ?>movimentacoes">Listar Todas</a></li>
                                            <li><a href="<?= BASE_URL; ?>movimentacao/adicionar">Nova Movimentação</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        <!-- End navigation menu -->
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->

    </div>
    <!-- header-bg -->