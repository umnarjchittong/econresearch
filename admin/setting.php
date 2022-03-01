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

function department_form_append()
{
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

function department_form_update($d_id)
{
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
    <?php } else {
        echo "data not founded to edit.<br>" . $sql;
    } ?>

<?php
}

function check_db_fiscalyear()
{
    global $fnc;
    $sql = "SELECT `res_id` as chk_id, `res_period_begin` as chk_date, `res_fiscalyear` as fiscalyear FROM `research` WHERE `res_fiscalyear` != ''";
    $data_array = $fnc->get_db_array($sql);
    if (!empty($data_array)) {
        echo '

        <h3>DB Research</h3>';
        foreach ($data_array as $data) {
            if ($fnc->get_fiscal_year($data["chk_date"]) != $data["fiscalyear"]) {
                echo '
                <p class="my-2 text-danger"><a href="research.php?p=research&act=viewinfo&rid=' . $data["chk_id"] . '" target="_blank" class="link-danger">ID: ' . $data["chk_id"] . ' - Fiscal Year Error Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> : Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></a></p>';
            } else {
                echo '
                <p class="my-0">ID: ' . $data["chk_id"] . ' - Fiscal Year Successfully Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> vs Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></p>';
            }
        }
    }

    $sql = "SELECT `pro_id` as chk_id, `pro_date_begin` as chk_date, `pro_fiscalyear` as fiscalyear FROM `proceeding` WHERE `pro_fiscalyear` != ''";
    $data_array = $fnc->get_db_array($sql);
    if (!empty($data_array)) {
        echo '

        <h3 class="mt-3">DB Proceeding</h3>';
        foreach ($data_array as $data) {
            if ($fnc->get_fiscal_year($data["chk_date"]) != $data["fiscalyear"]) {
                echo '
                <p class="my-2 text-danger"><a href="proceeding.php?p=proceeding&act=viewinfo&pid=' . $data["chk_id"] . '" target="_blank" class="link-danger">ID: ' . $data["chk_id"] . ' - Fiscal Year Error Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> : Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></a></p>';
            } else {
                echo '
                <p class="my-0">ID: ' . $data["chk_id"] . ' - Fiscal Year Successfully Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> vs Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></p>';
            }
        }
    }

    $sql = "SELECT `jour_id` as chk_id, `jour_date_avaliable` as chk_date, `jour_fiscalyear` as fiscalyear FROM `journal` WHERE `jour_fiscalyear` != ''";
    $data_array = $fnc->get_db_array($sql);
    if (!empty($data_array)) {
        echo '
        
        <h3 class="mt-3">DB Journal</h3>';
        foreach ($data_array as $data) {
            if ($fnc->get_fiscal_year($data["chk_date"]) != $data["fiscalyear"]) {
                echo '
                <p class="my-2 text-danger"><a href="journal.php?p=journal&act=viewinfo&jid=' . $data["chk_id"] . '" target="_blank" class="link-danger">ID: ' . $data["chk_id"] . ' - Fiscal Year Error Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> : Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></a></p>';
            } else {
                echo '
                <p class="my-0">ID: ' . $data["chk_id"] . ' - Fiscal Year Successfully Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> vs Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></p>';
            }
        }
    }

    $sql = "SELECT `proj_id` as chk_id, `proj_period_begin` as chk_date, `proj_fiscalyear` as fiscalyear FROM `project` WHERE `proj_fiscalyear` != ''";
    $data_array = $fnc->get_db_array($sql);
    if (!empty($data_array)) {
        echo '
        
        <h3 class="mt-3">DB Project</h3>';
        foreach ($data_array as $data) {
            if ($fnc->get_fiscal_year($data["chk_date"]) != $data["fiscalyear"]) {
                echo '
                <p class="my-2 text-danger"><a href="project.php?p=project&act=viewinfo&jid=' . $data["chk_id"] . '" target="_blank" class="link-danger">ID: ' . $data["chk_id"] . ' - Fiscal Year Error Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> : Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></a></p>';
            } else {
                echo '
                <p class="my-0">ID: ' . $data["chk_id"] . ' - Fiscal Year Successfully Month,Year=' . date("M", strtotime($data["chk_date"])) . ', ' . (date("Y", strtotime($data["chk_date"])) + 543) . ' // DB=<strong>' . $data["fiscalyear"] . '</strong> vs Right=<strong>' . $fnc->get_fiscal_year($data["chk_date"]) . '</strong></p>';
            }
        }
    }
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

    <?php include('main_menu.php'); ?>

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
                    case "chkFiscalYear":
                        echo '<div class="container">';
                        check_db_fiscalyear();
                        echo '</div>';
                        break;
                }
            } else {
                // echo "none parameters";
            ?>
                <div class="container">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>


                </div>
            <?php
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