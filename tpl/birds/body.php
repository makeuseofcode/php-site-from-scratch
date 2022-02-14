<body>
    <div class="container">
        <div class="row">
            <?php echo nav(); ?>
        </div>

        <div class="row mt-4 mb-2">
            <?php echo breadcrumbs(); ?>
        </div>

        <div class="row mt-2">
            <!-- sidebar -->
            <div class="sidebar col-4 d-flex flex-column flex-shrink-0 p-3">
                <ul class="nav nav-pills flex-column mb-auto">
                    <?php show_items("birds"); ?>
                </ul>
            </div>

            <div class="col-8">
                <?php show_content() ?>
            </div>
        </div>

        <div class="row">
            <?php require TPL_DIR."/footer.php"; ?>
        </div>
    </div>

    <?php require TPL_DIR."/scripts.html"; ?>
</body>
