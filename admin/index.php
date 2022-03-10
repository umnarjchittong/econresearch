<!doctype html>
<?php
// die('<h1>NO USED</h1>');
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web;
$sql_display_limit = ' limit 5';

if (empty($_SESSION["admin"])) {
    die('<meta http-equiv="refresh" content="0;url=../sign/">');
} else {
    $fnc->debug_console("Admin: \\n", $_SESSION["admin"]);
}


function gen_my_research($data_array)
{
    global $fnc;
    $linkable = 'true';
?>
    <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
        <thead class="thead-inverse|thead-default">
            <tr class="text-center fw-bold">
                <th style="width:3em;">#</th>
                <th class="d-none d-md-table-cell">นักวิจัย</th>
                <th>ชื่องานวิจัย/เรื่อง</th>
                <th>แหล่งทุน</th>
                <th class="d-none d-md-table-cell" style="width:7em;">ระยะเวลา</th>
            </tr>
        </thead>
        <tbody style="font-size: 0.85em;">
            <?php
            if (!empty($data_array)) {
                $x = 1;
                foreach ($data_array as $row) {
            ?>
                    <tr>
                        <td scope="row" class="text-center"><?= $x ?></td>
                        <td class="d-none d-md-table-cell" nowrap><?php
                                                                    if ($linkable) {
                                                                        echo '<a href="research.php?p=research&find=memberId&k=' . $row["res_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["res_owner_prename"]) . $row["res_owner_firstname"] . ' ' . $row["res_owner_lastname"] . '</a>';
                                                                    } else {
                                                                        echo $fnc->gen_titlePosition_short($row["res_owner_prename"]) . $row["res_owner_firstname"] . ' ' . $row["res_owner_lastname"];
                                                                    }
                                                                    ?>
                            <?php
                            $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'research' AND `cow_ref_id` = " . $row["res_id"];
                            $fnc->debug_console("co worker sql: " . $sql);
                            $co_worker = $fnc->get_db_array($sql);
                            if (!empty($co_worker)) {
                                // $fnc->debug_console("co worker data: " . " res_ id " . $row["res_id"] . " cnt " . count($co_worker) . " - " , $co_worker);
                                foreach ($co_worker as $cow) {
                                    echo '<br>';
                                    if (!empty($cow["cow_citizenid"]) && $linkable) {
                                        echo '<a href="research.php?p=research&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                                    } else {
                                        echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?php
                            if ($linkable) {
                                echo '<a href="research.php?p=research&act=viewinfo&rid=' . $row["res_id"] . '" target="_top" class="fw-bold">' . $row["res_name"] . '</a>';
                            } else {
                                echo $row["res_name"];
                            }
                            if (!empty($row["res_researchID"])) {
                                echo '<a href="https://erp.mju.ac.th/researchDetail.aspx?rid=' . $row["res_researchID"] . '" target="_blank" class="ms-3 link-danger"><i class="bi bi-info-circle me-1"></i>ERP</a>';
                            }
                            ?>
                        </td>
                        <td><?php
                            if ($linkable) {
                                // echo '<a href="research.php?p=' . $_GET['p'] . '&act=viewinfo&rid=' . $row["res_id"] . '" target="_top" class="fw-bold">' . $row["res_conf"] . '</a>';
                                echo $row["res_budget_source"];
                            } else {
                                echo $row["res_budget_source"];
                            }
                            ?>
                        </td>
                        <td class="text-center d-none d-md-table-cell"><?php $fnc->gen_date_semi_th(($row["res_period_begin"])) ?></td>
                    </tr>
            <?php
                    $x++;
                }
            } else {
                echo '<tr>';
                echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="5">no data founded</td>';
                echo '</tr>';
            } ?>
        </tbody>
    </table>
<?php
}

function gen_my_proceeding($data_array)
{
    global $fnc;
    $linkable = 'true';
?>
    <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
        <thead class="thead-inverse|thead-default">
            <tr class="text-center fw-bold">
                <th style="width:3em;">#</th>
                <th class="d-none d-md-table-cell">เจ้าของผลงาน</th>
                <th>ชื่อผลงาน/เรื่อง</th>
                <th>ชื่อการประชุมวิชาการ</th>
                <th class="d-none d-md-table-cell" style="width:7em;">วันที่นำเสนอ</th>
            </tr>
        </thead>
        <tbody style="font-size: 0.85em;">
            <?php
            if (!empty($data_array)) {
                $x = 1;
                foreach ($data_array as $pro) {
                    $sql = "SELECT * FROM `proceeding` WHERE `pro_id` = " . $pro["pro_id"];
                    $row = $fnc->get_db_row($sql);
                    if (!empty($row)) {
                        if (!empty($row["pro_tier"]) && $row["pro_tier"] == "ระดับนานาชาติ") {
                            $pro_tier = '../images/tier_icon_global_64.png';
                        } else {
                            $pro_tier = '../images/tier_icon_local_64.png';
                        }
                        $pro_tier = '<img src="' . $pro_tier . '" class="mb-1 me-2" width="16em">';
            ?>
                        <tr>
                            <td scope="row" class="text-center"><?= $x
                                                                ?><? //= $row["pro_id"]; 
                                                                    ?></td>
                            <td class="d-none d-md-table-cell" nowrap><?php
                                                                        if ($linkable) {
                                                                            // echo '<a href="research.php?p=proceeding&find=memberId&k=' . $row["citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["prename"]) . $row["firstname"] . ' ' . $row["lastname"] . '</a>';
                                                                            echo '<a href="proceeding.php?p=proceeding&find=memberId&k=' . $row["pro_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"] . '</a>';
                                                                        } else {
                                                                            // echo $fnc->gen_titlePosition_short($row["prename"]) . $row["firstname"] . ' ' . $row["lastname"];
                                                                            echo $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"];
                                                                        }
                                                                        ?>
                                <?php
                                $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'proceeding' AND `cow_ref_id` = " . $row["pro_id"];
                                // $fnc->debug_console("co worker sql: " . $sql);
                                $co_worker = $fnc->get_db_array($sql);
                                if (!empty($co_worker)) {
                                    foreach ($co_worker as $cow) {
                                        echo '<br>';
                                        if (!empty($cow["cow_citizenid"]) && $linkable) {
                                            echo '<a href="proceeding.php?p=proceeding&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                                        } else {
                                            echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td><?php
                                if ($linkable) {
                                    echo $pro_tier . '<a href="proceeding.php?p=proceeding&act=viewinfo&pid=' . $row["pro_id"] . '" target="_top" class="fw-bold">' . $row["pro_study"] . '</a>';
                                } else {
                                    echo $pro_tier . $row["pro_study"];
                                }
                                ?>
                            </td>
                            <td><?php
                                if ($linkable) {
                                    // echo '<a href="proceeding.php?p=' . $_GET['p'] . '&act=viewinfo&pid=' . $row["pro_id"] . '" target="_top" class="fw-bold">' . $row["pro_conf"] . '</a>';
                                    echo $row["pro_conf"];
                                } else {
                                    echo $row["pro_conf"];
                                }
                                ?>
                            </td>
                            <td class="text-center d-none d-md-table-cell"><?php $fnc->gen_date_semi_th(($row["pro_date_begin"])) ?></td>
                        </tr>
            <?php
                    }
                    $x++;
                }
            } else {
                echo '<tr>';
                echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="5">no data founded</td>';
                echo '</tr>';
            } ?>

        </tbody>
    </table>
<?php
}

function gen_my_journal($data_array)
{
    global $fnc;
    $linkable = 'true';
?>
    <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
        <thead class="thead-inverse|thead-default">
            <tr class="text-center fw-bold">
                <th style="width:3em;">#</th>
                <th class="d-none d-md-table-cell">เจ้าของผลงาน</th>
                <th>ชื่อผลงาน/เรื่อง</th>
                <th>ชื่อวารสาร/ฐานข้อมูล</th>
                <th class="d-none d-md-table-cell" style="width:7em;">วันที่เผยแพร่</th>
            </tr>
        </thead>
        <tbody style="font-size: 0.85em;">
            <?php

            if (!empty($data_array)) {
                $x = 1;
                foreach ($data_array as $row) {
                    if (!empty($row["jour_tier"]) && $row["jour_tier"] == "ระดับนานาชาติ") {
                        $jour_tier = '../images/tier_icon_global_64.png';
                    } else {
                        $jour_tier = '../images/tier_icon_local_64.png';
                    }
                    $jour_tier = '<img src="' . $jour_tier . '" class="mb-1 me-2" width="16em">';
            ?>
                    <tr>
                        <td scope="row" class="text-center"><?= $x ?></td>
                        <td class="d-none d-md-table-cell" nowrap><?php
                                                                    if ($linkable) {
                                                                        echo '<a href="journal.php?p=journal&find=memberId&k=' . $row["jour_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["jour_owner_prename"]) . $row["jour_owner_firstname"] . ' ' . $row["jour_owner_lastname"] . '</a>';
                                                                    } else {
                                                                        echo $fnc->gen_titlePosition_short($row["jour_owner_prename"]) . $row["jour_owner_firstname"] . ' ' . $row["jour_owner_lastname"];
                                                                    }
                                                                    ?>
                            <?php
                            $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'journal' AND `cow_ref_id` = " . $row["jour_id"];
                            $fnc->debug_console("co worker sql: " . $sql);
                            $co_worker = $fnc->get_db_array($sql);
                            if (!empty($co_worker)) {
                                // $fnc->debug_console("co worker data: " . " pro id " . $row["jour_id"] . " cnt " . count($co_worker) . " - " , $co_worker);
                                foreach ($co_worker as $cow) {
                                    echo '<br>';
                                    if (!empty($cow["cow_citizenid"]) && $linkable) {
                                        echo '<a href="journal.php?p=journal&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                                    } else {
                                        echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?php
                            if ($linkable) {
                                echo $jour_tier . '<a href="journal.php?p=journal&act=viewinfo&jid=' . $row["jour_id"] . '" target="_top" class="fw-bold">' . $row["jour_study"] . '</a>';
                            } else {
                                echo $jour_tier . $row["jour_study"];
                            }
                            ?>
                        </td>
                        <td><?php
                            if ($linkable) {
                                // echo '<a href="journal.php?p=' . $_GET['p'] . '&act=viewinfo&jid=' . $row["jour_id"] . '" target="_top" class="fw-bold">' . $row["jour_conf"] . '</a>';
                                echo $row["jour_journal"];
                            } else {
                                echo $row["jour_journal"];
                            }
                            ?>
                        </td>
                        <td class="text-center d-none d-md-table-cell"><?php $fnc->gen_date_semi_th(($row["jour_date_avaliable"])) ?></td>
                    </tr>
            <?php
                    $x++;
                }
            } else {
                echo '<tr>';
                echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="5">no data founded</td>';
                echo '</tr>';
            } ?>

        </tbody>
    </table>
<?php
}

function gen_my_project($data_array)
{
    global $fnc;
    $linkable = 'true';
?>
    <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
        <thead class="thead-inverse|thead-default">
            <tr class="text-center fw-bold">
                <th style="width:3em;">#</th>
                <th class="d-none d-md-table-cell">นักวิจัย</th>
                <th>โครงการบริการวิชาการ</th>
                <!-- <th>แหล่งทุน</th> -->
                <th class="d-none d-md-table-cell" style="width:7em;">ระยะเวลา</th>
            </tr>
        </thead>
        <tbody style="font-size: 0.85em;">
            <?php
            if (!empty($data_array)) {
                $x = 1;
                foreach ($data_array as $row) {
            ?>
                    <tr>
                        <td scope="row" class="text-center"><?= $x ?></td>
                        <td class="d-none d-md-table-cell" nowrap><?php
                                                                    if ($linkable) {
                                                                        echo '<a href="project.php?p=project&find=memberId&k=' . $row["proj_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["proj_owner_prename"]) . $row["proj_owner_firstname"] . ' ' . $row["proj_owner_lastname"] . '</a>';
                                                                    } else {
                                                                        echo $fnc->gen_titlePosition_short($row["proj_owner_prename"]) . $row["proj_owner_firstname"] . ' ' . $row["proj_owner_lastname"];
                                                                    }
                                                                    ?>
                            <?php
                            $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'project' AND `cow_ref_id` = " . $row["proj_id"];
                            $fnc->debug_console("co worker sql: " . $sql);
                            $co_worker = $fnc->get_db_array($sql);
                            if (!empty($co_worker)) {
                                // $fnc->debug_console("co worker data: " . " proj_ id " . $row["proj_id"] . " cnt " . count($co_worker) . " - " , $co_worker);
                                foreach ($co_worker as $cow) {
                                    echo '<br>';
                                    if (!empty($cow["cow_citizenid"]) && $linkable) {
                                        echo '<a href="project.php?p=project&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                                    } else {
                                        echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?php
                            if ($linkable) {
                                echo '<a href="project.php?p=project&act=viewinfo&pid=' . $row["proj_id"] . '" target="_top" class="fw-bold">' . $row["proj_name"] . '</a>';
                            } else {
                                echo $row["proj_name"];
                            }
                            ?>
                        </td>
                        <!-- <td><?php
                                    // if ($linkable) {
                                    //     // echo '<a href="project.php?p=' . $_GET['p'] . '&act=viewinfo&pid=' . $row["proj_id"] . '" target="_top" class="fw-bold">' . $row["proj_conf"] . '</a>';
                                    //     echo $row["proj_budget_source"];
                                    // } else {
                                    //     echo $row["proj_budget_source"];
                                    // }
                                    ?>
                                    </td> -->
                        <td class="text-center d-none d-md-table-cell"><?php $fnc->gen_date_semi_th(($row["proj_period_begin"])) ?></td>
                    </tr>
            <?php
                    $x++;
                }
            } else {
                echo '<tr>';
                echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="5">no data founded</td>';
                echo '</tr>';
            } ?>

        </tbody>
    </table>
<?php
}
?>


<html lang="en">

<head>
    <title>ECON-Academic and Services</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <!-- <link href="../images/favicon.png" rel="icon"> -->

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">

    <style>
            .accordion-button {
                background-color: #baa0df;
            }
            .user_photo {
                width: 120px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            }
        </style>

</head>

<body style="background-color: #DFD9EA;">

    <?php include('main_menu.php'); ?>

    <div style="margin-top:3em;">&nbsp;</div>

    <main class="mb-3">
        <div class="container mx-auto py-3">

            <?php
            // if (isset($_GET['p']) && $_GET['p'] != '') {
            //     switch ($_GET['p']) {
            //         case "proceeding":
            //             die("");
            //             break;
            //     }
            // } else {
            // }
            ?>



            <div class="row">
                <div class="col-3 text-center">
                    <img src="<?= $_SESSION["admin"]["personnelPhoto"] ?>" class="img-thumbnail rounded rounded-3 mx-auto user_photo" alt="">
                </div>
                <div class="col-auto pt-3" style="font-size: 1rem;">
                    <h2 style="font-size: 1.75em"><?= $_SESSION["admin"]["titlePosition"] . " " . $_SESSION["admin"]["firstName"] . "  " . $_SESSION["admin"]["lastName"] ?></h2>
                    <h3 style="font-size: 1.6em"><?= $_SESSION["admin"]["titleNameEn"] . " " . $_SESSION["admin"]["firstName_en"] . "  " . $_SESSION["admin"]["lastName_en"] ?></h3>
                    <h3 style="font-size: 1.2em"><?= "สิทธิ์การเข้าถึง : ระดับ" . $fnc->system_auth_lv[$_SESSION["admin"]["auth_lv"]] ?></h3>
                </div>
            </div>



        </div>

        <div class="container-fluid p-3" style="font-size: 0.8rem">
            <div class="accordion" id="accordionPanelsStayOpen">
                <div class="accordion-item">
                    <?php
                    $sql = "Select res.* From research res Left Join co_worker cowo On cowo.cow_ref_id = res.res_id Where ";
                    $sql .= "res.res_status Like 'enable'";
                    $sql .= " AND (res_owner_citizenid LIKE '" . $_SESSION["admin"]["citizenId"] . "' OR (cowo.cow_citizenid Like '" . $_SESSION["admin"]["citizenId"] . "' AND cowo.cow_ref_table LIKE 'research'))";
                    $sql_group = " Group By res_period_begin, res.res_id";
                    $sql_order = " Order By res_period_begin Desc"; // order
                    $sql .= $sql_group . $sql_order;
                    $sql .= $sql_display_limit;
                    $fnc->debug_console('sql table my research : \n' . $sql);
                    $data_array = $fnc->get_db_array($sql);
                    ?>
                    <h2 class="accordion-header" id="panelsStayOpen-heading1">
                        <button class="accordion-button<?php if (empty($data_array)) {
                                                            echo ' collapsed';
                                                        } ?> text-dark" id="accordion-button1" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse1" aria-expanded="true" aria-controls="panelsStayOpen-collapse1">
                            งานวิจัย
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapse1" class="accordion-collapse collapse<?php if (!empty($data_array)) {
                                                                                                echo ' show';
                                                                                            } ?>" aria-labelledby="panelsStayOpen-heading1">
                        <div class="accordion-body">
                            <?php gen_my_research($data_array); ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <?php
                    $sql = "SELECT pro_id FROM v_proceeding_report2 WHERE";
                    $sql .= " pro_status = 'enable'";
                    $sql .= " AND (citizenid = '" . $_SESSION["admin"]["citizenId"] . "')"; // (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'research'))";
                    $sql_group = " Group By pro_id, pro_date_begin";
                    $sql_order = " Order By pro_date_begin Desc";
                    $sql .= $sql_group . $sql_order;
                    $sql .= $sql_display_limit;
                    $fnc->debug_console('sql table my proceeding: \n' . $sql);
                    $data_array = $fnc->get_db_array($sql);
                    ?>
                    <h2 class="accordion-header" id="panelsStayOpen-heading2">
                        <button class="accordion-button<?php if (empty($data_array)) {
                                                            echo ' collapsed';
                                                        } ?>" id="accordion-button2" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse2" aria-expanded="false" aria-controls="panelsStayOpen-collapse2">
                            งานนำเสนอ
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapse2" class="accordion-collapse collapse<?php if (!empty($data_array)) {
                                                                                                echo ' show';
                                                                                            } ?>" aria-labelledby="panelsStayOpen-heading2">
                        <div class="accordion-body">
                            <?php gen_my_proceeding($data_array); ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <?php
                    $sql = "Select jou.* From journal jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                    $sql .= "jou.jour_status Like 'enable'";
                    $sql .= " AND (jou.jour_owner_citizenid LIKE '" . $_SESSION["admin"]["citizenId"] . "' OR  (cowo.cow_citizenid Like '" . $_SESSION["admin"]["citizenId"] . "' AND cowo.cow_ref_table LIKE 'journal'))";
                    $sql_group = " Group By jou.jour_date_avaliable, jou.jour_id";
                    $sql_order = " Order By jou.jour_date_avaliable Desc"; // order
                    $sql .= $sql_group . $sql_order;
                    $sql .= $sql_display_limit;
                    $fnc->debug_console('sql table owner: \n' . $sql);
                    $data_array = $fnc->get_db_array($sql);
                    ?>
                    <h2 class="accordion-header" id="panelsStayOpen-heading3">
                        <button class="accordion-button<?php if (empty($data_array)) {
                                                            echo ' collapsed';
                                                        } ?>" id="accordion-button3" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse3" aria-expanded="false" aria-controls="panelsStayOpen-collapse3">
                            งานตีพิมพ์
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapse3" class="accordion-collapse collapse<?php if (!empty($data_array)) {
                                                                                                echo ' show';
                                                                                            } ?>" aria-labelledby="panelsStayOpen-heading3">
                        <div class="accordion-body">
                            <?php gen_my_journal($data_array); ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <?php
                    $sql = "Select proj.* From project proj Left Join co_worker cowo On cowo.cow_ref_id = proj.proj_id Where ";
                    $sql .= "proj.proj_status Like 'enable'";
                    $sql .= " AND (proj.proj_owner_citizenid LIKE '" . $_SESSION["admin"]["citizenId"] . "' OR (cowo.cow_citizenid Like '" . $_SESSION["admin"]["citizenId"] . "' AND cowo.cow_ref_table LIKE 'project'))";
                    $sql_group = " Group By proj.proj_period_begin, proj.proj_id";
                    $sql_order = " Order By proj.proj_period_begin Desc"; // order
                    $sql .= $sql_group . $sql_order;
                    // * display 30 records per load
                    $sql .= $sql_display_limit;
                    $fnc->debug_console('sql table owner: \n' . $sql);
                    $data_array = $fnc->get_db_array($sql);
                    ?>
                    <h2 class="accordion-header" id="panelsStayOpen-heading4">
                        <button class="accordion-button<?php if (empty($data_array)) {
                                                            echo ' collapsed';
                                                        } ?>" id="accordion-button4" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse4" aria-expanded="false" aria-controls="panelsStayOpen-collapse4">
                            งานบริการวิชาการ
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapse4" class="accordion-collapse collapse<?php if (!empty($data_array)) {
                                                                                                echo ' show';
                                                                                            } ?>" aria-labelledby="panelsStayOpen-heading4">
                        <div class="accordion-body">
                            <?php gen_my_project($data_array); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <?php  include('../sweet_alert.php'); 
    ?>

</body>

</html>