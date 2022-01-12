<!doctype html>
<?php

// * journal function
class journal_fnc
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

    public function gen_update_form($id)
    {
        $fnc = new web;
        $sql = "SELECT * FROM `journal` WHERE `jour_id` = " . $id;
        $row = $fnc->get_db_row($sql);
        $fnc->debug_console("data row: ", $row);
    ?>
        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">Updating: Journal</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">ปรับปรุงข้อมูล - การนำเสนอผลงานวิจัย/ผลงานทางวิชาการ</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
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
                                    // $fnc->debug_console("econ member", $econ_member[0]);
                                    // $econ_member = $fnc->econ_member_remove_exists("journal", $id, $econ_member);
                                    // $fnc->debug_console("econ member", $econ_member[0]);
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
                    <input type="hidden" name="jour_id" value="<?= $id ?>">
                    <div class="row px-3 gx-3 mt-3">
                        <div class="col-6 col-md-3 offset-md-6">
                            <button type="button" class="btn btn-outline-secondary w-100 py-2 text-uppercase" onclick="window.open('../admin/?p=journal&act=viewinfo&jid=<?= $id ?>','_top');">close</button>
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
                                    $sql .= " AND (jou.jour_owner_citizenid LIKE '" . $_GET["k"] . "' OR  (cowo.cow_citizenid Like '" . $_GET["k"] . "' AND cowo.cow_ref_table LIKE 'journal'))";
                                    break;
                                case "search":
                                    $sql .= " AND (jou.jour_owner_lastname LIKE '%" . $_GET["k"] . "%' Or jou.jour_owner_firstname LIKE '%" . $_GET["k"] . "%' Or ((cowo.cow_firstname LIKE '%" . $_GET["k"] . "%' Or cowo.cow_lastname LIKE '%" . $_GET["k"] . "%' Or jou.jour_study LIKE '%" . $_GET["k"] . "%') AND cowo.cow_ref_table LIKE 'journal'))";
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

    public function gen_data_owner($id, $row)
    {
        $fnc = new web;
        $sum_ratio = 0;
        // print_r($row);
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
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = 'journal' AND `cow_ref_id` = " . $id;
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
                                    $confirm_parameter = "'journal'," . $id . "," . $cow["cow_id"];
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

    public function gen_data_detail($id)
    {
        $fnc = new web;

        $sql = "SELECT * FROM journal WHERE jour_id = " . $id;
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
                $jour_tier = '../images/tier_icon_global_64.png';
            } else {
                $jour_tier = '../images/tier_icon_local_64.png';
            }
            $jour_tier = '<img src="' . $jour_tier . '" class="mb-1 me-2" width="16em">';
            ?>
            <div class="row mb-3">
                <label class="<?= $label_cls ?>">ระดับ</label>
                <label class="<?= $data_cls ?>"><?= $jour_tier . $row["jour_tier"] ?></label>
            </div>

            <div class="row mb-3">
                <label class="<?= $label_cls ?>">วันที่เผยแพร่</label>
                <label class="<?= $data_cls ?>"><?php
                                                $fnc->gen_date_full_thai($row["jour_date_avaliable"]);
                                                ?></label>
            </div>

            <?php if (!empty($row["department_name"])) { ?>
                <div class="row mb-3">
                    <label class="<?= $label_cls ?>">หลักสูตร/สาขาวิชา</label>
                    <label class="<?= $data_cls ?>"><?= $row["department_name"] ?></label>
                    <?php
                    $sql = "Select co_worker.department_name From co_worker Inner Join journal On co_worker.cow_ref_id = journal.jour_id Where journal.jour_id = " . $id . " And co_worker.cow_ref_table = '" . $_GET["p"] . "' And co_worker.cow_status = 'enable' And co_worker.department_name != '' Group By co_worker.department_name Order By co_worker.department_name";
                    $departments = $fnc->get_db_array($sql);
                    foreach ($departments as $dept) {
                        echo '<label class="col-11 offset-1 col-md-9 offset-md-3 col-form-label">' . $dept["department_name"] . '</label>';
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
                            $sql = "SELECT * FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'journal' AND `att_ref_id` = " . $id . " ORDER BY att_filename";
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
                                        $confirm_parameter = "'journal'," . $id . "," . $att["att_id"];
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
                            <label for="file_attach" class="form-label">ไฟล์แนบ (เลือกได้มากกว่า 1 ไฟล์)A</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="file_attach[]" id="file_attach" aria-describedby="inputGroupFileAddon04" aria-label="Upload" accept=".pdf, .jpg, .jpeg, .png" multiple required>
                                <button class="btn btn-outline-primary text-uppercase" type="submit" id="inputGroupFileAddon04">upload</button>
                            </div>
                        </div>
                        <input type="hidden" name="fst" value="uploadAttachments">
                        <input type="hidden" name="ref_table" value="journal">
                        <input type="hidden" name="ref_id" value="<?= $id ?>">
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

    <?php $this->gen_data_owner($id, $row);

        return $row;
    }

    public function gen_data_action_menu()
    {
    ?>
        <div class="col-auto align-self-top text-end fw-bold text-primary" style="font-size:0.75em;">
            <a href="?p=<?= $_GET["p"] ?>&act=viewinfo&jid=<?= $_GET["jid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase" style="font-size:1em;">view info</a>
            <a href="?p=<?= $_GET["p"] ?>&act=update&jid=<?= $_GET["jid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase ms-3" style="font-size:1em;">update info</a>
            <a href="?p=<?= $_GET["p"] ?>&act=coWorker&jid=<?= $_GET["jid"] ?>" target="_top" class="btn btn-outline-success btn-sm px-2 text-uppercase ms-3" style="font-size:1em;">co-worker/attachment</a>
        </div>
    <?php
    }

    public function gen_data_info($id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary">แสดงรายละเอียดของ Journal</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การตีพิมพ์ผลงานวิจัย/บทความทางวิชาการ</h6>
                </div>

                <?php $this->gen_data_action_menu(); ?>
            </div>


            <div class="card-body mt-3">

                <?php $row = $this->gen_data_detail($id); ?>

            </div>

            <div class="card-footer text-end">
                <div class="col mt-3">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 text-uppercase" onclick="window.open('?p=journal');">close</button>
                    <?php if ($row["jour_status"] == 'delete') { ?>
                        <button type="button" class="btn btn-outline-success px-4 py-2 text-uppercase" onclick="window.open('../db_mgt.php?p=journal&act=restore&pid=<?= $id ?>','_top');">restore</button>
                    <?php } else {
                        $confirm_parameter = "'journal'," . $id; ?>
                        <!-- <button type="button" class="btn btn-outline-danger px-4 py-2 text-uppercase" onclick="data_delete_confirmation(<? //= 'journal,' . $id 
                                                                                                                                                ?>);">delete</button> -->
                        <button type="button" class="btn btn-outline-danger px-4 py-2 text-uppercase" onclick="data_delete_confirmation(<?= $confirm_parameter ?>);">delete</button>
                        <!-- <button type="button" class="btn btn-primary px-4 py-2 text-uppercase">Action</button> -->
                    <?php } ?>

                </div>
            </div>

            </form>
        </div>

    <?php
    }

    public function gen_journal_coworker($id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">journal Co-Worker</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การตีพิมพ์ผลงานวิจัย/บทความทางวิชาการ - ผู้ร่วมงาน</h6>
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
            $econ_member = $fnc->econ_member_remove_exists("journal", $id, $MJU_API->GetAPI_array($api_url));
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
                                    <label for="jour_owner_citizenid" class="form-label text-capitalize">Register a new co-worker <span class="lbl_required">*</span></label>
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

    public function gen_journal_attachment($id)
    {
        $fnc = new web;
    ?>

        <div class="card p-0 p-md-3 box_shadow">
            <div class="card-header bg-light bg-gradient row justify-content-between">
                <div class="col-auto">
                    <h5 class="card-title mt-2 h3 text-primary text-capitalize">journal attachment</h5>
                    <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.8em;">การตีพิมพ์ผลงานวิจัย/บทความทางวิชาการ - ไฟล์แนบ</h6>
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
                        <input type="hidden" name="ref_table" value="journal">
                        <input type="hidden" name="ref_id" value="<?= $id ?>">
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
                        $sql_year = "Select jour_fiscalyear As fyear From journal Where journal.jour_status = 'enable' Group By jour_fiscalyear Order By jour_fiscalyear Desc";
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
                            $sql = "Select jour.* From journal jour Left Join co_worker cowo On cowo.cow_ref_id = jour.jour_id Where ";
                            $sql .= "jour.jour_status LIKE 'enable'";
                            if (isset($_GET["k"]) && $_GET["k"] != "") {
                                $sql .= " AND (jour.jour_owner_citizenid LIKE '" . $_GET["k"] . "' OR cowo.cow_citizenid Like '" . $_GET["k"] . "')";
                            }
                            if (isset($_GET['fyear']) && $_GET['fyear'] != "") {
                                $sql_year = " AND jour.jour_fiscalyear >= '" . ($_GET["fyear"] - 5) . "' AND jour.jour_fiscalyear < '" . ($_GET["fyear"]) . "'";
                            } else {
                                $sql_year = "";
                            }
                            $sql_group = " Group By jour.jour_date_begin, jour.jour_id";
                            $sql_order = " ORDER BY jour.jour_date_avaliable Asc"; // order
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
                        $sql_year = "Select jour_fiscalyear As fyear From journal Where journal.jour_status = 'enable' Group By jour_fiscalyear Order By jour_fiscalyear Desc";
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
                        // $sql = "Select pro.* From journal pro Left Join co_worker cowo On cowo.cow_ref_id = pro.jour_id Where ";
                        $sql = "Select jou.* From journal jou Left Join co_worker cowo On cowo.cow_ref_id = jou.jour_id Where ";
                        // $sql .= "pro.jour_status LIKE 'enable'";
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
