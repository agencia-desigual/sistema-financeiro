<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NOME; ?> | Acessar sistema</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/theme/iofrom/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/theme/iofrom/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/theme/iofrom/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/theme/iofrom/css/iofrm-theme22.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/custom/css/estilo.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL; ?>assets/custom/img/favicon.ico" />
</head>
<body>
    <div class="form-body without-side">
        <div class="row">
            <div class="img-holder" style="background-color: #34133d;">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="<?= BASE_URL; ?>assets/theme/iofrom/images/graphic3.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <img src="<?= BASE_URL; ?>assets/custom/img/logo-roxo.png"
                             style="display: block; margin: 0 auto; padding-bottom: 35px;">

                        <form id="formLogin">
                            <input class="form-control" type="email" name="email" placeholder="E-mail" required>
                            <input class="form-control" type="password" name="senha" placeholder="Senha" required>
                            <div class="form-button text-center">
                                <button id="submit" type="submit" class="ibtn" style="background: #cb245e;">Acessar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery -->
    <script src='<?= BASE_URL; ?>assets/plugins/jquery/jquery-3.4.1.min.js'></script>

    <!-- Autoload JS ================================================== -->
    <?php $this->view("autoload/js"); ?>

    <script src="<?= BASE_URL; ?>assets/theme/iofrom/js/popper.min.js"></script>
</body>
</html>