<body>
    <div class="container">
        <div class="row">
            <?php echo nav(); ?>
        </div>

        <div class="row mt-4 mb-2">
            <?php echo breadcrumbs(); ?>
        </div>

        <div class="row mt-2">
            <div class="col-8">
                <?php show_content(); ?>
            </div>
        </div>

        <div class="row">
            <?php require TPL_DIR."/footer.php"; ?>
        </div>
    </div>

    <?php require TPL_DIR."/scripts.html"; ?>
</body>
