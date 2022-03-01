<!doctype html>
<?php

// * Proceeding function
class proceeding_fnc
{
    public function gen_append_form()
    {
        $fnc = new web;
?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient">
                <h5 class="card-title mt-2 h3 text-primary">Proceeding: New</h5>
                <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การนำเสนอผลงานวิจัย/ผลงานทางวิชาการ</h6>
            </div>

            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pro_study" id="pro_study" aria-describedby="pro_studyHelp" placeholder="ชื่อผลงาน/เรื่อง" required>
                        <label for="pro_study" class="form-label">ชื่อผลงาน/เรื่อง <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pro_conf" id="pro_conf" aria-describedby="pro_confHelp" placeholder="ชื่อการการประชุมวิชาการ" required>
                        <label for="pro_conf" class="form-label">ชื่อการประชุมวิชาการ <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pro_conf_owner" id="pro_conf_owner" aria-describedby="pro_conf_ownerHelp" placeholder="หน่วยงานที่จัดประชุม">
                        <label for="pro_conf_owner" class="form-label">หน่วยงานที่จัดประชุม</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pro_location" id="pro_location" aria-describedby="pro_locationHelp" placeholder="สถานที่จัดประชุม">
                        <label for="pro_location" class="form-label">สถานที่จัดประชุม</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pro_volume_issue" id="pro_volume_issue" aria-describedby="pro_volume_issueHelp" placeholder="9(1)">
                        <label for="pro_volume_issue" class="form-label">ปีที่ Volume (ฉบับที่ Issue) </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pro_page" id="pro_page" aria-describedby="pro_pageHelp" placeholder="101-104">
                        <label for="pro_page" class="form-label">หน้าที่ตีพิมพ์ </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="pro_link" id="pro_link" aria-describedby="pro_linkHelp" placeholder="http://mju.ac.th">
                        <label for="pro_link" class="form-label">ลิงก์ออนไลน์ </label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="pro_date_begin" class="form-label">ระดับการนำเสนอ <span class="lbl_required">*</span></label>
                            <div class="col-12 mb-3">
                                <div class="form-check form-check-inline ms-2 ms-md-5">
                                    <input class="form-check-input" type="radio" name="pro_tier" id="pro_tier_1" value="ระดับชาติ" checked>
                                    <label class="form-check-label" for="pro_tier_1">ชาติ</label>
                                </div>
                                <div class="form-check form-check-inline ms-2 ms-md-3">
                                    <input class="form-check-input" type="radio" name="pro_tier" id="pro_tier_2" value="ระดับนานาชาติ">
                                    <label class="form-check-label" for="pro_tier_2">นานาชาติ</label>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row g-3">
                                    <div class="col-md-6 form-floating">
                                        <input type="date" class="form-control" name="pro_date_begin" id="pro_date_begin" aria-describedby="pro_date_beginHelp" required>
                                        <label for="pro_date_begin" class="form-label">วันที่นำเสนอ <span class="lbl_required">*</span></label>
                                    </div>
                                    <div class="col-md-6  form-floating">
                                        <input type="date" class="form-control" name="pro_date_end" id="pro_date_end" aria-describedby="pro_date_endHelp">
                                        <label for="pro_date_end" class="form-label">วันที่สิ้นสุด (ถ้ามี)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating col-12 mb-3">
                                <textarea class="form-control" name="pro_detail" id="pro_detail" rows="5" style="height: 10em;" placeholder="(ถ้ามี)"></textarea>
                                <label for="pro_detail" class="form-label">รายละเอียด</label>
                            </div>

                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <?php
                            $sql_department = "SELECT `department_name` FROM `department` WHERE `department_name` <> '' ORDER BY `department_order`,`department_name`";
                            $dept = $fnc->get_db_array($sql_department);
                            if (!empty($dept)) { ?>
                                <div class="col-12 mb-3 form-floating">
                                    <select class="form-select" name="department_name" id="department_name" aria-describedby="department_nameHelp" required>
                                        <?php
                                        // $sql = "SELECT * FROM `department` ORDER BY `department_order`, `department_name`";
                                        // $data_array = $fnc->get_db_array($sql);
                                        echo '<option value=""';
                                        echo ' selected';
                                        echo '>ไม่ระบุ</option>';
                                        foreach ($dept as $opt) {
                                            echo '<option value="' . $opt["department_name"] . '"';
                                            echo '>' . $opt["department_name"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="department_name" class="form-label">หลักสูตร/สาขาวิชา <span class="lbl_required">*</span></label>
                                </div>
                            <?php } ?>

                            <div class="col-12 mb-3 form-floating">
                                <select class="form-select" size="8" style="height: 10em;" name="pro_owner_citizenid" id="pro_owner_citizenid" aria-describedby="pro_owner_citizenidHelp" required>
                                    <?php
                                    $MJU_API = new MJU_API;
                                    $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
                                    $econ_member = $MJU_API->GetAPI_array($api_url);
                                    $fnc->debug_console("econ member", $econ_member[0]);
                                    if (!empty($econ_member)) {
                                        foreach ($econ_member as $member) {
                                            echo '<option value="' . $member["citizenId"] . '">' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                        }
                                    } else {
                                        $fnc->debug_console("no member");
                                    }
                                    ?>
                                </select>
                                <label for="pro_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                            </div>

                            <div class="col-12">
                                <div class="col form-floating">
                                    <input type="number" class="form-control" name="pro_ratio" id="pro_ratio" aria-describedby="pro_ratioHelp" value="100" max="100" maxlength="5">
                                    <label for="pro_ratio" class="form-label">สัดส่วน (%)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="proceeding_append">
                    <div class="row px-3 gx-3 mt-3">
                        <div class="col-6 col-md-3 offset-md-6">
                            <button type="button" class="btn btn-secondary w-100 py-2 text-uppercase" onclick="window.location='?p=proceeding'">close</button>
                        </div>
                        <div class="col-6 col-md-3">
                            <button type="submit" class="btn btn-primary w-100 py-2 ms-3 text-uppercase">Save</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    <?php
    }

    public function gen_update_form($id)
    {
        $fnc = new web;
        $sql = "SELECT * FROM `proceeding` WHERE `pro_id` = " . $id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("data row: ", $row);
    ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">Proceeding: Updating</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การนำเสนอผลงานวิจัย/ผลงานทางวิชาการ - ปรับปรุงข้อมูล</h6>
                </div>

                <?php $this->gen_proceeding_action_menu(); ?>
            </div>


            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="pro_study" id="pro_study" aria-describedby="pro_studyHelp" value="<?= $row["pro_study"] ?>" required>
                        <label for="pro_study" class="form-label">ชื่อผลงาน/เรื่อง <span class="lbl_required">*</span></label>
                        <!-- <div id="pro_studyHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="pro_conf" id="pro_conf" aria-describedby="pro_confHelp" value="<?= $row["pro_conf"] ?>" required>
                        <label for="pro_conf" class="form-label">ชื่อการประชุมวิชาการ <span class="lbl_required">*</span></label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="pro_conf_owner" id="pro_conf_owner" aria-describedby="pro_conf_ownerHelp" value="<?= $row["pro_conf_owner"] ?>">
                        <label for="pro_conf_owner" class="form-label">หน่วยงานที่จัดประชุม</label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="pro_location" id="pro_location" aria-describedby="pro_locationHelp" value="<?= $row["pro_location"] ?>">
                        <label for="pro_location" class="form-label">สถานที่จัดประชุม</label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="pro_volume_issue" id="pro_volume_issue" aria-describedby="pro_volume_issueHelp" value="<?= $row["pro_volume_issue"] ?>">
                        <label for="pro_volume_issue" class="form-label">ปีที่ Volume (ฉบับที่ Issue) </label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="pro_page" id="pro_page" aria-describedby="pro_pageHelp" value="<?= $row["pro_page"] ?>">
                        <label for="pro_page" class="form-label">หน้าที่ตีพิมพ์ </label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="pro_link" id="pro_link" aria-describedby="pro_linkHelp" value="<?= $row["pro_link"] ?>">
                        <label for="pro_link" class="form-label">ลิงก์ออนไลน์ </label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="pro_date_begin" class="form-label">ระดับการนำเสนอ <span class="lbl_required">*</span></label>
                            <div class="col-12 mb-3">
                                <div class="form-check form-check-inline ms-2 ms-md-5">
                                    <input class="form-check-input" type="radio" name="pro_tier" id="pro_tier_1" value="ระดับชาติ" <?php if ($row["pro_tier"] == 'ระดับชาติ') {
                                                                                                                                        echo ' checked';
                                                                                                                                    } ?>>
                                    <label class="form-check-label" for="pro_tier_1">ชาติ</label>
                                </div>
                                <div class="form-check form-check-inline ms-2 ms-md-3">
                                    <input class="form-check-input" type="radio" name="pro_tier" id="pro_tier_2" value="ระดับนานาชาติ" <?php if ($row["pro_tier"] == 'ระดับนานาชาติ') {
                                                                                                                                            echo ' checked';
                                                                                                                                        } ?>>
                                    <label class="form-check-label" for="pro_tier_2">นานาชาติ</label>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row g-3">
                                    <div class="col-md-6 form-floating">
                                        <input type="date" class="form-control" name="pro_date_begin" id="pro_date_begin" aria-describedby="pro_date_beginHelp" value="<?= $row["pro_date_begin"] ?>" required>
                                        <label for="pro_date_begin" class="form-label">วันที่นำเสนอ <span class="lbl_required">*</span></label>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <input type="date" class="form-control" name="pro_date_end" id="pro_date_end" aria-describedby="pro_date_endHelp" value="<?= $row["pro_date_end"] ?>">
                                        <label for="pro_date_end" class="form-label">วันที่สิ้นสุด (ถ้ามี)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3 form-floating">
                                <textarea class="form-control" name="pro_detail" id="pro_detail" rows="5" style="height: 10em;" placeholder="(ถ้ามี)"><?= $row["pro_detail"] ?></textarea>
                                <label for="pro_detail" class="form-label">รายละเอียด</label>
                            </div>

                            <!-- <div class="col-12 mb-3">
                                    <label for="pro_attach" class="form-label">ไฟล์แนบ (ถ้ามี)</label>
                                    <input class="form-control" type="file" name="pro_attach" id="pro_attach" accept=".pdf" multiple>
                                </div> -->

                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <?php
                            $sql_department = "SELECT `department_name` FROM `department` WHERE `department_name` <> '' ORDER BY `department_order`,`department_name`";
                            $dept = $fnc->get_db_array($sql_department);
                            if (!empty($dept)) { ?>
                                <div class="col-12 mb-3 form-floating">
                                    <select class="form-select" name="department_name" id="department_name" aria-describedby="department_nameHelp">
                                        <?php
                                        $sql = "SELECT * FROM `department` ORDER BY `department_order`, `department_name`";
                                        $data_array = $fnc->get_db_array($sql);
                                        echo '<option value=""';
                                        if ($row['department_name'] == "") {
                                            echo ' selected';
                                        }
                                        echo '>' . 'ไม่ระบุ' . '</option>';
                                        foreach ($data_array as $opt) {
                                            echo '<option value="' . $opt["department_name"] . '"';
                                            if ($row['department_name'] == $opt['department_name']) {
                                                echo ' selected';
                                            }
                                            echo '>' . $opt["department_name"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="department_name" class="form-label">หลักสูตร/สาขาวิชา <span class="lbl_required">*</span></label>
                                </div>
                            <?php } elseif (!empty($row['department_name'])) { ?>
                                <div class="col-12 mb-3">
                                    <label for="department_name" class="form-label">หลักสูตร/สาขาวิชา <span class="lbl_required">*</span></label>
                                    <input type="text" class="form-control" name="department_name" id="department_name" aria-describedby="department_nameHelp" value="<?= $row["department_name"] ?>" readonly>
                                </div>
                            <?php } ?>

                            <div class="col-12 mb-3 form-floating">
                                <select class="form-select" size="8" style="height: 10em;" name="pro_owner_citizenid" id="pro_owner_citizenid" aria-describedby="pro_owner_citizenidHelp">
                                    <?php
                                    $MJU_API = new MJU_API();
                                    $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
                                    $econ_member = $MJU_API->GetAPI_array($api_url);
                                    // $fnc->debug_console("econ member", $econ_member[0]);
                                    // $econ_member = $fnc->econ_member_remove_exists("proceeding", $id, $econ_member);
                                    // $fnc->debug_console("econ member", $econ_member[0]);
                                    if (!empty($econ_member)) {
                                        foreach ($econ_member as $member) {
                                            echo '<option value="' . $member["citizenId"] . '"';
                                            if ($row["pro_owner_citizenid"] == $member["citizenId"]) {
                                                echo ' selected';
                                            }
                                            echo '>' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                        }
                                    } else {
                                        // $fnc->debug_console("no member");
                                    }
                                    ?>
                                </select>
                                <label for="pro_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                            </div>

                            <div class="col-12">
                                <div class="col form-floating">
                                    <input type="number" class="form-control" name="pro_ratio" id="pro_ratio" aria-describedby="pro_ratioHelp" max="100" value="<?= $row["pro_ratio"] ?>" maxlength="5">
                                    <label for="pro_ratio" class="form-label">สัดส่วน (%)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="proceeding_update">
                    <input type="hidden" name="pro_id" value="<?= $id ?>">
                    <div class="row px-3 gx-3 mt-3">
                        <div class="col-6 col-md-3 offset-md-6">
                            <button type="button" class="btn btn-outline-secondary w-100 py-2 text-uppercase" onclick="window.open('../admin/?p=proceeding&act=viewinfo&pid=<?= $pro_id ?>','_top');">close</button>
                        </div>
                        <div class="col-6 col-md-3">
                            <button type="submit" class="btn btn-outline-primary w-100 py-2 ms-3 text-uppercase">Update</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    <?php
    }

    public function gen_proceeding_table($data_status = 'enable')
    {
        $fnc = new web;
    ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-8 col-lg-9">
                    <?php
                    if ($data_status == 'delete') {
                        echo '<h5 class="card-title mt-2 h3 text-primary">Proceeding Deleted</h5>';
                    } else {
                        echo '<h5 class="card-title mt-2 h3 text-primary">Proceedings Management</h5>';
                    }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการ</h6>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3">
                    <form action="?" method="get">
                        <?php
                        if (isset($_GET['p']) && $_GET['p'] != '') {
                            echo '<input type="hidden" name="p" value="' . $_GET['p'] . '">';
                        }
                        if (isset($_GET['act']) && $_GET['act'] != '') {
                            echo '<input type="hidden" name="act" value="' . $_GET['act'] . '">';
                        }
                        if (isset($_GET['find']) && $_GET['find'] == 'memberId') {
                            if (isset($_GET['find']) && $_GET['find'] != '') {
                                echo '<input type="hidden" name="find" value="' . $_GET['find'] . '">';
                            }
                            if (isset($_GET['k']) && $_GET['k'] != '') {
                                echo '<input type="hidden" name="k" value="' . $_GET['k'] . '">';
                            }
                        } else {
                        ?>
                        <?php

                        } ?>
                        <div class="input-group mb-0">
                            <input type="hidden" name="find" value="search">
                            <input type="text" class="form-control form-control-sm" name="k" placeholder="ค้นหา" <?php if (isset($_GET['find']) && $_GET['find'] == "search") {
                                                                                                                        echo ' value="' . $_GET['k'] . '"';
                                                                                                                    } ?> aria-describedby="button-addon2">
                            <button class="btn btn-outline-info btn-sm" type="submit" id="button-addon2">ค้น</button>
                        </div>
                        <?php
                        $sql_year = "SELECT YEAR(pro_date_begin) AS b_year FROM v_proceeding_report2 WHERE pro_status = 'enable' GROUP BY YEAR(pro_date_begin) ORDER BY b_year DESC";
                        $byear = $fnc->get_db_array($sql_year);
                        $fnc->debug_console("b year = ", $byear);
                        if (!empty($byear)) {
                        ?>
                            <select class="form-select form-select-sm" name="byear" aria-label="Default select example" onchange="this.form.submit();">
                                <?php
                                echo '<option value=""';
                                if (!isset($_GET['byear']) || $_GET['byear'] == "") {
                                    echo ' selected';
                                };
                                echo '>แสดงทั้งหมด</option>';
                                // for ($y = 2565; $y >= 2560; $y--) {
                                foreach ($byear as $y) {
                                    echo '<option value="' . $y['b_year'] . '"';
                                    if (isset($_GET['byear']) && $_GET['byear'] != "" && $_GET['byear'] == $y['b_year']) {
                                        echo ' selected';
                                    };
                                    echo '>ปี พ.ศ. ' . ($y['b_year'] + 543) . '</option>';
                                }
                                ?>
                            </select>
                            <?php
                            if (isset($_GET['p']) && $_GET['p'] != '') {
                                echo '<input type="hidden" name="p" value="' . $_GET['p'] . '">';
                            }
                            ?>
                        <?php } ?>
                    </form>
                </div>


            </div>


            <div class="card-body mt-3">

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
                        // $sql = "SELECT * FROM proceeding LEFT JOIN co_worker ON co_worker.cow_ref_id = proceeding.pro_id WHERE co_worker.  = 'proceeding' AND proceeding.pro_status = 'enable' AND( proceeding.pro_owner_citizenid = '1509900700434' OR co_worker.cow_citizenid = '1509900700434' ) GROUP BY proceeding.pro_id, proceeding.pro_date_begin ORDER BY proceeding.pro_date_begin DESC";
                        // $sql = "SELECT * FROM proceeding LEFT JOIN co_worker ON co_worker.cow_ref_id = proceeding.pro_id WHERE co_worker.cow_ref_table  = 'proceeding' AND proceeding.pro_status = 'enable'";
                        $sql = "SELECT pro_id FROM v_proceeding_report2 WHERE";
                        // " AND (proceeding.pro_owner_citizenid = '1509900700434' OR co_worker.cow_citizenid = '1509900700434') GROUP BY proceeding.pro_id, proceeding.pro_date_begin ORDER BY proceeding.pro_date_begin DESC";
                        // $sql = "Select * From v_proceeding_report Where";
                        $sql .= " pro_status = '" . $data_status . "'";
                        if (isset($_GET["find"]) && $_GET["find"] != "" && isset($_GET["k"]) && $_GET["k"] != "") {
                            switch ($_GET["find"]) {
                                case "memberId":
                                    // $sql .= " AND (proceeding.pro_owner_citizenid = '" . $_GET["k"] . "' OR co_worker.cow_citizenid = '" . $_GET["k"] . "')"; // (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'research'))";
                                    $sql .= " AND (citizenid = '" . $_GET["k"] . "')"; // (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'research'))";
                                    break;
                                case "search":
                                    $sql .= " AND (firstname LIKE '%" . $_GET["k"] . "%' Or lastname LIKE '%" . $_GET["k"] . "%' Or pro_study LIKE '%" . $_GET["k"] . "%')";
                                    // $sql .= " AND (proceeding.pro_owner_firstname LIKE '%" . $_GET["k"] . "%' Or proceeding.pro_owner_lastname LIKE '%" . $_GET["k"] . "%' Or proceeding.department_name LIKE '%" . $_GET["k"] . "%' Or co_worker.cow_firstname LIKE '%" . $_GET["k"] . "%' Or co_worker.cow_lastname LIKE '%" . $_GET["k"] . "%' Or co_worker.department_name LIKE '%" . $_GET["k"] . "%' Or proceeding.pro_study LIKE '%" . $_GET["k"] . "%')";
                                    break;
                            }
                        }
                        if (isset($_GET["byear"]) && $_GET["byear"] != "") {
                            $sql_year = " AND Year(proceeding.pro_date_begin) LIKE '" . $_GET["byear"] . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By pro_id, pro_date_begin";
                        $sql_order = " Order By pro_date_begin Desc";
                        // $sql_group = " GROUP BY proceeding.pro_id, proceeding.pro_date_begin";
                        // $sql_order = " ORDER BY proceeding.pro_date_begin DESC";
                        // $sql_order = " ORDER BY pro_id DESC";

                        // $sql = "Select pro.* From proceeding pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                        // $sql .= "pro.pro_status LIKE '" . $data_status . "'";
                        // if (isset($_GET["find"]) && $_GET["find"] != "" && isset($_GET["k"]) && $_GET["k"] != "") {
                        //     switch ($_GET["find"]) {
                        //         case "memberId":
                        //             $sql .= " AND (pro.pro_owner_citizenid LIKE '" . $_GET["k"] . "' OR (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'research'))"; // (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'research'))";
                        //             break;
                        //         case "search":
                        //             $sql .= " AND (pro.pro_owner_prename LIKE '%" . $_GET["k"] . "%' Or pro.pro_owner_firstname LIKE '%" . $_GET["k"] . "%' Or ((cowo.cow_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_lastname LIKE '%" . $_GET["k"] . "%' Or pro.pro_study LIKE '%" . $_GET["k"] . "%') AND cowo.cow_ref_table LIKE 'proceeding'))";
                        //             break;
                        //     }
                        // }
                        // if (isset($_GET["byear"]) && $_GET["byear"] != "") {
                        //     $sql_year = " AND Year(pro.pro_date_begin) LIKE '" . $_GET["byear"] . "'";
                        // } else {
                        //     $sql_year = "";
                        // }
                        // $sql_group = " Group By pro.pro_date_begin, pro.pro_id";
                        // $sql_order = " ORDER BY pro.pro_date_begin Desc"; // order
                        $sql .= $sql_year . $sql_group . $sql_order;
                        $fnc->debug_console('sql table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_proceeding_tr($data_array);
                        } else {
                            echo '<tr>';
                            echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="4">no data founded</td>';
                            echo '</tr>';
                        } ?>

                    </tbody>
                </table>


            </div>

            <div class="card-footer text-end text-muted" style="font-size: 0.6em;">
                last update: <?= date('M d, Y'); ?>
                <!-- <div class="col mt-3">
                <button type="button" class="btn btn-primary px-4 py-2 text-uppercase">Action</button>

            </div> -->
            </div>

            </form>
        </div>
        <?php
    }

    public function gen_proceeding_tr($data_array)
    {
        $fnc = new web;

        if (isset($_GET["act"]) && $_GET["act"] == "report") {
            $linkable = false;
        } else {
            $linkable = true;
        }

        $fnc->debug_console("data list: ", $data_array[0]);
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
                                                        ?><?//= $row["pro_id"]; ?></td>
                    <td class="d-none d-md-table-cell" nowrap><?php
                                                                if ($linkable) {
                                                                    // echo '<a href="?p=proceeding&find=memberId&k=' . $row["citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["prename"]) . $row["firstname"] . ' ' . $row["lastname"] . '</a>';
                                                                    echo '<a href="?p=proceeding&find=memberId&k=' . $row["pro_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"] . '</a>';
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
                                    echo '<a href="?p=proceeding&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                                } else {
                                    echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                                }
                            }
                        }
                        ?>
                    </td>
                    <td><?php
                        if ($linkable) {
                            echo $pro_tier . '<a href="?p=' . $_GET['p'] . '&act=viewinfo&pid=' . $row["pro_id"] . '" target="_top" class="fw-bold">' . $row["pro_study"] . '</a>';
                        } else {
                            echo $pro_tier . $row["pro_study"];
                        }
                        ?>
                    </td>
                    <td><?php
                        if ($linkable) {
                            // echo '<a href="?p=' . $_GET['p'] . '&act=viewinfo&pid=' . $row["pro_id"] . '" target="_top" class="fw-bold">' . $row["pro_conf"] . '</a>';
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
    }

    public function gen_proceeding_owner($id, $row)
    {
        $fnc = new web;
        $sum_ratio = 0;
        ?>

        <!-- * เจ้าของผลงาน / ผู้ร่วมงาน -->
        <div class="mb-3 mt-4 col-12 col-md-8 offset-md-2">
            <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
                <thead class="thead-inverse|thead-default">
                    <tr>
                        <th class="text-center" style="width:3em;">#</th>
                        <th>นักวิจัย</th>
                        <th>หลักสูตร/สาขาวิชา</th>
                        <th id="ratio_title" class="text-center">สัดส่วน</th>
                        <?php
                        if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                            echo '<th id="ratio_title" class="text-center">นำออก</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8em;">
                    <tr>
                        <td scope="row" class="text-center">1</td>
                        <td><?= '<a href="?p=proceeding&find=memberId&k=' . $row["pro_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"] . '</a>' ?></td>
                        <td class="text-start"><a href="?p=proceeding&act=report&cat=department&d=<?= $row["department_name"] ?>" target="_top" class="link-primary fw-bold"><?= $row["department_name"] ?></a></td>
                        <td class="text-center"><?= $row["pro_ratio"] ?></td>
                        <?php
                        if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                            echo '<td class="text-center"></td>';
                        }
                        ?>

                    </tr>
                    <?php
                    $sum_ratio += $row["pro_ratio"];
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'proceeding' AND `cow_ref_id` = " . $id;
                    $fnc->debug_console("co worker sql: " . $sql);
                    $co_worker = $fnc->get_db_array($sql);
                    if (!empty($co_worker[0])) {
                        // echo "<pre>" . print_r($co_worker[0]) . "</pre>";
                        $x = 2;
                        foreach ($co_worker as $cow) {
                    ?>
                            <tr>
                                <td scope="row" class="text-center"><?= $x; ?></td>
                                <?php
                                if (!empty($cow["cow_citizenid"])) {
                                    echo '<td><a href="?p=proceeding&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a></td>';
                                } else {
                                    echo '<td>' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</td>';
                                }
                                ?>
                                <td class="text-start"><a href="?p=proceeding&act=report&cat=department&d=<?= $cow["department_name"] ?>" target="_top" class="link-primary fw-bold"><?= $cow["department_name"] ?></a></td>
                                <td class="text-center"><?= $cow["cow_ratio"] ?></td>
                                <?php
                                if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                                    // echo '<td class="text-center"><a href="#" target="_top" onclick="proceeding_coworker_delete_confirmation(' . $id . ', ' . $cow["cow_id"] . ');" class="text-danger fw-bold" style="font-size: 1.1em;"><i class="bi bi-person-dash-fill"></i></a></td>';
                                    $confirm_parameter = "'proceeding'," . $id . ", " . $cow["cow_id"];
                                    echo '<td class="text-center"><a href="#" target="_top" onclick="coworker_delete_confirmation(' . $confirm_parameter . ');" class="text-danger fw-bold" style="font-size: 1.1em;"><i class="bi bi-person-dash-fill"></i></a></td>';
                                }
                                ?>
                            </tr>
                    <?php
                            $sum_ratio += $cow["cow_ratio"];
                            $x++;
                        }
                    } ?>
                </tbody>
            </table>
            <?php
            if ($sum_ratio > 100) {
                echo '<script type="text/javascript">';
                echo 'document.getElementById("ratio_title").setAttribute("class", "text-center text-danger");';
                // echo 'document.getElementById("ratio_title").innerHTML = "Hello World";';
                echo '</script>';
            } elseif ($sum_ratio < 100) {
                echo '<script type="text/javascript">';
                echo 'document.getElementById("ratio_title").setAttribute("class", "text-center text-warning");';
                // echo 'document.getElementById("ratio_title").innerHTML = "Hello World";';
                echo '</script>';
            }

            ?>

        </div>

    <?php
    }

    public function gen_proceeding_detail($id)
    {
        $fnc = new web;

        $sql = "SELECT * FROM proceeding WHERE pro_id = " . $id;
        $row = $fnc->get_db_row($sql);

        $label_cls = "col-12 col-md-4 col-lg-3 col-form-label fw-bold text-primary text-md-end";
        $data_cls = "col-11 offset-1 col-md-8 offset-md-0 col-lg-9 col-form-label";
    ?>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">ชื่อผลงาน/ชื่อเรื่อง</label>
            <label class="<?= $data_cls ?>"><?= $row["pro_study"] ?></label>
        </div>

        <?php if (!empty($_GET["act"]) && $_GET["act"] != "coWorker") { ?>

            <?php if (!empty($row["pro_conf"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">ชื่อการประชุมวิชาการ</label>
                    <label class="<?= $data_cls ?>"><?= $row["pro_conf"] ?></label>
                </div>
            <?php } ?>

            <?php if (!empty($row["pro_conf_owner"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">หน่วยงานที่จัดประชุม</label>
                    <label class="<?= $data_cls ?>"><?= $row["pro_conf_owner"] ?></label>
                </div>
            <?php } ?>

            <?php if (!empty($row["pro_location"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">สถานที่จัดประชุม</label>
                    <label class="<?= $data_cls ?>"><?= $row["pro_location"] ?></label>
                </div>
            <?php } ?>

            <?php if (!empty($row["pro_volume_issue"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">ปีที่ Volume (ฉบับที่ Issue)</label>
                    <label class="<?= $data_cls ?>"><?= $row["pro_volume_issue"] ?></label>
                </div>
            <?php } ?>

            <?php if (!empty($row["pro_page"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">หน้าที่ตีพิมพ์</label>
                    <label class="<?= $data_cls ?>"><?= $row["pro_page"] ?></label>
                </div>
            <?php } ?>

            <?php if (!empty($row["pro_link"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">ลิงก์ออนไลน์</label>
                    <label class="<?= $data_cls ?>"><?= $row["pro_link"] ?></label>
                </div>
            <?php } ?>

            <?php
            if (!empty($row["pro_tier"]) && $row["pro_tier"] == "ระดับนานาชาติ") {
                $pro_tier = '../images/tier_icon_global_64.png';
            } else {
                $pro_tier = '../images/tier_icon_local_64.png';
            }
            $pro_tier = '<img src="' . $pro_tier . '" class="mb-1 me-2" width="16em">';
            ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ระดับ</label>
                <label class="<?= $data_cls ?>"><?= $pro_tier . $row["pro_tier"] ?></label>
            </div>

            <div class="row mb-3">
                <label class="<?= $label_cls ?>">วันที่นำเสนอ</label>
                <label class="<?= $data_cls ?>"><?php
                                                $fnc->gen_date_full_thai($row["pro_date_begin"]);
                                                if ($row["pro_date_begin"] < $row["pro_date_end"]) {
                                                    echo ' - ';
                                                    echo $fnc->gen_date_full_thai($row["pro_date_end"]);
                                                } ?></label>
            </div>

            <?php if (!empty($row["department_name"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">หลักสูตร/สาขาวิชา</label>
                    <label class="<?= $data_cls ?>"><?= $row["department_name"] ?></label>
                    <?php
                    $sql = "Select co_worker.department_name From co_worker Inner Join proceeding On co_worker.cow_ref_id = proceeding.pro_id Where proceeding.pro_id = " . $id . " And co_worker.cow_ref_table = '" . $_GET["p"] . "' And co_worker.cow_status = 'enable' And co_worker.department_name != '' Group By co_worker.department_name Order By co_worker.department_name";
                    $departments = $fnc->get_db_array($sql);
                    // $fnc->debug_console("department sql:\\n" . $sql);
                    // $fnc->debug_console("department list", $departments);
                    if (!empty($departments)) {
                        foreach ($departments as $dept) {
                            echo '<label class="col-11 offset-1 col-md-9 offset-md-3 col-form-label">' . $dept["department_name"] . '</label>';
                        }
                    }
                    ?>
                </div>
            <?php } ?>

            <?php if (!empty($row["pro_detail"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">รายละเอียด</label>
                    <label class="<?= $data_cls ?>"><?= $row["pro_detail"] ?></label>
                </div>
            <?php } ?>

        <?php } ?>

        <?php if ($row["pro_attach"] == "true") { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">เอกสารแนบ</label>
                <!-- <label class="<? //= $data_cls 
                                    ?>"><? //= $row["pro_attach"] 
                                        ?></label> -->
                <div class="mb-3 mt-2 col-12 col-md-8">
                    <?php if ($row["pro_attach"] == "true") { ?>
                        <div class="list-group" style="font-size: 0.8em;">
                            <!-- <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        The current link item
                    </a> -->
                            <?php
                            $sql = "SELECT * FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'proceeding' AND `att_ref_id` = " . $id . " ORDER BY att_filename";
                            $attachment_file = $fnc->get_db_array($sql);
                            if (!empty($attachment_file)) {
                                foreach ($attachment_file as $att) {
                                    // echo '<a href="../' . $att["att_filepath"] . $att["att_filename"] . '" target="_blank" class="list-group-item list-group-item-action text-primary">' . $att["att_filename"] . '</a>';
                                    echo '<li class="list-group-item">';
                                    echo '<div class="row">';
                                    echo '<div class="col-auto">';
                                    echo '<a href="../' . $att["att_filepath"] . $att["att_filename"] . '" target="_blank" class="text-primary fw-bold">' . $att["att_filename"] . '</a>';
                                    echo '</div>';
                                    if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                                        $confirm_parameter = "'proceeding'," . $id . "," . $att["att_id"];
                                        echo '<div class="col text-end">';
                                        // echo '<a onclick="proceeding_attachment_delete_confirmation(' . $id . ',' . $att["att_id"] . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
                                        echo '<a onclick="attachment_delete_confirmation(' . $confirm_parameter . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '</li>';
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($_GET['act']) && $_GET['act'] == "coWorker") { ?>
            <form action="../db_mgt.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="row mb-3">
                    <!-- <label class="col-sm-2 col-form-label fw-bold text-primary text-md-end">เพิ่มเอกสารแนบ</label> -->
                    <div class="mb-3 mt-0 col-12 col-md-8 offset-md-2">
                        <div class="col-12 mb-3">
                            <label for="file_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)1</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="file_attach[]" id="file_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple required>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="proceeding">
                        <input type="hidden" name="ref_id" value="<?= $id ?>">
                    </div>
                </div>
            </form>
        <?php } ?>


        <?php if (!empty($row["pro_notes"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">หมายเหตุ</label>
                <label class="<?= $data_cls ?>"><?= $row["pro_notes"] ?></label>
            </div>
        <?php } ?>

    <?php $this->gen_proceeding_owner($id, $row);

        return $row;
    }

    public function gen_proceeding_action_menu()
    {
    ?>
        <div class="col-auto align-self-top text-end fw-bold text-primary" style="font-size:0.75em;">
            <a href="?p=proceeding&act=viewinfo&pid=<?= $_GET["pid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase" style="font-size:1em;">view info</a>
            <a href="?p=proceeding&act=update&pid=<?= $_GET["pid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase ms-3" style="font-size:1em;">update info</a>
            <a href="?p=proceeding&act=coWorker&pid=<?= $_GET["pid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase ms-3" style="font-size:1em;">co-worker/attachment</a>
        </div>
    <?php
    }

    public function gen_proceeding_info($pro_id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">แสดงรายละเอียดของ Proceeding</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการ</h6>
                </div>

                <?php $this->gen_proceeding_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $row = $this->gen_proceeding_detail($pro_id); ?>

            </div>

            <div class="card-footer text-end">
                <div class="col mt-3">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 text-uppercase" onclick="window.open('?p=proceeding');">close</button>
                    <?php if ($row["pro_status"] == 'delete') { ?>
                        <button type="button" class="btn btn-outline-success px-4 py-2 text-uppercase" onclick="window.open('../db_mgt.php?p=proceeding&act=restore&pid=<?= $pro_id ?>','_top');">restore</button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-outline-danger px-4 py-2 text-uppercase" onclick="proceeding_delete_confirmation(<?= $pro_id ?>);">delete</button>
                        <!-- <button type="button" class="btn btn-primary px-4 py-2 text-uppercase">Action</button> -->
                    <?php } ?>

                </div>
            </div>

            </form>
        </div>

    <?php
    }

    public function gen_proceeding_coworker($id)
    {
        $fnc = new web;
        global $core_fnc;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">Proceeding Co-Worker</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการ - ผู้ร่วมงาน</h6>
                </div>

                <?php $this->gen_proceeding_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $row = $this->gen_proceeding_detail($id); ?>

            </div>

            <?php
            $MJU_API = new MJU_API;
            $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
            // $econ_member = $MJU_API->GetAPI_array($api_url);                                    
            $econ_member = $fnc->econ_member_remove_exists("proceeding", $id, $MJU_API->GetAPI_array($api_url));
            $fnc->debug_console("econ member", $econ_member[0]);
            ?>
            <div class="card-body row">
                <hr class="mt-0 mb-5">
                <div class="col-md-5 offset-md-1 mb-4 mb-md-0">
                    <form action="../db_mgt.php" method="post" autocomplete="off">
                        <div class="card col-">
                            <div class="card-body p-4">
                                <?php
                                $sql_department = "SELECT `department_name` FROM `department` WHERE `department_name` <> '' ORDER BY `department_order`,`department_name`";
                                $dept = $fnc->get_db_array($sql_department);
                                if (!empty($dept)) { ?>
                                    <div class="col-12 mb-3">
                                        <label for="department_name" class="form-label">หลักสูตร/สาขาวิชา <span class="lbl_required">*</span></label>
                                        <select class="form-select" name="department_name" id="department_name" aria-describedby="department_nameHelp">
                                            <?php
                                            foreach ($dept as $opt) {
                                                echo '<option value="' . $opt["department_name"] . '"';
                                                if ($row['department_name'] == $opt['department_name']) {
                                                    echo ' selected';
                                                }
                                                echo '>' . $opt["department_name"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>

                                <div class="col-12 mb-3">
                                    <label for="cow_citizenid" class="form-label text-capitalize">select co-worker <span class="lbl_required">*</span></label>
                                    <select class="form-select" size="8" name="cow_citizenid" id="cow_citizenid" aria-describedby="cow_citizenidHelp">
                                        <?php
                                        foreach ($econ_member as $member) {
                                            echo '<option value="' . $member["citizenId"] . '">' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="col">
                                        <label for="cow_ratio" class="form-label">สัดส่วน (%)</label>
                                        <input type="number" class="form-control" name="cow_ratio" id="cow_ratio" aria-describedby="cow_ratioHelp" max="100" maxlength="5">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <div class="col mt-0">
                                    <!-- <button type="button" class="btn btn-secondary px-4 py-2 text-uppercase">close</button>
                        <button type="button" class="btn btn-danger px-4 py-2 text-uppercase">delete</button> -->
                                    <button type="submit" class="btn btn-outline-primary px-4 py-2 text-uppercase">Add</button>
                                    <input type="hidden" name="fst" value="proceedingCoWorkerIntAppend">
                                    <input type="hidden" name="ref_table" value="proceeding">
                                    <input type="hidden" name="ref_id" value="<?= $_GET["pid"] ?>">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <form action="../db_mgt.php" method="post" autocomplete="off">
                        <div class="card col-">
                            <div class="card-body p-4">
                                <div class="col-12 mb-3">
                                    <label for="pro_owner_citizenid" class="form-label text-capitalize">Register a new co-worker <span class="lbl_required">*</span></label>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control form-control-sm" name="cow_prename" id="floatingPrename">
                                        <label for="floatingPrename">คำนำหน้า/ตำแหน่งวิชาการ</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control form-control-sm" name="cow_firstname" id="floatingFirstname" required>
                                        <label for="floatingFirstname">ชื่อ <span class="lbl_required">*</span></label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" name="cow_lastname" id="floatingLastname" required>
                                        <label for="floatingLastname">นามสกุล <span class="lbl_required">*</span></label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="col">
                                        <label for="cow_ratio" class="form-label">สัดส่วน (%)</label>
                                        <input type="number" class="form-control" name="cow_ratio" id="cow_ratio" aria-describedby="cow_ratioHelp" max="100" maxlength="5">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <div class="col mt-0">
                                    <!-- <button type="button" class="btn btn-secondary px-4 py-2 text-uppercase">close</button>
                        <button type="button" class="btn btn-danger px-4 py-2 text-uppercase">delete</button> -->
                                    <button type="submit" class="btn btn-outline-primary px-4 py-2 text-uppercase">Add</button>
                                    <input type="hidden" name="fst" value="proceedingCoWorkerExtAppend">
                                    <input type="hidden" name="ref_table" value="proceeding">
                                    <input type="hidden" name="ref_id" value="<?= $_GET["pid"] ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>



            </form>
        </div>

    <?php
    }

    public function gen_proceeding_attachment($jour_id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">Proceeding attachment</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการ - ไฟล์แนบ</h6>
                </div>

                <?php $this->gen_proceeding_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $this->gen_proceeding_detail($jour_id); ?>

            </div>

            <div class="card-body">
                <div class="col-md-8 mx-auto">
                    <form action="../db_mgt.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="col-12 mb-3">
                            <label for="pro_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)2</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="pro_attach[]" id="pro_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="proceeding">
                        <input type="hidden" name="ref_id" value="<?= $jour_id ?>">
                    </form>
                </div>

            </div>



            </form>
        </div>

    <?php
    }

    public function data_report_submenu()
    {
        $fnc = new web;
    ?>
        <div class="text-white-50 mb-0 d-print-none" style="background-color:#baa0df; margin-top:3.6em;">
            <div class="container px-0 px-md-5">
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'personal') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=proceeding&act=report&cat=personal">รายบุคคล</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'department') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=proceeding&act=report&cat=department">รายหลักสูตร</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'apasample') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=proceeding&act=report&cat=apasample">APA's Ref</a>
                    </li>
                </ul>
            </div>
        </div>
    <?php
    }

    public function gen_table_report($disp_year)
    {
        global $fnc;
    ?>
        <table class="table table-bordered table-inverse table-responsive">
            <thead class="thead-inverse bg-light">
                <tr class="text-center fw-bold align-middle">
                    <th style="width:5em;">ลำดับที่</th>
                    <th>ชื่อ-สกุล</th>
                    <?php ?>
                    <th>สัดส่วน</th>
                    <?php ?>
                    <th>การนำเสนอผลงาน</th>
                    <th style="width:3em;">ระดับ</th>
                    <th>ชื่อการประุชม</th>
                    <th>สถานที่</th>
                    <th style="width:8.5em;">วันที่</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.85em;">
                <?php
                // $sql = "Select * From v_proceeding_report Where pro_status = 'enable'";
                $sql = "SELECT pro_id FROM v_proceeding_report2 WHERE pro_status = 'enable'";
                if (isset($_GET["cat"]) && $_GET["cat"] == 'department') {
                    // $sql = "SELECT pro_id FROM v_proceeding_dpm WHERE pro_status = 'enable'";
                }
                if (isset($_GET["k"]) && $_GET["k"] != "") {
                    // $sql .= " AND (pro_owner_citizenid LIKE '" . $_GET["k"] . "' OR cow_citizenid LIKE '" . $_GET["k"] . "')";
                    $sql .= " AND citizenid LIKE '" . $_GET["k"] . "'";
                }
                if (isset($_GET["d"]) && $_GET["d"] != "") {
                    // $sql .= " AND (pro_department_name = '" . $_GET["d"] . "' OR cow_department_name = '" . $_GET["d"] . "')";
                    $sql .= " AND department_name = '" . $_GET["d"] . "'";
                }
                if ($disp_year != "" && $disp_year != "5yrs") {
                    $sql_year = " AND pro_fiscalyear = '" . ($disp_year) . "'";
                } else {
                    $sql_year = "";
                }
                if ($disp_year == "5yrs") {
                    $sql_year = " AND pro_fiscalyear >= '" . ($fnc->get_fiscal_year() - 5) . "' AND pro_fiscalyear <= '" . ($fnc->get_fiscal_year()) . "'";
                }
                $sql_group = " Group By pro_date_begin, pro_id";
                $sql_order = " Order By pro_date_begin Desc"; // order
                $sql .= $sql_year . $sql_group . $sql_order;
                $fnc->debug_console('sql proceeding table owner: \n' . $sql);
                $data_array = $fnc->get_db_array($sql);
                $fnc->debug_console("data array:", $data_array);
                if (!empty($data_array)) {
                    $this->gen_table_tr_report($data_array);
                } else {
                    echo '<tr style="page-break-before:auto">';
                    echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="7">no data founded</td>';
                    echo '</tr>';
                } ?>

            </tbody>
        </table>
        <?php
    }

    public function gen_table_tr_report($data_array)
    {
        $fnc = new web;

        if (isset($_GET["act"]) && $_GET["act"] == "report") {
            $linkable = false;
        } else {
            $linkable = true;
        }

        $fnc->debug_console("data list sample: ", $data_array[0]);
        $x = 1;
        foreach ($data_array as $pro) {
            $sql = "SELECT proceeding.* FROM proceeding WHERE pro_id = " . $pro["pro_id"];
            $row = $fnc->get_db_row($sql);
            if (!empty($row)) {
        ?>
                <!-- <tr style="page-break-before: always;"> -->
                <tr>
                    <td scope="row" class="text-center"><?= $x ?></td>
                    <td nowrap>
                        <?php
                        echo '<p class="m-0 border-bottom border-secondary">';
                        if ($linkable) {
                            echo '<a href="?p=proceeding&find=memberId&k=' . $row["pro_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"] . '</a>';
                            // echo '<a href="?p=proceeding&find=memberId&k=' . $row["citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["prename"]) . $row["firstname"] . ' ' . $row["lastname"] . '</a>';
                        } else {
                            echo $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"];
                            // echo $fnc->gen_titlePosition_short($row["prename"]) . $row["firstname"] . ' ' . $row["lastname"];
                        }
                        echo '</p>';
                        echo '<strong class="text-danger">Dept:</strong>' . $row["department_name"];
                        ?>
                        <?php
                        $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'proceeding' AND `cow_ref_id` = " . $row["pro_id"];
                        // $fnc->debug_console("co worker sql: " . $sql);
                        $co_worker = $fnc->get_db_array($sql);
                        if (!empty($co_worker)) {
                            foreach ($co_worker as $cow) {
                                echo '<p class="m-0 border-bottom border-secondary ms-2">';
                                if (!empty($cow["cow_citizenid"]) && $linkable) {
                                    echo '<a href="?p=proceeding&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                                } else {
                                    echo '<span class="">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                                }
                                echo '</p>';
                                echo '<strong class="text-danger ms-2">Dept:</strong>' . $cow["department_name"];
                            }
                        }
                        ?>
                    </td>
                    <?php ?>
                    <td class="text-center">
                        <?= '<p class="border-bottom border-secondary">' . $row["pro_ratio"] . '</p>'; ?>
                        <?php
                        $sql = "SELECT cow_ratio FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'proceeding' AND `cow_ref_id` = " . $row["pro_id"];
                        // $fnc->debug_console("co worker sql: " . $sql);
                        $co_worker = $fnc->get_db_array($sql);
                        if (!empty($co_worker)) {
                            foreach ($co_worker as $cow) {
                                echo '<p class="border-bottom border-secondary">' . $cow["cow_ratio"] . '</p>';
                            }
                        }
                        ?>
                    </td>
                    <?php ?>
                    <td class="text-start"><?php
                                            if ($linkable) {
                                                echo '<a href="?p=' . $_GET['p'] . '&act=viewinfo&pid=' . $row["pro_id"] . '" target="_top" class="fw-bold">' . $row["pro_study"] . '</a>';
                                            } else {
                                                echo $row["pro_study"];
                                            }
                                            ?></td>
                    <td class="text-center"><?php
                                            if (!empty($row["pro_tier"])) {
                                                echo $row["pro_tier"];
                                            }
                                            ?>
                    </td>
                    <td class="text-start"><?php
                                            if (!empty($row["pro_conf"])) {
                                                echo $row["pro_conf"];
                                            }
                                            ?>
                    </td>
                    <td><?= $row["pro_location"] ?></td>
                    <td class="text-center">
                        <?php
                        if (!empty($row["pro_date_begin"])) {
                            if (!empty($row["pro_tier"]) && $row["pro_tier"] == "ระดับนานาชาติ") {
                                $fnc->gen_date_range_semi_en($row["pro_date_begin"], $row["pro_date_end"]);
                            } else {
                                $fnc->gen_date_range_semi_th($row["pro_date_begin"], $row["pro_date_end"]);
                            }
                        }
                        // if (!empty($row["pro_date_end"])) {
                        //     echo '<br>- ';
                        //     $fnc->gen_date_semi_th(($row["pro_date_end"]));
                        // }
                        ?></td>
                    <td><?php
                        echo $row["pro_detail"];
                        ?>
                    </td>
                </tr>
        <?php
            }
            $x++;
        }
    }

    public function gen_report_personal()
    {
        $fnc = new web;
        if (!isset($_GET['fyear']) || $_GET['fyear'] == "") {
            $disp_year = $fnc->get_fiscal_year();
        } else {
            $disp_year = $_GET['fyear'];
        }
        $fnc->debug_console("display year:\\n" . $disp_year);
        ?>

        <div class="card p-0 p-md-0 border border-white">
            <div class="card-header bg-light bg-gradient row d-print-none">
                <div class="col-12 col-md-12 col-lg-9 d-print-none">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">Proceeding Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding Report</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานการตีพิมพ์ผลงานการวิจัย/บทความทางวิชาการ</h6>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3 d-print-none">
                    <form action="?" method="get">
                        <?php
                        if (isset($_GET['find']) && $_GET['find'] == 'memberId') {
                            if (isset($_GET['find']) && $_GET['find'] != '') {
                                echo '<input type="hidden" name="find" value="' . $_GET['find'] . '">';
                            }
                            if (isset($_GET['k']) && $_GET['k'] != '') {
                                echo '<input type="hidden" name="k" value="' . $_GET['k'] . '">';
                            }
                        } else {
                        ?>
                        <?php

                        } ?>
                        <div class="input-group mb-0">
                            <input type="hidden" name="p" value="proceeding">
                            <input type="hidden" name="act" value="report">
                            <input type="hidden" name="cat" value="personal">
                            <?php
                            $sql = "SELECT citizenid, prename, firstname, lastname FROM v_proceeding_report2 WHERE citizenid != '' AND pro_status = 'enable' GROUP BY citizenid, prename, firstname, lastname ORDER BY firstname";
                            $econ_member = $fnc->get_db_array($sql);
                            $fnc->debug_console("econ member", $econ_member[0]);
                            ?>
                            <select class="form-select form-select-sm" name="k" id="k" onchange="this.form.submit();">
                                <!-- <select class="form-select form-select-sm" name="k" id="k" aria-label="Default select example" onchange="this.form.submit();"> -->
                                <?php
                                echo '<option value=""';
                                if (!isset($_GET["k"]) || $_GET["k"] == "") {
                                    echo ' selected';
                                }
                                echo '>' . 'แสดงข้อมูลบุคลากรทุกคน' . '</option>';
                                foreach ($econ_member as $member) {
                                    echo '<option value="' . $member["citizenid"] . '"';
                                    if (isset($_GET["k"]) && $_GET["k"] == $member["citizenid"]) {
                                        echo ' selected';
                                        $cur_personal = ' ' . $fnc->gen_titlePosition_short($member["prename"]) . ' ' . $member["firstname"] . '&nbsp;&nbsp;' . $member["lastname"];
                                    }
                                    echo '>' . $member["firstname"] . '&nbsp;&nbsp;' . $member["lastname"] . ' (' . $fnc->gen_titlePosition_short($member["prename"]) . ')' . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                        $sql_year = "SELECT pro_fiscalyear As fyear FROM proceeding WHERE pro_status = 'enable' GROUP BY pro_fiscalyear ORDER BY pro_fiscalyear DESC";
                        // $fyear = $fnc->get_db_array($sql_year);
                        $fyear = $fnc->get_db_array($sql_year);
                        $fnc->debug_console("fiscal year = ", $fyear);
                        if ($disp_year > $fyear[0]["fyear"] && $disp_year != "5yrs") {
                            $disp_year = $fyear[0]["fyear"];
                            $fnc->debug_console("display year update to:\\n" . $disp_year);
                        }
                        if (!empty($fyear)) {
                        ?>
                            <select class="form-select form-select-sm" name="fyear" onchange="this.form.submit();">
                                <?php
                                echo '<option value="5yrs"';
                                if ($disp_year == "5yrs") {
                                    echo ' selected';
                                };
                                echo '>ย้อนหลัง 5 ปีงปม.</option>';
                                // for ($y = 2565; $y >= 2560; $y--) {
                                foreach ($fyear as $y) {
                                    echo '<option value="' . $y['fyear'] . '"';
                                    if ($disp_year == $y['fyear']) {
                                        echo ' selected';
                                    };
                                    echo '>ปี งปม. ' . ($y['fyear']) . '</option>';
                                }
                                ?>
                            </select>
                            <?php
                            if (isset($_GET['p']) && $_GET['p'] != '') {
                                echo '<input type="hidden" name="p" value="' . $_GET['p'] . '">';
                            }
                            ?>
                        <?php } ?>
                    </form>
                </div>

            </div>

            <div class="card-body mt-0" style="font-size: 0.8em;">
                <?php
                if (isset($_GET['k']) && $_GET['k'] != '') {
                    $k = 'ของ' . $cur_personal;
                } else {
                    $k = '';
                }
                if ($disp_year != '') {
                    $y = ' ปี งปม. ' . $disp_year;
                } else {
                    $y = ' ทั้งหมด';
                }
                // ***
                // echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding ' . $k . $y . '</h5>';
                echo '<div class="text-center">
                <p class="h4 mb-1" style="font-size: 0.9rem;">สรุปผลงานการนำเสนอผลงานการวิจัย/บทความทางวิชาการ';
                if (isset($_GET["k"]) && $_GET["k"] != '') {
                    echo 'ของ' . $cur_personal;
                }
                echo '</p>';
                if ($disp_year == "5yrs") {
                    echo '<p class="h4 mb-1" style="font-size: 0.9rem;">ปีงบประมาณ ' . $fnc->get_fiscal_year() . ' (ตุลาคม ' . ($fnc->get_fiscal_year() - 1) . ' - กันยายน ' . $fnc->get_fiscal_year() . ')</p>';
                } else {
                    echo '<p class="h4 mb-1" style="font-size: 0.9rem;">ปีงบประมาณ ' . $disp_year . ' (ตุลาคม ' . ($disp_year - 1) . ' - กันยายน ' . $disp_year . ')</p>';
                }
                echo '<p class="h4 mb-3" style="font-size: 0.9rem;">คณะเศรษฐศาสตร์ มหาวิทยาลัยแม่โจ้</p>
                </div>';

                $this->gen_table_report($disp_year);
                ?>
            </div>

            <div class="card-footer text-end text-muted" style="font-size: 0.6em;">
                last update: <?= date('M d, Y'); ?>
            </div>

            </form>
        </div>
    <?php
    }

    public function gen_report_department()
    {
        $fnc = new web;
        if (!isset($_GET['fyear']) || $_GET['fyear'] == "") {
            $disp_year = $fnc->get_fiscal_year();
        } else {
            $disp_year = $_GET['fyear'];
        }
        $fnc->debug_console("display year:\\n" . $disp_year);
    ?>
        <div class="card p-0 p-md-0 border border-white">
            <div class="card-header bg-light bg-gradient row d-print-none">
                <div class="col-12 col-md-12 col-lg-9 d-print-none">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">Proceeding Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding Report by Department</h5>';
                    // }

                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการ ของหลักสูตร</h6>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3 d-print-none">
                    <form action="?" method="get">
                        <div class="input-group mb-0">
                            <input type="hidden" name="p" value="proceeding">
                            <input type="hidden" name="act" value="report">
                            <input type="hidden" name="cat" value="department">
                            <select class="form-select form-select-sm" name="d" id="d" onchange="this.form.submit();">
                                <?php
                                $sql = "SELECT * FROM `department` ORDER BY `department_name`";
                                $department = $fnc->get_db_array($sql);
                                $fnc->debug_console("department ", $department[0]);
                                echo '<option value=""';
                                if (!isset($_GET["d"]) || $_GET["d"] == "") {
                                    echo ' selected';
                                }
                                echo '>' . 'แสดงหน่วยงานทั้งหมด' . '</option>';
                                foreach ($department as $opt) {
                                    echo '<option value="' . $opt["department_name"] . '"';
                                    if (isset($_GET["d"]) && $_GET["d"] == $opt["department_name"]) {
                                        echo ' selected';
                                        $cur_department = $opt["department_name"];
                                    }
                                    echo '>' . $opt["department_name"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                        $sql_year = "SELECT pro_fiscalyear As fyear FROM proceeding WHERE pro_status = 'enable' GROUP BY pro_fiscalyear ORDER BY pro_fiscalyear DESC";
                        $fyear = $fnc->get_db_array($sql_year);
                        $fnc->debug_console("b year = ", $fyear);
                        $fnc->debug_console("b year sql = ", $sql_year);
                        if ($disp_year > $fyear[0]["fyear"] && $disp_year != "5yrs") {
                            $disp_year = $fyear[0]["fyear"];
                            $fnc->debug_console("display year update to:\\n" . $disp_year);
                        }
                        if (!empty($fyear)) {
                        ?>
                            <select class="form-select form-select-sm" name="fyear" onchange="this.form.submit();">
                                <?php
                                echo '<option value="5yrs"';
                                if ($disp_year == "5yrs") {
                                    echo ' selected';
                                };
                                echo '>ย้อนหลัง 5 ปีงปม.</option>';
                                // for ($y = 2565; $y >= 2560; $y--) {
                                foreach ($fyear as $y) {
                                    echo '<option value="' . $y['fyear'] . '"';
                                    if ($disp_year == $y['fyear']) {
                                        echo ' selected';
                                    };
                                    echo '>ปี งปม. ' . ($y['fyear']) . '</option>';
                                }
                                ?>
                            </select>
                            <?php
                            if (isset($_GET['p']) && $_GET['p'] != '') {
                                echo '<input type="hidden" name="p" value="' . $_GET['p'] . '">';
                            }
                            ?>
                        <?php } ?>
                    </form>
                </div>

            </div>

            <div class="card-body mt-0" style="font-size: 0.8em;">
                <?php
                if (isset($_GET['d']) && $_GET['d'] != '') {
                    $d = 'ของ' . $cur_department;
                } else {
                    $d = '';
                }
                if (isset($_GET['fyear']) && $_GET['fyear'] != '') {
                    $y = ' ปี งปม. ' . $_GET['fyear'];
                } else {
                    $y = ' ทั้งหมด';
                }
                // ***
                // echo '<h5 class="card-title mt-2 h5 text-primary">research ' . $d . $y . '</h5>';
                echo '<div class="text-center">
                <p class="h4 mb-1" style="font-size: 0.9rem;">สรุปผลงานการนำเสนอผลงานการวิจัย/บทความทางวิชาการ';
                if (isset($_GET["d"]) && $_GET["d"] != '') {
                    echo ' ของ' . $_GET["d"];
                }
                echo '</p>';
                if ($disp_year == "5yrs") {
                    echo '<p class="h4 mb-1" style="font-size: 0.9rem;">ปีงบประมาณ ' . $fnc->get_fiscal_year() . ' (ตุลาคม ' . ($fnc->get_fiscal_year() - 1) . ' - กันยายน ' . $fnc->get_fiscal_year() . ')</p>';
                } else {
                    echo '<p class="h4 mb-1" style="font-size: 0.9rem;">ปีงบประมาณ ' . $disp_year . ' (ตุลาคม ' . ($disp_year - 1) . ' - กันยายน ' . $disp_year . ')</p>';
                }
                echo '<p class="h4 mb-3" style="font-size: 0.9rem;">คณะเศรษฐศาสตร์ มหาวิทยาลัยแม่โจ้</p>
                </div>';

                $this->gen_table_report($disp_year);
                ?>
            </div>

            <div class="card-footer text-end text-muted" style="font-size: 0.6em;">
                last update: <?= date('M d, Y'); ?>
            </div>

            </form>
        </div>
<?php
    }

    public function gen_report_apa()
    {
        $fnc = new web;
        echo '<div class="bg-white p-3">';
        $data_array = $fnc->get_db_array("SELECT * FROM `proceeding` WHERE `pro_status` = 'enable'");
        $fnc->debug_console("data array:", $data_array);
        if (!empty($data_array)) {
            echo '<table id="myTable" class="table table-striped table-bordered table-hover table-inverse table-responsive">';
            echo '<thead class="thead-inverse">';
            echo '<tr>
            <th>ID</th>
            <th>OWNER</th>
            <th>TILE</th>
        </tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($data_array as $row) {
                echo '<tr>
                <td scope="row">' . $row['pro_id'] . '</td>';
                echo '<td>';
                echo $fnc->gen_titlePosition_short($row['pro_owner_prename']);
                echo $row['pro_owner_firstname'] . ' ' . $row['pro_owner_lastname'];
                echo '</td>';
                echo '<td>' . '<a href="?p=proceeding&act=report&cat=apasample&pid=' . $row['pro_id'] . '">' . $row['pro_study'] . '</a>' . '</td>
            </tr>';
            }
        }

        if (isset($_GET['pid']) && $_GET['pid'] != '') {
            $pid = $_GET['pid'];
            $row = $fnc->get_db_row("SELECT * FROM `proceeding` WHERE `pro_id` = " . $pid);
            if (!empty($row)) {
                echo '<h4>data</h4>';
                echo '<pre style="font-size: 0.6em;">'  . print_r($row, true) . '</pre>';
                echo '<hr class="my-3">';
                echo '<strong>Sample: </strong>' . 'เกวลิน สมบูรณ์, ชลระดา หนันติ๊ และวรัทยา แจ้งกระจ่าง. (2564). Rice Price volatility of Exports Leaders in World Markets using TGARCH model. 2021 International Conference on Internet Finance and Digital Economy (ICIFDE 2021).' . '<br>';
                // ชื่อผู้เขียนบทความ
                $apa_owner = $row['pro_owner_firstname'] . ' ' . $row['pro_owner_lastname'];
                $cow = $fnc->get_db_array("SELECT * FROM `co_worker` WHERE `cow_ref_table` = 'proceeding' AND `cow_ref_id` = " . $pid);
                if (!empty($cow)) {
                    for ($i = 0; $i < count($cow); $i++) {
                        if ($i == (count($cow) - 1)) {
                            $apa_owner .= ' และ' . $cow[$i]['cow_firstname'] . ' ' . $cow[$i]['cow_lastname'];
                        } else {
                            $apa_owner .= ', ' . $cow[$i]['cow_firstname'] . ' ' . $cow[$i]['cow_lastname'];
                        }
                    }
                }
                $apa = $apa_owner;
                // ปีที่พิมพ์
                if (!empty($row['pro_date_begin'])) {
                    $apa .= '. ' . '(' . (date("Y", strtotime($row['pro_date_begin'])) + 543) . ').';
                }
                // ชื่อบทความ
                if (!empty($row['pro_study'])) {
                    $apa .= ' ' . $row['pro_study'];
                }
                // ชื่อวารสาร
                if (!empty($row['pro_conf'])) {
                    $apa .= '. ' . $row['pro_conf'] . '.';
                }
                // ปีที่ volumn (ฉบับที่ Issue)
                if (!empty($row['pro_volumn_issue'])) {
                    $apa .= '. ' . $row['pro_volumn_issue'] . '.';
                }
                // หน้าแรก-หน้าสุดท้าย
                if (!empty($row['pro_page'])) {
                    $apa .= ', ' . $row['pro_page'];
                }
                echo '<br><strong>Output: </strong>' . $apa;


                // * apa v.7th เอกสารการประชุมทางวิชาการ / การสัมมนา / การอภิปราย รายงานการประชุม
                echo '<hr><p class="text-info fw-bold mt-2">เอกสารการประชุมทางวิชาการ / การสัมมนา / การอภิปราย รายงานการประชุม</p>';
                // ชื่อผู้แต่ง
                $apa = $apa_owner . '.';
                // ปีที่พิมพ์, วันที่, เดือน
                if (!empty($row['pro_date_begin'])) {
                    $apa .= ' (' . (date("Y", strtotime($row['pro_date_begin'])) + 543) . ', ';
                    if ($row['pro_date_begin'] != $row['pro_date_end']) {
                        // echo date("m", strtotime($row['pro_date_begin'])) . ' vs ' . date("m", strtotime($row['pro_date_end']));
                        if (date("n", strtotime($row['pro_date_begin'])) != date("n", strtotime($row['pro_date_end']))) {
                            $apa .= date("j", strtotime($row['pro_date_begin'])) . ' ' . $fnc->month_fullname[date("n", strtotime($row['pro_date_begin']))] . '-' . date("j", strtotime($row['pro_date_end'])) . ' ' . $fnc->month_fullname[date("n", strtotime($row['pro_date_end']))] . ').';
                        } else {
                            $apa .= date("j", strtotime($row['pro_date_begin'])) . '-' . date("j", strtotime($row['pro_date_end'])) . ' ' . $fnc->month_fullname[date("n", strtotime($row['pro_date_begin']))] . ').';
                        }
                    } else {
                        $apa .= date("j", strtotime($row['pro_date_begin'])) . ' ' . $fnc->month_fullname[date("n", strtotime($row['pro_date_begin']))] . ').';
                    }
                }
                // ชื่อบทความหรือชื่อเรื่องของบท
                if (!empty($row['pro_study'])) {
                    $apa .= ' ' . $row['pro_study'];
                    $apa .= ' [เอกสารนำเสนอ]';
                }
                // ชื่อการประชม
                if (!empty($row['pro_conf'])) {
                    $apa .= '. ' . $row['pro_conf'];
                }
                // เมืองที่ประชุม
                if (!empty($row['pro_location'])) {
                    $apa .= '. ' . $row['pro_location'] . '.';
                }
                echo $apa;

                echo '<br><br>';
            }
        }
        echo '</div>';
    }
}
