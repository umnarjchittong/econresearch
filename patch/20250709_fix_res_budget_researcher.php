<!DOCTYPE html>
<?php

include("../core.php");

function fix_research_with_co_worker($excute = false) {
    $fnc = new Web();

    $sql = "Select research.res_id, research.res_researchID, research.res_budget, research.res_ratio,
    research.res_budget_researcher, Sum(co_worker.cow_ratio) As Sum_cow_ratio From research Left Join
    co_worker On co_worker.cow_ref_id = research.res_id
    Where co_worker.cow_ref_table = 'research' Group By research.res_id, research.res_researchID, research.res_budget,
    research.res_ratio, research.res_budget_researcher";
    
    $research = $fnc->get_db_array($sql);
    $sql_update = "";
    foreach ($research as $row) {
        $res_budget_researcher = $row['res_budget'] * ($row['res_ratio'] + $row['Sum_cow_ratio']) / 100;
        $sql_update .= "UPDATE `research` SET `res_budget_researcher`='$res_budget_researcher' WHERE `res_id` = '" . htmlspecialchars($row['res_id']) . "'; ";
    }
    
    if ($excute) $fnc->sql_execute_multi($sql_update);
    return $sql_update;
}

function fix_research_withNo_co_worker($excute = false) {
    $fnc = new Web();

    $sql = "Select research.res_id, research.res_researchID, research.res_budget, research.res_ratio, research.res_budget_researcher
From research
Where research.res_budget_researcher Is Null Group By research.res_id, research.res_researchID, research.res_budget,
    research.res_ratio, research.res_budget_researcher";
    
    $research = $fnc->get_db_array($sql);
    $sql_update = "";
    foreach ($research as $row) {
        $res_budget_researcher = $row['res_budget'] * ($row['res_ratio']) / 100;
        $sql_update .= "UPDATE `research` SET `res_budget_researcher`='$res_budget_researcher' WHERE `res_id` = '" . htmlspecialchars($row['res_id']) . "'; ";
    }
    
    if ($excute) $fnc->sql_execute_multi($sql_update);
    return $sql_update;
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>20250709_fix_res_budget_researcher</title>
</head>

<body>
<?php // echo fix_research_with_co_worker(); ?>
<?php echo fix_research_withNo_co_worker(true); ?>
</body>

</html>