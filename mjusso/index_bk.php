<!DOCTYPE html>
<html lang="en">
<?php
// แก้ไข Client ID ตามที่ได้รับจากการลงทะเบียนไว้
$clientId = '63845c675e46447d8c91cfdf7f1c81e8';
// นำเข้าชุดคำสั่งจากไฟล์ mjusso.php
include_once('mjusso.php');
// หากเข้าระบบสำเร็จข้อมูลจะถูกส่งไปที่ตัวแปร userInfo
// $userInfo;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MJU SSO TEST</title>
    <style>
        body {
            background-color: #2C3E4C;
            font-family: 'Prompt', sans-serif;
            color: antiquewhite;
        }

        .container {
            width: 500px;
            margin: 50px auto;
            padding: 16px;
            border-radius: 8px;
            border: 2px solid #FDAB9F;
            text-align: center;
        }

        a {
            color: #52B2BF;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        a::before {
            content: "[ ";
        }

        a::after {
            content: " ]";
        }

        a:hover {
            text-decoration: underline;
        }

        h1 {
            color: burlywood;
            letter-spacing: 4px;
        }

        .result {
            word-break: break-all;
            text-wrap: word-break;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="mju_sso_php.zip" target="_blank">dowload this code</a>
        <h1>MJU SSO TESTING</h1>
        <?php if ($ac) { ?>
            <div style="margin-bottom: 25px">
                <p><?php echo 'Client ID: ' . $clientId; ?></p>
                <p><?php echo 'Code: ' . $ac ?></p>

            </div>
            <div class="result">
                <?php
                // $userInfo = 'Array ( [0] => citizenID [1] => name [2] => pictureUrl [3] => humanID [4] => personID [5] => studentID [6] => studentCode [7] => nationID [8] => titleName [9] => firstName [10] => lastName [11] => titleNameEn [12] => firstNameEn [13] => lastNameEn [14] => position [15] => e_mail [16] => personnelPhoto [17] => sectionID [18] => section [19] => divisionID [20] => division [21] => facultyID [22] => faculty [23] => courseID [24] => course )';
                if (isset($userInfo) && $userInfo["citizenID"] !== "") {
                    echo '<ol style="text-align:left">';
                    foreach (array_keys($userInfo) as $key) {
                        echo "<li>$key</li>";
                    }
                    echo '</ol>';
                    echo '<div id="userInfo" style="display:none">';
                    print_r($userInfo);
                    echo '</div>';
                    echo '<br /><br />';
                    echo '<a href="#" onClick="' . "document.getElementById('userInfo').style.display='block'" . '">Show userInfo</a>';

                    echo '<br /><br />';
                    echo '<a href="https://sso.mju.ac.th/signout.aspx?cid=' . $clientId . '" target="_top">Signout</a>';
                } else {
                    echo "!! This Code is expired.";
                    echo '<br /><br />';
                    echo '<a href="https://sso.mju.ac.th/signin.aspx?cid=' . $clientId . '" target="_top">refresh Token</a>';
                }
                ?>

            </div>
        <?php } else { ?>
            <div>
                <?php
                if ($userInfo) {
                    echo '<a href="https://sso.mju.ac.th/signout.aspx?cid=' . $clientId . '" target="_top">Logout</a>';
                } else {
                    echo '<a href="https://sso.mju.ac.th/signin.aspx?cid=' . $clientId . '" target="_top">Login</a>';
                }
                ?>
            </div>
        <?php } ?>
    </div>
</body>

</html>