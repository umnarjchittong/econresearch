<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');

$fnc = new web();
// $MJU_API = new MJU_API();
// require('../admin/core_fnc_research.php');
// $research_fnc = new research_fnc();

if (isset($_GET['exp']) && $_GET['exp'] != "") {
    $exp = $_GET['exp'];
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

    <?php
    function gen_data_header()
    {
        echo '<div class="row mt-2 fw-bold" style="font-size: 0.9em;">';
        echo '<div class="col-6">';
        echo 'นักวิจัย';
        echo '</div>';
        echo '<div class="col-6">';
        echo 'ความเชี่ยวชาญ';
        echo '</div>';
        echo '</div>';
    }

    function gen_data_blog($row)
    {
        global $fnc;
        echo '<div class="row mt-3" style="font-size: 0.9em;">';
        echo '<div class="col-6">';
        echo $row['techName'] . $row['firstName'] . ' ' . $row['lastName'];
        echo '</div>';
        echo '<div class="col-6">';
        $sql = "SELECT * FROM res_expert WHERE citizenid = '" . $row['citizenid'] . "' ORDER BY expert_name ASC";
        $expertise = $fnc->get_db_array($sql);
        foreach ($expertise as $expert) {
            echo '<p class="mb-0" style="font-size: 0.9em;">- ' . $expert['expert_name'] . '</p>';
        }
        echo '</div>';
        echo '</div>';
    }

    function gen_data_tbl($row)
    {
        global $fnc;
        echo '<tr>';
        echo '<td scope="row">' . $row['techName'] . $row['firstName'] . ' ' . $row['lastName'] . '</td>';
        echo '<td>';
        $sql = "SELECT * FROM res_expert WHERE citizenid = '" . $row['citizenid'] . "' ORDER BY expert_name ASC";
        $expertise = $fnc->get_db_array($sql);
        foreach ($expertise as $expert) {
            echo '<p class="mb-0" style="font-size: 0.9em;">- ' . $expert['expert_name'] . '</p>';
        }
        echo '</td>';
        echo '</tr>';
    }
    ?>

    <main class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="pb-4 mb-4 blog-post-title border-bottom" style="font-size: 2rem;">
                    ทำเนียบนักวิจัย - ความเชี่ยวชาญด้าน <?= $exp ?>
                </h2>

                <?php
                $sql = "SELECT res.citizenid, res.techName, res.firstName, res.lastName, res.cv_filename FROM res_expert reex INNER JOIN researcher res ON reex.citizenid = res.citizenid GROUP BY res.citizenid, res.techName, res.firstName, res.lastName, res.cv_filename";
                $data_array = $fnc->get_db_array($sql);
                // echo '<div class="blog-post">';
                echo '<table class="table table-striped table-bordered table-hover table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th width="50%">นักวิจัย</th>
                        <th width="50%">ความเชี่ยวชาญ</th>
                    </tr>
                </thead>
                <tbody>';
                // gen_data_header();
                foreach ($data_array as $row) {
                    gen_data_tbl($row);
                }
                // echo '</div>';
                echo '</tbody>
                </table>';
                ?>

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
                    <h4 class="font-italic">ความเชี่ยวชาญ</h4>
                    <ol class="list-unstyled mb-0">
                        <?php
                        $sql = "SELECT expert_id, expert_name FROM expertise ORDER BY expert_name ASC";
                        $fiscalyear = $fnc->get_db_rows($sql);
                        foreach ($fiscalyear as $row) {
                            echo '<li><a href="?exp=' . $row['expert_id'] . '">' . $row['expert_name'] . '</a></li>';
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