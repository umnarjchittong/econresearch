<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web;

function department_table()
{
    global $fnc;
?>
    <div class="box_shadow mt-3">
        <table class="table table-light table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 4em;">#</th>
                    <th>Department Name</th>
                    <th class="text-center text-uppercase" style="width: 6em;"><a href="?p=department&act=formappend">add</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `department` ORDER BY `department_order`, `department_name`";
                $data_array = $fnc->get_db_array($sql);
                if (!empty($data_array)) {
                    $x = 1;
                    foreach ($data_array as $row) {
                        echo '<tr>';
                        echo '<td scope="row" class="text-center fw-bold">' . $x . '</td>';
                        echo '<td>' . $row['department_name'] . '</td>';
                        echo '<td class="text-center text-uppercase"><a href="?p=department&act=formupdate&d_id=' . $row["department_id"] . '">EDIT</a></td>';
                        echo '</tr>';
                        $x++;
                    }
                } else {
                    echo '<tr>';
                    echo '<td scope="row" colspan="3" class="text-center fw-bold text-uppercase">no data founded !</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

<?php
}

function department_form_append() {
    global $fnc;
    ?>
<div class="card p-0 p-md-3 box_shadow">
        <div class="card-header bg-light bg-gradient">
            <h5 class="card-title mt-2 h3 text-primary">New Department</h5>
            <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">เพิ่มหลักสูตร/สาขาวิชา</h6>
        </div>

        <form action="../db_mgt.php?p=setting&act=department_append" method="post" autocomplete="off">
            <div class="card-body mt-3">
                <div class="col mb-3">
                    <label for="department_name" class="form-label">หลักสูตร/สาขาวิชา <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control" name="department_name" id="department_name" aria-describedby="department_nameHelp" maxlength="80">
                    <div id="department_nameHelp" class="form-text">ระบุชื่อหลักสูตร, สาขาวิชา หรือหน่วยงาน</div>
                </div>
            </div>

            <div class="card-footer text-end">
                <input type="hidden" name="fst" value="department_append">
                <div class="row px-3 gx-3 mt-3">
                    <div class="col-6 col-md-3 offset-md-6">
                        <button type="button" class="btn btn-secondary w-100 py-2 text-uppercase" onclick="window.location='setting.php?p=department'">close</button>
                    </div>
                    <div class="col-6 col-md-3">
                        <button type="submit" class="btn btn-primary w-100 py-2 ms-3 text-uppercase">Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

<?php
}

function department_form_update($d_id) {
    global $fnc;
    $sql = "SELECT * FROM `department` WHERE `department_id` = " . $d_id;
    $row = $fnc->get_db_row($sql);
    if (!empty($row)) {
    ?>
<div class="card p-0 p-md-3 box_shadow">
        <div class="card-header bg-light bg-gradient">
            <h5 class="card-title mt-2 h3 text-primary">Update Department</h5>
            <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">แก้ไขหลักสูตร/สาขาวิชา</h6>
        </div>

        <form action="../db_mgt.php?p=setting&act=department_update" method="post" autocomplete="off">
            <div class="card-body mt-3">
                <div class="col mb-3">
                    <label for="department_name" class="form-label">หลักสูตร/สาขาวิชา <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control" name="department_name" id="department_name" aria-describedby="department_nameHelp" maxlength="80" value="<?= $row['department_name'] ?>">
                    <div id="department_nameHelp" class="form-text">ระบุชื่อหลักสูตร, สาขาวิชา หรือหน่วยงาน</div>
                </div>
            </div>

            <div class="card-footer text-end">
                <input type="hidden" name="department_id" value="<?= $row['department_id'] ?>">
                <input type="hidden" name="fst" value="department_update">
                <div class="row gx-2 gx-md-4 mt-3">
                    <div class="col-4 col-md-3 offset-md-3">
                        <button type="button" class="btn btn-danger w-100 px-0 px-md-2 py-2 text-uppercase" onclick="department_delete_confirmation(<?= $d_id ?>);">close</button>
                    </div>
                    <div class="col-4 col-md-3">
                        <button type="button" class="btn btn-secondary w-100 px-0 px-md-2 py-2 text-uppercase" onclick="window.location='setting.php?p=department'">close</button>
                    </div>
                    <div class="col-4 col-md-3">
                        <button type="submit" class="btn btn-primary w-100 px-0 px-md-2 py-2 text-uppercase">Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <?php } else { echo "data not founded to edit.<br>" . $sql; } ?>

<?php
}
?>
<html lang="en">

<head>
    <title>Setting ECON-A&S</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <!-- <link href="../images/favicon.png" rel="icon"> -->

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body style="background-color: #DFD9EA;">

    <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #592464;">
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
                        <a class="nav-link" href="#">Research</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php if (isset($_GET['p']) && $_GET['p'] == 'proceeding') {
                                                                echo ' active';
                                                            } ?>" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Proceeding</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../admin/index.php?p=proceeding" target="_top">Data Manager</a></li>
                            <li><a class="dropdown-item" href="../admin/index.php?p=proceeding&act=append" target="_top">Create New</a></li>
                            <li><a class="dropdown-item" href="../admin/index.php?p=proceeding&act=viewdeleted" target="_top">Deleted Data</a></li>
                            <li><a class="dropdown-item" href="../admin/index.php?p=proceeding&act=report">reports</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Journal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">SDG</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">admin</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "department") {
                                                            echo ' active" aria-current="page';
                                                        } ?>" href="../admin/setting.php?p=department" target="_top">หลักสูตร/สาขาวิชา</a></li>

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

            <?php
            if (isset($_GET['p']) && $_GET['p'] != '') {
                switch ($_GET['p']) {
                    case "department":
                        if (isset($_GET['act'])) {
                            switch ($_GET['act']) {
                                case "formappend":
                                    echo '<h2 class="text-capitalize">Department Form Add</h2>';
                                    department_form_append();
                                    break;
                                case "formupdate":
                                    if (isset($_GET["d_id"])) {
                                    echo '<h2 class="text-capitalize">Department Form Update</h2>';
                                    department_form_update($_GET["d_id"]);
                                    }
                                    break;
                            }
                        } else {
                        echo '<h2 class="text-capitalize">Department manager</h2>';
                        department_table();
                        }
                        break;
                }
            } else {
                echo "none parameters";
            }
            ?>

        </div>
    </main>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <?php include('../sweet_alert.php'); ?>

</body>

</html>