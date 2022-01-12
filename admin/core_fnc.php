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
