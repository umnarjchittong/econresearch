<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');

$fnc = new web();
// $MJU_API = new MJU_API();
// require('../admin/core_fnc_research.php');
// $research_fnc = new research_fnc();

if (!isset($_GET['fyear']) || $_GET['fyear'] == "") {
    $fyear = $fnc->get_fiscal_year();
} else {
    $fyear = $_GET['fyear'];
}
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

</head>

<body>
    <?PHP include("header.php"); ?>

    <?PHP
    include ('homepage_configure.php');
    
    echo '<div class="container">';
    include('carousel.php');
    echo '</div>';
    ?>

    <?php
    function gen_data_blog($row)
    {
        global $fnc;
        echo '<div class="blog-post">';
        echo '<h6 class="blog-post-title">' . $row['res_name'] . '</h6>';
        $sql = "SELECT * FROM co_worker WHERE cow_ref_table = 'research' AND cow_ref_id = " . $row['res_id'] . " ORDER BY cow_ratio DESC";
        $data_array = $fnc->get_db_array($sql);
        $researcher_list = "";
        echo '<p class="researcher_list">';
        foreach ($data_array as $cow) {
            $researcher_list .= ', ' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . '&nbsp;&nbsp;' . $cow["cow_lastname"];
        }
        echo $row['res_owner_prename'] . $row['res_owner_firstname'] . ' ' . $row['res_owner_lastname'] . $researcher_list;
        echo '</p>';
        echo '<p class="research_source"><strong>แหล่งทุน</strong> ' . $row['res_budget_source'] . '</p>';
        echo '<p class="blog-post-meta"><strong>ระยะเวลา</strong> ';
        echo $fnc->gen_date_range_semi_th($row["res_period_begin"], $row["res_period_finish"]);
        echo '</p>';
        echo '</div>';
    }
    ?>

    <main class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="pb-4 mb-4 blog-post-title border-bottom" style="font-size: 2rem;">
                    งานวิจัย ปีงบประมาณ <?= $fyear; ?>
                </h2>

                <?php
                $sql = "SELECT * FROM research WHERE res_status = 'enable' AND res_fiscalyear = '" . $fyear . "' ORDER BY res_fiscalyear DESC";
                if (!isset($_GET['moreBtn']) || $_GET['moreBtn'] != "true") {
                    $sql .= " Limit 5";
                }
                $data_array = $fnc->get_db_array($sql);
                foreach ($data_array as $row) {
                    gen_data_blog($row);
                } ?>

                <!-- /.blog-post -->
                <nav class="blog-pagination">
                    <?php
                    $data_count = 0;
                    $sql = "SELECT COUNT(res_id) AS Count_data FROM research WHERE res_status = 'enable' AND res_fiscalyear = '" . $fyear . "'";
                    $data_count = $fnc->get_db_col($sql);
                    if ($data_count > 5 && $_GET['moreBtn'] != "true") {
                        echo '<a class="btn btn-outline-primary" href="?fyear=' . $fyear . '&moreBtn=true">More...</a>';
                    }
                    ?>
                </nav>

            </div>

            <aside class="col-md-4">
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="font-italic">About</h4>
                    <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur
                        purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                </div>

                <div class="p-4">
                    <h4 class="font-italic">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        <?php
                        $sql = "SELECT res_fiscalyear FROM research WHERE res_status = 'enable' GROUP BY res_fiscalyear ORDER BY res_fiscalyear DESC";
                        $fiscalyear = $fnc->get_db_rows($sql);
                        foreach ($fiscalyear as $row) {
                            echo '<li><a href="?fyear=' . $row['res_fiscalyear'] . '">ปี งปม. ' . $row['res_fiscalyear'] . '</a></li>';
                        }
                        ?>
                    </ol>
                </div>

                <div class="p-4">
                    <h4 class="font-italic">Download</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">แบบฟอร์ม 1</a></li>
                        <li><a href="#">แบบฟอร์ม 2</a></li>
                        <li><a href="#">แบบฟอร์ม 3</a></li>
                    </ol>
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