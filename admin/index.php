<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web;


?>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link href="../images/favicon.png" rel="icon">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="../admin/"><?= $fnc->system_name ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../admin/">home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Proceeding</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">job2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">job3</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">job4</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">job5</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">admin</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../score/" target="_blank">Result Manager</a></li>
                            <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "so") {
                                                            echo ' active" aria-current="page';
                                                        } ?>" href="../admin/?p=so">SO Manager</a></li>
                            <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "match") {
                                                            echo ' active" aria-current="page';
                                                        } ?>" href="../admin/?p=match">Match Manager</a></li>
                            <!-- <li><a class="dropdown-item" href="#">Jobs Manager</a></li> -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../admin/report.php">reports</a></li>
                            <li><a class="dropdown-item" href="../admin/setting.php">Settings</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../sign/signout.php?p=signout">Sign-out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main style="margin-top: 2.5em;">
        <div class="container mx-auto p-3 p-md-5">

            <div class="card p-0 p-md-3">
                <div class="card-header bg-light bg-gradient">
                    <h5 class="card-title mt-2">Proceeding</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">Card subtitle</h6>
                </div>

                <form action="#" method="post" autocomplete="off">
                    <div class="card-body mt-3">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="pro_title" class="form-label">ชื่อเรื่อง <span class="lbl_required">*</span></label>
                                <input type="email" class="form-control" name="pro_title" id="pro_title" aria-describedby="pro_titleHelp" maxlength="180">
                                <div id="pro_titleHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label for="pro_place" class="form-label">สถานที่ <span class="lbl_required">*</span></label>
                                <input type="email" class="form-control" name="pro_place" id="pro_place" aria-describedby="pro_placeHelp" maxlength="60">
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="pro_date_begin" class="form-label">วันที่ <span class="lbl_required">*</span></label>
                                        <input type="date" class="form-control" name="pro_date_begin" id="pro_date_begin" aria-describedby="pro_date_beginHelp">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pro_date_end" class="form-label">ถึง วันที่</label>
                                        <input type="date" class="form-control" name="pro_date_end" id="pro_date_end" aria-describedby="pro_date_endHelp">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label for="pro_detail" class="form-label">รายละเอียด</label>
                                <textarea class="form-control" name="pro_detail" id="pro_detail" rows="5"></textarea>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="pro_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                                <select class="form-select" size="5" name="pro_owner_citizenid" id="pro_owner_citizenid" aria-describedby="pro_owner_citizenidHelp">
                                    <?php
                                    $MJU_API = new MJU_API;
                                    $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
                                    $econ_member = $MJU_API->GetAPI_array($api_url);
                                    $fnc->debug_console("econ member" , $econ_member);
                                    foreach ($econ_member as $member) {
                                        echo '<option value="1">' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <input type="hidden" name="fst" value="">
                        <div class="row px-3 gx-3">
                            <div class="col-6 col-md-3 offset-md-6">
                                <button type="button" class="btn btn-secondary w-100 py-2 text-uppercase">close</button>
                            </div>
                            <div class="col-6 col-md-3">
                                <button type="submit" class="btn btn-primary w-100 py-2 ms-3 text-uppercase">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>







        </div>

    </main>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>