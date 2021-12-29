<!doctype html>
<?php

class general_fnc
{
    public function array_remove_data($search_citizenId, $array_data)
    {
        // $i = 0;
        // echo "find : " . $search_citizenId . "<br>";
        // foreach ($array_data as $econ_member) {
        // echo "<pre>";
        // print_r($array_data);
        // echo "</pre>";
        for ($i = 0; $i < count($array_data); $i++) {
            // echo "sample array data : " . $array_data[$i]["citizenId"] . " = " . $search_citizenId . "<br>";
            // echo "found: " . $array_data[$i][]["citizenId"] . "<br>";
            if ($array_data[$i]["citizenId"] == $search_citizenId) {
                unset($array_data[$i]);
                // echo "remove id completed.<br>";
                return $array_data;
            }
        }
        return $array_data;
    }

    public function econ_member_remove_exists($pro_id, $econ_member, $type = "owner")
    {
        $fnc = new web;

        $sql_own_co = "Select pro.pro_owner_citizenid, cowo.cow_citizenid From proceeding pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id 
                                    Where pro.pro_id = " . $pro_id . " Group By pro.pro_owner_citizenid, cowo.cow_citizenid";
        $owner_coWorking = $fnc->get_db_array($sql_own_co);
        // echo "get remove array data = " . $owner_coWorking[0]["pro_owner_citizenid"] . "<br>";
        if ($type == "coworking") {
            $econ_member = $this->array_remove_data($owner_coWorking[0]["pro_owner_citizenid"], $econ_member);
        }

        foreach ($owner_coWorking as $own_cow) {
            $econ_member = $this->array_remove_data($own_cow["cow_citizenid"], $econ_member);
        }
        return $econ_member;
    }
}

