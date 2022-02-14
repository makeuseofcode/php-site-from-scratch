<body>
    <div class="container">
        <?php echo nav(); ?>

        <?php echo content(); ?>

        <?php require_once TPL_DIR."/footer.php"; ?>
    </div>

    <?php require TPL_DIR."/scripts.html"; ?>
</body>
