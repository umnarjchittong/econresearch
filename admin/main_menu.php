<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #592464;">
        <div class="container-fluid">
            <a class="navbar-brand" href="../admin/"><?= $fnc->system_name ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-print-none" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 text-capitalize justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../admin/">home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php if (isset($_GET['p']) && $_GET['p'] == 'research') {
                                                                echo ' active';
                                                            } ?>" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">research</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="research.php?p=research" target="_top">Data Manager</a></li>
                            <li><a class="dropdown-item" href="research.php?p=research&act=append" target="_top">Create New</a></li>
                            <!-- <li><a class="dropdown-item" href="?p=research&act=viewdeleted" target="_top">Deleted Data</a></li> -->
                            <li><a class="dropdown-item" href="research.php?p=research&act=report">reports</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php if (isset($_GET['p']) && $_GET['p'] == 'proceeding') {
                                                                echo ' active';
                                                            } ?>" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Proceeding</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="proceeding.php?p=proceeding" target="_top">Data Manager</a></li>
                            <li><a class="dropdown-item" href="proceeding.php?p=proceeding&act=append" target="_top">Create New</a></li>
                            <!-- <li><a class="dropdown-item" href="?p=proceeding&act=viewdeleted" target="_top">Deleted Data</a></li> -->
                            <li><a class="dropdown-item" href="proceeding.php?p=proceeding&act=report">reports</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle<?php if (isset($_GET['p']) && $_GET['p'] == 'journal') {
                                                                echo ' active';
                                                            } ?>" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Journal</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="journal.php?p=journal" target="_top">Data Manager</a></li>
                            <li><a class="dropdown-item" href="journal.php?p=journal&act=append" target="_top">Create New</a></li>
                            <!-- <li><a class="dropdown-item" href="?p=journal&act=viewdeleted" target="_top">Deleted Data</a></li> -->
                            <li><a class="dropdown-item" href="journal.php?p=journal&act=report">reports</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">SDG</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" aria-current="page" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">admin</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item<?php if (isset($_GET["p"]) && $_GET["p"] == "department") {
                                                            echo ' active" aria-current="page';
                                                        } ?>" href="../admin/setting.php?p=department" target="_top">หลักสูตร/สาขาวิชา</a></li>

                            <!-- <li><a class="dropdown-item" href="#">Jobs Manager</a></li> -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../admin/report.php">reports</a></li>
                            <li><a class="dropdown-item" href="../admin/datatable.php">data table</a></li>
                            <li><a class="dropdown-item" href="../admin/setting.php">Settings</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../sign/signout.php?p=signout">Sign-out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>