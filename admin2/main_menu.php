<?php
// if (empty($_SESSION["admin"]) || !isset($_SESSION["admin"]) || !$_SESSION["admin"]["email"]) {
//     die('<meta http-equiv="refresh" content="0;url=../mjusso/signout.php">');
// } else {
//     $fnc->debug_console("Admin: \\n", $_SESSION["admin"]);
// }

$main_nav_items = [
    'home' => 'Home',
    'research' => 'Research',
    'setting' => 'Setting',
    'signout' => 'Sign-out'
];

function NavHeader($items)
{
    function navSocialIcons($fbIcon, $igIcon, $ttIcon)
    {
        // global $fbIcon, $igIcon, $ttIcon;
        return '<div class="flex flex-row gap-1 items-center lg:gap-4 xl:gap-5 transition-all ease-in-out duration-300">
        ' . $fbIcon . $igIcon . $ttIcon . '
    </div>';
    }

    function navMain($items, $dropdownIcon)
    {
        // global $dropdownId;
        function navItem($item)
        {
            $res = '<a href="' . $item["link"] . '" target="' . $item["target"] . '" class="navMainItem">' . $item["text"] . '</a>';
            return $res;
        }

        function navDropdown($item, $dropdownIcon)
        {
            $res = '<div class="relative">';
            $res .= '<button id="dropdown_' . $item["id"] . '_btn" class="flex gap-1 lg:gap-2.5 items-center cursor-pointer">
            <span class="navMainItem">' . $item["text"] . '</span>
            ' . $dropdownIcon . '
        </button>';
            $res .= '<div id="dropdown_' . $item["id"] . '" class="absolute z-50 left-0 w-auto hidden navDropdownHolder">';
            foreach ($item["children"] as $child) {
                $res .= '<a href="' . $child["link"] . '" target="' . $child["target"] . '" class="block px-4 pe-16 py-2 w-full text-nowrap text-gray-700 hover:bg-gray-200 rounded-md">' . $child["text"] . '</a>';
            }
            $res .= '</div>';
            $res .= '</div>';

            return $res;
        }

        $res = '<nav class="gap-6 items-center lg:gap-8 xl:gap-16 hidden md:flex transition-normal ease-in-out duration-300">';
        foreach ($items as $item) {
            if (isset($item["children"]) && count($item["children"]) > 0) {
                $res .= navDropdown($item, $dropdownIcon);
                // $res .= navItem($item);
            } else {
                $res .= navItem($item);
            }
        }
        $res .= '</nav>';

        return $res;
    }

    function navBurgerMenu($items, $menuIcon)
    {
        $res = '<div class="flex flex-row gap-x-4">
        ';
        $res .= '<form method="get" action="' . BASE_URL . 'search" class="">
            <input type="text" name="q" placeholder="';
        if (isset($_GET["q"]) && $_GET["q"] !== "") {
            $res .= $_GET["q"];
        } else {
            $res .= !isset($_SESSION["Language"]) || $_SESSION["Language"] === 'en' ? "search..." : "ค้นหา...";
        }
        $res .= '" class="px-4 py-1 md-py-2 border border-gray-300 rounded-md w-40 md:w-20 lg:w-30 xl:w-40" />
        <input type="hidden" name="range" value="1 ปีที่ผ่านมา" />
        </form>';

        $res .= '<div id="dropdown_mainMenu_btn" class="relative block md:hidden">' . $menuIcon . '
                    <div id="dropdown_mainMenu" class="absolute z-50 -right-4 hidden navDropdownHolder">
                ';

        // $res .= '<div class="block flex justify-center py-2 rounded-md">';
        // $res .= genLanguageButton(true);
        // $res .= '</div>';
        // $res .= genLanguageButton(true);
        foreach ($items as $item) {
            if (isset($item["children"]) && count($item["children"]) > 0) {
                $res .= '<div id="group_' . $item["id"] . '" class="mb-5">';
                $res .= '<p class="px-4 pe-16 py-2 text-nowrap text-gray-700 rounded-md font-bold">' . $item["text"] . '</p>';

                foreach ($item["children"] as $child) {
                    $res .= '<a href="' . $child["link"] . '" target="' . $child["target"] . '"class="block ps-8 px-4 pe-16 py-2 w-full text-nowrap text-gray-700 hover:bg-gray-200 rounded-md">' . $child["text"] . '</a>';
                }
                $res .= '</div>';
            } else {
                $res .= '<a href="' . $item["link"] . '" target="' . $item["target"] . '" class="block px-4 pe-16 py-2 text-nowrap text-gray-700 hover:bg-gray-200 rounded-md">' . $item["text"] . '</a>';
            }
        }

        $res .= '   </div>
                </div>';

        $res .= '</div>';

        return $res;
    }

    function navDropdownJs($items)
    {
        $dropdownId = ["mainMenu"];
        foreach ($items as $item) {
            if (isset($item["children"]) && count($item["children"]) > 0) {
                $dropdownId[] = $item["id"];
            }
        }

        $res = '<script>';
        // $res .= 'document.addEventListener("click", (e) => {
        //     let target = e.target;
        //     let dropdowns = document.querySelectorAll(".navDropdownHolder");
        //     dropdowns.forEach((dropdown) => {
        //         if (!dropdown.contains(target) && !dropdown.classList.contains("hidden")) {
        //             dropdown.classList.add("hidden");
        //         }
        //     });
        // });';
        foreach ($dropdownId as $id) {
            $res .= 'document.getElementById("dropdown_' . $id . '_btn").addEventListener("click", () => {
                ';
            foreach ($dropdownId as $element) {
                if ($id == $element) {
                    $res .= 'document.getElementById("dropdown_' . $element . '").classList.toggle("hidden");
                        ';
                } else {
                    $res .= 'document.getElementById("dropdown_' . $element . '").classList.add("hidden");
                        ';
                }
            }
            $res .= 'console.log("btn ' . $id . ':","click");
                ';
            $res .= '});
                ';
        }
        $res .= '</script>';
        return $res;
    }

    $menuIcon = '<i class="fa-solid fa-bars menuIcon"></i>';
    $dropdownIcon = '<i class="fa-solid fa-chevron-down"></i>';

    $navHeader = '<div class="flex flex-row justify-between items-center w-full border-b border-solid border-b-zinc-900/40 max-md:px-5 pb-3 max-md:pb-5 max-sm:px-4 navHeader">';
    // $navHeader .= navSocialIcons($fbIcon, $igIcon, $ttIcon);
    $navHeader .= navMain($items, $dropdownIcon);
    $navHeader .= navBurgerMenu($items, $menuIcon);
    // $navHeader .= navDropdownJs();
    $navHeader .= '</div>';
    $navHeader .= navDropdownJs($items);

    return $navHeader;
}

