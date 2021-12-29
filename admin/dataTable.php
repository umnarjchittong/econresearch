<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web;
?>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.0.2 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../css/style.css">

</head>

<body>

  <div class="container-fluid p-3">
    Table: 
    <a href="?tbl=proceeding" class="ms-2 text-primary">proceeding</a>
    <a href="?tbl=co_worker" class="ms-2 text-primary">co-worker</a>
    <a href="?tbl=attachment" class="ms-2 text-primary">attachment</a>
    <a href="?tbl=department" class="ms-2 text-primary">department</a>
  </div>

  <div class="container-fluid p-3">
    <?php
    if (isset($_GET['tbl']) && $_GET['tbl'] != '') {
      $table = $_GET['tbl'];
    } else {
      $table = "proceeding";
    }
    $sql = "SELECT * FROM " . $table;
    $data_array = $fnc->get_db_array($sql);
    // echo '<pre style="font-size: 0.6em;">' . print_r($data_array, true) . '</pre>';
    $col_name = $fnc->get_db_col_name($sql);
    // echo '<pre style="font-size: 0.6em;">' . print_r($col_name, true) . '</pre>';

    ?>

    <table id="myTable" class="table table-striped table-sm table-bordered table-hover table-inverse table-responsive">
      <thead class="thead-inverse bg-primary text-white">
        <?php
        foreach ($col_name as $col) {
          echo '<th>' . $col . '</th>';
        }
        ?>
      </thead>
      <tbody>
        <?php
        foreach ($data_array as $row) {
          echo '<tr>';
          foreach ($col_name as $col) {
            echo '<th>' . $row[$col] . '</th>';
          }
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
</body>

</html>