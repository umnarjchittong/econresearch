<!doctype html>
<?php

// * reseach function
class project_fnc
{

    public function gen_append_form()
    {
        // $fnc = new web;
        global $fnc;
?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient">
                <h5 class="card-title mt-2 h3 text-primary">Academic Service Project: New</h5>
                <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลโครงการบริการวิชาการ</h6>
            </div>

            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="proj_name" id="proj_name" aria-describedby="proj_nameHelp" placeholder="ชื่อโครงการบริการวิชาการ" required>
                        <label for="proj_name" class="form-label">ชื่อโครงการบริการวิชาการ <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="proj_budget_source" id="proj_budget_source" aria-describedby="proj_budget_sourceHelp" placeholder="แหล่งทุน" required>
                        <label for="proj_budget_source" class="form-label">แหล่งทุน <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="proj_budget" id="proj_budget" aria-describedby="proj_budgetHelp" placeholder="งบประมาณ" min="0" required>
                        <label for="proj_budget" class="form-label">งบประมาณ <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="proj_target" id="proj_target" aria-describedby="proj_targetHelp" placeholder="กลุ่มเป้าหมาย">
                        <label for="proj_target" class="form-label">กลุ่มเป้าหมาย </label>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="date" class="form-control" name="proj_period_begin" id="proj_period_begin" aria-describedby="proj_period_beginHelp" required>
                                <label for="proj_period_begin" class="form-label">วันเริ่มต้นโครงการ <span class="lbl_required">*</span></label>
                            </div>
                            <div class="col-md-6  form-floating">
                                <input type="date" class="form-control" name="proj_period_finish" id="proj_period_finish" aria-describedby="proj_period_finishHelp">
                                <label for="proj_period_finish" class="form-label">วันสิ้นสุดโครงการ</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">

                            <div class="form-floating col-12 mb-3">
                                <textarea class="form-control" name="proj_detail" id="proj_detail" rows="10" style="height: 15em;" placeholder="(ถ้ามี)"></textarea>
                                <label for="proj_detail" class="form-label">รายละเอียด</label>
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
                                <select class="form-select" size="8" style="height: 10em;" name="proj_owner_citizenid" id="proj_owner_citizenid" aria-describedby="proj_owner_citizenidHelp" required>
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
                                <label for="proj_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                            </div>
                            <?php } else { ?>
                                <div class="col-12 mb-3 form-floating">
                                    <div class="col form-floating">
                                        <input type="hidden" name="proj_owner_citizenid" id="proj_owner_citizenid" value="<?= $_SESSION["admin"]["citizenId"] ?>">
                                        <input type="text" class="form-control" name="proj_owner_fullname" id="proj_owner_fullname" aria-describedby="proj_owner_fullnameHelp" value="<?= $_SESSION["admin"]["firstName"] . " " . $_SESSION["admin"]["lastName"] . " (" . $fnc->gen_titlePosition_short($_SESSION["admin"]["titlePosition"]) . ")" ?>" readonly>
                                        <label for="proj_owner_fullname" class="form-label">Owner <span class="lbl_required">*</span></label>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="project_append">
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-secondary btn-sm px-3 py-2 text-uppercase" onclick="window.location='?p=project','_top'"><?= $fnc->icon_set["goback"] ?>go back</button>
                        <button type="submit" class="btn btn-primary btn-sm px-3 py-2 ms-3 text-uppercase"><?= $fnc->icon_set["create"] ?>create project</button>
                    </div>
                </div>

            </form>
        </div>
    <?php
    }

    public function gen_update_form($id)
    {
        // $fnc = new web;
        global $fnc;
        $sql = "SELECT * FROM `project` WHERE `proj_id` = " . $id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("data row: ", $row);
    ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">Updating: project</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ปรับปรุงข้อมูล - ข้อมูลโครงการบริการวิชาการ</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
            </div>


            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="proj_name" id="proj_name" aria-describedby="proj_nameHelp" value="<?= $row["proj_name"] ?>" required>
                        <label for="proj_name" class="form-label">ชื่อโครงการบริการวิชาการ <span class="lbl_required">*</span></label>
                        <!-- <div id="proj_nameHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="proj_budget_source" id="proj_budget_source" aria-describedby="proj_budget_sourceHelp" value="<?= $row["proj_budget_source"] ?>" required>
                        <label for="proj_budget_source" class="form-label">แหล่งทุน <span class="lbl_required">*</span></label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="number" class="form-control" name="proj_budget" id="proj_budget" aria-describedby="proj_budgetHelp" value="<?= $row["proj_budget"] ?>">
                        <label for="proj_budget" class="form-label">งบประมาณ <span class="lbl_required">*</span></label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="proj_target" id="proj_target" aria-describedby="proj_targetHelp" value="<?= $row["proj_target"] ?>">
                        <label for="proj_target" class="form-label">กลุ่มเป้าหมาย </label>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="date" class="form-control" name="proj_period_begin" id="proj_period_begin" aria-describedby="proj_period_beginHelp" value="<?= $row["proj_period_begin"] ?>" required>
                                <label for="proj_period_begin" class="form-label">วันเริ่มต้นโครงการ <span class="lbl_required">*</span></label>
                            </div>
                            <div class="col-md-6  form-floating">
                                <input type="date" class="form-control" name="proj_period_finish" id="proj_period_finish" aria-describedby="proj_period_finishHelp" value="<?= $row["proj_period_finish"] ?>">
                                <label for="proj_period_finish" class="form-label">วันสิ้นสุดโครงการ</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">

                            <div class="col-12 mb-3 form-floating">
                                <textarea class="form-control" name="proj_detail" id="proj_detail" rows="5" style="height: 15em;" placeholder="(ถ้ามี)"><?= $row["proj_detail"] ?></textarea>
                                <label for="proj_detail" class="form-label">รายละเอียด</label>
                            </div>
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
                                <select class="form-select" size="8" style="height: 10em;" name="proj_owner_citizenid" id="proj_owner_citizenid" aria-describedby="proj_owner_citizenidHelp">
                                    <?php
                                    $MJU_API = new MJU_API();
                                    $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
                                    $econ_member = $MJU_API->GetAPI_array($api_url);
                                    // $fnc->debug_console("econ member", $econ_member[0]);
                                    $econ_member = $fnc->econ_member_remove_exists("project", $id, $econ_member, "owner");
                                    // $fnc->debug_console("econ member", $econ_member[0]);
                                    if (!empty($econ_member)) {
                                        foreach ($econ_member as $member) {
                                            echo '<option value="' . $member["citizenId"] . '"';
                                            if ($row["proj_owner_citizenid"] == $member["citizenId"]) {
                                                echo ' selected';
                                            }
                                            echo '>' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                        }
                                    } else {
                                        // $fnc->debug_console("no member");
                                    }
                                    ?>
                                </select>
                                <label for="proj_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="project_update">
                    <input type="hidden" name="proj_id" value="<?= $id ?>">
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-secondary btn-sm px-3 py-2 text-uppercase" onclick="window.open('?p=project&act=viewinfo&pid=<?= $id ?>','_top');"><?= $fnc->icon_set["goback"] ?>go back</button>
                        <button type="submit" class="btn btn-primary btn-sm px-3 py-2 ms-3 text-uppercase"><?= $fnc->icon_set["update"] ?>Update</button>
                    </div>
                </div>

            </form>
        </div>
        <?php
    }

    public function gen_table_tr($data_array)
    {
        // $fnc = new web;
        global $fnc;

        if (isset($_GET["act"]) && $_GET["act"] == "report") {
            $linkable = false;
        } else {
            $linkable = true;
        }

        $fnc->debug_console("data list: ", $data_array);
        $x = 1;
        foreach ($data_array as $row) {
        ?>
            <tr>
                <td scope="row" class="text-center"><?= $x ?></td>
                <td class="d-none d-md-table-cell" nowrap><?php
                                                            if ($linkable) {
                                                                echo '<a href="?p=project&find=memberId&k=' . $row["proj_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["proj_owner_prename"]) . $row["proj_owner_firstname"] . ' ' . $row["proj_owner_lastname"] . '</a>';
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
                                echo '<a href="?p=project&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                            } else {
                                echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                            }
                        }
                    }
                    ?>
                </td>
                <td><?php
                    if ($linkable) {
                        echo '<a href="?p=' . $_GET['p'] . '&act=viewinfo&pid=' . $row["proj_id"] . '" target="_top" class="fw-bold">' . $row["proj_name"] . '</a>';
                    } else {
                        echo $row["proj_name"];
                    }
                    ?>
                </td>
                <!-- <td><?php
                            // if ($linkable) {
                            //     // echo '<a href="?p=' . $_GET['p'] . '&act=viewinfo&pid=' . $row["proj_id"] . '" target="_top" class="fw-bold">' . $row["proj_conf"] . '</a>';
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
    }

