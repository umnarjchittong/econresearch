<?php

// function for components

function genMemberInfoCard()
{
    $fnc = new CommonFnc;
    $res = '<div class="member-info-card">
    <div>
    <img src="' . $_SESSION["admin"]["personnelPhoto"] . '"
    alt="' . $_SESSION["admin"]["titleNameEn"] . " " . $_SESSION["admin"]["firstName_en"] . '">
    </div>
            <div class="col-auto pt-3" style="font-size: 1rem;">
                <p>
                    ' . $_SESSION["admin"]["titlePosition"] . " " . $_SESSION["admin"]["firstName"] . "  " . $_SESSION["admin"]["lastName"] . '
                </p>
                <p>
                    ' . $_SESSION["admin"]["titleNameEn"] . " " . $_SESSION["admin"]["firstName_en"] . "  " . $_SESSION["admin"]["lastName_en"] . '
                <p>
                <p>
                    ' . "ระดับสิทธิ์: " . $fnc->system_auth_lv[$_SESSION["admin"]["auth_lv"]] . '
                </p>
            </div>
        </div>';
    return $res;
}

function navMain() {
    $res = '<nav class="navbar navbar-expand-lg navbar-dark items-center h-full">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>';
    return $res;
}

function navHeader() {
    if (!file_exists(ROOT_PATH . 'src/includes/app.php'))
        die("Sorry, cannot load core engine or not found. Please check app.php line 18-19.");
    require_once(ROOT_PATH . 'src/includes/app.php');
    $json = new JsonConfig();
    $items = $json->jsonReader($_SESSION["Language"] === 'en' ? 'navTop_en' : 'navTop');

}