<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-2 pt-1">
                <a class="link-secondary" href="https://econ.mju.ac.th/academicservice/home/"><img src="../images/econ_logo.png" class="img-responsive w-100" style="min-width: 80px; max-width: 130px;"></a>
            </div>
            <div class="col-8 text-center">
                <a class="blog-header-logo text-dark fw-bold" href="#" style="text-decoration: none; letter-spacing: 0.15em; font-size: clamp(1.75em, 5vw, 2.3em);"><span style="color: #9d3fb0;">ECON</span> RESEARCH<p class="h5 d-none d-md-block" style="text-decoration: none; letter-spacing: 0em;">งานบริการวิชาการและวิจัย คณะเศรษฐศาสตร์</p></a>
            </div>
            <div class="col-2 d-flex justify-content-end align-items-center">
                <!-- <a class="link-secondary d-none" href="#" aria-label="Search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24">
                            <title>Search</title>
                            <circle cx="10.5" cy="10.5" r="7.5" />
                            <path d="M21 21l-5.2-5.2" />
                        </svg>
                    </a> -->
                <a class="btn btn-sm btn-outline-secondary" href="../sign/">Sign in</a>
            </div>
        </div>
    </header>
<?php $fnc->debug_console("file name: " . $fnc->get_url_filename()); ?>
    <div class="nav-scroller py-1 mt-1 mb-3 d-md-block d-none">
        <nav class="nav d-flex justify-content-between fw-bold text-uppercase">
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="../home/">home<p class="top-2menu d-none d-lg-block">หน้าแรก</p></a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "research.php") { echo ' top-menu-active'; } ?>" href="../home/research.php">research<p class="top-2menu d-none d-lg-block">งานวิจัย</p></a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "proceeding.php") { echo ' top-menu-active'; } ?>" href="../home/proceeding.php">proceeding<p class="top-2menu d-none d-lg-block">งานนำเสนอ</p></a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "journal.php") { echo ' top-menu-active'; } ?>" href="../home/journal.php">journal<p class="top-2menu d-none d-lg-block">ผลงานตีพิมพ์</p></a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "project.php") { echo ' top-menu-active'; } ?>" href="../home/project.php">project<p class="top-2menu d-none d-lg-block">บริการวิชาการ</p></a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "researcher.php") { echo ' top-menu-active'; } ?>" href="../home/researcher.php">researcher<p class="top-2menu d-none d-lg-block">ทำเนียบนักวิจัย</p></a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "contact.php") { echo ' top-menu-active'; } ?>" href="../home/contact.php">contact us<p class="top-2menu d-none d-lg-block">ติดต่อเรา</p></a>
        </nav>
    </div>
    <div class="nav py-1 mt-1 mb-0 d-block d-md-none" style="font-size: 1em;">
        <nav class="nav d-flex justify-content-between fw-bold text-capitalize">
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="../home/">home</a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "research.php") { echo ' top-menu-active'; } ?>" href="../home/research.php">research</a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "proceeding.php") { echo ' top-menu-active'; } ?>" href="../home/proceeding.php">proceeding</a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "journal.php") { echo ' top-menu-active'; } ?>" href="../home/journal.php">journal</a>
            <!-- <a class="link-secondary top-menu<?//php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="#">project</a>
            <a class="link-secondary top-menu<?//php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="#">researcher</a>
            <a class="link-secondary top-menu<?//php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="#">contact us</a> -->
        </nav>
    </div>
    <div class="nav py-1 mt-0 mb-3 d-block d-md-none col-10 mx-auto" style="font-size: 1em;">
        <nav class="nav d-flex justify-content-between fw-bold text-capitalize">
            <!-- <a class="link-secondary top-menu<?//php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="../home/">home2</a> -->
            <!-- <a class="link-secondary top-menu<?//php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="../home/research.php">research</a>
            <a class="link-secondary top-menu<?//php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="#">proceeding</a>
            <a class="link-secondary top-menu<?//php if ($fnc->get_url_filename() == "index.php") { echo ' top-menu-active'; } ?>" href="#">journal</a> -->
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "project.php") { echo ' top-menu-active'; } ?>" href="../home/project.php">project</a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "researcher.php") { echo ' top-menu-active'; } ?>" href="../home/researcher.php">researcher</a>
            <a class="link-secondary top-menu<?php if ($fnc->get_url_filename() == "contact.php") { echo ' top-menu-active'; } ?>" href="../home/contact.php">contact us</a>
        </nav>
    </div>
    <!-- <div class="nav-scroller py-1 mt-0 mb-3 d-block d-lg-none">
        <nav class="nav d-flex justify-content-between fw-bold text-uppercase">
            
        </nav>
    </div> -->
   
</div>