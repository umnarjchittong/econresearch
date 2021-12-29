<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    <?php
    if (isset($_GET["alert"]) && isset($_GET["title"]) && isset($_GET["msg"])) {
        // echo 'swal("' . $_GET["title"] . '", "' . $_GET["msg"] . '", "' . $_GET["alert"] . '");';
        if ($_GET["alert"] == "success") {
            $show_timer = "800";
        } else {
            $show_timer = "2000";
        }
        echo "swal.fire({
            position: 'center',
            icon: '" . $_GET["alert"] . "',
            title: '" . $_GET["title"] . "',
            text: '" . $_GET["msg"] . "',
            showConfirmButton: false,
            timer: " . $show_timer . "
          })";
    }
    ?>

    // function approve_confirmation(mid) {
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "คุณต้องการยืนยันแมทซ์แข่งขันนี้ !",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         confirmButtonText: 'ยันยัน !',
    //         cancelButtonColor: '#d33',
    //         cancelButtonText: 'ยกเลิก',
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             Swal.fire(
    //                 'Match Approved!',
    //                 'ยืนยันแมทซ์แข่งขันเรียบร้อย.',
    //                 'success'
    //             ).then(function() {
    //                 window.location = "../db_mgt.php?p=match&act=matchsanctionapprove&mid=" + mid
    //             });
    //         }
    //     })
    // }

    // function department_delete_confirmation(d_id) {
    //     Swal.fire({
    //         title: 'Are you sure ?',
    //         text: "คุณต้องการลบหลักสูตร/สาขาวิชา นี้ !",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#d33',
    //         confirmButtonText: 'ยันยัน !',
    //         cancelButtonColor: '#666',
    //         cancelButtonText: 'ยกเลิก',
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             Swal.fire(
    //                 'Delete Confirmed !',
    //                 'หลักสูตร/สาขาวิชา กำลังจะถูกลบ',
    //                 'success'
    //             ).then(function() {
    //                 window.location = "../db_mgt.php?p=setting&act=department_remove&d_id=" + d_id
    //             });
    //         }
    //     })
    // }

    function proceeding_delete_confirmation(pid) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบข้อมูล Proceeding นี้ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังดำเนินการลบ Proceeding.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=proceeding&act=delete&pid=" + pid
                });
            }
        })
    }
    
    function proceeding_attachment_delete_confirmation(pid, att_id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบไฟล์แนบนี้ออก !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังดำเนินการลบไฟล์แนบนี้.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=proceeding&act=deletefile&pid=" + pid + "&fid=" + att_id;
                });
            }
        })
    }
    
    function proceeding_coworker_delete_confirmation(pid, cowid) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการนำรายชื่อผู้ร่วมงานท่านนี้ออก !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังนำผู้ร่วมงานท่านนี้ออก.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=proceeding&act=coWorkerRemove&pid=" + pid + "&cowid=" + cowid;
                });
            }
        })
    }

    function data_delete_confirmation(page, id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบข้อมูล " + page + " นี้ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังดำเนินการลบ ' + page + '.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=" + page + "&act=datadelete&id=" + id;
                });
            }
        })
    }

    function journal_delete_confirmation(pid) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบข้อมูล journal นี้ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังดำเนินการลบ journal.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=journal&act=delete&pid=" + pid
                });
            }
        })
    }
    
    function attachment_delete_confirmation(page, id, att_id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบไฟล์แนบนี้ออก !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังดำเนินการลบไฟล์แนบนี้.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=" + page + "&act=deletefile&id=" + id + "&fid=" + att_id;
                });
            }
        })
    }
    
    function coworker_delete_confirmation(page, id, cowid) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการนำรายชื่อผู้ร่วมงานท่านนี้ออก !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังนำผู้ร่วมงานท่านนี้ออก.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=" + page + "&act=coWorkerRemove&id=" + id + "&cowid=" + cowid;
                });
            }
        })
    }
    
    function department_delete_confirmation(d_id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "คุณต้องการลบหลักสูตร/สาขาวิชา นี้ !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยันยัน !',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Delete Confirmed !',
                    'กำลังลบหลักสูตร/สาขาวิชา.',
                    'success'
                ).then(function() {
                    window.location = "../db_mgt.php?p=setting&act=department_remove&d_id=" + d_id
                });
            }
        })
    }
    
</script>