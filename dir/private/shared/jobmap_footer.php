        <!-- Cookie notice Footer -->
        <footer class="footer bg-dark text-white">
        <div class="alert alert-dismissible text-center cookiealert" role="alert">
            <div class="cookiealert-container">
                 We use cookies to personalize your experience and understand how people are using our services. To learn more or change your preferences, please visit our <a class="text-info" href="<?php echo url_for('cookie_policy.php'); ?>">Cookie Policy</a>
                <button type="button" class="btn btn-green btn-sm acceptcookies" aria-label="Close">I agree</button>
            </div>
        </div>
            <div class="row p-1">
            <div class="col-md-12 text-left small">&copy; <?php echo date('Y'); ?> PONToon. <span class="trn">All Rights Reserved.</span></div>
            </div>
        </footer>

<!-- Bootstrap scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- Cookie notice script -->
<script src="<?php echo url_for('/jobmap/js/cookiealert.js'); ?>"></script>

</body>
</html>

<?php
db_disconnect($db);
?>
