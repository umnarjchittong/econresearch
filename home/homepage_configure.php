<?php

// * top banner
$top_banner = array(
    array(
        "bgColor" => "#592464",
        "h1Cls" => "display-4 font-italic",
        "h1Text" => "ขอต้อนรับ",
        "pCls" => "lead my-3",
        "pText" => "เข้าสู่เว็บไซต์งานบริการวิชาการและวิจัย คณะเศรษฐศาสตร์ มหาวิทยาลัยแม่โจ้",
        "pLinkCls" => "lead mb-0",
        "LinkCls" => "text-warning font-weight-bold",
        "LinkText" => "Continue reading...",
        "LinkUrl" => "#"
    )
);

// * carousel items
$carousels = array(
    array(
        "display" => " home,research", // home, research, proceeding, journal, project, researcher
        "type" => "text", // image
        "bgColor" => "#592464",
        "h1Cls" => "display-4 font-italic text-center",
        "h1Text" => "งานวิจัยโดดเด่น",
        "pCls" => "lead my-3 text-center",
        "pText" => "Multiple lines of text that form the lede, informing new readers quickly",
        "pLinkCls" => "lead mb-0 text-center",
        "LinkCls" => "ext-white font-weight-bold",
        "LinkText" => "Continue reading...",
        "LinkUrl" => "#",
        "imageUrl" => "https://cdn.vox-cdn.com/thumbor/h7BGgS-dE6lmXWC6S3eBJDLVUmw=/0x0:1600x800/1400x788/filters:focal(672x272:928x528):format(jpeg)/cdn.vox-cdn.com/uploads/chorus_image/image/55717463/google_ai_photography_street_view_2.0.jpg"
    ),
    array(
        "display" => "imdex, home, proceeding, journal", // home, research, proceeding, journal, project, researcher
        "type" => "text", // image
        "bgColor" => "#222460",
        "h1Cls" => "display-4 font-italic text-center",
        "h1Text" => "งานนำเสนอ และบทความล่าสุด",
        "pCls" => "lead my-3 text-center",
        "pText" => "Multiple lines of text that form the lede, informing new readers quickly",
        "pLinkCls" => "lead mb-0 text-center",
        "LinkCls" => "text-white font-weight-bold",
        "LinkText" => "Continue reading...",
        "LinkUrl" => "#"
    ),
    array(
        "display" => "index, home, project", // home, research, proceeding, journal, project, researcher
        "type" => "text", // image
        "bgColor" => "#892434",
        "h1Cls" => "display-4 font-italic text-center",
        "h1Text" => "โครงการบริการวิชาการที่ได้รับรางวัล",
        "pCls" => "lead my-3 text-center",
        "pText" => "Multiple lines of text that form the lede, informing new readers quickly",
        "pLinkCls" => "lead mb-0 text-center",
        "LinkCls" => "text-white font-weight-bold",
        "LinkText" => "Continue reading...",
        "LinkUrl" => "#"
    ),
    array(
        "display" => "index, home, researcher", // home, research, proceeding, journal, project, researcher
        "type" => "text", // image
        "bgColor" => "#598444",
        "h1Cls" => "display-4 font-italic text-center",
        "h1Text" => "นักวิจัยดีเด่น",
        "pCls" => "lead my-3 text-center",
        "pText" => "Multiple lines of text that form the lede, informing new readers quickly <br> <br> This is a wider card with supporting text below as a natural lead-in to additional content.",
        "pLinkCls" => "lead mb-0 text-center",
        "LinkCls" => "text-white font-weight-bold",
        "LinkText" => "Continue reading...",
        "LinkUrl" => "#"
    )
);

// * feature double items
$home_features = array(
    array(
        "type" => "text", // image
        "titleCls" => "d-inline-block mb-2 text-primary",
        "titleText" => "World",
        "h3Cls" => "mb-0",
        "h3Text" => "Featured post",
        "dateCls" => "mb-1 text-muted",
        "dateText" => "Nov 12",
        "pCls" => "card-text mb-auto",
        "pText" => "This is a wider card with supporting text below as a natural lead-in to additional content.",
        "LinkCls" => "stretched-link",
        "LinkText" => "Continue reading",
        "LinkUrl" => "#",
        "imageTag" => ''
    ),
    array(
        "type" => "image", // image
        "titleCls" => "d-inline-block mb-2 text-primary",
        "titleText" => "Research",
        "h3Cls" => "mb-0",
        "h3Text" => "Featured post",
        "dateCls" => "mb-1 text-muted",
        "dateText" => "Nov 12",
        "pCls" => "card-text mb-auto",
        "pText" => "This is a wider card with supporting text below as a natural lead-in to additional content.",
        "LinkCls" => "stretched-link",
        "LinkText" => "Continue reading",
        "LinkUrl" => "#",
        "imageTag" => '<svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" role="img" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>'
    )
);

// * About
$about_text = 'Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur
purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.';

// * Notices เอกสาร
$notice = array(
    array('ประกาศทุนสนับสนุนวิจัยคณะฯ 65','../download/Announcement researchECON 65.pdf'),
    array('ประกาศหลักเกณฑ์และวิธีการสนับสนุนงบประมาณเพื่อการพัฒนาบุคลากรคณะฯ 65', '../download/Announcement personnel development fund ECON 65.pdf')
);

// * Download เอกสาร
$download_list = array(
    array('แบบเสนอโครงการวิจัย (Research Project) คณะเศรษฐศาสตร์ ','../download/Research Project Form [65].pdf'),
    array('แบบฟอร์มรายงานความก้าวหน้าการดำเนินงานโครงการวิจัยฯ', '../download/Reserch project progress report form.pdf'),
    array('แบบฟอร์มการนำผลงานวิจัยหรืองานสร้างสรรค์ไปเผยแพร่และใช้ประโยชน์', '../download/Publishing research form.pdf')
);

// * Links Other
$Links_list = array(
    array('แบบฟอร์มงานวิจัย','#'),
    array('รายงานความก้าวหน้า', '#'),
    array('การนำไปใช้ประโยชน์', '#')
);

