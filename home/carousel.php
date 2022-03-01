<!-- corousel -->
<!-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="p-4 p-md-5 mb-4 text-white rounded" style="background-color: #592464">
                <div class="col-md-10 mx-auto px-0">
                    <h1 class="display-4 font-italic text-center">Title of a longer featured blog post</h1>
                    <p class="lead my-3 text-center">Multiple lines of text that form the lede, informing new readers quickly and
                        efficiently about what’s most interesting in this post’s contents.</p>
                    <p class="lead mb-0 text-center"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="p-4 p-md-5 mb-4 text-white rounded" style="background-color: #222460">
                <div class="col-md-6 px-0">
                    <h1 class="display-4 font-italic">บทความล่าสุด</h1>
                    <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and
                        efficiently about what’s most interesting in this post’s contents.</p>
                    <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="p-4 p-md-5 mb-4 text-white rounded" style="background-color: #892434">
                <div class="col-md-6 px-0">
                    <h1 class="display-4 font-italic">โครงการบริการวิชาการที่ได้รับรางวัล</h1>
                    <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and
                        efficiently about what’s most interesting in this post’s contents.</p>
                    <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div> -->

<!-- corousel php -->
<?php
$current_page = explode('.', $fnc->get_url_filename())[0];
if ($current_page == "index") {
    $current_page = "home";
}
$carouselName = "carouselExampleIndicators";
echo $current_page;
if (!empty($carousels)) {
    echo '
    <div id="' . $carouselName . '" class="carousel slide" data-bs-ride="carousel">';

    echo '  <div class="carousel-indicators">';

    for ($i = 0; $i < count($carousels); $i++) {
        // echo $current_page;
        // echo $carousels[$i]['display'];
        // echo strpos($carousels[$i]['display'], 'home');
        if (strpos($carousels[$i]['display'], $current_page) >= 0) {
            if ($i == 0) {
                echo '
                  <button type="button" data-bs-target="#' . $carouselName . '" data-bs-slide-to="0" aria-label="Slide 1" class="active" aria-current="true"></button>';
            } else {
                echo '
                  <button type="button" data-bs-target="#' . $carouselName . '" data-bs-slide-to="' . $i . '" aria-label="Slide ' . ($i + 1) . '"></button>';
            }
        }
    }
    echo '
      </div>';

    echo '
      <div class="carousel-inner">';

    for ($i = 0; $i < count($carousels); $i++) {
        // if ($carousels[$i]['display'] == 'home') {
            echo $carousels[$i]['display'] . " - " . $current_page;
        if (strpos($carousels[$i]['display'], $current_page) >= 0) {
            if ($i == 0) {
                echo '
        <div class="carousel-item active">';
            } else {
                echo '
        <div class="carousel-item">';
            }
            echo '
            <div class="p-4 p-md-5 mb-4 text-white rounded" style="background-color: ' . $carousels[$i]['bgColor'] . '">';
            echo '
                <div class="col-md-10 mx-auto px-0">';
            echo '
                    <h1 class="' . $carousels[$i]['h1Cls'] . '">' . $carousels[$i]['h1Text'] . '</h1>';
            echo '
                    <p class="' . $carousels[$i]['pCls'] . '">' . $carousels[$i]['pText'] . '</p>';
            echo '
                    <p class="' . $carousels[$i]['pLinkCls'] . '"><a href="' . $carousels[$i]['LinkUrl'] . '" class="' . $carousels[$i]['LinkCls'] . '">' . $carousels[$i]['LinkText'] . '</a></p>';
            echo '
                </div>';
            echo '
            </div>';
            echo '
        </div>';
        }
    }
    echo '
      </div>';

    echo '
          <button class="carousel-control-prev" type="button" data-bs-target="#' . $carouselName . '" data-bs-slide="prev">';
    echo '
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    echo '
              <span class="visually-hidden">Previous</span>';
    echo '
          </button>';
    echo '
          <button class="carousel-control-next" type="button" data-bs-target="#' . $carouselName . '" data-bs-slide="next">';
    echo '
              <span class="carousel-control-next-icon" aria-hidden="true"></span>';
    echo '
              <span class="visually-hidden">Next</span>';
    echo '
          </button>';

    echo '
    </div>';
}
?>