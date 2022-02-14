<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted">© 2022 Company, Inc</p>

    <?php
    if (file_exists($file = MD_DIR.PAGE.'.md')) {
        echo 'Last updated: '.date('r', filemtime(MD_DIR.PAGE.'.md'));
    }
    ?>

    <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Home</a></li>
        <li class="nav-item"><a href="/about" class="nav-link px-2 text-muted">About</a></li>
        <!--<li class="nav-item"><a href="/info" class="nav-link px-2 text-muted">Info</a></li>-->
    </ul>
</footer>