    public function gen_data_table($data_status = 'enable')
    {
        // $fnc = new web;
        global $fnc;
        ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-8 col-lg-9">
                    <?php
                    if ($data_status == 'delete') {
                        echo '<h5 class="card-title mt-2 h3 text-primary">Project Deleted</h5>';
                    } else {
                        echo '<h5 class="card-title mt-2 h3 text-primary">Academic Service Project Management</h5>';
                    }
                    ?>
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
                        $sql_year = "Select Year(proj_period_begin) As b_year From project Where proj_status = 'enable' Group By Year(proj_period_begin)";
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
                            <th>โครงการบริการวิชาการ</th>
                            <!-- <th>แหล่งทุน</th> -->
                            <th class="d-none d-md-table-cell" style="width:7em;">ระยะเวลา</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.85em;">
                        <?php
                        // $sql = "Select jou.* From project jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                        $sql = "Select proj.* From project proj Left Join co_worker cowo On cowo.cow_ref_id = proj.proj_id Where ";
                        $sql .= "proj.proj_status Like '" . $data_status . "'";
                        if (isset($_GET["find"]) && $_GET["find"] != "" && isset($_GET["k"]) && $_GET["k"] != "") {
                            switch ($_GET["find"]) {
                                case "memberId":
                                    $sql .= " AND (proj.proj_owner_citizenid LIKE '" . $_GET["k"] . "' OR (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'project'))";
                                    break;
                                case "search":
                                    $sql .= " AND (proj.proj_owner_firstname LIKE '%" . $_GET["k"] . "%' Or proj.proj_owner_lastname LIKE '%" . $_GET["k"] . "%' Or ((cowo.cow_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_lastname LIKE '%" . $_GET["k"] . "%' Or proj_name LIKE '%" . $_GET["k"] . "%') AND cowo.cow_ref_table LIKE 'project'))";
                                    break;
                            }
                        } else {
                            if ($_SESSION["admin"]["auth_lv"] <= 7) {
                                //$sql .= " AND (proj.proj_owner_citizenid LIKE '" . $_SESSION["admin"]["citizenId"] . "' OR (cowo.cow_citizenid Like '" . $_SESSION["admin"]["citizenId"] . "' AND cowo.cow_ref_table LIKE 'project'))";
                            }
                        }
                        if (isset($_GET["byear"]) && $_GET["byear"] != "") {
                            $sql_year = " AND Year(proj.proj_period_begin) LIKE '" . $_GET["byear"] . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By proj.proj_period_begin, proj.proj_id";
                        $sql_order = " Order By proj.proj_period_begin Desc"; // order
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
        // $fnc = new web;
        global $fnc;
        $sum_ratio = 0;
    ?>

        <!-- * เจ้าของผลงาน / ผู้ร่วมงาน -->
        <div class="mb-3 mt-4 col-12 col-md-8 offset-md-3">
            <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
                <thead class="thead-inverse|thead-default">
                    <tr>
                        <th class="text-center" style="width:3em;">#</th>
                        <th>เจ้าของโครงการ</th>
                        <th>หลักสูตร/สาขาวิชา</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8em;">
                    <tr>
                        <td scope="row" class="text-center">1</td>
                        <td><?php if (!empty($row["proj_owner_citizenid"])) {
                                echo '<a href="?p=project&find=memberId&k=' . $row["proj_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["proj_owner_prename"]) . $row["proj_owner_firstname"] . ' ' . $row["proj_owner_lastname"] . '</a>';
                            } ?></td>
                        <td class="text-start"><a href="?p=project&d=<?= $row["department_name"] ?>" target="_top" class="link-primary fw-bold"><?= $row["department_name"] ?></a></td>
                    </tr>
                </tbody>
            </table>
            <?php
            // if ($sum_ratio > 100) {
            //     echo '<script type="text/javascript">';
            //     echo 'document.getElementById("ratio_title").setAttribute("class", "text-center text-danger");';
            //     // echo 'document.getElementById("ratio_title").innerHTML = "Hello World";';
            //     echo '</script>';
            // } elseif ($sum_ratio < 100) {
            //     echo '<script type="text/javascript">';
            //     echo 'document.getElementById("ratio_title").setAttribute("class", "text-center text-warning");';
            //     // echo 'document.getElementById("ratio_title").innerHTML = "Hello World";';
            //     echo '</script>';
            // }

            ?>

        </div>

    <?php
    }

    public function gen_data_detail($id)
    {
        // $fnc = new web;
        global $fnc;

        $sql = "SELECT * FROM project WHERE proj_id = " . $id;
        $row = $fnc->get_db_row($sql);

        $label_cls = "col-12 col-md-4 col-lg-3 col-form-label fw-bold text-primary text-md-end";
        $data_cls = "col-11 offset-1 col-md-8 offset-md-0 col-lg-8 col-form-label";
    ?>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">ชื่อโครงการบริการวิชาการ</label>
            <label class="<?= $data_cls ?>"><?= $row["proj_name"] ?></label>
        </div>

        <?php if (isset($_GET["act"]) && $_GET["act"] == "viewinfo") { ?>

            <?php if (!empty($row["proj_budget_source"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">แหล่งทุน</label>
                    <label class="<?= $data_cls ?>"><?= $row["proj_budget_source"]; ?></label>
                </div>
            <?php } ?>

            <div class="row mb-3">
                <label class="<?= $label_cls ?>">งบประมาณ</label>
                <label class="<?= $data_cls ?>"><?php
                                                echo number_format($row["proj_budget"], 2) . ' บาท';
                                                ?></label>
            </div>

            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ระยะเวลา</label>
                <label class="<?= $data_cls ?>"><?php
                                                $fnc->gen_date_range_semi_th($row["proj_period_begin"], $row["proj_period_finish"]);
                                                ?></label>
            </div>

            <?php if (!empty($row["proj_target"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">กลุ่มเป้าหมาย</label>
                    <label class="<?= $data_cls ?>"><?= $row["proj_target"]; ?></label>
                </div>
            <?php } ?>

            <?php if (!empty($row["department_name"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">หลักสูตร/สาขาวิชา</label>
                    <label class="<?= $data_cls ?>"><?= $row["department_name"] ?></label>
                    <?php
                    $sql = "Select co_worker.department_name From co_worker Inner Join project On co_worker.cow_ref_id = project.proj_id Where project.proj_id = " . $id . " And co_worker.cow_ref_table = '" . $_GET["p"] . "' And co_worker.cow_status = 'enable' And co_worker.department_name != '' Group By co_worker.department_name Order By co_worker.department_name";
                    $departments = $fnc->get_db_array($sql);
                    foreach ($departments as $dept) {
                        echo '<label class="col-11 offset-1 col-md-9 offset-md-3 col-form-label">' . $dept["department_name"] . '</label>';
                    }
                    ?>
                </div>
            <?php } ?>

            <?php if (!empty($row["proj_detail"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">รายละเอียด</label>
                    <label class="<?= $data_cls ?>"><?= $row["proj_detail"] ?></label>
                </div>
            <?php } ?>

        <?php } ?>

        <?php if (!empty($row["proj_attach"]) && $row["proj_attach"] == "true") { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">เอกสารแนบ</label>
                <!-- <label class="<? //= $data_cls 
                                    ?>"><? //= $row["proj_attach"] 
                                        ?></label> -->
                <div class="mb-3 mt-2 col-12 col-md-8">
                    <?php if ($row["proj_attach"] == "true") { ?>
                        <div class="list-group" style="font-size: 0.8em;">
                            <!-- <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        The current link item
                    </a> -->
                            <?php
                            $sql = "SELECT * FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'project' AND `att_ref_id` = " . $id . " ORDER BY att_filename";
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
                                        $confirm_parameter = "'project'," . $id . "," . $att["att_id"];
                                        echo '<div class="col text-end">';
                                        echo '<a onclick="attachment_delete_confirmation(' . $confirm_parameter . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
                                        // echo '<a onclick="proceeding_attachment_delete_confirmation(' . $id . ',' . $att["att_id"] . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
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
                            <label for="file_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)ธ</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="file_attach[]" id="file_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple required>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="project">
                        <input type="hidden" name="ref_id" value="<?= $id ?>">
                    </div>
                </div>
            </form>
        <?php } ?>


        <?php if (!empty($row["proj_notes"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">หมายเหตุ</label>
                <label class="<?= $data_cls ?>"><?= $row["proj_notes"] ?></label>
            </div>
        <?php } ?>

    <?php $this->gen_data_owner($id, $row);

        return $row;
    }

    // !! *******
    public function gen_activity_detail($project, $id)
    {
        global $fnc;
        $sql = "SELECT * FROM project_activity WHERE pa_id = " . $id;
        $row = $fnc->get_db_row($sql);

        if ($row["pa_attach"] == 'false') {
            echo '<script>
    document.getElementById("btn_photomgt").setAttribute("class", "d-none"); 
  </script>';
            // echo '';
        }

        $label_cls = "col-12 col-md-4 col-lg-3 col-form-label fw-bold text-primary text-md-end";
        $data_cls = "col-11 offset-1 col-md-8 offset-md-0 col-lg-9 col-form-label";
    ?>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">สถานที่ดำเนินกิจกรรม</label>
            <label class="<?= $data_cls ?>"><?= $row["pa_location"] ?></label>
        </div>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">ระยะเวลาดำเนินกิจกรรม</label>
            <label class="<?= $data_cls ?>"><?php
                                            $fnc->gen_date_range_semi_th($row["pa_period_begin"], $row["pa_period_finish"]);
                                            ?></label>
        </div>

        <?php if (!empty($row["pa_participant"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ผู้เข้าร่วมกิจกรรม</label>
                <label class="<?= $data_cls ?>"><?= $row["pa_participant"] ?></label>
            </div>
        <?php } ?>

        <?php if (!empty($row["pa_participant_number"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">จำนวนผู้เข้าร่วมกิจกรรม</label>
                <label class="<?= $data_cls ?>"><?php
                                                echo number_format($row["pa_participant_number"]) . ' คน';
                                                ?></label>
            </div>
        <?php } ?>

        <?php if (!empty($row["pa_detail"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">รายละเอียด</label>
                <label class="<?= $data_cls ?>"><?= $row["pa_detail"] ?></label>
            </div>
        <?php } ?>




        <?php if (!empty($row["proj_attach"]) && $row["proj_attach"] == "true") { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">เอกสารแนบ</label>
                <!-- <label class="<? //= $data_cls 
                                    ?>"><? //= $row["proj_attach"] 
                                        ?></label> -->
                <div class="mb-3 mt-2 col-12 col-md-8">
                    <?php if ($row["proj_attach"] == "true") { ?>
                        <div class="list-group" style="font-size: 0.8em;">
                            <?php
                            $sql = "SELECT * FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'project' AND `att_ref_id` = " . $id . " ORDER BY att_filename";
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
                                        $confirm_parameter = "'project'," . $id . "," . $att["att_id"];
                                        echo '<div class="col text-end">';
                                        echo '<a onclick="attachment_delete_confirmation(' . $confirm_parameter . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
                                        // echo '<a onclick="proceeding_attachment_delete_confirmation(' . $id . ',' . $att["att_id"] . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
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

        <?php
        $sql = "SELECT `proj_id` FROM `project` WHERE `proj_id` = " . $_GET["jid"] . " AND `proj_owner_citizenid` LIKE '" . $_SESSION["admin"]["citizenId"] . "'";
        if (!empty($fnc->get_db_row($sql)) || $_SESSION["admin"]["auth_lv"] >= 7) {
            ?>
        <form action="../db_mgt.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="row mb-3">
                <!-- <label class="col-sm-2 col-form-label fw-bold text-primary text-md-end">เพิ่มเอกสารแนบ</label> -->
                <div class="mb-3 mt-0 col-12 col-md-8 offset-md-2">
                    <div class="col-12 mb-3">
                        <label for="file_attach" class="form-label">ไฟล์ภาพประกอบ (เลือกได้มากกว่า 1 ไฟล์)</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="file_attach[]" id="file_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".jpg, .jpeg, .png" multiple required>
                            <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                        </div>
                    </div>
                    <input type="hidden" name="fst" value="uploadAttachments">
                    <input type="hidden" name="ref_table" value="activity">
                    <input type="hidden" name="ref_pid" value="<?= $_GET['pid'] ?>">
                    <input type="hidden" name="ref_id" value="<?= $id ?>">
                </div>
            </div>
        </form>
        <?php } ?>

        <?php
        if (isset($_GET['act']) && $_GET['act'] == 'photomgt') {
            $this->gen_photo_table_view($row, $id);
        } elseif ($_GET['act'] == 'info') {
            $this->gen_photo_grid_view($project, $row, $id);
        }

        return $row;
    }

    public function gen_photo_grid_view($project, $row, $id)
    {
        global $fnc;
        // * image grid view
        if ($row['pa_attach'] == "true") {
            $sql = "SELECT * FROM `attachment` WHERE `att_ref_table` = 'activity' AND `att_ref_id` = " . $id . " ORDER BY att_id";
            $attach_array = $fnc->get_db_array($sql);
            $fnc->debug_console("attach sql:\\n" . $sql);
            $fnc->debug_console("attach array:", $attach_array);
            if (!empty($attach_array)) {
        ?>
                <div class="row">
                    <div id="carouselImage" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php
                            $carousel_item_active = ' class="active" aria-current="true"';
                            $i = 0;
                            foreach ($attach_array as $att) {
                                $i++;
                            ?>
                                <button type="button" data-bs-target="#carouselImage" data-bs-slide-to="<?= ($i - 1); ?>" <?php
                                                                                                                            if (!empty($carousel_item_active)) {
                                                                                                                                echo $carousel_item_active;
                                                                                                                                $carousel_item_active = "";
                                                                                                                            }
                                                                                                                            ?> aria-label="<?= $project["proj_name"] . '-' . $row["pa_location"] . ' #' . $i; ?>"></button>
                            <?php } ?>
                        </div>
                        <div class="carousel-inner">
                            <?php
                            $carousel_item_active = " active";
                            foreach ($attach_array as $att) {
                            ?>
                                <div class="carousel-item<?php
                                                            if (!empty($carousel_item_active)) {
                                                                echo $carousel_item_active;
                                                                $carousel_item_active = "";
                                                            }
                                                            ?>">
                                    <img src="<?= '../' . $att['att_filepath'] . $att['att_filename']; ?>" class="d-block w-100" alt="<?= $project["proj_name"] . '-' . $row["pa_location"]; ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImage" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImage" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <?php
                    foreach ($attach_array as $att) {
                    ?>
                        <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                            <!-- <a href="#" onclick="image_popup('<? //= '../' . $att['att_filepath'] . $att['att_filename']; 
                                                                    ?>')"><img src="<? //= '../' . $att['att_filepath'] . $att['att_filename']; 
                                                                                    ?>" alt="..." class="w-100 box_shadow rounded mb-4 img-fluid img-thumbnail" data-toggle="modal" data-target="#lightbox"></a> -->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#PhotoModal" data-bs-title_text="<?= $project["proj_name"] . '-' . $row["pa_location"]; ?>" data-bs-src="<?= '../' . $att['att_filepath'] . $att['att_filename']; ?>"><img src="<?= '../' . $att['att_filepath'] . $att['att_filename']; ?>" alt="..." class="w-100 box_shadow rounded mb-4 img-fluid img-thumbnail"></a>
                        </div>
                    <?php } ?>
                </div>

                <!-- Modal -->

                <div class="modal fade" id="PhotoModal" tabindex="-1" aria-labelledby="PhotoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="PhotoModalLabel">New message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-2">
                                <div class="mb-3 text-center">
                                    <img id="modalImage" src="images/tier_icon_local_64.png" class="img-fluid" alt="123">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var PhotoModal = document.getElementById('PhotoModal')
                    PhotoModal.addEventListener('show.bs.modal', function(event) {
                        var button = event.relatedTarget
                        var title_text = button.getAttribute('data-bs-title_text');
                        var image_src = button.getAttribute('data-bs-src');
                        var modalTitle = PhotoModal.querySelector('.modal-title');
                        modalTitle.textContent = title_text;
                        document.getElementById("modalImage").src = image_src;
                    })
                </script>
            <?php
            } ?>
        <?php
        }
    }

    public function gen_photo_table_view($row, $id)
    {
        global $fnc;
        // * image grid view
        if ($row['pa_attach'] == "true") {
            $sql = "SELECT * FROM `attachment` WHERE `att_ref_table` = 'activity' AND `att_ref_id` = " . $id . " ORDER BY att_id";
            $attach_array = $fnc->get_db_array($sql);
            $fnc->debug_console("attach sql:\\n" . $sql);
            $fnc->debug_console("attach array:", $attach_array);
            if (!empty($attach_array)) {
                echo '<div class="row">';
                echo '<table class="table table-striped table-bordered table-hover table-inverse table-responsive">';
                echo '<thead class="thead-inverse">';
                echo '<tr>';
                echo '<th class="text-center" style="width: 3em;">#</th>';
                echo '<th colspan="2">Photo File Name</th>';
                // echo '<th style="width: 3em;"></th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $i = 1;
                foreach ($attach_array as $att) {
                    echo '<tr>';
                    echo '<td scope="row" class="align-middle text-center">' . $i . '</td>';
                    echo '<td class="align-middle"><img src="' . '../' . $att['att_filepath'] . $att['att_filename'] . '" class="img-thumbnail me-3" width="80px">' . $att['att_filename'] . '</td>';
                    echo '<td class="align-middle text-center" style="width: 3em;">';
                    $confirm_parameter = $_GET["pid"] . "," . $_GET["paid"] . "," . $att["att_id"];
                    echo '<a onclick="activity_photo_delete_confirmation(' . $confirm_parameter . ')" href="#" target="_TOP" class="text-danger fw-bold" style="font-size: 1.1em;"><i class="bi bi-trash-fill"></i></a>';
                    echo '</td>';
                    echo '</tr>';
                    $i++;
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }
        }
    }

    public function gen_data_action_menu()
    {
        global $fnc;
        $sql = "SELECT `proj_id` FROM `project` WHERE `proj_id` = " . $_GET["jid"] . " AND `proj_owner_citizenid` LIKE '" . $_SESSION["admin"]["citizenId"] . "'";
        if (!empty($fnc->get_db_row($sql)) || $_SESSION["admin"]["auth_lv"] >= 7) {
        ?>
            <div class="col-12 col-lg-auto align-self-top text-end fw-bold text-primary" style="font-size:0.75em;">
                <a href="?p=project&act=viewinfo&pid=<?= $_GET["pid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-3 text-uppercase" style="font-size:1em;"><?= $fnc->icon_set["viewinfo"] ?>view project info</a>
                <a href="?p=activity&act=view&pid=<?= $_GET["pid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-3 text-uppercase ms-3" style="font-size:1em;"><?= $fnc->icon_set["activities"] ?>activities in project</a>
                <?PHP if ($_GET['p'] == 'activity' && $_GET['act'] == "info" || $_GET['act'] == "photomgt") { ?>
                    <div class="text-end mt-2">
                        <a href="?p=activity&act=update&pid=<?= $_GET["pid"] ?>&paid=<?= $_GET["paid"] ?>" target="_top" class="btn btn-outline-primary btn-sm px-3 text-uppercase" style="font-size:1em;"><?= $fnc->icon_set["updateinfo"] ?>Activity Update</a>
                        <?PHP if ($_GET['act'] == "info") { ?>
                            <a id="btn_photomgt" href="?p=activity&act=photomgt&pid=<?= $_GET["pid"] ?>&paid=<?= $_GET["paid"] ?>" target="_top" class="btn btn-outline-primary btn-sm px-3 text-uppercase ms-3" style="font-size:1em;"><?= $fnc->icon_set["tableview"] ?>Photo Management</a>
                        <?PHP } ?>
                        <?PHP if ($_GET['act'] == "photomgt") { ?>
                            <a href="?p=activity&act=info&pid=<?= $_GET["pid"] ?>&paid=<?= $_GET["paid"] ?>" target="_top" class="btn btn-outline-primary btn-sm px-3 text-uppercase ms-3" style="font-size:1em;"><?= $fnc->icon_set["photoview"] ?>Photo View</a>
                        <?PHP } ?>
                    </div>
                <?PHP } ?>
                <?php if (isset($_GET['act']) && $_GET['act'] == "viewinfo") { ?>
                    <div class="text-end mt-2">
                        <a href="?p=project&act=update&pid=<?= $_GET["pid"] ?>" target="_top" class="btn btn-outline-primary btn-sm px-3 text-uppercase" style="font-size:1em;"><?= $fnc->icon_set["updateinfo"] ?>update project info</a>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['act']) && $_GET['act'] == "view") { ?>
                    <div class="text-end mt-2">
                        <a href="?p=activity&act=new&pid=<?= $_GET["pid"] ?>" target="_top" class="btn btn-outline-primary btn-sm px-3 text-uppercase" style="font-size:1em;"><?= $fnc->icon_set["activities_add"] ?>new activity</a>
                    </div>
                <?php } ?>
                <!-- <a href="?p=<? //= $_GET["p"] 
                                    ?>&act=coWorker&pid=<? //= $_GET["pid"] 
                                                    ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase ms-3" style="font-size:1em;">co-worker/attachment</a> -->
            </div>
        <?php
        }
    }

    public function gen_data_info($id)
    {
        // $fnc = new web;
        global $fnc;
        ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">แสดงรายละเอียดของ Project</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลโครงการบริการวิชาการ</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $row = $this->gen_data_detail($id); ?>

            </div>


            <?php $this->gen_activity_in_project($id); ?>

            <div class="card-footer text-end">
                <div class="col mt-3 me-1">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 text-uppercase" onclick="history.back()"><?= $fnc->icon_set["goback"] ?>go back</button>
                    <?php
                    $sql = "SELECT `proj_id` FROM `project` WHERE `proj_id` = " . $_GET["jid"] . " AND `proj_owner_citizenid` LIKE '" . $_SESSION["admin"]["citizenId"] . "'";
                    if (!empty($fnc->get_db_row($sql)) || $_SESSION["admin"]["auth_lv"] >= 7) {
                        if ($row["proj_status"] == 'delete') { ?>
                            <button type="button" class="btn btn-outline-success btn-sm px-3 py-2 text-uppercase" onclick="window.open('../db_mgt.php?p=project&act=restore&pid=<?= $id ?>','_top');"><?= $fnc->icon_set["restore"] ?>restore</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-outline-danger btn-sm px-3 py-2 text-uppercase ms-3" onclick="data_delete_confirmation(<?= "'project'," . $id ?>);"><?= $fnc->icon_set["delete"] ?>delete project</button>
                            <!-- <button type="button" class="btn btn-primary px-4 py-2 text-uppercase">Action</button> -->
                    <?php
                        }
                    } ?>

                </div>
            </div>

            </form>
        </div>

    <?php
    }

    public function gen_activity_in_project($id)
    {
        global $fnc;
    ?>

        <div class="card-body mt-0">
            <div class="mb-3 mt-0 col-12 col-md-10 mx-auto">
                <h5 class="text-primary">กิจกรรมภายใต้โครงการ</h5>
                <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
                    <thead class="thead-inverse|thead-default">
                        <tr>
                            <th class="text-center" style="width:3em;">#</th>
                            <th style="width:6em;">ระยะเวลา</th>
                            <th>สถานที่ดำเนินกิจกรรม/รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9em;">
                        <?php
                        $sql = "SELECT * FROM `project_activity` WHERE `proj_id` = " . $_GET["pid"];
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            foreach ($data_array as $act) {
                        ?>
                                <tr>
                                    <td scope="row" class="text-center">1</td>
                                    <td class="text-center"><?= $fnc->gen_date_semi_th($act["pa_period_begin"]); ?></td>
                                    <td class="text-start"><a href="project.php?p=activity&act=info&pid=<?= $_GET["pid"] ?>&paid=<?= $act["pa_id"] ?>" target="_TOP" class="text-primary"><?= $act["pa_location"] ?></a>
                                        <?php if (!empty($act["pa_detail"])) { ?><p class="p-0 m-0 mt-2"><strong class="text-dark ps-4">รายละเอียด</strong> <?= $act["pa_detail"] ?></p><?php } ?>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>

    <?php
    }

    public function gen_data_coworker($id)
    {
        // $fnc = new web;
        global $fnc;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">project Co-Worker</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลโครงการบริการวิชาการ - ผู้ร่วมงาน</h6>
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
            $econ_member = $fnc->econ_member_remove_exists("project", $id, $MJU_API->GetAPI_array($api_url));
            // $econ_member = $fnc->econ_member_remove_exists("proceeding", $id, $MJU_API->GetAPI_array($api_url));
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
                                    <button type="submit" class="btn btn-outline-primary px-4 py-2 text-uppercase">Add</button>
                                    <input type="hidden" name="fst" value="CoWorkerIntAppend">
                                    <input type="hidden" name="ref_table" value="project">
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
                                    <label for="proj_owner_citizenid" class="form-label text-capitalize">Register a new co-worker <span class="lbl_required">*</span></label>
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
                                    <input type="hidden" name="fst" value="CoWorkerExtAppend">
                                    <input type="hidden" name="ref_table" value="project">
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

    public function gen_data_activity($id)
    {
        global $fnc;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">project activities</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลโครงการบริการวิชาการ - กิจกรรม</h6>
                </div>
                <?php $this->gen_data_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $project = $this->gen_data_detail($id); ?>

            </div>

            <?PHP $this->gen_activity_attachment($project) ?>



        </div>

        <?php
    }

    public function gen_activity_attachment($project)
    {
        global $fnc;

        if (isset($_GET['act']) && $_GET['act'] == "view") {
            $sql = "SELECT * FROM `project_activity` WHERE `proj_id` = " . $_GET["pid"];
            $data_array = $fnc->get_db_array($sql);
            if (!empty($data_array)) {
        ?>
                <div class="card-body mt-0 px-5 mx-5">
                    <!-- <div class="text-end">
                        <a href="?p=activity&act=new&pid=1" class="btn btn-sm btn-primary px-4">NEW</a>
                    </div> -->
                    <div class="row gx-3">
                        <?php foreach ($data_array as $act) { ?>
                            <div class="col-6 col-md-4 p-2 mx-auto text-center"><a href="?p=activity&act=info&pid=<?= $_GET['pid'] ?>&paid=<?= $act['pa_id'] ?>" class="btn w-100 text-white mx-2 box_shadow activity_gradient"><?php echo $act["pa_location"] .  "<br>";
                                                                                                                                                                                                                                $fnc->gen_date_semi_th($act["pa_period_begin"]); ?></a></div>
                        <?php } ?>
                    </div>

                </div>

            <?php }
        } else if ($_GET['act'] == "info" || $_GET['act'] == "photomgt") { ?>
            <div class="card col-10 col-md-8 mx-auto p-0 p-md-3">
                <div class="card-header bg-light bg-gradient row justify-content-between">
                    <div class="col-auto">
                        <h5 class="card-title mt-2 h3 text-primary">รายละเอียดกิจกรรม</h5>
                        <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">แสดงรายละเอียดข้อมูลกิจกรรม</h6>
                    </div>
                </div>


                <div class="card-body mt-3">

                    <?php $activity = $this->gen_activity_detail($project, $_GET['paid']); ?>

                </div>

                <div class="card-footer text-end">
                    <div class="col mt-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 text-uppercase" onclick="history.back()"><?= $fnc->icon_set["goback"] ?>go back</button>
                        <?php
                        $sql = "SELECT `proj_id` FROM `project` WHERE `proj_id` = " . $_GET["jid"] . " AND `proj_owner_citizenid` LIKE '" . $_SESSION["admin"]["citizenId"] . "'";
                        if (!empty($fnc->get_db_row($sql)) || $_SESSION["admin"]["auth_lv"] >= 7) {
                            ?>
                        <button type="button" class="btn btn-outline-danger btn-sm px-3 py-2 text-uppercase ms-3" onclick="project_activity_delete_confirmation(<?= "'activity'," . $id . "," . $_GET["paid"]; ?>);"><?= $fnc->icon_set["delete"] ?>delete activity</button>
                        <?php } ?>

                    </div>
                </div>

                </form>
            </div>

        <?php } else if ($_GET['act'] == "new") { ?>
            <div class="card col-10 col-md-8 mx-auto p-0 p-md-3">
                <div class="card-header bg-light bg-gradient">
                    <h5 class="card-title mt-2 h3 text-primary">NEW: Activity</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลกิจกรรม</h6>
                </div>

                <form action="../db_mgt.php" method="post" autocomplete="off">
                    <div class="card-body mt-3">

                        <div class="col-12 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6 form-floating">
                                    <input type="date" class="form-control" name="pa_period_begin" id="pa_period_begin" aria-describedby="pa_period_beginHelp" required>
                                    <label for="pa_period_begin" class="form-label">วันเริ่มต้นกิจกรรม <span class="lbl_required">*</span></label>
                                </div>
                                <div class="col-md-6  form-floating">
                                    <input type="date" class="form-control" name="pa_period_finish" id="pa_period_finish" aria-describedby="pa_period_finishHelp">
                                    <label for="pa_period_finish" class="form-label">วันสิ้นสุดกิจกรรม</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="pa_location" id="pa_location" aria-describedby="pa_locationHelp" placeholder="ชื่อโครงการบริการวิชาการ" required>
                            <label for="pa_location" class="form-label">สถานที่ <span class="lbl_required">*</span></label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="pa_participant" id="pa_participant" aria-describedby="pa_participantHelp" placeholder="แหล่งทุน">
                            <label for="pa_participant" class="form-label">ผู้เข้าร่วมกิจกรรม</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="pa_participant_number" id="pa_participant_number" aria-describedby="pa_participant_numberHelp" placeholder="งบประมาณ" min="0">
                            <label for="pa_participant_number" class="form-label">จำนวนผู้เข้าร่วมกิจกรรม</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="pa_detail" id="pa_detail" rows="10" style="height: 8em;" placeholder="(ถ้ามี)"></textarea>
                            <label for="pa_detail" class="form-label">รายละเอียด</label>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <input type="hidden" name="fst" value="activity_append">
                        <input type="hidden" name="pid" value="<?= $_GET['pid'] ?>">
                        <div class="col mt-3 text-end">
                            <button type="button" class="btn btn-secondary btn-sm px-3 py-2 text-uppercase" onclick="window.location='?p=activity&act=view&pid=<?= $_GET["pid"] ?>','_top'"><?= $fnc->icon_set["goback"] ?>go back</button>
                            <button type="submit" class="btn btn-primary btn-sm px-3 py-2 ms-3 text-uppercase"><?= $fnc->icon_set["create"] ?>Create</button>
                        </div>
                    </div>

                </form>
            </div>
        <?php } else if ($_GET['act'] == "update") { ?>
            <div class="card col-10 col-md-8 mx-auto p-0 p-md-3">
                <div class="card-header bg-light bg-gradient">
                    <h5 class="card-title mt-2 h3 text-primary">UPDATE: Activity</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ปรับปรุงข้อมูลกิจกรรม</h6>
                </div>
                <?php
                $sql = "SELECT * FROM `project_activity` WHERE `pa_id` = " . $_GET['paid'];
                $row = $fnc->get_db_row($sql);
                $fnc->debug_console("data: ", $row);
                ?>
                <form action="../db_mgt.php" method="post" autocomplete="off">
                    <div class="card-body mt-3">

                        <div class="col-12 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6 form-floating">
                                    <input type="date" class="form-control" name="pa_period_begin" id="pa_period_begin" aria-describedby="pa_period_beginHelp" value="<?= $row['pa_period_begin'] ?>" required>
                                    <label for="pa_period_begin" class="form-label">วันเริ่มต้นกิจกรรม <span class="lbl_required">*</span></label>
                                </div>
                                <div class="col-md-6  form-floating">
                                    <input type="date" class="form-control" name="pa_period_finish" id="pa_period_finish" value="<?php if ($row['pa_period_finish']) {
                                                                                                                                        echo $row['pa_period_finish'];
                                                                                                                                    } ?>" aria-describedby="pa_period_finishHelp">
                                    <label for="pa_period_finish" class="form-label">วันสิ้นสุดกิจกรรม</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="pa_location" id="pa_location" aria-describedby="pa_locationHelp" placeholder="ชื่อโครงการบริการวิชาการ" value="<?= $row['pa_location'] ?>" required>
                            <label for="pa_location" class="form-label">สถานที่ <span class="lbl_required">*</span></label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="pa_participant" id="pa_participant" aria-describedby="pa_participantHelp" placeholder="ผู้เข้าร่วมกิจกรรม" value="<?php if ($row['pa_participant']) {
                                                                                                                                                                                                echo $row['pa_participant'];
                                                                                                                                                                                            } ?>">
                            <label for="pa_participant" class="form-label">ผู้เข้าร่วมกิจกรรม</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="pa_participant_number" id="pa_participant_number" aria-describedby="pa_participant_numberHelp" placeholder="จำนวนผู้เข้าร่วมกิจกรรม" min="0" value="<?php if ($row['pa_participant_number']) {
                                                                                                                                                                                                                                    echo $row['pa_participant_number'];
                                                                                                                                                                                                                                } ?>">
                            <label for="pa_participant_number" class="form-label">จำนวนผู้เข้าร่วมกิจกรรม</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="pa_detail" id="pa_detail" rows="10" style="height: 8em;" placeholder="(ถ้ามี)"><?php if ($row['pa_detail']) {
                                                                                                                                                    echo $row['pa_detail'];
                                                                                                                                                } ?></textarea>
                            <label for="pa_detail" class="form-label">รายละเอียด</label>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <input type="hidden" name="fst" value="activity_update">
                        <input type="hidden" name="pid" value="<?= $_GET['pid'] ?>">
                        <input type="hidden" name="paid" value="<?= $_GET['paid'] ?>">
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-secondary btn-sm px-3 py-2 text-uppercase" onclick="window.location='?p=activity&act=info&pid=<?= $_GET["pid"] ?>&paid=<?= $_GET["paid"] ?>','_top'"><?= $fnc->icon_set["goback"] ?>go back</button>
                            <button type="submit" class="btn btn-primary btn-sm px-3 py-2 ms-3 text-uppercase"><?= $fnc->icon_set["update"] ?>Update</button>
                        </div>
                    </div>

                </form>
            </div>
        <?php } ?>
    <?php }

    public function gen_data_attachment($id)
    {
        // $fnc = new web;
        global $fnc;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">project attachment</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลโครงการบริการวิชาการ - ไฟล์แนบ</h6>
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
                        <input type="hidden" name="ref_table" value="project">
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
        // $fnc = new web;
        global $fnc;
    ?>
        <div class="text-white-50 mb-0 d-print-none" style="background-color:#baa0df; margin-top:3.6em;">
            <div class="px-0 px-md-5">
                <ul class="nav justify-content-start">
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

    public function gen_table_report($disp_year)
    {
        global $fnc;
    ?>
        <table class="table table-bordered table-inverse table-responsive">
            <thead class="thead-inverse bg-light">
                <tr class="text-center fw-bold align-middle">
                    <th style="width:5em;">ลำดับที่</th>
                    <th>โครงการบริการวิชาการ</th>
                    <th>ชื่อ-สกุล</th>
                    <th>งบประมาณ</th>
                    <th>แหล่งทุน</th>
                    <th>ระยะเวลา</th>
                    <th>กลุ่มเป้าหมาย</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.85em;">
                <?php
                $sql = "SELECT * FROM project WHERE proj_status = 'enable'"; // ORDER BY proj_period_begin DESC";
                if (isset($_GET["k"]) && $_GET["k"] != "") {
                    $sql .= " AND proj_owner_citizenid LIKE '" . $_GET["k"] . "' ";
                }
                if (isset($_GET["d"]) && $_GET["d"] != "") {
                    $sql .= " And department_name = '" . $_GET["d"] . "'";
                }
                if ($disp_year != "" && $disp_year != "5yrs") {
                    $sql_year = " AND proj_fiscalyear = '" . ($disp_year) . "'";
                } else {
                    $sql_year = "";
                }
                if ($disp_year == "5yrs") {
                    $sql_year = " AND proj_fiscalyear >= '" . ($fnc->get_fiscal_year() - 5) . "' AND proj_fiscalyear <= '" . ($fnc->get_fiscal_year()) . "'";
                }
                $sql_group = "";
                $sql_order = " ORDER BY proj_period_begin DESC"; // order
                $sql .= $sql_year . $sql_group . $sql_order;
                $fnc->debug_console('sql project table owner: \n' . $sql);
                $data_array = $fnc->get_db_array($sql);
                $fnc->debug_console("data array:", $data_array[0]);
                if (!empty($data_array)) {
                    $this->gen_table_tr_report($data_array);
                } else {
                    echo '<tr style="page-break-before:auto">';
                    echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="8">no data founded</td>';
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
        $linkable = true;

        // $fnc->debug_console("data list sample: ", $data_array[0]);
        $x = 1;
        foreach ($data_array as $row) {
        ?>
            <!-- <tr style="page-break-before: always;"> -->
            <tr>
                <td scope="row" class="text-center"><?= $x ?></td>
                <td class="text-start"><?php
                                        if ($linkable) {
                                            echo '<a href="activity.php?p=activity&act=report&pid=' . $row["proj_id"] . '" target="_top" class="fw-bold">' . $row["proj_name"] . '</a>';
                                        } else {
                                            echo $row["proj_name"];
                                        }
                                        ?></td>
                <td nowrap>
                    <?php
                    echo '<p class="m-0">';
                    if ($linkable) {
                        echo '<a href="?p=jourjnal&find=memberId&k=' . $row["proj_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["proj_owner_prename"]) . $row["proj_owner_firstname"] . ' ' . $row["proj_owner_lastname"] . '</a>';
                    } else {
                        echo $fnc->gen_titlePosition_short($row["proj_owner_prename"]) . $row["proj_owner_firstname"] . ' ' . $row["proj_owner_lastname"];
                    }
                    echo '</p>';
                    echo '<strong class="text-danger ms-2">Dept:</strong>' . $row["department_name"];
                    ?>
                    <?php
                    // $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'journal' AND `cow_ref_id` = " . $row["jour_id"];
                    // // $fnc->debug_console("co worker sql: " . $sql);
                    // $co_worker = $fnc->get_db_array($sql);
                    // if (!empty($co_worker)) {
                    //     foreach ($co_worker as $cow) {
                    //         echo '<p class="m-0 border-bottom border-secondary ms-2">';
                    //         if (!empty($cow["cow_citizenid"]) && $linkable) {
                    //             echo '<a href="?p=jourjnal&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                    //         } else {
                    //             echo '<span class="">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                    //         }
                    //         echo '</p>';
                    //         echo '<strong class="text-danger ms-2">Dept:</strong>' . $cow["department_name"];
                    //     }
                    // }
                    ?>
                </td>
                <td class="text-end"><?php
                                        if (!empty($row["proj_budget"])) {
                                            echo number_format($row["proj_budget"], 0);
                                        }
                                        ?>
                </td>
                <td class="text-start"><?php
                                        if (!empty($row["proj_budget_source"])) {
                                            echo $row["proj_budget_source"];
                                        }
                                        ?>
                </td>
                <td class="text-center"><?php
                                        if (!empty($row["proj_period_begin"])) {
                                            $fnc->gen_date_range_semi_th($row["proj_period_begin"], $row["proj_period_finish"]);
                                        }
                                        ?>
                </td>
                <td class="text-start"><?php
                                        if (!empty($row["proj_target"])) {
                                            echo $row["proj_target"];
                                        }
                                        ?>
                </td>
                <td class="text-start"><?php
                                        if (!empty($row["proj_detail"])) {
                                            echo $row["proj_detail"];
                                        }
                                        ?>
                </td>
            </tr>
        <?php
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
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">Project Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">Project Report</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานสรุปผลงานบริการวิชาการ</h6>
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
                            <input type="hidden" name="p" value="journal">
                            <input type="hidden" name="act" value="report">
                            <input type="hidden" name="cat" value="personal">
                            <?php
                            $sql = "SELECT proj_owner_citizenid as citizenid, proj_owner_prename as prename, proj_owner_firstname as firstname, proj_owner_lastname as lastname FROM project WHERE proj_owner_citizenid != '' AND proj_status = 'enable' GROUP BY proj_owner_citizenid, proj_owner_prename, proj_owner_firstname, proj_owner_lastname ORDER BY proj_owner_firstname, proj_owner_lastname";
                            $econ_member = $fnc->get_db_array($sql);
                            $fnc->debug_console("econ member", $econ_member[0]);
                            ?>
                            <select class="form-select form-select-sm" name="k" id="k" onchange="this.form.submit();">
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
                        $sql_year = "SELECT proj_fiscalyear AS fyear FROM project WHERE proj_status = 'enable' GROUP BY proj_fiscalyear ORDER BY proj_fiscalyear DESC";
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
                // echo '<h5 class="card-title mt-2 h5 text-primary">journal ' . $k . $y . '</h5>';
                echo '<div class="text-center">
                <p class="h4 mb-1" style="font-size: 0.9rem;">สรุปผลงานการบริการวิชาการ';
                if (isset($_GET["k"]) && $_GET["k"] != '') {
                    echo 'ของ' . $cur_personal;
                }
                echo '</p>';
                if ($disp_year == "5yrs") {
                    echo '<p class="h4 mb-1" style="font-size: 0.9rem;">ปีงบประมาณ ' . ($fnc->get_fiscal_year() - 5) . ' - ' . $fnc->get_fiscal_year() . '</p>';
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
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">journal Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">Project Report by Department</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานสรุปผลงานบริการวิชาการของหลักสูตร</h6>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3 d-print-none">
                    <form action="?" method="get">
                        <div class="input-group mb-0">
                            <input type="hidden" name="p" value="journal">
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
                        $sql_year = "SELECT proj_fiscalyear AS fyear FROM project WHERE proj_status = 'enable' GROUP BY proj_fiscalyear ORDER BY proj_fiscalyear DESC";
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
                <p class="h4 mb-1" style="font-size: 0.9rem;">สรุปผลงานการบริการวิชาการ';
                if (isset($_GET["d"]) && $_GET["d"] != '') {
                    echo ' ของ' . $_GET["d"];
                }
                echo '</p>';
                if ($disp_year == "5yrs") {
                    echo '<p class="h4 mb-1" style="font-size: 0.9rem;">ปีงบประมาณ ' . ($fnc->get_fiscal_year() - 5) . ' - ' . $fnc->get_fiscal_year() . '</p>';
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


    public function gen_report_personal_old()
    {
        // $fnc = new web;
        global $fnc;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-12 col-lg-9">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">project Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">project Report by Personal</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานข้อมูลโครงการบริการวิชาการรายบุคคล</h6>
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
                            <input type="hidden" name="p" value="project">
                            <input type="hidden" name="act" value="report">
                            <input type="hidden" name="cat" value="personal">
                            <select class="form-select form-select-sm" name="k" id="k" onchange="this.form.submit();">
                                <?php
                                $MJU_API = new MJU_API;
                                $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
                                $econ_member = $MJU_API->GetAPI_array($api_url);
                                $fnc->debug_console("econ member", $econ_member[0]);
                                echo '<option value=""';
                                if (!isset($_GET["k"]) || $_GET["k"] == "") {
                                    echo ' selected';
                                }
                                echo '>' . 'แสดงข้อมูลบุคลากรทุกคน' . '</option>';
                                foreach ($econ_member as $member) {
                                    echo '<option value="' . $member["citizenId"] . '"';
                                    if (isset($_GET["k"]) && $_GET["k"] == $member["citizenId"]) {
                                        echo ' selected';
                                        $cur_personal = $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')';
                                    }
                                    echo '>' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                        $sql_year = "Select proj_fiscalyear As fyear From project Where project.proj_status = 'enable' Group By proj_fiscalyear Order By proj_fiscalyear Desc";
                        $fyear = $fnc->get_db_array($sql_year);
                        $fnc->debug_console("fiscal year = ", $fyear);
                        if (!empty($fyear)) {
                        ?>
                            <select class="form-select form-select-sm" name="fyear" aria-label="Default select example" onchange="this.form.submit();">
                                <?php
                                echo '<option value=""';
                                if (!isset($_GET['fyear']) || $_GET['fyear'] == "") {
                                    echo ' selected';
                                };
                                echo '>แสดงทุกปี งปม.</option>';
                                // for ($y = 2565; $y >= 2560; $y--) {
                                foreach ($fyear as $y) {
                                    echo '<option value="' . $y['fyear'] . '"';
                                    if (isset($_GET['fyear']) && $_GET['fyear'] != "" && $_GET['fyear'] == $y['fyear']) {
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

            <div class="card-body mt-3">
                <?php
                if (isset($_GET['k']) && $_GET['k'] != '') {
                    $k = 'ของ' . $cur_personal;
                } else {
                    $k = '';
                }
                if (isset($_GET['fyear']) && $_GET['fyear'] != '') {
                    $y = ' ปี งปม. ' . $_GET['fyear'];
                } else {
                    $y = ' ทั้งหมด';
                }
                echo '<h5 class="card-title mt-2 h5 text-primary">project ' . $k . $y . '</h5>';
                ?>
                <table class="table table-striped table-bordered table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr class="text-center fw-bold">
                            <th style="width:3em;">#</th>
                            <th class="d-none d-md-table-cell">ผู้นำเสนอ</th>
                            <th>ชื่อเรื่อง</th>
                            <th>ชื่อการประชุม</th>
                            <th class="d-none d-md-table-cell" style="width:5em;">วันที่</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.85em;">
                        <?php
                        // $sql = "elect jou.* From project jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where jou.jour_status Like 'enable' Group By jou.jour_date_avaliable, jou.jour_id Order By jou.jour_date_avaliable Desc";
                        $sql = "Select jou.* From project jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                        $sql .= "jou.jour_status LIKE 'enable'";
                        if (isset($_GET["k"]) && $_GET["k"] != "") {
                            $sql .= " AND (jou.jour_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                        }
                        if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                            $sql_year = " AND jou.jour_fiscalyear LIKE '" . ($_GET["fyear"]) . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By jou.jour_date_avaliable, jou.jour_id";
                        $sql_order = " ORDER BY jou.jour_date_avaliable Desc"; // order
                        $sql .= $sql_year . $sql_group . $sql_order;
                        $fnc->debug_console('sql project table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_table_tr($data_array);
                        } else {
                            echo '<tr style="page-break-before:auto">';
                            echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="4">no data founded</td>';
                            echo '</tr>';
                        } ?>

                    </tbody>
                </table>

            </div>

            <?php if (isset($_GET['fyear']) && $_GET['fyear'] != "") { ?>
                <div class="card-body mt-3">
                    <?php
                    $y = 'ย้อนหลัง 5 ปี งปม.';
                    echo '<h5 class="card-title mt-2 h5 text-primary">project ' . $k . ' ' . $y . '</h5>';
                    ?>
                    <table class="table table-striped table-bordered table-inverse table-responsive">
                        <thead class="thead-inverse|thead-default">
                            <tr class="text-center fw-bold">
                                <th style="width:3em;">#</th>
                                <th class="d-none d-md-table-cell">ผู้นำเสนอ</th>
                                <th>ชื่อเรื่อง</th>
                                <th class="d-none d-md-table-cell" style="width:5em;">วันที่</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.85em;">
                            <?php
                            $sql = "Select proj.* From project proj Left Join co_worker cowo On cowo.cow_ref_id = proj.proj_id Where ";
                            $sql .= "proj.proj_status LIKE 'enable'";
                            if (isset($_GET["k"]) && $_GET["k"] != "") {
                                $sql .= " AND (proj.proj_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                            }
                            if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                                $sql_year = " AND proj.proj_fiscalyear >= '" . ($_GET["fyear"] - 5) . "' AND proj.proj_fiscalyear < '" . ($_GET["fyear"]) . "'";
                            } else {
                                $sql_year = "";
                            }
                            $sql_group = " Group By proj.proj_period_begin, proj.proj_id";
                            $sql_order = " ORDER BY proj.proj_period_begin Asc"; // order
                            $sql .= $sql_year . $sql_group . $sql_order;
                            $fnc->debug_console('sql table owner: \n' . $sql);
                            $data_array = $fnc->get_db_array($sql);
                            if (!empty($data_array)) {
                                $this->gen_table_tr($data_array);
                            } else {
                                echo '<tr style="page-break-before:auto">';
                                echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="4">no data founded</td>';
                                echo '</tr>';
                            } ?>

                        </tbody>
                    </table>

                </div>
            <?php } ?>

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

    public function gen_report_department_old()
    {
        // $fnc = new web;
        global $fnc;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-8 col-lg-9">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">project Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">project Report by Department</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานข้อมูลโครงการบริการวิชาการของหลักสูตร</h6>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3 d-print-none">
                    <form action="?" method="get">
                        <div class="input-group mb-0">
                            <input type="hidden" name="p" value="project">
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
                        $sql_year = "Select proj__fiscalyear As fyear From project Where project.proj__status = 'enable' Group By proj__fiscalyear Order By proj__fiscalyear Desc";
                        $fyear = $fnc->get_db_array($sql_year);
                        $fnc->debug_console("b year = ", $fyear);
                        if (!empty($fyear)) {
                        ?>
                            <select class="form-select form-select-sm" name="fyear" aria-label="Default select example" onchange="this.form.submit();">
                                <?php
                                echo '<option value=""';
                                if (!isset($_GET['fyear']) || $_GET['fyear'] == "") {
                                    echo ' selected';
                                };
                                echo '>แสดงทั้งหมด</option>';
                                // for ($y = 2565; $y >= 2560; $y--) {
                                foreach ($fyear as $y) {
                                    echo '<option value="' . $y['fyear'] . '"';
                                    if (isset($_GET['fyear']) && $_GET['fyear'] != "" && $_GET['fyear'] == $y['fyear']) {
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

            <div class="card-body mt-3">
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
                echo '<h5 class="card-title mt-2 h5 text-primary">project ' . $d . $y . '</h5>';
                ?>
                <table class="table table-striped table-bordered table-inverse table-responsive">
                    <thead class="thead-inverse|thead-default">
                        <tr class="text-center fw-bold">
                            <th style="width:3em;">#</th>
                            <th class="d-none d-md-table-cell">ผู้นำเสนอ</th>
                            <th>ชื่อเรื่อง</th>
                            <th>ชื่อการประชุม</th>
                            <th class="d-none d-md-table-cell" style="width:5em;">วันที่</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.85em;">
                        <?php
                        // $sql = "Select proj_.* From project proj_ Left Join co_worker cowo On cowo.cow_ref_id = proj_.proj__id Where ";
                        $sql = "Select jou.* From project jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                        // $sql .= "proj_.proj__status LIKE 'enable'";
                        $sql .= "jou.jour_status LIKE 'enable'";
                        if (isset($_GET["d"]) && $_GET["d"] != "") {
                            $sql .= " AND (jou.department_name LIKE '" . $_GET["d"] . "' OR cowo.department_name Like '" . $_GET["d"] . "')";
                        }
                        if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                            $sql_year = " AND (jou.jour_fiscalyear) LIKE '" . ($_GET["fyear"]) . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By jou.jour_date_avaliable, jou.jour_id";
                        $sql_order = " ORDER BY jou.jour_date_avaliable Desc"; // order
                        $sql .= $sql_year . $sql_group . $sql_order;
                        $fnc->debug_console('sql table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_table_tr($data_array);
                        } else {
                            echo '<tr style="page-break-before:auto">';
                            echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="5">no data founded</td>';
                            echo '</tr>';
                        } ?>

                    </tbody>
                </table>

            </div>

            <?php if (isset($_GET['fyear']) && $_GET['fyear'] != '') { ?>
                <div class="card-body mt-3">
                    <?php
                    $y = 'ย้อนหลัง 5 ปี งปม.';
                    echo '<h5 class="card-title mt-2 h5 text-primary">project ' . $d . ' ' . $y . '</h5>';
                    ?>
                    <table class="table table-striped table-bordered table-inverse table-responsive">
                        <thead class="thead-inverse|thead-default">
                            <tr class="text-center fw-bold">
                                <th style="width:3em;">#</th>
                                <th class="d-none d-md-table-cell">ผู้นำเสนอ</th>
                                <th>ชื่อเรื่อง</th>
                                <th class="d-none d-md-table-cell" style="width:5em;">วันที่</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.85em;">
                            <?php
                            $sql = "Select jou.* From project jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                            $sql .= "jou.jour_status LIKE 'enable'";
                            if (isset($_GET["d"]) && $_GET["d"] != "") {
                                $sql .= " AND (jou.department_name LIKE '" . $_GET["d"] . "' OR cowo.department_name Like '" . $_GET["d"] . "')";
                            }
                            if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                                $sql_year = " AND jou.jour_fiscalyear >= '" . ($_GET["fyear"] - 5) . "' AND jou.jour_fiscalyear < '" . ($_GET["fyear"]) . "'";
                            } else {
                                $sql_year = "";
                            }
                            $sql_group = " Group By jou.jour_date_avaliable, jou.jour_id";
                            $sql_order = " ORDER BY jou.jour_date_avaliable Desc"; // order
                            $sql .= $sql_year . $sql_group . $sql_order;
                            $fnc->debug_console('sql table owner: \n' . $sql);
                            $data_array = $fnc->get_db_array($sql);
                            if (!empty($data_array)) {
                                $this->gen_table_tr($data_array);
                            } else {
                                echo '<tr style="page-break-before:auto">';
                                echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="4">no data founded</td>';
                                echo '</tr>';
                            } ?>

                        </tbody>
                    </table>

                </div>
            <?php } ?>

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

    public function gen_report_apa()
    {
        // $fnc = new web;
        global $fnc;
        echo '<div class="bg-white p-3">';
        $data_array = $fnc->get_db_array("SELECT * FROM `project` WHERE `jour_status` = 'enable'");
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
                <td scope="row">' . $row['jour_id'] . '</td>';
                echo '<td>';
                echo $fnc->gen_titlePosition_short($row['jour_owner_prename']);
                echo $row['jour_owner_firstname'] . ' ' . $row['jour_owner_lastname'];
                echo '</td>';
                echo '<td>' . '<a href="?p=project&act=report&cat=apasample&pid=' . $row['jour_id'] . '">' . $row['jour_study'] . '</a>' . '</td>
            </tr>';
            }
        }

        if (isset($_GET['pid']) && $_GET['pid'] != '') {
            $pid = $_GET['pid'];
            $row = $fnc->get_db_row("SELECT * FROM `project` WHERE `jour_id` = " . $pid);
            if (!empty($row)) {
                echo '<h4>data</h4>';
                echo '<pre style="font-size: 0.6em;">'  . print_r($row, true) . '</pre>';
                echo '<hr class="my-3">';
                echo '<strong>Sample: </strong>' . 'เกวลิน สมบูรณ์, ชลระดา หนันติ๊ และวรัทยา แจ้งกระจ่าง. (2564). Rice Price volatility of Exports Leaders in World Markets using TGARCH model. 2021 International Conference on Internet Finance and Digital Economy (ICIFDE 2021).' . '<br>';
                // ชื่อผู้เขียนบทความ
                $apa_owner = $row['jour_owner_firstname'] . ' ' . $row['jour_owner_lastname'];
                $cow = $fnc->get_db_array("SELECT * FROM `co_worker` WHERE `cow_ref_table` = 'project' AND `cow_ref_id` = " . $pid);
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
                if (!empty($row['jour_date_avaliable'])) {
                    $apa .= '. ' . '(' . (date("Y", strtotime($row['jour_date_avaliable'])) + 543) . ').';
                }
                // ชื่อบทความ
                if (!empty($row['jour_study'])) {
                    $apa .= ' ' . $row['jour_study'] . '.';
                }
                // ชื่อวารสาร
                if (!empty($row['jour_journal'])) {
                    $apa .= ' ' . $row['jour_journal'] . '.';
                }
                // ปีที่ volumn (ฉบับที่ Issue)
                if (!empty($row['jour_volume_issue'])) {
                    $apa .= ' ' . $row['jour_volume_issue'] . ',';
                }
                // หน้าแรก-หน้าสุดท้าย
                if (!empty($row['jour_page'])) {
                    $apa .= ' ' . $row['jour_page'] . '.';
                }
                // online
                if (!empty($row['jour_link'])) {
                    $apa .= ' ' . $row['jour_link'];
                }
                echo '<br><strong>Output: </strong>' . $apa;

                // * apa v.7th วารสาร
                echo '<hr><p class="text-info fw-bold mt-2">วารสาร</p>';
                // ชื่อผู้เขียนบทความ
                $apa = $apa_owner . '.';
                // ปีที่พิมพ์
                if (!empty($row['jour_date_avaliable'])) {
                    $apa .= ' ' . '(' . (date("Y", strtotime($row['jour_date_avaliable'])) + 543) . ').';
                }
                // ชื่อบทความ
                if (!empty($row['jour_study'])) {
                    $apa .= ' ' . $row['jour_study'] . '.';
                }
                // ชื่อวารสาร
                if (!empty($row['jour_journal'])) {
                    $apa .= ' ' . $row['jour_journal'] . ',';
                }
                // ปีที่ volumn (ฉบับที่ Issue)
                if (!empty($row['jour_volume_issue'])) {
                    $apa .= ' ' . $row['jour_volume_issue'] . ',';
                }
                // หน้าแรก-หน้าสุดท้าย
                if (!empty($row['jour_page'])) {
                    $apa .= ' ' . $row['jour_page'] . '.';
                }
                // online
                if (!empty($row['jour_link'])) {
                    $apa .= ' ' . $row['jour_link'];
                }
                echo $apa;
            }
        } else {
            echo "NONE";
        }
        echo '</div>';
    }
}
