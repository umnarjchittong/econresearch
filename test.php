<!DOCTYPE html>
<html lang="en">
<?php
require('vendor/autoload.php');
require('core.php');
$fnc = new web();
$MJU_API = new MJU_API();
// require('core_fnc.php');
// $core_fnc = new general_fnc();
require('admin/core_fnc_activity.php');
$activity_fnc = new activity_fnc();

Select
    citizenid,
    prename,
    firstname,
    lastname
From
    v_proceeding_report2
Where
    citizenid != '' And
    pro_status = 'enable'
Group By
    citizenid,
    prename,
    firstname,
    lastname
Order By
    firstname



?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Site</title>
  <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">

  <style>
        /* css ส่วนสำหรับการแบ่งหน้าข้อมูลสำหรับการพิมพ์ */


        @media print {
            .page-break {
                /* display: block;
                height: 1px; */
                page-break-before: always;
            }

            .page-break-no {
                /* display: block;
                height: 1px; */
                page-break-after: avoid;
            }
        }
    </style>

</head>

<body>
  <h1>Hello-Bootstrap</h1>

  <div class="container mb-3">
    <h2>Activate Modal with JavaScript</h2>

    <a hre="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#PhotoModal" data-bs-title_text="@mdo" data-bs-src="images/tier_icon_global_64.png">Open modal for @mdo</a>
    <a hre="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#PhotoModal" data-bs-title_text="@fat" data-bs-src="images/tier_icon_global_128.png">Open modal for @fat</a>
    <a hre="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#PhotoModal" data-bs-title_text="@getbootstrap" data-bs-src="images/tier_icon_global_360.png">Open modal for @getbootstrap</a>

    <div class="modal fade" id="PhotoModal" tabindex="-1" aria-labelledby="PhotoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="PhotoModalLabel">New message</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3 text-center">
              <img id="modalImage" src="images/tier_icon_local_64.png" class="img-fluid" alt="123">
            </div>
          </div>
          <div class="modal-footer d-none">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4"><button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button></div>
                <div class="col-auto ms-auto"><button type="button" class="btn btn-sm btn-primary">Send message</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      var PhotoModal = document.getElementById('PhotoModal')
      PhotoModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var title_text = button.getAttribute('data-bs-title_text');
        var image_src = button.getAttribute('data-bs-src');
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = PhotoModal.querySelector('.modal-title')
        // var modalBodyInput = PhotoModal.querySelector('.modal-body input')

        modalTitle.textContent = 'New message to ' + title_text;
        // modalBodyInput.value = title_text
        document.getElementById("modalImage").src = image_src;
      })
    </script>

  </div>

  <div class="page-break" style"page-break-before: always;">page break before</div>
  <div class="h2">HELLO</div>

  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>