function NavExpand()
{
    ?>

    <div class="flex flex-row gap-x-2">
        <ul>
            <li>
                <a class="nav-link" aria-current="page" href="../admin/">home</a>
            </li>

        </ul>
        <ul>
            <li>research</li>
            <li><a class="dropdown-item" href="research.php?p=research" target="_blank">Data Manager</a></li>
            <li><a class="dropdown-item" href="research.php?p=research&act=append" target="_blank">Create New</a></li>
            <!-- <li><a class="dropdown-item" href="?p=research&act=viewdeleted" target="_blank">Deleted Data</a></li> -->
            <li><a class="dropdown-item" href="research.php?p=research&act=report">reports</a></li>
        </ul>
        <ul>
            <li>Proceeding</li>
            <li><a class="dropdown-item" href="proceeding.php?p=proceeding" target="_blank">Data Manager</a></li>
            <li><a class="dropdown-item" href="proceeding.php?p=proceeding&act=append" target="_blank">Create
                    New</a></li>
            <!-- <li><a class="dropdown-item" href="?p=proceeding&act=viewdeleted" target="_blank">Deleted Data</a></li> -->
            <li><a class="dropdown-item" href="proceeding.php?p=proceeding&act=report">reports</a></li>
        </ul>
        <ul>
            <li>Journal</li>
            <li><a class="dropdown-item" href="journal.php?p=journal" target="_blank">Data Manager</a></li>
            <li><a class="dropdown-item" href="journal.php?p=journal&act=append" target="_blank">Create
                    New</a></li>
            <!-- <li><a class="dropdown-item" href="?p=journal&act=viewdeleted" target="_blank">Deleted Data</a></li> -->
            <li><a class="dropdown-item" href="journal.php?p=journal&act=report">reports</a></li>
        </ul>
        <ul>
            <li>Project</li>
            <li><a class="dropdown-item" href="project.php?p=project" target="_blank">Data Manager</a></li>
            <li><a class="dropdown-item" href="project.php?p=project&act=append" target="_blank">Create
                    New</a></li>
            <!-- <li><a class="dropdown-item" href="?p=project&act=viewdeleted" target="_blank">Deleted Data</a></li> -->
            <li><a class="dropdown-item" href="project.php?p=project&act=report">reports</a></li>
        </ul>
        <ul>
            <li>admin</li>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "department") {
                    echo ' active" aria-current="page';
                } ?>" href="../admin/setting.php?p=department" target="_blank">หลักสูตร/สาขาวิชา</a></li>

                <!-- <li><a class="dropdown-item" href="#">Jobs Manager</a></li> -->
                <?PHP if ($_SESSION["admin"]["auth_lv"] >= 7) { ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <!-- <li><a class="dropdown-item" href="../admin/report.php">reports</a></li> -->
                    <li><a class="dropdown-item" href="../admin/datatable.php">data table</a></li>
                    <li><a class="dropdown-item" href="../admin/setting.php?p=chkFiscalYear">Fiscal Year</a></li>
                    <!-- <li><a class="dropdown-item" href="../admin/setting.php">Settings</a></li> -->
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=dev" target="_blank">9Developer</a></li>
                    <li><a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=admin" target="_blank">8Admin</a></li>
                    <li><a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=" target="_blank">7Officer</a></li>
                    <li><a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=dean" target="_blank">5Dean</a></li>
                    <li><a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=Katesuda" target="_blank">3Katesuda</a>
                    </li>
                    <li><a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=Prasert" target="_blank">3Prasert</a>
                    </li>
                    <li><a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=Kanitta" target="_blank">3Kanitta</a>
                    </li>
                <?PHP } ?>
            </ul>
        </ul>
        <!-- <a class="nav-link" href="#" onclick="signout_confirmation();">Sign-out</a> -->
        <a class="nav-link" href="../mjusso/signout.php" target="_blank">Sign-out</a>
    </div>


    <?php
}

// echo NavHeader($main_nav_items);
NavExpand();
?>