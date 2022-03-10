<!doctype html>
<?php

// * research function
class research_fnc
{

    public function gen_append_form()
    {
        $fnc = new web;
?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient">
                <h5 class="card-title mt-2 h3 text-primary">Research: New</h5>
                <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลงานวิจัย (ภายใน/ภายนอก)</h6>
            </div>

            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="res_name" id="res_name" aria-describedby="res_nameHelp" placeholder="ชื่องานวิจัย/เรื่อง" required>
                        <label for="res_name" class="form-label">ชื่องานวิจัย/เรื่อง <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="res_budget_source" id="res_budget_source" aria-describedby="res_budget_sourceHelp" placeholder="แหล่งทุน" required>
                        <label for="res_budget_source" class="form-label">แหล่งทุน <span class="lbl_required">*</span></label>
                    </div>
                    <!-- </div> -->

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="res_budget" id="res_budget" aria-describedby="res_budgetHelp" placeholder="งบประมาณ" min="0" required>
                        <label for="res_budget" class="form-label">งบประมาณ <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="res_budget_province" id="res_budget_province" aria-describedby="res_budget_provinceHelp" placeholder="จังหวัด">
                        <label for="res_budget_province" class="form-label">จังหวัด </label>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="date" class="form-control" name="res_period_begin" id="res_period_begin" aria-describedby="res_period_beginHelp" required>
                                <label for="res_period_begin" class="form-label">วันเริ่มต้นโครงการ <span class="lbl_required">*</span></label>
                            </div>
                            <div class="col-md-6  form-floating">
                                <input type="date" class="form-control" name="res_period_finish" id="res_period_finish" aria-describedby="res_period_finishHelp">
                                <label for="res_period_finish" class="form-label">วันสิ้นสุดโครงการ</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="res_period_begin" class="form-label">แหล่งงบประมาณ <span class="lbl_required">*</span></label>
                            <div class="col-12 mb-3">
                                <div class="form-check form-check-inline ms-2 ms-md-5">
                                    <input class="form-check-input" type="radio" name="res_tier" id="res_tier_1" value="ภายใน" checked>
                                    <label class="form-check-label" for="res_tier_1">ภายในสถาบัน</label>
                                </div>
                                <div class="form-check form-check-inline ms-2 ms-md-3">
                                    <input class="form-check-input" type="radio" name="res_tier" id="res_tier_2" value="ภายนอก">
                                    <label class="form-check-label" for="res_tier_2">ภายนอกสถาบัน</label>
                                </div>
                            </div>

                            <div class="form-floating col-12 mb-3">
                                <textarea class="form-control" name="res_detail" id="res_detail" rows="10" style="height: 15em;" placeholder="(ถ้ามี)"></textarea>
                                <label for="res_detail" class="form-label">รายละเอียด</label>
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
                                        $sql = "SELECT * FROM `department` ORDER BY `department_order`, `department_name`";
                                        $data_array = $fnc->get_db_array($sql);
                                        echo '<option value=""';
                                        echo ' selected';
                                        echo '>ไม่ระบุ</option>';
                                        foreach ($data_array as $opt) {
                                            echo '<option value="' . $opt["department_name"] . '"';
                                            if ($dept['department_name'] == $opt['department_name']) {
                                                // echo ' selected';
                                            }
                                            echo '>' . $opt["department_name"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="department_name" class="form-label">หลักสูตร/สาขาวิชา <span class="lbl_required">*</span></label>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION["admin"]["auth_lv"] >= 7) { ?>
                                <div class="col-12 mb-3 form-floating">
                                    <select class="form-select" size="8" style="height: 10em;" name="res_owner_citizenid" id="res_owner_citizenid" aria-describedby="res_owner_citizenidHelp" required>
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
                                    <label for="res_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                                </div>
                            <?php } else { ?>
                                <div class="col-12 mb-3 form-floating">
                                    <div class="col form-floating">
                                        <input type="hidden" name="res_owner_citizenid" id="res_owner_citizenid" value="<?= $_SESSION["admin"]["citizenId"] ?>">
                                        <input type="text" class="form-control" name="res_owner_fullname" id="res_owner_fullname" aria-describedby="res_owner_fullnameHelp" value="<?= $_SESSION["admin"]["firstName"] . " " . $_SESSION["admin"]["lastName"] . " (" . $fnc->gen_titlePosition_short($_SESSION["admin"]["titlePosition"]) . ")" ?>" readonly>
                                        <label for="res_owner_fullname" class="form-label">Owner <span class="lbl_required">*</span></label>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="col-12">
                                <div class="col form-floating">
                                    <input type="number" class="form-control" name="res_ratio" id="res_ratio" aria-describedby="res_ratioHelp" value="100" max="100" maxlength="5">
                                    <label for="res_ratio" class="form-label">สัดส่วน (%)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="research_append">
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-secondary btn-sm px-3 py-2 text-uppercase" onclick="history.back()"><?= $fnc->icon_set["goback"] ?>go back</button>
                        <button type="submit" class="btn btn-primary btn-sm px-3 py-2 ms-3 text-uppercase"><?= $fnc->icon_set["create"] ?>create</button>
                    </div>
                </div>

            </form>
        </div>
    <?php
    }

    public function gen_update_form($id)
    {
        $fnc = new web;
        $sql = "SELECT * FROM `research` WHERE `res_id` = " . $id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("data row: ", $row);
    ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">Updating: Research</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ปรับปรุงข้อมูล - ข้อมูลงานวิจัย (ภายใน/ภายนอก)</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
            </div>


            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="res_name" id="res_name" aria-describedby="res_nameHelp" value="<?= $row["res_name"] ?>" required>
                        <label for="res_name" class="form-label">ชื่องานวิจัย/เรื่อง <span class="lbl_required">*</span></label>
                        <!-- <div id="res_nameHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="res_budget_source" id="res_budget_source" aria-describedby="res_budget_sourceHelp" value="<?= $row["res_budget_source"] ?>" required>
                        <label for="res_budget_source" class="form-label">แหล่งทุน <span class="lbl_required">*</span></label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="number" class="form-control" name="res_budget" id="res_budget" aria-describedby="res_budgetHelp" value="<?= $row["res_budget"] ?>">
                        <label for="res_budget" class="form-label">งบประมาณ <span class="lbl_required">*</span></label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="res_budget_province" id="res_budget_province" aria-describedby="res_budget_provinceHelp" value="<?= $row["res_budget_province"] ?>">
                        <label for="res_budget_province" class="form-label">จังหวัด </label>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="date" class="form-control" name="res_period_begin" id="res_period_begin" aria-describedby="res_period_beginHelp" value="<?= $row["res_period_begin"] ?>" required>
                                <label for="res_period_begin" class="form-label">วันเริ่มต้นโครงการ <span class="lbl_required">*</span></label>
                            </div>
                            <div class="col-md-6  form-floating">
                                <input type="date" class="form-control" name="res_period_finish" id="res_period_finish" aria-describedby="res_period_finishHelp" value="<?= $row["res_period_finish"] ?>">
                                <label for="res_period_finish" class="form-label">วันสิ้นสุดโครงการ</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">

                            <label for="res_period_begin" class="form-label">แหล่งงบประมาณ <span class="lbl_required">*</span></label>
                            <div class="col-12 mb-3">
                                <div class="form-check form-check-inline ms-2 ms-md-5">
                                    <input class="form-check-input" type="radio" name="res_tier" id="res_tier_1" value="ภายใน" <?php if ($row["res_tier"] == 'ภายใน') {
                                                                                                                                    echo ' checked';
                                                                                                                                } ?>>
                                    <label class="form-check-label" for="res_tier_1">ภายในสถาบัน</label>
                                </div>
                                <div class="form-check form-check-inline ms-2 ms-md-3">
                                    <input class="form-check-input" type="radio" name="res_tier" id="res_tier_2" value="ภายนอก" <?php if ($row["res_tier"] == 'ภายนอก') {
                                                                                                                                    echo ' checked';
                                                                                                                                } ?>>
                                    <label class="form-check-label" for="res_tier_2">ภายนอกสถาบัน</label>
                                </div>
                            </div>

                            <div class="col-12 mb-3 form-floating">
                                <textarea class="form-control" name="res_detail" id="res_detail" rows="5" style="height: 10em;" placeholder="(ถ้ามี)"><?= $row["res_detail"] ?></textarea>
                                <label for="res_detail" class="form-label">รายละเอียด</label>
                            </div>

                            <div class="col mb-3 form-floating">
                                <input type="text" class="form-control" name="res_researchCode" id="res_researchCode" aria-describedby="res_researchCodeHelp" value="<?= $row["res_researchCode"] ?>">
                                <label for="res_researchCode" class="form-label">รหัสงานวิจัย</label>
                            </div>

                            <?php if (isset($_SESSION["admin"]) && $_SESSION["admin"]["auth_lv"] >= 7) { ?>
                                <div class="col mb-3 form-floating">
                                    <input type="text" class="form-control" name="res_researchID" id="res_researchID" aria-describedby="res_researchIDHelp" value="<?= $row["res_researchID"] ?>">
                                    <label for="res_researchID" class="form-label">รหัส rid <span class="lbl_required">* สำหรับเจ้าหน้าที่</span></label>
                                </div>
                            <?php } ?>

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
                                <select class="form-select" size="8" style="height: 10em;" name="res_owner_citizenid" id="res_owner_citizenid" aria-describedby="res_owner_citizenidHelp">
                                    <?php
                                    $MJU_API = new MJU_API();
                                    $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
                                    $econ_member = $MJU_API->GetAPI_array($api_url);
                                    // $fnc->debug_console("econ member", $econ_member[0]);
                                    $econ_member = $fnc->econ_member_remove_exists("research", $id, $econ_member, "owner");
                                    // $fnc->debug_console("econ member", $econ_member[0]);
                                    if (!empty($econ_member)) {
                                        foreach ($econ_member as $member) {
                                            echo '<option value="' . $member["citizenId"] . '"';
                                            if ($row["res_owner_citizenid"] == $member["citizenId"]) {
                                                echo ' selected';
                                            }
                                            echo '>' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                        }
                                    } else {
                                        // $fnc->debug_console("no member");
                                    }
                                    ?>
                                </select>
                                <label for="res_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                            </div>

                            <div class="col-12">
                                <div class="col form-floating">
                                    <input type="number" class="form-control" name="res_ratio" id="res_ratio" aria-describedby="res_ratioHelp" max="100" value="<?= $row["res_ratio"] ?>" maxlength="5">
                                    <label for="res_ratio" class="form-label">สัดส่วน (%)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="research_update">
                    <input type="hidden" name="res_id" value="<?= $id ?>">
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-secondary btn-sm px-3 py-2 text-uppercase" onclick="history.back()"><?= $fnc->icon_set["goback"] ?>go back</button>
                        <button type="submit" class="btn btn-primary btn-sm px-3 py-2 ms-3 text-uppercase"><?= $fnc->icon_set["update"] ?>Update</button>
                    </div>
                </div>

            </form>
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
                    <th rowspan="2" style="width:3em;">ลำดับ<br>ที่</th>
                    <th rowspan="2">รหัส<br>โครงการวิจัย</th>
                    <th rowspan="2">ชื่องานวิจัย</th>
                    <th colspan="2">นักวิจัย</th>
                    <th colspan="2">งบประมาณ</th>
                    <th rowspan="2" style="width:6em;">ระยะเวลา</th>
                    <th rowspan="2">แหล่งทุน</th>
                    <th rowspan="2">หมายเหตุ</th>
                </tr>
                <tr class="text-center fw-bold">
                    <th>ชื่อ</th>
                    <th>สัดส่วน</th>
                    <th>ประเภท</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.85em;">
                <?php
                // $sql = "SELECT * FROM v_research_report2 WHERE ((res_owner_citizenid = '3501400119821' ) OR( cow_citizenid = '3501400119821' ) ) AND res_fiscalyear >= '2560' AND res_fiscalyear <= '2565' GROUP BY res_id ORDER BY res_period_begin DESC";
                $sql = "SELECT res_id FROM v_research_report2 WHERE";
                $sql .= " res_status = 'enable'";
                if (isset($_GET["k"]) && $_GET["k"] != "") {
                    // $sql .= " AND (res_owner_citizenid = '" . $_GET["k"] . "' OR cow_citizenid = '" . $_GET["k"] . "')";
                    $sql .= " AND (citizenid = '" . $_GET["k"] . "')";
                }
                if (isset($_GET["d"]) && $_GET["d"] != "") {
                    // $sql .= " AND (res_department_name = '" . $_GET["d"] . "' Or cow_department_name = '" . $_GET["d"] . "')";
                    $sql .= " AND (department_name = '" . $_GET["d"] . "')";
                    // $sql .= " And vrr.department_name = '" . $_GET["d"] . "'";
                }
                if ($disp_year != "" && $disp_year != "5yrs") {
                    $sql_year = " AND res_fiscalyear = '" . ($disp_year) . "'";
                } else {
                    $sql_year = "";
                }
                if ($disp_year == "5yrs") {
                    $sql_year = " AND res_fiscalyear >= '" . ($fnc->get_fiscal_year() - 5) . "' AND res_fiscalyear <= '" . ($fnc->get_fiscal_year()) . "'";
                }
                $sql_group = " GROUP BY res_id";
                $sql_order = " ORDER BY res_period_begin DESC"; // order
                $sql .= $sql_year . $sql_group . $sql_order;
                $fnc->debug_console('sql research table owner: \n' . $sql);
                $data_array = $fnc->get_db_array($sql);
                if (!empty($data_array)) {
                    $this->gen_table_tr_report($data_array);
                } else {
                    echo '<tr style="page-break-before:auto">';
                    echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="10">no data founded</td>';
                    echo '</tr>';
                } ?>

            </tbody>
        </table>
        <?php
    }

    public function gen_table_tr_report($data_array)
    {
        $fnc = new web;
        $fnc->debug_console("data array:", $data_array);

        if (isset($_GET["act"]) && $_GET["act"] == "report") {
            $linkable = false;
        } else {
            $linkable = true;
        }

        $fnc->debug_console("data list sample: ", $data_array[0]);
        $x = 1;
        foreach ($data_array as $res) {
            $sql = "SELECT * FROM research WHERE res_id = " . $res["res_id"];
            $row = $fnc->get_db_row($sql);
            if (!empty($row)) {
        ?>
                <!-- <tr style="page-break-before: always;"> -->
                <tr>
                    <td scope="row" class="text-center"><?= $x ?></td>
                    <td class="text-center"><?php
                                            if (!empty($row["res_researchCode"])) {
                                                echo $row["res_researchCode"];
                                            }
                                            ?>
                    </td>
                    <td class="text-start"><?php
                                            if (!empty($row["res_name"])) {
                                                echo $row["res_name"];
                                            }
                                            ?>
                                            <a href="?p=research&act=report&cat=apasample&rid=<?= $row["res_id"] ?>" target="_blank" class="d-print-none"><span class="badge rounded-pill bg-secondary text-white px-2 ms-2 fw-light" style="font-size: 1em;">APA</span></a>
                    </td>
                    <td nowrap>
                        <?php
                        echo '<p class="m-0 border-bottom border-secondary">';
                        if ($linkable) {
                            echo '<a href="?p=research&find=memberId&k=' . $row["res_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["res_owner_prename"]) . $row["res_owner_firstname"] . '&nbsp;&nbsp;' . $row["res_owner_lastname"] . '</a>';
                        } else {
                            echo $fnc->gen_titlePosition_short($row["res_owner_prename"]) . $row["res_owner_firstname"] . '&nbsp;&nbsp;' . $row["res_owner_lastname"];
                        }
                        echo '</p>';
                        echo '<strong class="text-danger">Dept:</strong>' . $row["department_name"];
                        $ratio_data = array($row["res_ratio"]);
                        ?>
                        <?php
                        $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'research' AND `cow_ref_id` = " . $row["res_id"];
                        // $fnc->debug_console("co worker sql: " . $sql);
                        $co_worker = $fnc->get_db_array($sql);
                        if (!empty($co_worker)) {
                            foreach ($co_worker as $cow) {
                                echo '<p class="m-0 border-bottom border-secondary ms-2">';
                                if (!empty($cow["cow_citizenid"]) && $linkable) {
                                    echo '<a href="?p=research&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . '&nbsp;&nbsp;' . $cow["cow_lastname"] . '</a>';
                                } else {
                                    echo '<span class="">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . '&nbsp;&nbsp;' . $cow["cow_lastname"] . '</span>';
                                }
                                array_push($ratio_data, $cow["cow_ratio"]);
                                echo '</p>';
                                echo '<strong class="text-danger ms-2">Dept:</strong>' . $cow["department_name"];
                            }
                        }
                        ?>
                    </td>
                    <td class="text-end"><?php
                                            foreach ($ratio_data as $ratio) {
                                                echo '<p class="m-0 border-bottom border-secondary text-center">' . $ratio . '</p><br>';
                                            }
                                            ?>
                    </td>
                    <td class="text-center"><?php
                                            if (!empty($row["res_tier"])) {
                                                echo $row["res_tier"];
                                            }
                                            ?>
                    </td>
                    <td class="text-end" nowarp><?php
                                                if (!empty($row["res_budget"])) {
                                                    echo number_format($row["res_budget"], 0);
                                                }
                                                ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if (!empty($row["res_period_begin"])) {
                            $fnc->gen_date_range_semi_th($row["res_period_begin"], $row["res_period_finish"]);
                        }
                        ?></td>
                    <td>
                        <?php
                        if (!empty($row["res_budget_source"])) {
                            echo $row["res_budget_source"];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if (!empty($row["res_detail"])) {
                            echo $row["res_detail"];
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
            $x++;
        }
    }

    public function gen_table_tr($data_array)
    {
        $fnc = new web;

        if (isset($_GET["act"]) && $_GET["act"] == "report") {
            $linkable = false;
        } else {
            $linkable = true;
        }

        // $fnc->debug_console("data list: ", $data_array);
        $x = 1;
        foreach ($data_array as $row) {
            ?>
            <tr>
                <td scope="row" class="text-center"><?= $x ?></td>
                <td class="d-none d-md-table-cell" nowrap><?php
                                                            if ($linkable) {
                                                                echo '<a href="?p=research&find=memberId&k=' . $row["res_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["res_owner_prename"]) . $row["res_owner_firstname"] . ' ' . $row["res_owner_lastname"] . '</a>';
                                                            } else {
                                                                echo $fnc->gen_titlePosition_short($row["res_owner_prename"]) . $row["res_owner_firstname"] . ' ' . $row["res_owner_lastname"];
                                                            }
                                                            ?>
                    <?php
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'research' AND `cow_ref_id` = " . $row["res_id"];
                    // $fnc->debug_console("co worker sql: " . $sql);
                    $co_worker = $fnc->get_db_array($sql);
                    if (!empty($co_worker)) {
                        // $fnc->debug_console("co worker data: " . " res_ id " . $row["res_id"] . " cnt " . count($co_worker) . " - " , $co_worker);
                        foreach ($co_worker as $cow) {
                            echo '<br>';
                            if (!empty($cow["cow_citizenid"]) && $linkable) {
                                echo '<a href="?p=research&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                            } else {
                                echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                            }
                        }
                    }
                    ?>
                </td>
                <td><?php
                    if ($linkable) {
                        echo '<a href="?p=' . $_GET['p'] . '&act=viewinfo&rid=' . $row["res_id"] . '" target="_top" class="fw-bold">' . $row["res_name"] . '</a>';
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
                        // echo '<a href="?p=' . $_GET['p'] . '&act=viewinfo&rid=' . $row["res_id"] . '" target="_top" class="fw-bold">' . $row["res_conf"] . '</a>';
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
    }

    public function gen_data_table($data_status = 'enable')
    {
        $fnc = new web;
        ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-8 col-lg-9">
                    <?php
                    if ($data_status == 'delete') {
                        echo '<h5 class="card-title mt-2 h3 text-primary">Research Deleted</h5>';
                    } else {
                        echo '<h5 class="card-title mt-2 h3 text-primary">Research Management</h5>';
                    }
                    ?>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3">
                    <form action="?p=research" method="get">
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
                        $sql_year = "Select Year(res_period_begin) As b_year From research Where res_status = 'enable' Group By Year(res_period_begin)";
                        $byear = $fnc->get_db_array($sql_year);
                        // $fnc->debug_console("b year = ", $byear);
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
                            <th class="d-none d-md-table-cell">นักวิจัย</th>
                            <th>ชื่องานวิจัย/เรื่อง</th>
                            <th>แหล่งทุน</th>
                            <th class="d-none d-md-table-cell" style="width:7em;">ระยะเวลา</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.85em;">
                        <?php
                        // $sql = "Select jou.* From research jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                        $sql = "Select res.* From research res Left Join co_worker cowo On cowo.cow_ref_id = res.res_id Where ";
                        $sql .= "res.res_status Like '" . $data_status . "'";
                        if (isset($_GET["find"]) && $_GET["find"] != "" && isset($_GET["k"]) && $_GET["k"] != "") {
                            switch ($_GET["find"]) {
                                case "memberId":
                                    $sql .= " AND (res_owner_citizenid LIKE '" . $_GET["k"] . "' OR (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'research'))"; //  (cowo.cow_citizenid LIKE '3501400517681' AND cowo.cow_ref_table LIKE 'research')
                                    break;
                                case "search":
                                    $sql .= " AND (res_researchCode LIKE '%" . $_GET["k"] . "%' Or res_owner_firstname LIKE '%" . $_GET["k"] . "%' Or res_owner_lastname LIKE '%" . $_GET["k"] . "%' Or ((cowo.cow_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_lastname LIKE '%" . $_GET["k"] . "%' Or res_name LIKE '%" . $_GET["k"] . "%') AND cowo.cow_ref_table LIKE 'research'))";
                                    break;
                            }
                        } else {
                            if ($_SESSION["admin"]["auth_lv"] <= 7) {
                                //$sql .= " AND (res_owner_citizenid LIKE '" . $_SESSION["admin"]["citizenId"] . "' OR (cowo.cow_citizenid Like '" . $_SESSION["admin"]["citizenId"] . "' AND cowo.cow_ref_table LIKE 'research'))";
                            }
                        }
                        if ($_SESSION["admin"]["auth_lv"] <= 3) {
                            // $sql .= " AND (res_owner_citizenid LIKE '" . $_SESSION["admin"]["citizenId"] . "' OR (cowo.cow_citizenid Like '" . $_SESSION["admin"]["citizenId"] . "' AND cowo.cow_ref_table LIKE 'research'))";
                        }
                        if (isset($_GET["byear"]) && $_GET["byear"] != "") {
                            $sql_year = " AND Year(	res_period_begin) LIKE '" . $_GET["byear"] . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By res_period_begin, res.res_id";
                        $sql_order = " Order By res_period_begin Desc"; // order
                        $sql .= $sql_year . $sql_group . $sql_order;
                        // * display 20 records per load
                        $sql .= " limit 20";
                        $fnc->debug_console('sql table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_table_tr($data_array);
                        } else {
                            echo '<tr>';
                            echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="5">no data founded</td>';
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

    public function gen_data_owner($id, $row)
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
                        <td><?php if (!empty($row["res_owner_citizenid"])) {
                                echo '<a href="?p=research&find=memberId&k=' . $row["res_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["res_owner_prename"]) . $row["res_owner_firstname"] . ' ' . $row["res_owner_lastname"] . '</a>';
                            } ?></td>
                        <!-- <td class="text-start"><a href="?p=research&act=report&cat=department&d=<? //= $row["department_name"] 
                                                                                                        ?>" target="_top" class="link-primary fw-bold"><? //= $row["department_name"] 
                                                                                                                                                        ?></a></td> -->
                        <td class="text-start"><a href="?p=research&d=<?= $row["department_name"] ?>" target="_top" class="link-primary fw-bold"><?= $row["department_name"] ?></a></td>
                        <td class="text-center"><?php if (!empty($row["res_ratio"])) {
                                                    echo $row["res_ratio"];
                                                }  ?></td>
                        <?php
                        if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                            echo '<td class="text-center"></td>';
                        }
                        ?>

                    </tr>
                    <?php
                    if (!empty($row["res_ratio"])) {
                        $sum_ratio += $row["res_ratio"];
                    }
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'research' AND `cow_ref_id` = " . $id;
                    // $fnc->debug_console("co worker sql: " . $sql);
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
                                    echo '<td><a href="?p=research&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a></td>';
                                } else {
                                    echo '<td>' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</td>';
                                }
                                ?>
                                <!-- <td class="text-start"><a href="?p=research&act=report&cat=department&d=<? //= $cow["department_name"] 
                                                                                                                ?>" target="_top" class="link-primary fw-bold"><? //= $cow["department_name"] 
                                                                                                                                                                ?></a></td> -->
                                <td class="text-start"><a href="?p=research&d=<?= $cow["department_name"] ?>" target="_top" class="link-primary fw-bold"><?= $cow["department_name"] ?></a></td>
                                <td class="text-center"><?= $cow["cow_ratio"] ?></td>
                                <?php
                                if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                                    $confirm_parameter = "'research'," . $id . "," . $cow["cow_id"];
                                    echo '<td class="text-center"><a href="#" target="_top" onclick="coworker_delete_confirmation(' . $confirm_parameter . ');" class="text-danger fw-bold" style="font-size: 1.1em;">' . $fnc->icon_set["coworker_del"] . '</a></td>';
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

    public function gen_data_detail($id)
    {
        $fnc = new web;

        $sql = "SELECT * FROM research WHERE res_id = " . $id;
        $row = $fnc->get_db_row($sql);

        $label_cls = "col-12 col-md-4 col-lg-3 col-form-label fw-bold text-primary text-md-end";
        $data_cls = "col-11 offset-1 col-md-8 offset-md-0 col-lg-9 col-form-label";
    ?>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">ชื่องานวิจัย/เรื่อง</label>
            <label class="<?= $data_cls ?>"><?= $row["res_name"] ?></label>
        </div>

        <?php if (isset($_GET["act"]) && $_GET["act"] == "viewinfo") { ?>

            <?php if (!empty($row["res_budget_source"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">แหล่งทุน (จังหวัด)</label>
                    <label class="<?= $data_cls ?>"><?= $row["res_budget_source"] . ', ' . $row["res_budget_province"] . ''; ?></label>
                </div>
            <?php } ?>

            <?php if (!empty($row["res_budget"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">งบประมาณ</label>
                    <label class="<?= $data_cls ?>"><?php
                                                    echo number_format($row["res_budget"], 2) . ' บาท';
                                                    if (!empty($row["res_int_ext_source"])) {
                                                        echo ' (' . $row["res_int_ext_source"] . ')';
                                                    }
                                                    ?></label>
                </div>
            <?php } ?>

            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ระยะเวลา</label>
                <label class="<?= $data_cls ?>"><?php
                                                $fnc->gen_date_full_thai($row["res_period_begin"]);
                                                if (!empty($row["res_period_finish"])) {
                                                    echo " - ";
                                                    $fnc->gen_date_full_thai($row["res_period_finish"]);
                                                }
                                                ?></label>
            </div>

            <?php if (!empty($row["department_name"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">หลักสูตร/สาขาวิชา</label>
                    <label class="<?= $data_cls ?>"><?= $row["department_name"] ?></label>
                    <?php
                    $sql = "Select co_worker.department_name From co_worker Inner Join research On co_worker.cow_ref_id = research.res_id Where research.res_id = " . $id . " And co_worker.cow_ref_table = '" . $_GET["p"] . "' And co_worker.cow_status = 'enable' And co_worker.department_name != '' Group By co_worker.department_name Order By co_worker.department_name";
                    $fnc->debug_console("department sql:\\n" . $sql);
                    $departments = $fnc->get_db_array($sql);
                    foreach ($departments as $dept) {
                        echo '<label class="col-11 offset-1 col-md-9 offset-md-3 col-form-label">' . $dept["department_name"] . '</label>';
                    }
                    ?>
                </div>
            <?php } ?>

            <?php if (!empty($row["res_detail"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">รายละเอียด</label>
                    <label class="<?= $data_cls ?>"><?= $row["res_detail"] ?></label>
                </div>
            <?php } ?>

        <?php } ?>

        <?php if (!empty($row["res_attach"]) && $row["res_attach"] == "true") { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">เอกสารแนบ</label>
                <!-- <label class="<? //= $data_cls 
                                    ?>"><? //= $row["res_attach"] 
                                        ?></label> -->
                <div class="mb-3 mt-2 col-12 col-md-8">
                    <?php if ($row["res_attach"] == "true") { ?>
                        <div class="list-group" style="font-size: 0.8em;">
                            <!-- <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        The current link item
                    </a> -->
                            <?php
                            $sql = "SELECT * FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'research' AND `att_ref_id` = " . $id . " ORDER BY att_filename";
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
                                        $confirm_parameter = "'research'," . $id . "," . $att["att_id"];
                                        echo '<div class="col text-end">';
                                        echo '<a onclick="attachment_delete_confirmation(' . $confirm_parameter . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
                                        // echo '<a onclick="research_attachment_delete_confirmation(' . $id . ',' . $att["att_id"] . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
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
                            <label for="file_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="file_attach[]" id="file_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple required>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="research">
                        <input type="hidden" name="ref_id" value="<?= $id ?>">
                    </div>
                </div>
            </form>
        <?php } ?>


        <?php if (!empty($row["res_notes"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">หมายเหตุ</label>
                <label class="<?= $data_cls ?>"><?= $row["res_notes"] ?></label>
            </div>
        <?php } ?>

        <?php $this->gen_data_owner($id, $row);

        return $row;
    }

    public function gen_data_action_menu()
    {
        global $fnc;
        $sql = "SELECT `res_id` FROM `research` WHERE `res_id` = " . $_GET["rid"] . " AND `res_owner_citizenid` LIKE '" . $_SESSION["admin"]["citizenId"] . "'";
        if (!empty($fnc->get_db_row($sql)) || $_SESSION["admin"]["auth_lv"] >= 7) {
        ?>
            <div class="col-12 col-lg-auto align-self-top text-end fw-bold text-primary" style="font-size:0.75em;">
                <a href="?p=<?= $_GET["p"] ?>&act=viewinfo&rid=<?= $_GET["rid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-3 text-uppercase" style="font-size:1em;"><?= $fnc->icon_set["viewinfo"]; ?>view research info</a>
                <a href="?p=<?= $_GET["p"] ?>&act=coWorker&rid=<?= $_GET["rid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-3 text-uppercase ms-3" style="font-size:1em;"><?= $fnc->icon_set["coworker"]; ?>co-worker/attachment</a>
                <?php if (isset($_GET['act']) && $_GET['act'] == "viewinfo") { ?>
                    <div class="text-end mt-2">
                        <a href="?p=<?= $_GET["p"] ?>&act=update&rid=<?= $_GET["rid"] ?>" target="_top" class="btn btn-outline-primary btn-sm px-3 text-uppercase" style="font-size:1em;"><?= $fnc->icon_set["updateinfo"]; ?>update research info</a>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
    }

    public function gen_data_info($id)
    {
        $fnc = new web;
        ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">แสดงรายละเอียดของ Research</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลงานวิจัย (ภายใน/ภายนอก)</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $row = $this->gen_data_detail($id); ?>

            </div>

            <div class="card-footer text-end">
                <div class="col mt-3 me-1">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 text-uppercase" onclick="history.back()"><?= $fnc->icon_set["goback"]; ?>go back</button>
                    <?php
                    $sql = "SELECT `res_id` FROM `research` WHERE `res_id` = " . $_GET["rid"] . " AND `res_owner_citizenid` LIKE '" . $_SESSION["admin"]["citizenId"] . "'";
                    $fnc->debug_console("tool - " . $sql);
                    if (!empty($fnc->get_db_row($sql)) || $_SESSION["admin"]["auth_lv"] >= 7) {
                        if ($row["res_status"] == 'delete') { ?>
                            <button type="button" class="btn btn-outline-success px-3 py-2 text-uppercase" onclick="window.open('../db_mgt.php?p=research&act=restore&rid=<?= $id ?>','_top');">restore</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-outline-danger btn-sm px-3 py-2 text-uppercase ms-3" onclick="data_delete_confirmation(<?= "'research'," . $id ?>);"><?= $fnc->icon_set["delete"]; ?>delete research</button>
                            <!-- <button type="button" class="btn btn-primary px-4 py-2 text-uppercase">Action</button> -->
                    <?php }
                    } ?>

                </div>
            </div>

            </form>
        </div>

    <?php
    }

    public function gen_data_coworker($id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">research Co-Worker</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลงานวิจัย (ภายใน/ภายนอก) - ผู้ร่วมงาน</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $this->gen_data_detail($id); ?>

            </div>

            <?php
            $MJU_API = new MJU_API;
            $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
            // $econ_member = $MJU_API->GetAPI_array($api_url);                                    
            $econ_member = $fnc->econ_member_remove_exists("research", $id, $MJU_API->GetAPI_array($api_url));
            // $econ_member = $fnc->econ_member_remove_exists("research", $id, $MJU_API->GetAPI_array($api_url));
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
                                    <button type="submit" class="btn btn-outline-primary btn-sm px-3 py-2 text-uppercase"><?= $fnc->icon_set["coworker_add"] ?>Add</button>
                                    <input type="hidden" name="fst" value="CoWorkerIntAppend">
                                    <input type="hidden" name="ref_table" value="research">
                                    <input type="hidden" name="ref_id" value="<?= $_GET["rid"] ?>">

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
                                    <label for="res_owner_citizenid" class="form-label text-capitalize">Register a new co-worker <span class="lbl_required">*</span></label>
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
                                    <button type="submit" class="btn btn-outline-primary btn-sm px-3 py-2 text-uppercase"><?= $fnc->icon_set["coworker_add"] ?>Add</button>
                                    <input type="hidden" name="fst" value="CoWorkerExtAppend">
                                    <input type="hidden" name="ref_table" value="research">
                                    <input type="hidden" name="ref_id" value="<?= $_GET["rid"] ?>">
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

    public function gen_data_attachment($id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">research attachment</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลงานวิจัย (ภายใน/ภายนอก) - ไฟล์แนบ</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $this->gen_data_detail($id); ?>

            </div>

            <div class="card-body">
                <div class="col-md-8 mx-auto">
                    <form action="../db_mgt.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="col-12 mb-3">
                            <label for="file_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)B</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="file_attach[]" id="file_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="research">
                        <input type="hidden" name="ref_id" value="<?= $id ?>">
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
            <div class="px-0 px-md-5">
                <ul class="nav justify-content-start">
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'personal') {
                                                echo ' active link-primary" aria-current="page';
                                            } else {
                                                echo ' link-light';
                                            } ?>" href="?p=research&act=report&cat=personal">รายบุคคล</a>
                    </li>
                    <li class="nav-item d-none">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'personal') {
                                                echo ' active link-primary" aria-current="page';
                                            } else {
                                                echo ' link-light';
                                            } ?>" href="?p=research&act=report&cat=personal-old">รายบุคคล-ตัวอย่าง</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'department') {
                                                echo ' active link-primary" aria-current="page';
                                            } else {
                                                echo ' link-light';
                                            } ?>" href="?p=research&act=report&cat=department">รายหลักสูตร</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'apasample') {
                                                echo ' active link-primary" aria-current="page';
                                            } else {
                                                echo ' link-light';
                                            } ?>" href="?p=research&act=report&cat=apasample">APA's Ref</a>
                    </li>
                </ul>
            </div>
        </div>
    <?php
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
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">research Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">research Report by Personal</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานข้อมูลงานวิจัย (ภายใน/ภายนอก)รายบุคคล</h6>
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
                            <input type="hidden" name="p" value="research">
                            <input type="hidden" name="act" value="report">
                            <input type="hidden" name="cat" value="personal">
                            <?php
                            // $sql = "SELECT citizenid As citizenId, prename As prename, firstname As firstname, lastname As lastname FROM v_research_userlist GROUP BY citizenid, firstname, lastname ORDER BY firstname, lastname";
                            $sql = "SELECT citizenid, prename, firstname, lastname FROM v_research_report2 WHERE citizenid != '' AND res_status = 'enable' GROUP BY citizenid, prename, firstname, lastname ORDER BY firstname";
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
                        $sql_year = "Select res_fiscalyear As fyear From research Where research.res_status = 'enable' Group By res_fiscalyear Order By res_fiscalyear Desc";
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
                // echo '<h5 class="card-title mt-2 h5 text-primary">research ' . $k . $y . '</h5>';
                echo '<div class="text-center">
                <p class="h4 mb-1" style="font-size: 0.9rem;">สรุปจำนวนเงินสนับสนุนทุนวิจัยจากแหล่งทุนภายในและภายนอก';
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

    public function gen_table_report_department($disp_year)
    {
        global $fnc;
    ?>
        <table class="table table-bordered table-inverse table-responsive">
            <thead class="thead-inverse bg-light">
                <tr class="text-center fw-bold align-middle">
                    <th rowspan="2" style="width:3em;">ลำดับ<br>ที่</th>
                    <th rowspan="2">รหัส<br>โครงการวิจัย</th>
                    <th rowspan="2">ชื่องานวิจัย</th>
                    <th colspan="2">นักวิจัย</th>
                    <th colspan="2">งบประมาณ</th>
                    <th rowspan="2" style="width:6em;">ระยะเวลา</th>
                    <th rowspan="2">แหล่งทุน</th>
                    <th rowspan="2">รายละเอียด</th>
                </tr>
                <tr class="text-center fw-bold">
                    <th>ชื่อ</th>
                    <th>สัดส่วน</th>
                    <th>ประเภท</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.85em;">
                <?php
                // $sql = "Select res_.* From research res_ Left Join co_worker cowo On cowo.cow_ref_id = res_.res_id Where ";
                $sql = "Select res.* From research res Left Join co_worker cowo On cowo.cow_ref_id = res.res_id Where ";
                // $sql .= "res_.res_status LIKE 'enable'";
                $sql .= "res.res_status LIKE 'enable'";
                if (isset($_GET["d"]) && $_GET["d"] != "") {
                    $sql .= " AND (res.department_name LIKE '" . $_GET["d"] . "' OR cowo.department_name Like '" . $_GET["d"] . "')";
                }
                if ($disp_year != "" && $disp_year != "5yrs") {
                    $sql_year = " AND res.res_fiscalyear = '" . ($disp_year) . "'";
                } else {
                    $sql_year = "";
                }
                if ($disp_year == "5yrs") {
                    $sql_year = " AND res.res_fiscalyear > '" . ($fnc->get_fiscal_year() - 5) . "' AND res.res_fiscalyear <= '" . ($fnc->get_fiscal_year()) . "'";
                }
                $sql_group = " Group By res.res_period_begin, res.res_id";
                $sql_order = " ORDER BY res.res_period_begin Desc"; // order
                $sql .= $sql_year . $sql_group . $sql_order;
                $fnc->debug_console('sql table owner: \n' . $sql);
                $data_array = $fnc->get_db_array($sql);
                if (!empty($data_array)) {
                    $this->gen_table_tr_report($data_array);
                } else {
                    echo '<tr style="page-break-before:auto">';
                    echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="5">no data founded</td>';
                    echo '</tr>';
                } ?>

            </tbody>
        </table>
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
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">research Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">research Report by Department</h5>';
                    // }

                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานข้อมูลงานวิจัย (ภายใน/ภายนอก)ของหลักสูตร</h6>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3 d-print-none">
                    <form action="?" method="get">
                        <div class="input-group mb-0">
                            <input type="hidden" name="p" value="research">
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
                        $sql_year = "Select res_fiscalyear As fyear From research Where research.res_status = 'enable' Group By res_fiscalyear Order By res_fiscalyear Desc";
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
                <p class="h4 mb-1" style="font-size: 0.9rem;">สรุปจำนวนเงินสนับสนุนทุนวิจัยจากแหล่งทุนภายในและภายนอก';
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
        $data_array = $fnc->get_db_array("SELECT * FROM `research` WHERE `res_status` = 'enable'");
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
                echo '<tr style="font-size: 0.75em;">
                <td scope="row">' . $row['res_id'] . '</td>';
                echo '<td>';
                echo $fnc->gen_titlePosition_short($row['res_owner_prename']);
                echo $row['res_owner_firstname'] . ' ' . $row['res_owner_lastname'];
                echo '</td>';
                echo '<td>' . '<a href="?p=research&act=report&cat=apasample&rid=' . $row['res_id'] . '">' . $row['res_name'] . '</a>' . '</td>
            </tr>';
            }
        }

        if (isset($_GET['rid']) && $_GET['rid'] != '') {
            $rid = $_GET['rid'];
            $row = $fnc->get_db_row("SELECT * FROM `research` WHERE `res_id` = " . $rid);
            if (!empty($row)) {
                echo '<h4>data</h4>';
                echo '<pre style="font-size: 0.6em;">'  . print_r($row, true) . '</pre>';
                echo '<hr class="my-3">';
                echo '<strong>Sample: </strong>' . 'เกวลิน สมบูรณ์, ชลระดา หนันติ๊ และวรัทยา แจ้งกระจ่าง. (2564). Rice Price volatility of Exports Leaders in World Markets using TGARCH model. 2021 International Conference on Internet Finance and Digital Economy (ICIFDE 2021).' . '<br>';
                // ชื่อผู้เขียนบทความ
                $apa_owner = $row['res_owner_firstname'] . ' ' . $row['res_owner_lastname'];
                $cow = $fnc->get_db_array("SELECT * FROM `co_worker` WHERE `cow_ref_table` = 'research' AND `cow_ref_id` = " . $rid);
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
                if (!empty($row['res_period_begin'])) {
                    $apa .= '. ' . '(' . (date("Y", strtotime($row['res_period_begin'])) + 543) . ').';
                }
                // ชื่อบทความ
                if (!empty($row['res_name'])) {
                    $apa .= ' ' . $row['res_name'] . '.';
                }
                // ชื่อวารสาร
                if (!empty($row['res_budget_source'])) {
                    $apa .= ' ' . $row['res_budget_source'] . '.';
                }
                // ปีที่ volumn (ฉบับที่ Issue)
                if (!empty($row['res_budget'])) {
                    $apa .= ' ' . $row['res_budget'] . ',';
                }
                // หน้าแรก-หน้าสุดท้าย
                if (!empty($row['res_budget_province'])) {
                    $apa .= ' ' . $row['res_budget_province'] . '.';
                }
                // online
                if (!empty($row['res_tier'])) {
                    $apa .= ' ' . $row['res_tier'];
                }
                echo '<br><strong>Output: </strong>' . $apa;

                // * apa v.7th วารสาร
                echo '<hr><p class="text-info fw-bold mt-2">วารสาร</p>';
                // ชื่อผู้เขียนบทความ
                $apa = $apa_owner . '.';
                // ปีที่พิมพ์
                if (!empty($row['res_date_avaliable'])) {
                    $apa .= ' ' . '(' . (date("Y", strtotime($row['res_date_avaliable'])) + 543) . ').';
                }
                // ชื่อบทความ
                if (!empty($row['res_study'])) {
                    $apa .= ' ' . $row['res_study'] . '.';
                }
                // ชื่อวารสาร
                if (!empty($row['res_resnal'])) {
                    $apa .= ' ' . $row['res_resnal'] . ',';
                }
                // ปีที่ volumn (ฉบับที่ Issue)
                if (!empty($row['res_volume_issue'])) {
                    $apa .= ' ' . $row['res_volume_issue'] . ',';
                }
                // หน้าแรก-หน้าสุดท้าย
                if (!empty($row['res_page'])) {
                    $apa .= ' ' . $row['res_page'] . '.';
                }
                // online
                if (!empty($row['res_link'])) {
                    $apa .= ' ' . $row['res_link'];
                }
                echo $apa;
            }
        } else {
            echo "NONE";
        }
        echo '</div>';
    }
}
