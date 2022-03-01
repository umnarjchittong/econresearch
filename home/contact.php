<!doctype html>
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

    <main class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="pb-4 mb-4 blog-post-title border-bottom" style="font-size: 2rem;">
                    งานวิจัย ปีงบประมาณ 2565
                </h2>

                <?php for ($i = 0; $i <= 4; $i++) { ?>
                    <div class="blog-post">
                        <h6 class="blog-post-title">โครงการศึกษาและวิเคราะห์การเปลี่ยนแปลงทางกายภาพของพรรณไม้ภายในอุทยานราชพฤกษ์ ระยะที่ 3</h6>
                        <p class="researcher_list">ผศ.ดร.ขนิษฐา เสถียรพีระกุล, ผศ.ดร.วิชญ์ภาส สังพาลี, ผศ.ดร.สุธีระ เหิมฮึก, ผศ.ดร.สิทธิชัย ชูสำโรง, รศ.ดร.เกรียงศักดิ์ ศรีเงินยวง</p>
                        <p class="research_source"><strong>แหล่งทุน</strong> สถาบันวิจัยและพัฒนาพื้นที่สูง (องค์การมหาชน), เชียงใหม่</p>
                        <p class="blog-post-meta"><strong>ระยะเวลา</strong> 1 ตุลาคม 2564 - 30 กันยายน 2565</p>
                    </div><!-- /.blog-post -->
                <?php } ?>


                <!-- /.blog-post -->



                <nav class="blog-pagination">
                    <a class="btn btn-outline-primary" href="#">More...</a>
                    <!-- <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a> -->
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
                        <?php for ($i=2565; $i>=2561; $i--) { ?>
                        <li><a href="#">ปี งปม. <?= $i ?></a></li>
                        <?php } ?>
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