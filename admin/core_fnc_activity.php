<!doctype html>
<?php

// * reseach function
class activity_fnc
{
    public function data_report_submenu()
    {
        // $fnc = new web;
        global $fnc;
?>
        <div class="text-white-50 mb-0 d-print-none" style="background-color:#baa0df; margin-top:3.6em;">
            <div class="container px-0 px-md-5">
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'personal') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=project&act=report&cat=personal">รายบุคคล</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'department') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=project&act=report&cat=department">รายหลักสูตร</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'apasample') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=project&act=report&cat=apasample">APA's Ref</a>
                    </li>
                </ul>
            </div>
        </div>
    <?php
    }

    public function gen_report()
    {
        global $fnc;

        $sql = "SELECT * FROM project WHERE proj_id = " . $_GET["pid"];
        $fnc->debug_console('sql project table: \n' . $sql);
        $data_project = $fnc->get_db_row($sql);
        $fnc->debug_console("data array:", $data_project);
    ?>

        <div class="card p-0 p-md-0 border border-white">
            <div class="card-header bg-light bg-gradient row d-print-none">
                <div class="col-12 col-md-12 col-lg-9 d-print-none">
                    <h5 class="card-title mt-2 h5 text-primary">Activity Report</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานสรุปผลดำเนินงานการบริการวิชาการ</h6>
                </div>

            </div>

            <div class="card-body mt-0" style="font-size: 0.8em;">
                <?php
                // ***
                // echo '<h5 class="card-title mt-2 h5 text-primary">journal ' . $k . $y . '</h5>';
                echo '<div class="text-center">
                <p class="h4 mb-1" style="font-size: 0.9rem;">' . 'สรุปรายละเอียดการดำเนินงานการบริการวิชาการ' . '</p>';
                echo '<p class="h4 mb-1" style="font-size: 0.9rem;">' . 'โครงการ' . $data_project["proj_name"] . '</p>';
                echo '<p class="h4 mb-1" style="font-size: 0.9rem;">' . 'โดย ' . $fnc->gen_titlePosition_short($data_project["proj_owner_prename"]) . $data_project["proj_owner_firstname"] . ' ' . $data_project["proj_owner_lastname"] . '</p>';
                echo '<p class="h4 mb-1" style="font-size: 0.9rem;">ระยะเวลาดำเนินการ ';
                $fnc->gen_date_range_semi_th($data_project["proj_period_begin"], $data_project["proj_period_finish"]);
                echo '</p>';
                echo '<p class="h4 mb-3" style="font-size: 0.9rem;">' . 'งบประมาณ ' . number_format($data_project["proj_budget"], 0) . ' บาท' . '  (แหล่งทุน: ' . $data_project["proj_budget_source"] . ')</p>';
                echo '
                </div>';

                $data_array = $this->gen_table_report($data_project);

                if (!empty($data_project["proj_detail"])) {
                    echo '<p class="h5 mb-1" style="font-size: 0.8rem;"><strong>หมายเหตุ.</strong> ' . $data_project["proj_detail"] . '</p>';
                }
                ?>
            </div>

            <div class="card-footer text-end text-muted" style="font-size: 0.6em;">
                last update: <?= date('M d, Y'); ?>
            </div>

        </div>
        <?php
        if (!empty($data_array)) {
            // echo '<div class="page-break" style"page-break-before: always;">page break before</div>';
            $pages = count($data_array);
            $cur_page = 1;
            echo '<div class="px-5 bg-white">';
            foreach ($data_array as $activity) {
                $cur_page++;
                echo '<div class="page-break">&nbsp;</div>'; // * page break
                echo '<div class="row mb-3 mt-4">';
                echo '<div id="activity_detail" class=" col-auto">';
                echo '<p class="h5 fw-bold" style="font-size: 0.8rem;">';
                $fnc->gen_date_full_thai($activity["pa_period_begin"]);
                echo ' : ' . $activity["pa_location"] . '</p>';
                echo '</div>';
                echo '<div id"page_number" class="col-auto ms-auto text-end">
                <p class="text-end fw--bold" style="font-size: 0.8rem;">โครงการ ' . $data_project["proj_name"] . ' หน้า ' . $cur_page . '/' . ($pages+1) .'</p>
                </div>';
                echo ' 
                </div>';


                echo '
                    <div class="p-3">';
                $sql = "SELECT * FROM attachment WHERE att_ref_table = 'activity' AND att_status = 'enable' AND att_ref_id = " . $activity["pa_id"];
                $data_att = $fnc->get_db_array($sql);
                if (!empty($data_att)) {
                    echo '<div class="row g-5" style="page-break-inside: avoid;">';
                    foreach ($data_att as $att) {
                        echo '
                            <div class="col-3">';
                        echo '<img src="../' . $att["att_filepath"] . $att["att_filename"] . '" class="border border-secondary border-2 img-fluid w-100 box_shadow" alt="' . $activity["pa_location"] . '">';
                        echo '</div>';
                    }
                    echo '</div>';
                }


                echo '</div>';
            }
            echo '</div>';
        }
        ?>


    <?php
    }

    public function gen_table_report($data_project)
    {
        global $fnc;
    ?>
        <table class="table table-bordered table-inverse table-responsive">
            <thead class="thead-inverse bg-light">
                <tr class="text-center fw-bold align-middle">
                    <th style="width:5em;">ลำดับที่</th>
                    <th>วันที่</th>
                    <th>สถานที่</th>
                    <th>ผู้เข้าร่วมกิจกรรม</th>
                    <th>จำนวนผู้เข้าร่วม</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.85em;">
                <?php
                $sql = "SELECT * FROM project_activity WHERE pa_status = 'enable' AND proj_id = " . $data_project["proj_id"];
                $sql .= " ORDER BY pa_period_begin Asc";
                $fnc->debug_console('sql project activity table: \n' . $sql);
                $data_array = $fnc->get_db_array($sql);
                $fnc->debug_console("activity data array:", $data_array[0]);
                if (!empty($data_array)) {
                    $this->gen_table_tr_report($data_array);
                } else {
                    echo '<tr style="page-break-before:auto">';
                    echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="6">no data founded</td>';
                    echo '</tr>';
                } ?>

            </tbody>
        </table>
        <?php
        return $data_array;
    }

    public function gen_table_tr_report($data_array)
    {
        $fnc = new web;

        // $fnc->debug_console("data list sample: ", $data_array[0]);
        $x = 1;
        foreach ($data_array as $row) {
        ?>
            <!-- <tr style="page-break-before: always;"> -->
            <tr>
                <td scope="row" class="text-center"><?= $x ?></td>
                <td class="text-center" nowarp><?php
                                                if (!empty($row["pa_period_begin"])) {
                                                    $fnc->gen_date_range_semi_th($row["pa_period_begin"], $row["pa_period_finish"]);
                                                }
                                                ?>
                </td>
                <td class="text-start"><?php
                                        if (!empty($row["pa_location"])) {
                                            echo $row["pa_location"];
                                        }
                                        ?>
                </td>
                <td class="text-start"><?php
                                        if (!empty($row["pa_participant"])) {
                                            echo $row["pa_participant"];
                                        }
                                        ?>
                </td>
                <td class="text-center"><?php
                                        if (!empty($row["pa_participant_number"])) {
                                            echo $row["pa_participant_number"];
                                        }
                                        ?>
                </td>
                <td class="text-start"><?php
                                        if (!empty($row["pa_detail"])) {
                                            echo $row["pa_detail"];
                                        }
                                        ?>
                </td>
            </tr>
<?php
            $x++;
        }
    }
}
