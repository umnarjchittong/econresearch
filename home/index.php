<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');

$fnc = new web();

include("../fusioncharts/fusioncharts.php");

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Kanchana Chittong">
    <title>ECON RESEARCH</title>

    <!-- <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/blog/"> -->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;300&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="style.css">

    <!-- FusionCharts Library -->
    <script type="text/javascript" src="../js/fusioncharts.js"></script>
    <script type="text/javascript" src="../js/themes/fusioncharts.theme.fusion.js"></script>
    <!--
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.fusion.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.fint.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.gammel.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.zune.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.candy.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.carbon.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.ocean.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.umber.js"></script>
    -->

</head>

<body>

    <?PHP include("header.php"); ?>

    <?PHP
    include('homepage_configure.php');

    echo '
    <div class="container">';
    include('banner.php');

    include('carousel.php');
    echo '
    </div>';
    ?>

    <!-- 2 side -->
    <?php

    if (!empty($home_features)) {
        echo '
    <div class="container">';
        echo '
        <div class="row mb-2">';

        foreach ($home_features as $feature) {
            echo '
            <div class="col-md-6">';

            echo '
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">';
            echo '
                    <div class="col p-4 d-flex flex-column position-static">';
            echo '<strong class="' . $feature['titleCls'] . '">' . $feature['titleText'] . '</strong>
                <h3 class="' . $feature['h3Cls'] . '">' . $feature['h3Text'] . '</h3>
                <div class="' . $feature['dateCls'] . '">' . $feature['dateText'] . '</div>
                <p class="' . $feature['pCls'] . '">' . $feature['pText'] . '</p>
                <a href="' . $feature['LinkUrl'] . '" class="' . $feature['LinkCls'] . '">' . $feature['LinkText'] . '</a>
            </div>
            <div class="col-auto d-none d-lg-block">
            ' . $feature['imageTag'] . '
            </div>
            </div>';

            echo '
                </div>';
        }

        echo '
        </div>';
        echo '
    </div>';
    }

    ?>

    <div class="container">
        <?php

        function genChartGauge($objId, $chartTitle, $chartValue, $chartTarget, $chartSurfix, $zoneDanger = 2, $zoneWarning = 3, $zoneSuccess = 4)
        {
            // $colorDanger = "#F2726";
            // $colorWarning = "#FFC533";
            // $colorSuccess = "#62B58F";
            $colorDanger = "#c6344c";
            $colorWarning = "#e9c930";
            $colorSuccess = "#0c7239";
            $gaugeData = '{
            "chart": {
              "origw": "380",
              "origh": "200",
              "gaugestartangle": "180",
              "gaugeendangle": "0",
              "gaugeoriginx": "180",
              "gaugeoriginy": "200",
              "gaugeouterradius": "140",
              "theme": "fusion",
              "showvalue": "1",
              "numbersuffix": " ' . $chartSurfix . '",
              "valuefontsize": "20"
            },
            "colorrange": {
              "color": [
                {
                  "minvalue": "0",
                  "maxvalue": "' . $zoneDanger . '",
                  "code": "' . $colorDanger . '"
                },
                {
                  "minvalue": "' . $zoneDanger . '",
                  "maxvalue": "' . $zoneWarning . '",
                  "code": "' . $colorWarning . '"
                },
                {
                  "minvalue": "' . $zoneWarning . '",
                  "maxvalue": "' . $zoneSuccess . '",
                  "code": "' . $colorSuccess . '"
                }
              ]
            },
            "dials": {
              "dial": [
                {
                  "value": "' . $chartValue . '",
                  "tooltext": "' . $chartTitle . '"
                }
              ]
            }
          }';

            $columnChart = new FusionCharts("angulargauge", "ex_" . $objId, "100%", 200, $objId, "json", $gaugeData);
            $columnChart->render();

            echo '<div id="' . $objId . '" class="mt-0 mt-lg-1 p-0" style="height: 9em;">Chart will render here!</div>';
        }

        ?>
        <div class="row mb-2">
            <?php foreach ($charts as $chart) { ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
                        <div class="col p-4 d-flex flex-column position-static"><span class="d-inline-block mb-0 text-dark"><?= $chart["ChartTitle"]; ?></span>
                            <div class="pb-4 text-muted" style="font-size: 0.8em;"><?= $chart["ChartUnit"]; ?></div>
                            <?php
                            genChartGauge($chart["ChartName"], $chart["ChartTitle"], $chart["ChartValue"], $chart["ChartTarget"], $chart["ChartCaption"], $chart["ChartDanger"], $chart["ChartWarning"], $chart["ChartSuccess"]);
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


    <main class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    ข่าวทุนวิจัย / ข่าวประชาสัมพันธ์
                </h3>

                <div class="blog-post">
                    <h2 class="blog-post-title">ข่าวทุนวิจัย</h2>
                    <!-- <p class="blog-post-meta">Jan 1, 2014</p> -->
                    <ul>
                        <li><a href="#" target="_blank" class="news_link">Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</a><a href="#" target="_blank" class="icon_link"><i class="ms-2 bi bi-filetype-pdf"></i></a></li>
                        <li><a href="#" target="_blank" class="news_link">Donec id elit non mi porta gravida at eget metus.</a></li>
                        <li><a href="#" target="_blank" class="news_link">Nulla vitae elit libero, a pharetra augue.</a></li>
                        <li><a href="#" target="_blank" class="news_link">Nulla vitae elit libero, a pharetra augue.</a></li>
                    </ul>

                    <h2 class="mt-5 blog-post-title">ข่าวประชาสัมพันธ์</h2>
                    <!-- <p class="blog-post-meta">Jan 1, 2014</p> -->
                    <ul>
                        <li><a href="#" target="_blank" class="news_link">Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</a><a href="#" target="_blank" class="icon_link"><i class="ms-2 bi bi-filetype-pdf"></i></a></li>
                        <li><a href="#" target="_blank" class="news_link">Donec id elit non mi porta gravida at eget metus.</a></li>
                        <li><a href="#" target="_blank" class="news_link">Nulla vitae elit libero, a pharetra augue.</a></li>
                        <li><a href="#" target="_blank" class="news_link">Nulla vitae elit libero, a pharetra augue.</a></li>
                    </ul>

                    <div class="my-4">&nbsp;</div>

                    <h3 class="pb-3 mb-4 font-italic border-bottom">
                        <p class="mb-0">วารสารเศรษฐศาสตร์ มหาวิทยาลัยแม่โจ้</p>
                        <p class="fs-6 mb-0">Journal Of Economics Maejo University (ECONMJU)</p>
                    </h3>
                    <div class="row row-cols-2 row-cols-lg-4">
                        <div class="col"><a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fmaejopoll.mju.ac.th%2Fjournal.aspx%3Fid%3D4167&h=AT0TC9R05rnoI5stcstlZsmzbtL8xoDnNb3LpdBv7F0rV4uXPbA1B94DEdRSo8Uny0qlC7tgalq3PyBcIFrHBNlo6VdLTh236IRqePbfHgHeUaWMXpAf3MMbMN4j3keP30IXruTNZTbxdAg&s=1" target="_blank"><img src="../images/econjournal-1.jpeg" class="img-fluid shadow rounded"></a></div>
                        <div class="col"><a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fmaejopoll.mju.ac.th%2Fjournal.aspx%3Fid%3D1150&h=AT3OQLBcOzoDAT19_4CnA-3d7liH-DjIvUTkgP-CzQ2AABam8OItfJDdwaxsYikoXt_bPTMgqM6Ypy9WmryaIP1MXYSPF7E1H8cHc1rvVzUnYV10jG0_fK4nDpauXaIb84wwBWQpQ5NddIU&s=1" target="_blank"><img src="../images/econjournal-2.jpeg" class="img-fluid shadow rounded"></a></div>
                    </div>

                    <div class="my-4">&nbsp;</div>


                    <h3>Sub-heading</h3>
                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean
                        lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce
                        dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit
                        amet risus.</p>
                    <ul>
                        <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
                        <li>Donec id elit non mi porta gravida at eget metus.</li>
                        <li>Nulla vitae elit libero, a pharetra augue.</li>
                    </ul>
                    <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.
                    </p>
                    <ol>
                        <li>Vestibulum id ligula porta felis euismod semper.</li>
                        <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
                        <li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>
                    </ol>
                    <p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.</p>
                </div><!-- /.blog-post -->

                <!-- <div class="blog-post">
                    <h2 class="blog-post-title">Another blog post</h2>
                    <p class="blog-post-meta">December 23, 2013 by <a href="#">Jacob</a></p>

                    <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus
                        mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere
                        consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
                    <blockquote>
                        <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong>
                            ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </blockquote>
                    <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet
                        fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non
                        commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus,
                        porta ac consectetur ac, vestibulum at eros.</p>
                </div> -->

                <!-- <div class="blog-post">
                    <h2 class="blog-post-title">New feature</h2>
                    <p class="blog-post-meta">December 14, 2013 by <a href="#">Chris</a></p>

                    <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean
                        lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce
                        dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit
                        amet risus.</p>
                    <ul>
                        <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
                        <li>Donec id elit non mi porta gravida at eget metus.</li>
                        <li>Nulla vitae elit libero, a pharetra augue.</li>
                    </ul>
                    <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet
                        fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.
                    </p>
                </div> -->

                <!-- <nav class="blog-pagination">
                    <a class="btn btn-outline-primary" href="#">Older</a>
                    <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
                </nav> -->

            </div>

            <aside class="col-md-4">
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="font-italic">About</h4>
                    <p class="mb-0 in" style="text-indent: 3em;"><?= $about_text; ?></p>
                </div>

                <div class="p-4">
                    <h4 class="font-italic">Notices</h4>
                    <ul class="mb-0">
                        <?php
                        foreach ($notice as $notice) {
                            echo '<li><a href="' . $notice[1] . '" class="news_link">' . $notice[0] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <div class="p-4">
                    <h4 class="font-italic">Downloads</h4>
                    <!-- <ol class="list-unstyled mb-0"> -->
                    <ul class="mb-0">
                        <?php
                        foreach ($download_list as $dl) {
                            echo '<li><a href="' . $dl[1] . '" class="news_link">' . $dl[0] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <div class="p-4">
                    <h4 class="font-italic">Links</h4>
                    <ul>
                        <!-- <ol class="list-unstyled"> -->
                        <?php
                        foreach ($Links_list as $lk) {
                            echo '<li><a href="' . $lk[1] . '" class="news_link">' . $lk[0] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>


                <div class="p-4">
                    <h4 class="font-italic">Parthers</h4>
                    <div class="row row-cols-1 g-3">
                        <div class="col"><img src="https://www.econ.cmu.ac.th/econadmin/banner/4711LB.png" class="img-fluid rounded shadow"></div>
                        <div class="col"><img src="https://www.econ.cmu.ac.th/econadmin/images/1127banneriserv.png" class="img-fluid rounded shadow"></div>
                        <div class="col"><img src="https://www.econ.cmu.ac.th/econadmin/images/5618cmu_press.jpg" class="img-fluid rounded shadow"></div>
                        <div class="col"><img src="https://www.econ.cmu.ac.th/econadmin/banner/1342acdemic.png" class="img-fluid rounded shadow"></div>
                    </div>
                </div>

            </aside>

        </div><!-- /.row -->

    </main><!-- /.container -->

    <footer class="blog-footer">
        <p class="mb-1">งานบริการวิชาการและวิจัย สำนักงานคณบดี <a href="https://econ.mju.ac.th/" class="fw-bold" style="text-decoration: none; color: #727272;">คณะเศรษฐศาสตร์ มหาวิทยาลัยแม่โจ้</a></p>
        <p class="mb-0">63 หมู่ 4 ถนนเชียงใหม่-พร้าว ต.หนองหาร อ.สันทราย จ.เชียงใหม่ 50290</p>
        <p class="m-0">โทรศัพท์. 053-875264 | โทรสาร. 053-875252 | อีเมล์ econ@mju.ac.th</p>
        <!-- <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p> -->
        <p>
            <a href="#">Back to top</a>
        </p>
    </footer>

    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>