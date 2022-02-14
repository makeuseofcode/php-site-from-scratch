<?php
include "../funcs.php";
include TPL_DIR."/home.php";

/* */
function content() {
?>
    <div class="my-5 text-center">
        <figure class="figure" style="overflow: hidden; height: 400px;">
            <img class="figure-img img-fluid rounded" src="/img/blackbird.jpg" />
        </figure>

        <h1 class="display-5 fw-bold">All about birds</h1>

        <p class="lead mb-4">Adventures in the aviary</p>
    </div>

    <style>
    .cards a.stretched-link { text-decoration: none; }
    .cards .col:hover a.stretched-link { text-decoration: underline; }
    </style>

<?php
    $featured = get_json("featured.json");

    $tpl = '<div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary">%s</strong>
                <h4>%s</h4>
                <p class="card-text mb-1">%s</p>
                <a href="%s" class="stretched-link">Read more</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <img style="width: auto; height: 250px;" src="%s" />
            </div>
        </div>
    </div>';

// Get bird data
    $content = file_get_contents(MD_DIR."/birds/".$featured["bird"].".md");
    preg_match('/\n[^#]([^\.]+.)/s', $content, $matches);
    $info1 = $matches[1];

    $bird_image = "/img/".$featured["bird"].".jpg";

// Get news story data
    $content = file_get_contents(MD_DIR."/news/".$featured["news"].".md");
    preg_match('/^#\s+(.+)/', $content, $matches);
    $info2 = $matches[1];

    preg_match('/\n!\[.+\]\((.+)\)/', $content, $matches);
    $news_image = $matches[1];
?>
    <div class="row mb-2 cards">
        <?php echo sprintf($tpl, "Birds", ucfirst(str_replace('-', ' ', $featured["bird"])), $info1, "birds/".$featured["bird"], $bird_image); ?>
        <?php echo sprintf($tpl, "News", ucfirst(str_replace('-', ' ', $featured["news"])), $info2, "news/".$featured["news"], $news_image); ?>
    </div>
<?php
}