// * Proceeding function
class proceeding_fnc extends general_fnc
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

    public function gen_update_form($pro_id)
    {
        $fnc = new web;
        $sql = "SELECT * FROM `proceeding` WHERE `pro_id` = " . $pro_id;
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
                                    $fnc->debug_console("econ member", $econ_member[0]);
                                    $econ_member = $this->econ_member_remove_exists($pro_id, $econ_member, "owner");
                                    $fnc->debug_console("econ member", $econ_member[0]);
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
                    <input type="hidden" name="pro_id" value="<?= $pro_id ?>">
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

    public function gen_proceeding_tr($data_array)
    {
        $fnc = new web;

        if (isset($_GET["act"]) && $_GET["act"] == "report") {
            $linkable = false;
        } else {
            $linkable = true;
        }

        $fnc->debug_console("data list: ", $data_array);
        $x = 1;
        foreach ($data_array as $row) {
            if (!empty($row["pro_tier"]) && $row["pro_tier"] == "ระดับนานาชาติ") {
                $pro_tier = '../images/tier_icon_global_64.png';
            } else {
                $pro_tier = '../images/tier_icon_local_64.png';
            }
            $pro_tier = '<img src="' . $pro_tier . '" class="mb-1 me-2" width="16em">';
        ?>
            <tr>
                <td scope="row" class="text-center"><?= $x ?></td>
                <td class="d-none d-md-table-cell" nowrap><?php
                                                            if ($linkable) {
                                                                echo '<a href="?p=proceeding&find=memberId&k=' . $row["pro_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"] . '</a>';
                                                            } else {
                                                                echo $fnc->gen_titlePosition_short($row["pro_owner_prename"]) . $row["pro_owner_firstname"] . ' ' . $row["pro_owner_lastname"];
                                                            }
                                                            ?>
                    <?php
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'proceeding' AND `cow_ref_id` = " . $row["pro_id"];
                    $fnc->debug_console("co worker sql: " . $sql);
                    $co_worker = $fnc->get_db_array($sql);
                    if (!empty($co_worker)) {
                        // $fnc->debug_console("co worker data: " . " pro id " . $row["pro_id"] . " cnt " . count($co_worker) . " - " , $co_worker);
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
            $x++;
        }
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
                        $sql_year = "Select Year(proceeding.pro_date_begin) As b_year From proceeding Where proceeding.pro_status = 'enable' Group By Year(proceeding.pro_date_begin)";
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
                        $sql = "Select pro.* From proceeding pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                        $sql .= "pro.pro_status LIKE '" . $data_status . "'";
                        if (isset($_GET["find"]) && $_GET["find"] != "" && isset($_GET["k"]) && $_GET["k"] != "") {
                            switch ($_GET["find"]) {
                                case "memberId":
                                    $sql .= " AND (pro.pro_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                                    break;
                                case "search":
                                    $sql .= " AND (pro.pro_owner_prename LIKE '%" . $_GET["k"] . "%' Or pro.pro_owner_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_lastname LIKE '%" . $_GET["k"] . "%' Or pro.pro_study LIKE '%" . $_GET["k"] . "%')";
                                    break;
                            }
                        }
                        if (isset($_GET["byear"]) && $_GET["byear"] != "") {
                            $sql_year = " AND Year(pro.pro_date_begin) LIKE '" . $_GET["byear"] . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By pro.pro_date_begin, pro.pro_id";
                        $sql_order = " ORDER BY pro.pro_date_begin Desc"; // order
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

    public function gen_proceeding_owner($pro_id, $row)
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
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'proceeding' AND `cow_ref_id` = " . $pro_id;
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
                                    // echo '<td class="text-center"><a href="#" target="_top" onclick="proceeding_coworker_delete_confirmation(' . $pro_id . ', ' . $cow["cow_id"] . ');" class="text-danger fw-bold" style="font-size: 1.1em;"><i class="bi bi-person-dash-fill"></i></a></td>';
                                    
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

    public function gen_proceeding_detail($pro_id)
    {
        $fnc = new web;

        $sql = "SELECT * FROM proceeding WHERE pro_id = " . $pro_id;
        $row = $fnc->get_db_row($sql);

        $label_cls = "col-12 col-md-4 col-lg-3 col-form-label fw-bold text-primary text-md-end";
        $data_cls = "col-11 offset-1 col-md-8 offset-md-0 col-lg-9 col-form-label";
    ?>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">ชื่อผลงาน/ชื่อเรื่อง</label>
            <label class="<?= $data_cls ?>"><?= $row["pro_study"] ?></label>
        </div>

        <?php if (!empty($_GET["act"]) && $_GET["act"] == "coWorker") { ?>

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

        <?php if (!empty($row["department_name"]) && "a" == "b") { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">อยู่ในหลักสูตร/สาขาวิชา</label>
                <label class="<?= $data_cls ?>"><?= $row["department_name"] ?></label>
                <?php
                $sql = "Select co_worker.department_name From co_worker Inner Join proceeding On co_worker.cow_ref_id = proceeding.pro_id Where proceeding.pro_id = 10 And co_worker.cow_status = 'enable'";
                $departments = $fnc->get_db_array($sql);
                foreach ($departments as $row) {
                    echo '<label class="col-11 offset-1 col-md-9 offset-md-3 col-form-label">' . $row["department_name"] . '</label>';
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
                            $sql = "SELECT * FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'proceeding' AND `att_ref_id` = " . $pro_id . " ORDER BY att_filename";
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
                                        $confirm_parameter = "'proceeding'," . $pro_id . "," . $att["att_id"];
                                        echo '<div class="col text-end">';
                                        // echo '<a onclick="proceeding_attachment_delete_confirmation(' . $pro_id . ',' . $att["att_id"] . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
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
                        <input type="hidden" name="ref_id" value="<?= $pro_id ?>">
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

    <?php $this->gen_proceeding_owner($pro_id, $row);

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

    public function gen_proceeding_coworker($pro_id)
    {
        $fnc = new web;
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

                <?php $this->gen_proceeding_detail($pro_id); ?>

            </div>

            <?php
            $MJU_API = new MJU_API;
            $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
            // $econ_member = $MJU_API->GetAPI_array($api_url);                                    
            $econ_member = $this->econ_member_remove_exists($pro_id, $MJU_API->GetAPI_array($api_url), "coworking");
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
                                            $sql = "SELECT * FROM `department` ORDER BY `department_order`, `department_name`";
                                            $data_array = $fnc->get_db_array($sql);
                                            foreach ($data_array as $opt) {
                                                echo '<option value="' . $opt["department_name"] . '"';
                                                if ($dept['department_name'] == $opt['department_name']) {
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

    public function proceeding_report_submenu()
    {
        $fnc = new web;
    ?>
        <div class="text-white-50 mb-3 d-print-none" style="background-color:#baa0df; margin-top:3.6em;">
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

    public function gen_report_personal()
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-12 col-lg-9">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">Proceeding Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding Report by Personal</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการรายบุคคล</h6>
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
                        $sql_year = "Select pro_fiscalyear As fyear From proceeding Where proceeding.pro_status = 'enable' Group By pro_fiscalyear Order By pro_fiscalyear Desc";
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
                echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding ' . $k . $y . '</h5>';
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
                        $sql = "Select pro.* From proceeding pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                        $sql .= "pro.pro_status LIKE 'enable'";
                        if (isset($_GET["k"]) && $_GET["k"] != "") {
                            $sql .= " AND (pro.pro_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                        }
                        if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                            $sql_year = " AND pro.pro_fiscalyear LIKE '" . ($_GET["fyear"]) . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By pro.pro_date_begin, pro.pro_id";
                        $sql_order = " ORDER BY pro.pro_date_begin Asc"; // order
                        $sql .= $sql_year . $sql_group . $sql_order;
                        $fnc->debug_console('sql table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_proceeding_tr($data_array);
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
                    echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding ' . $k . ' ' . $y . '</h5>';
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
                            $sql = "Select pro.* From proceeding pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                            $sql .= "pro.pro_status LIKE 'enable'";
                            if (isset($_GET["k"]) && $_GET["k"] != "") {
                                $sql .= " AND (pro.pro_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                            }
                            if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                                $sql_year = " AND pro.pro_fiscalyear >= '" . ($_GET["fyear"] - 5) . "' AND pro.pro_fiscalyear < '" . ($_GET["fyear"]) . "'";
                            } else {
                                $sql_year = "";
                            }
                            $sql_group = " Group By pro.pro_date_begin, pro.pro_id";
                            $sql_order = " ORDER BY pro.pro_date_begin Asc"; // order
                            $sql .= $sql_year . $sql_group . $sql_order;
                            $fnc->debug_console('sql table owner: \n' . $sql);
                            $data_array = $fnc->get_db_array($sql);
                            if (!empty($data_array)) {
                                $this->gen_proceeding_tr($data_array);
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

    public function gen_report_department()
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-8 col-lg-9">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">Proceeding Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding Report by Department</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการของหลักสูตร</h6>
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
                        $sql_year = "Select pro_fiscalyear As fyear From proceeding Where proceeding.pro_status = 'enable' Group By pro_fiscalyear Order By pro_fiscalyear Desc";
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
                echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding ' . $d . $y . '</h5>';
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
                        $sql = "Select pro.* From proceeding pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                        $sql .= "pro.pro_status LIKE 'enable'";
                        if (isset($_GET["d"]) && $_GET["d"] != "") {
                            $sql .= " AND (pro.department_name LIKE '" . $_GET["d"] . "' OR cowo.department_name Like '" . $_GET["d"] . "')";
                        }
                        if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                            $sql_year = " AND (pro.pro_fiscalyear) LIKE '" . ($_GET["fyear"]) . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By pro.pro_fiscalyear, pro.pro_id";
                        $sql_order = " ORDER BY pro.pro_id Asc"; // order
                        $sql .= $sql_year . $sql_group . $sql_order;
                        $fnc->debug_console('sql table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_proceeding_tr($data_array);
                        } else {
                            echo '<tr style="page-break-before:auto">';
                            echo '<td scope="row" class="text-center py-4 text-muted fw-bold text-uppercase" colspan="4">no data founded</td>';
                            echo '</tr>';
                        } ?>

                    </tbody>
                </table>

            </div>

            <?php if (isset($_GET['fyear']) && $_GET['fyear'] != '') { ?>
                <div class="card-body mt-3">
                    <?php
                    $y = 'ย้อนหลัง 5 ปี งปม.';
                    echo '<h5 class="card-title mt-2 h5 text-primary">Proceeding ' . $d . ' ' . $y . '</h5>';
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
                            $sql = "Select pro.* From proceeding pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                            $sql .= "pro.pro_status LIKE 'enable'";
                            if (isset($_GET["d"]) && $_GET["d"] != "") {
                                $sql .= " AND (pro.department_name LIKE '" . $_GET["d"] . "' OR cowo.department_name Like '" . $_GET["d"] . "')";
                            }
                            if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                                $sql_year = " AND pro.pro_fiscalyear >= '" . ($_GET["fyear"] - 5) . "' AND pro.pro_fiscalyear < '" . ($_GET["fyear"]) . "'";
                            } else {
                                $sql_year = "";
                            }
                            $sql_group = " Group By pro.pro_fiscalyear, pro.pro_id";
                            $sql_order = " ORDER BY pro.pro_id Asc"; // order
                            $sql .= $sql_year . $sql_group . $sql_order;
                            $fnc->debug_console('sql table owner: \n' . $sql);
                            $data_array = $fnc->get_db_array($sql);
                            if (!empty($data_array)) {
                                $this->gen_proceeding_tr($data_array);
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

// * journal function
class journal_fnc extends general_fnc
{

    public function gen_append_form()
    {
        $fnc = new web;
    ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient">
                <h5 class="card-title mt-2 h3 text-primary">Journal: New</h5>
                <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การตีพิมพ์ผลงานวิจัย/บทความทางวิชาการ</h6>
            </div>

            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="jour_study" id="jour_study" aria-describedby="jour_studyHelp" placeholder="ชื่อผลงาน/เรื่อง" required>
                        <label for="jour_study" class="form-label">ชื่อผลงาน/เรื่อง <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="jour_journal" id="jour_journal" aria-describedby="jour_journalHelp" placeholder="ชื่อวารสาร/ฐานข้อมูล" required>
                        <label for="jour_journal" class="form-label">ชื่อวารสาร/ฐานข้อมูล <span class="lbl_required">*</span></label>
                    </div>
                    <!-- </div> -->

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="jour_value" id="jour_value" aria-describedby="jour_valueHelp" placeholder="ชื่อวารสาร/ฐานข้อมูล" required>
                        <label for="jour_value" class="form-label">ค่าน้ำหนัก <span class="lbl_required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="jour_volume_issue" id="jour_volume_issue" aria-describedby="jour_volume_issueHelp" placeholder="9(1)">
                        <label for="jour_volume_issue" class="form-label">ปีที่ Volume (ฉบับที่ Issue) </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="jour_page" id="jour_page" aria-describedby="jour_pageHelp" placeholder="101-104">
                        <label for="jour_page" class="form-label">หน้าที่ตีพิมพ์ </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="jour_link" id="jour_link" aria-describedby="jour_linkHelp" placeholder="http://mju.ac.th">
                        <label for="jour_link" class="form-label">ลิงก์ออนไลน์ </label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="jour_date_begin" class="form-label">ระดับการนำเสนอ <span class="lbl_required">*</span></label>
                            <div class="col-12 mb-3">
                                <div class="form-check form-check-inline ms-2 ms-md-5">
                                    <input class="form-check-input" type="radio" name="jour_tier" id="jour_tier_1" value="ระดับชาติ" checked>
                                    <label class="form-check-label" for="jour_tier_1">ชาติ</label>
                                </div>
                                <div class="form-check form-check-inline ms-2 ms-md-3">
                                    <input class="form-check-input" type="radio" name="jour_tier" id="jour_tier_2" value="ระดับนานาชาติ">
                                    <label class="form-check-label" for="jour_tier_2">นานาชาติ</label>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="col-auto form-floating">
                                    <input type="date" class="form-control" name="jour_date_avaliable" id="jour_date_avaliable" aria-describedby="jour_date_avaliableHelp" required>
                                    <label for="jour_date_avaliable" class="form-label">วันที่เผยแพร่ <span class="lbl_required">*</span></label>
                                </div>
                            </div>

                            <div class="form-floating col-12 mb-3">
                                <textarea class="form-control" name="jour_detail" id="jour_detail" rows="5" style="height: 10em;" placeholder="(ถ้ามี)"></textarea>
                                <label for="jour_detail" class="form-label">รายละเอียด</label>
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

                            <div class="col-12 mb-3 form-floating">
                                <select class="form-select" size="8" style="height: 10em;" name="jour_owner_citizenid" id="jour_owner_citizenid" aria-describedby="jour_owner_citizenidHelp" required>
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
                                <label for="jour_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                            </div>

                            <div class="col-12">
                                <div class="col form-floating">
                                    <input type="number" class="form-control" name="jour_ratio" id="jour_ratio" aria-describedby="jour_ratioHelp" value="100" max="100" maxlength="5">
                                    <label for="jour_ratio" class="form-label">สัดส่วน (%)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="journal_append">
                    <div class="row px-3 gx-3 mt-3">
                        <div class="col-6 col-md-3 offset-md-6">
                            <button type="button" class="btn btn-secondary w-100 py-2 text-uppercase" onclick="window.location='?p=journal'">close</button>
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

    public function gen_update_form($jour_id)
    {
        $fnc = new web;
        $sql = "SELECT * FROM `journal` WHERE `jour_id` = " . $jour_id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("data row: ", $row);
    ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">Updating: Journal</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ปรับปรุงข้อมูล - การนำเสนอผลงานวิจัย/ผลงานทางวิชาการ</h6>
                </div>

                <?php $this->gen_journal_action_menu(); ?>
            </div>


            <form action="../db_mgt.php" method="post" autocomplete="off">
                <div class="card-body mt-3">
                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="jour_study" id="jour_study" aria-describedby="jour_studyHelp" value="<?= $row["jour_study"] ?>" required>
                        <label for="jour_study" class="form-label">ชื่อผลงาน/เรื่อง <span class="lbl_required">*</span></label>
                        <!-- <div id="jour_studyHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="jour_journal" id="jour_journal" aria-describedby="jour_journalHelp" value="<?= $row["jour_journal"] ?>" required>
                        <label for="jour_journal" class="form-label">ชื่อวารสาร / ฐานข้อมูล <span class="lbl_required">*</span></label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="jour_value" id="jour_value" aria-describedby="jour_valueHelp" value="<?= $row["jour_value"] ?>">
                        <label for="jour_value" class="form-label">ค่าน้ำหนัก <span class="lbl_required">*</span></label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="jour_volume_issue" id="jour_volume_issue" aria-describedby="jour_volume_issueHelp" value="<?= $row["jour_volume_issue"] ?>">
                        <label for="jour_volume_issue" class="form-label">ปีที่ Volume (ฉบับที่ Issue) </label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="jour_page" id="jour_page" aria-describedby="jour_pageHelp" value="<?= $row["jour_page"] ?>">
                        <label for="jour_page" class="form-label">หน้าที่ตีพิมพ์ </label>
                    </div>

                    <div class="col mb-3 form-floating">
                        <input type="text" class="form-control" name="jour_link" id="jour_link" aria-describedby="jour_linkHelp" value="<?= $row["jour_link"] ?>">
                        <label for="jour_link" class="form-label">ลิงก์ออนไลน์ </label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="jour_date_begin" class="form-label">ระดับการนำเสนอ <span class="lbl_required">*</span></label>
                            <div class="col-12 mb-3">
                                <div class="form-check form-check-inline ms-2 ms-md-5">
                                    <input class="form-check-input" type="radio" name="jour_tier" id="jour_tier_1" value="ระดับชาติ" <?php if ($row["jour_tier"] == 'ระดับชาติ') {
                                                                                                                                            echo ' checked';
                                                                                                                                        } ?>>
                                    <label class="form-check-label" for="jour_tier_1">ชาติ</label>
                                </div>
                                <div class="form-check form-check-inline ms-2 ms-md-3">
                                    <input class="form-check-input" type="radio" name="jour_tier" id="jour_tier_2" value="ระดับนานาชาติ" <?php if ($row["jour_tier"] == 'ระดับนานาชาติ') {
                                                                                                                                                echo ' checked';
                                                                                                                                            } ?>>
                                    <label class="form-check-label" for="jour_tier_2">นานาชาติ</label>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="jour_date_avaliable" id="jour_date_avaliable" aria-describedby="jour_date_avaliableHelp" value="<?= $row["jour_date_avaliable"] ?>" required>
                                    <label for="jour_date_avaliable" class="form-label">วันที่นำเสนอ <span class="lbl_required">*</span></label>
                                </div>
                            </div>

                            <div class="col-12 mb-3 form-floating">
                                <textarea class="form-control" name="jour_detail" id="jour_detail" rows="5" style="height: 10em;" placeholder="(ถ้ามี)"><?= $row["jour_detail"] ?></textarea>
                                <label for="jour_detail" class="form-label">รายละเอียด</label>
                            </div>

                            <!-- <div class="col-12 mb-3">
                                    <label for="jour_attach" class="form-label">ไฟล์แนบ (ถ้ามี)</label>
                                    <input class="form-control" type="file" name="jour_attach" id="jour_attach" accept=".pdf" multiple>
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
                                <select class="form-select" size="8" style="height: 10em;" name="jour_owner_citizenid" id="jour_owner_citizenid" aria-describedby="jour_owner_citizenidHelp">
                                    <?php
                                    $MJU_API = new MJU_API();
                                    $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
                                    $econ_member = $MJU_API->GetAPI_array($api_url);
                                    $fnc->debug_console("econ member", $econ_member[0]);
                                    $econ_member = $this->econ_member_remove_exists($jour_id, $econ_member, "owner");
                                    $fnc->debug_console("econ member", $econ_member[0]);
                                    if (!empty($econ_member)) {
                                        foreach ($econ_member as $member) {
                                            echo '<option value="' . $member["citizenId"] . '"';
                                            if ($row["jour_owner_citizenid"] == $member["citizenId"]) {
                                                echo ' selected';
                                            }
                                            echo '>' . $member["firstName"] . '&nbsp;&nbsp;' . $member["lastName"] . ' (' . $fnc->gen_titlePosition_short($member["titlePosition"]) . ')' . '</option>';
                                        }
                                    } else {
                                        // $fnc->debug_console("no member");
                                    }
                                    ?>
                                </select>
                                <label for="jour_owner_citizenid" class="form-label">Owner <span class="lbl_required">*</span></label>
                            </div>

                            <div class="col-12">
                                <div class="col form-floating">
                                    <input type="number" class="form-control" name="jour_ratio" id="jour_ratio" aria-describedby="jour_ratioHelp" max="100" value="<?= $row["jour_ratio"] ?>" maxlength="5">
                                    <label for="jour_ratio" class="form-label">สัดส่วน (%)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <input type="hidden" name="fst" value="journal_update">
                    <input type="hidden" name="jour_id" value="<?= $jour_id ?>">
                    <div class="row px-3 gx-3 mt-3">
                        <div class="col-6 col-md-3 offset-md-6">
                            <button type="button" class="btn btn-outline-secondary w-100 py-2 text-uppercase" onclick="window.open('../admin/?p=journal&act=viewinfo&jid=<?= $jour_id ?>','_top');">close</button>
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

    public function gen_journal_tr($data_array)
    {
        $fnc = new web;

        if (isset($_GET["act"]) && $_GET["act"] == "report") {
            $linkable = false;
        } else {
            $linkable = true;
        }

        $fnc->debug_console("data list: ", $data_array);
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
                                                                echo '<a href="?p=journal&find=memberId&k=' . $row["jour_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["jour_owner_prename"]) . $row["jour_owner_firstname"] . ' ' . $row["jour_owner_lastname"] . '</a>';
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
                                echo '<a href="?p=journal&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a>';
                            } else {
                                echo '<span class="ms-2">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</span>';
                            }
                        }
                    }
                    ?>
                </td>
                <td><?php
                    if ($linkable) {
                        echo $jour_tier . '<a href="?p=' . $_GET['p'] . '&act=viewinfo&jid=' . $row["jour_id"] . '" target="_top" class="fw-bold">' . $row["jour_study"] . '</a>';
                    } else {
                        echo $jour_tier . $row["jour_study"];
                    }
                    ?>
                </td>
                <td><?php
                    if ($linkable) {
                        // echo '<a href="?p=' . $_GET['p'] . '&act=viewinfo&jid=' . $row["jour_id"] . '" target="_top" class="fw-bold">' . $row["jour_conf"] . '</a>';
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
    }

    public function gen_journal_table($data_status = 'enable')
    {
        $fnc = new web;
        ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-8 col-lg-9">
                    <?php
                    if ($data_status == 'delete') {
                        echo '<h5 class="card-title mt-2 h3 text-primary">journal Deleted</h5>';
                    } else {
                        echo '<h5 class="card-title mt-2 h3 text-primary">Journals Management</h5>';
                    }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ข้อมูลการนำเสนอผลงานวิจัย/ผลงานทางวิชาการ</h6>
                </div>

                <div class="col-6 offset-6 offset-md-0 col-md-4 col-lg-3">
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
                            <input type="hidden" name="find" value="search">
                            <input type="text" class="form-control form-control-sm" name="k" placeholder="ค้นหา" <?php if (isset($_GET['find']) && $_GET['find'] == "search") {
                                                                                                                        echo ' value="' . $_GET['k'] . '"';
                                                                                                                    } ?> aria-describedby="button-addon2">
                            <button class="btn btn-outline-info btn-sm" type="submit" id="button-addon2">ค้น</button>
                        </div>
                        <?php
                        $sql_year = "Select Year(jour_date_avaliable) As b_year From journal Where jour_status = 'enable' Group By Year(jour_date_avaliable)";
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
                            <th class="d-none d-md-table-cell">เจ้าของผลงาน</th>
                            <th>ชื่อผลงาน/เรื่อง</th>
                            <th>ชื่อวารสาร/ฐานข้อมูล</th>
                            <th class="d-none d-md-table-cell" style="width:7em;">วันที่เผยแพร่</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.85em;">
                        <?php
                        $sql = "Select jou.* From journal jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                        $sql .= "jou.jour_status Like '" . $data_status . "'";
                        if (isset($_GET["find"]) && $_GET["find"] != "" && isset($_GET["k"]) && $_GET["k"] != "") {
                            switch ($_GET["find"]) {
                                case "memberId":
                                    $sql .= " AND (jou.jour_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                                    break;
                                case "search":
                                    $sql .= " AND (jou.jour_owner_lastname LIKE '%" . $_GET["k"] . "%' Or jou.jour_owner_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_lastname LIKE '%" . $_GET["k"] . "%' Or jou.jour_study LIKE '%" . $_GET["k"] . "%')";
                                    break;
                            }
                        }
                        if (isset($_GET["byear"]) && $_GET["byear"] != "") {
                            $sql_year = " AND Year(jou.jour_date_avaliable) LIKE '" . $_GET["byear"] . "'";
                        } else {
                            $sql_year = "";
                        }
                        $sql_group = " Group By jou.jour_date_avaliable, jou.jour_id";
                        $sql_order = " Order By jou.jour_date_avaliable Desc"; // order
                        $sql .= $sql_year . $sql_group . $sql_order;
                        $fnc->debug_console('sql table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_journal_tr($data_array);
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

    public function gen_journal_owner($jour_id, $row)
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
                        <td><?= '<a href="?p=journal&find=memberId&k=' . $row["jour_owner_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($row["jour_owner_prename"]) . $row["jour_owner_firstname"] . ' ' . $row["jour_owner_lastname"] . '</a>' ?></td>
                        <!-- <td class="text-start"><a href="?p=journal&act=report&cat=department&d=<? //= $row["department_name"] 
                                                                                                    ?>" target="_top" class="link-primary fw-bold"><? //= $row["department_name"] 
                                                                                                                                                                                    ?></a></td> -->
                        <td class="text-start"><a href="?p=journal&d=<?= $row["department_name"] ?>" target="_top" class="link-primary fw-bold"><?= $row["department_name"] ?></a></td>
                        <td class="text-center"><?= $row["jour_ratio"] ?></td>
                        <?php
                        if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                            echo '<td class="text-center"></td>';
                        }
                        ?>

                    </tr>
                    <?php
                    $sum_ratio += $row["jour_ratio"];
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'journal' AND `cow_ref_id` = " . $jour_id;
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
                                    echo '<td><a href="?p=journal&find=memberId&k=' . $cow["cow_citizenid"] . '" target="_top" class="fw-bold">' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</a></td>';
                                } else {
                                    echo '<td>' . $fnc->gen_titlePosition_short($cow["cow_prename"]) . $cow["cow_firstname"] . ' ' . $cow["cow_lastname"] . '</td>';
                                }
                                ?>
                                <!-- <td class="text-start"><a href="?p=journal&act=report&cat=department&d=<? //= $cow["department_name"] 
                                                                                                            ?>" target="_top" class="link-primary fw-bold"><? //= $cow["department_name"] 
                                                                                                                                                                                            ?></a></td> -->
                                <td class="text-start"><a href="?p=journal&d=<?= $cow["department_name"] ?>" target="_top" class="link-primary fw-bold"><?= $cow["department_name"] ?></a></td>
                                <td class="text-center"><?= $cow["cow_ratio"] ?></td>
                                <?php
                                if (isset($_GET['act']) && $_GET['act'] == "coWorker") {
                                    $confirm_parameter = "'journal'," . $jour_id . "," . $cow["cow_id"];
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

    public function gen_journal_detail($jour_id)
    {
        $fnc = new web;

        $sql = "SELECT * FROM journal WHERE jour_id = " . $jour_id;
        $row = $fnc->get_db_row($sql);

        $label_cls = "col-12 col-md-4 col-lg-3 col-form-label fw-bold text-primary text-md-end";
        $data_cls = "col-11 offset-1 col-md-8 offset-md-0 col-lg-9 col-form-label";
    ?>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">ชื่อผลงาน/ชื่อเรื่อง</label>
            <label class="<?= $data_cls ?>"><?= $row["jour_study"] ?></label>
        </div>

        <?php if (isset($_GET["act"]) && $_GET["act"] == "viewinfo") { ?>

        <?php if (!empty($row["jour_journal"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ชื่อวารสาร / ฐานข้อมูล</label>
                <label class="<?= $data_cls ?>"><?= $row["jour_journal"] ?></label>
            </div>
        <?php } ?>

        <?php if (!empty($row["jour_value"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ค่าน้ำหนัก</label>
                <label class="<?= $data_cls ?>"><?= $row["jour_value"] ?></label>
            </div>
        <?php } ?>

        <?php if (!empty($row["jour_volume_issue"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ปีที่ Volume (ฉบับที่ Issue)</label>
                <label class="<?= $data_cls ?>"><?= $row["jour_volume_issue"] ?></label>
            </div>
        <?php } ?>

        <?php if (!empty($row["jour_page"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">หน้าที่ตีพิมพ์</label>
                <label class="<?= $data_cls ?>"><?= $row["jour_page"] ?></label>
            </div>
        <?php } ?>

        <?php if (!empty($row["jour_link"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ลิงก์ออนไลน์</label>
                <label class="<?= $data_cls ?>"><?= $row["jour_link"] ?></label>
            </div>
        <?php } ?>

        <?php
        if (!empty($row["jour_tier"]) && $row["jour_tier"] == "ระดับนานาชาติ") {
            $pro_tier = '../images/tier_icon_global_64.png';
        } else {
            $pro_tier = '../images/tier_icon_local_64.png';
        }
        $pro_tier = '<img src="' . $pro_tier . '" class="mb-1 me-2" width="16em">';
        ?>
        <div class="row mb-3">
            <label class="<?= $label_cls ?>">ระดับ</label>
            <label class="<?= $data_cls ?>"><?= $pro_tier . $row["jour_tier"] ?></label>
        </div>

        <div class="row mb-3">
            <label class="<?= $label_cls ?>">วันที่เผยแพร่</label>
            <label class="<?= $data_cls ?>"><?php
                                            $fnc->gen_date_full_thai($row["jour_date_avaliable"]);
                                            ?></label>
        </div>

        <?php if (!empty($row["department_name"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">อยู่ในหลักสูตร/สาขาวิชา</label>
                <label class="<?= $data_cls ?>"><?= $row["department_name"] ?></label>
                <?php
                $sql = "Select co_worker.department_name From co_worker Inner Join journal On co_worker.cow_ref_id = journal.jour_id Where journal.jour_id = 10 And co_worker.cow_status = 'enable'";
                $departments = $fnc->get_db_array($sql);
                foreach ($departments as $row) {
                    echo '<label class="col-11 offset-1 col-md-9 offset-md-3 col-form-label">' . $row["department_name"] . '</label>';
                }
                ?>
            </div>
        <?php } ?>

        <?php if (!empty($row["jour_detail"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">รายละเอียด</label>
                <label class="<?= $data_cls ?>"><?= $row["jour_detail"] ?></label>
            </div>
        <?php } ?>

        <?php } ?>

        <?php if ($row["jour_attach"] == "true") { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">เอกสารแนบa</label>
                <!-- <label class="<? //= $data_cls 
                                    ?>"><? //= $row["jour_attach"] 
                                        ?></label> -->
                <div class="mb-3 mt-2 col-12 col-md-8">
                    <?php if ($row["jour_attach"] == "true") { ?>
                        <div class="list-group" style="font-size: 0.8em;">
                            <!-- <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        The current link item
                    </a> -->
                            <?php
                            $sql = "SELECT * FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'journal' AND `att_ref_id` = " . $jour_id . " ORDER BY att_filename";
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
                                        $confirm_parameter = "'journal'," . $jour_id . "," . $att["att_id"];
                                        echo '<div class="col text-end">';
                                        echo '<a onclick="attachment_delete_confirmation(' . $confirm_parameter . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
                                        // echo '<a onclick="proceeding_attachment_delete_confirmation(' . $jour_id . ',' . $att["att_id"] . ')" href="#" target="_TOP" class="text-danger fw-bold ms-3" style="font-size: 1.1em;">' . '<i class="bi bi-trash-fill"></i>' . '</a>';
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
                            <label for="file_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)A</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="file_attach[]" id="file_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple required>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="journal">
                        <input type="hidden" name="ref_id" value="<?= $jour_id ?>">
                    </div>
                </div>
            </form>
        <?php } ?>


        <?php if (!empty($row["jour_notes"])) { ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">หมายเหตุ</label>
                <label class="<?= $data_cls ?>"><?= $row["jour_notes"] ?></label>
            </div>
        <?php } ?>

    <?php $this->gen_journal_owner($jour_id, $row);

        return $row;
    }

    public function gen_journal_action_menu()
    {
    ?>
        <div class="col-auto align-self-top text-end fw-bold text-primary" style="font-size:0.75em;">
            <a href="?p=<?= $_GET["p"] ?>&act=viewinfo&jid=<?= $_GET["jid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase" style="font-size:1em;">view info</a>
            <a href="?p=<?= $_GET["p"] ?>&act=update&jid=<?= $_GET["jid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase ms-3" style="font-size:1em;">update info</a>
            <a href="?p=<?= $_GET["p"] ?>&act=coWorker&jid=<?= $_GET["jid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase ms-3" style="font-size:1em;">co-worker/attachment</a>
        </div>
    <?php
    }

    public function gen_journal_info($jour_id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">แสดงรายละเอียดของ Journal</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การตีพิมพ์ผลงานวิจัย/บทความทางวิชาการ</h6>
                </div>

                <?php $this->gen_journal_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $row = $this->gen_journal_detail($jour_id); ?>

            </div>

            <div class="card-footer text-end">
                <div class="col mt-3">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 text-uppercase" onclick="window.open('?p=journal');">close</button>
                    <?php if ($row["pro_status"] == 'delete') { ?>
                        <button type="button" class="btn btn-outline-success px-4 py-2 text-uppercase" onclick="window.open('../db_mgt.php?p=journal&act=restore&pid=<?= $jour_id ?>','_top');">restore</button>
                    <?php } else { 
                        $confirm_parameter = "'journal'," . $jour_id; ?>
                        <!-- <button type="button" class="btn btn-outline-danger px-4 py-2 text-uppercase" onclick="data_delete_confirmation(<?//= 'journal,' . $jour_id ?>);">delete</button> -->
                        <button type="button" class="btn btn-outline-danger px-4 py-2 text-uppercase" onclick="data_delete_confirmation(<?= $confirm_parameter ?>);">delete</button>
                        <!-- <button type="button" class="btn btn-primary px-4 py-2 text-uppercase">Action</button> -->
                    <?php } ?>

                </div>
            </div>

            </form>
        </div>

    <?php
    }

    public function gen_journal_coworker($jour_id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">journal Co-Worker</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การตีพิมพ์ผลงานวิจัย/บทความทางวิชาการ - ผู้ร่วมงาน</h6>
                </div>

                <?php $this->gen_journal_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $this->gen_journal_detail($jour_id); ?>

            </div>

            <?php
            $MJU_API = new MJU_API;
            $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
            // $econ_member = $MJU_API->GetAPI_array($api_url);                                    
            $econ_member = $this->econ_member_remove_exists($jour_id, $MJU_API->GetAPI_array($api_url), "coworking");
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
                                            $sql = "SELECT * FROM `department` ORDER BY `department_order`, `department_name`";
                                            $data_array = $fnc->get_db_array($sql);
                                            foreach ($data_array as $opt) {
                                                echo '<option value="' . $opt["department_name"] . '"';
                                                if ($dept['department_name'] == $opt['department_name']) {
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
                                    <input type="hidden" name="fst" value="journalCoWorkerIntAppend">
                                    <input type="hidden" name="ref_table" value="journal">
                                    <input type="hidden" name="ref_id" value="<?= $_GET["jid"] ?>">

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
                                    <input type="hidden" name="fst" value="journalCoWorkerExtAppend">
                                    <input type="hidden" name="ref_table" value="journal">
                                    <input type="hidden" name="ref_id" value="<?= $_GET["jid"] ?>">
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

    public function gen_journal_attachment($jour_id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">journal attachment</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การตีพิมพ์ผลงานวิจัย/บทความทางวิชาการ - ไฟล์แนบ</h6>
                </div>

                <?php $this->gen_journal_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $this->gen_journal_detail($jour_id); ?>

            </div>

            <div class="card-body">
                <div class="col-md-8 mx-auto">
                    <form action="../db_mgt.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="col-12 mb-3">
                            <label for="pro_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)B</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="pro_attach[]" id="pro_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="journal">
                        <input type="hidden" name="ref_id" value="<?= $jour_id ?>">
                    </form>
                </div>

            </div>



            </form>
        </div>

    <?php
    }

    public function journal_report_submenu()
    {
        $fnc = new web;
    ?>
        <div class="text-white-50 mb-3 d-print-none" style="background-color:#baa0df; margin-top:3.6em;">
            <div class="container px-0 px-md-5">
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'personal') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=journal&act=report&cat=personal">รายบุคคล</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'department') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=journal&act=report&cat=department">รายหลักสูตร</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php if (isset($_GET['cat']) && $_GET['cat'] == 'apasample') {
                                                echo ' active link-light" aria-current="page';
                                            } else {
                                                echo ' link-primary';
                                            } ?>" href="?p=journal&act=report&cat=apasample">APA's Ref</a>
                    </li>
                </ul>
            </div>
        </div>
    <?php
    }

    public function gen_report_personal()
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-12 col-lg-9">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">journal Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">journal Report by Personal</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานการตีพิมพ์ผลงานวิจัย/บทความทางวิชาการรายบุคคล</h6>
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
                        $sql_year = "Select pro_fiscalyear As fyear From journal Where journal.pro_status = 'enable' Group By pro_fiscalyear Order By pro_fiscalyear Desc";
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
                echo '<h5 class="card-title mt-2 h5 text-primary">journal ' . $k . $y . '</h5>';
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
                        // $sql = "elect jou.* From journal jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where jou.jour_status Like 'enable' Group By jou.jour_date_avaliable, jou.jour_id Order By jou.jour_date_avaliable Desc";
                        $sql = "Select jou.* From journal jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
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
                        $fnc->debug_console('sql journal table owner: \n' . $sql);
                        $data_array = $fnc->get_db_array($sql);
                        if (!empty($data_array)) {
                            $this->gen_journal_tr($data_array);
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
                    echo '<h5 class="card-title mt-2 h5 text-primary">journal ' . $k . ' ' . $y . '</h5>';
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
                            $sql = "Select pro.* From journal pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                            $sql .= "pro.pro_status LIKE 'enable'";
                            if (isset($_GET["k"]) && $_GET["k"] != "") {
                                $sql .= " AND (pro.pro_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                            }
                            if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                                $sql_year = " AND pro.pro_fiscalyear >= '" . ($_GET["fyear"] - 5) . "' AND pro.pro_fiscalyear < '" . ($_GET["fyear"]) . "'";
                            } else {
                                $sql_year = "";
                            }
                            $sql_group = " Group By pro.pro_date_begin, pro.pro_id";
                            $sql_order = " ORDER BY pro.pro_date_begin Asc"; // order
                            $sql .= $sql_year . $sql_group . $sql_order;
                            $fnc->debug_console('sql table owner: \n' . $sql);
                            $data_array = $fnc->get_db_array($sql);
                            if (!empty($data_array)) {
                                $this->gen_journal_tr($data_array);
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

    public function gen_report_department()
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row">
                <div class="col-12 col-md-8 col-lg-9">
                    <?php
                    // if ($data_status == 'delete') {
                    //     echo '<h5 class="card-title mt-2 h3 text-primary">journal Deleted</h5>';
                    // } else {
                    echo '<h5 class="card-title mt-2 h5 text-primary">journal Report by Department</h5>';
                    // }
                    ?>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">รายงานการตีพิมพ์ผลงานวิจัย/บทความทางวิชาการของหลักสูตร</h6>
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
                        $sql_year = "Select pro_fiscalyear As fyear From journal Where journal.pro_status = 'enable' Group By pro_fiscalyear Order By pro_fiscalyear Desc";
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
                echo '<h5 class="card-title mt-2 h5 text-primary">journal ' . $d . $y . '</h5>';
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
                        // $sql = "Select pro.* From journal pro Left Join co_worker cowo On cowo.cow_ref_id = pro.pro_id Where ";
                        $sql = "Select jou.* From journal jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                        // $sql .= "pro.pro_status LIKE 'enable'";
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
                            $this->gen_journal_tr($data_array);
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
                    echo '<h5 class="card-title mt-2 h5 text-primary">journal ' . $d . ' ' . $y . '</h5>';
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
                            $sql = "Select jou.* From journal jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
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
                                $this->gen_journal_tr($data_array);
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
        $fnc = new web;
        echo '<div class="bg-white p-3">';
        $data_array = $fnc->get_db_array("SELECT * FROM `journal` WHERE `jour_status` = 'enable'");
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
                echo '<td>' . '<a href="?p=journal&act=report&cat=apasample&jid=' . $row['jour_id'] . '">' . $row['jour_study'] . '</a>' . '</td>
            </tr>';
            }
        }

        if (isset($_GET['jid']) && $_GET['jid'] != '') {
            $jid = $_GET['jid'];
            $row = $fnc->get_db_row("SELECT * FROM `journal` WHERE `jour_id` = " . $jid);
            if (!empty($row)) {
                echo '<h4>data</h4>';
                echo '<pre style="font-size: 0.6em;">'  . print_r($row, true) . '</pre>';
                echo '<hr class="my-3">';
                echo '<strong>Sample: </strong>' . 'เกวลิน สมบูรณ์, ชลระดา หนันติ๊ และวรัทยา แจ้งกระจ่าง. (2564). Rice Price volatility of Exports Leaders in World Markets using TGARCH model. 2021 International Conference on Internet Finance and Digital Economy (ICIFDE 2021).' . '<br>';
                // ชื่อผู้เขียนบทความ
                $apa_owner = $row['jour_owner_firstname'] . ' ' . $row['jour_owner_lastname'];
                $cow = $fnc->get_db_array("SELECT * FROM `co_worker` WHERE `cow_ref_table` = 'journal' AND `cow_ref_id` = " . $jid);
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

