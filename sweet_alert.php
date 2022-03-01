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

    function signout_confirmation() {
        Swal.fire({
            title: 'ออกจากระบบ ?',
            text: "คุณต้องการออกจากระบบตอนนี้.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ออกจากระบบ',
            cancelButtonColor: '#666',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "../sign/?p=signout"
            }
        });
    }

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

    function image_popup(imgSrc) {
        imgtitle = '';
        imgCaption = '';
        imgAlt = '';
        Swal.fire({
            // title: imgtitle,
            // text: imgCaption,
            imageUrl: imgSrc,
            imageWidth: '100%',
            imageHeight: '100%',
            imageAlt: imgAlt,
            padding: '1rem',
            showConfirmButton: true,
        });
    }

    // * https://www.w3schools.com/bootstrap/bootstrap_ref_js_modal.asp

//     Link HTML

// <a href="#my_modal" data-toggle="modal" data-book-id="my_id_value">Open Modal</a>
// Modal JavaScript

// //triggered when modal is about to be shown
// $('#my_modal').on('show.bs.modal', function(e) {

//     //get data-id attribute of the clicked element
//     var bookId = $(e.relatedTarget).data('book-id');

//     //populate the textbox
//     $(e.currentTarget).find('input[name="bookId"]').val(bookId);
// });
</script>