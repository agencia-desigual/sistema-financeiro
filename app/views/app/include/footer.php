<!-- Footer -->
<footer class="footer">
    © <?= date("Y"); ?> - desenvolvido por Desigual.
</footer>

<!-- End Footer -->

<!-- jQuery  -->
<script src="<?= BASE_URL; ?>assets/theme/painel/js/jquery.min.js"></script>
<script src="<?= BASE_URL; ?>assets/theme/painel/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL; ?>assets/theme/painel/js/jquery.slimscroll.js"></script>
<script src="<?= BASE_URL; ?>assets/theme/painel/js/waves.min.js"></script>

<!--Morris Chart-->
<script src="<?= BASE_URL; ?>assets/theme/painel/plugins/morris/morris.min.js"></script>
<script src="<?= BASE_URL; ?>assets/theme/painel/plugins/raphael/raphael.min.js"></script>

<script src="<?= BASE_URL; ?>assets/theme/painel/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="<?= BASE_URL; ?>assets/theme/painel/js/app.js"></script>

<!-- Autoload JS ================================================== -->
<?php $this->view("autoload/js"); ?>