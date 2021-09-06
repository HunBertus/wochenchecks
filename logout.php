<?php
#include home.php;
clearstatcache();
session_start();
$_SESSION['kw'] = (int)date("W");
#$_SESSION['kw'] = 5;
$kw = $_SESSION['kw'];
$uname = $_SESSION['uname'];

$_SESSION['kunde'] = $_POST['kunde'];
$kunde = $_SESSION['kunde'];

$_SESSION['insert'] = $_POST['insert'];
$insert = $_SESSION['insert'];


$host = "localhost";
$port = "5432";
$dbname = "wochencheks";
$user = "sami";
$password = "Sami123";
$connection = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$dbconn = pg_connect($connection) or die ("Can not connect to server\n");

// $query_kunden_list = "select kunde from kunden order by kunde asc";
// $result_kunden_list = pg_query($dbconn, $query_kunden_list) or die ("Cannot execute query_kunden_list");
// $query_to_delete_list = "select kund from checks_$kw where wer = '$uname'";
// $result_to_delete_list = pg_query($dbconn, $query_to_delete_list) or die ("Cannot execute query_delete_to_list");

#QUERIES
$query_benny = "select kund from checks_$kw where wer = 'Benny' order by kund asc";
$query_gerhard = "select kund from checks_$kw where wer = 'Gerhard' order by kund asc";
#$query_gernot = "select kund from checks_$kw where wer = 'Gernot' order by kund asc";
$query_marko = "select kund from checks_$kw where wer = 'Marko' order by kund asc";
$query_michael = "select kund from checks_$kw where wer = 'Michael' order by kund asc";
$query_szabi = "select kund from checks_$kw where wer = 'Szabi' order by kund asc";
$query_nicht_gewahlt = "select kunde from kunden full outer join checks_$kw on kunden.kunde = checks_$kw.kund where checks_$kw.wer is null order by kunde asc";
#RESULTS
$result_benny = pg_query($dbconn, $query_benny) or die ("Cannot execute query_benny");
$result_gerhard = pg_query($dbconn, $query_gerhard) or die ("Cannot execute query_gerhard");
#$result_gernot = pg_query($dbconn, $query_gernot) or die ("Cannot execute query_gernot");
$result_marko = pg_query($dbconn, $query_marko) or die ("Cannot execute query_marko");
$result_michael = pg_query($dbconn, $query_michael) or die ("Cannot execute query_michael");
$result_szabi = pg_query($dbconn, $query_szabi) or die ("Cannot execute query_szabi");
$result_nicht_gewahlt = pg_query($dbconn, $query_nicht_gewahlt) or die ("Cannot execute query_nicht_gewahlt");

if(isset($_POST['login'])){

    header('Location: login.php');
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
  <meta charset="utf-8">
  <title>Logout</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="main.css">

 </head>
 <body>
<!-- HEADER===================================================================== -->
   <div class="container-fluid">
    <div class="row1">
     <div class="col-md-4" style="text-align: left">
      <img src="logo.jpg" alt="logo">
     </div>
     <div class="col-md-4" style="text-align: center">
      <h2>Abgemeldet</h2>
     </div>
     <div class="col-md-4" style="text-align: right">
      <h4>Heute ist: <?php echo date("d.m.Y  l"); ?></h4>
     </div>
    </div>
   </div>
   <br>
   <!-- <aside> -->
    <form method="post">
     <input type="submit" name="login" value="Wieder Einloggen" class="button2">
    </form>
  <!-- </aside> -->
<br>
<br>

  <table>
   <caption><strong>Zusammenfassung Wochencheck KW<?php echo date("W");  ?></strong></caption>
    <tr>
     <th class="" style="text-align: center">Checker</th>
     <th class="" style="text-align: center">Kunde</th>
    </tr>
    <tr>
     <td>Benny</td>
     <td><?php while ($row = pg_fetch_assoc($result_benny))
     {
       echo $row['kund'].", ";
     }  ?></td>
    </tr>
    <tr>
     <td>Gerhard</td>
     <td><?php while ($row = pg_fetch_assoc($result_gerhard))
     {
       echo $row['kund'].", ";
     } ?></td>
    </tr>
    <!--
    <tr>
     <td>Gernot</td>
     <td><?php while ($row = pg_fetch_assoc($result_gernot))
     {
       echo $row['kund'].", ";
     } ?></td>
    </tr>
    -->
    <tr>
     <td>Marko</td>
     <td><?php while ($row = pg_fetch_assoc($result_marko))
     {
       echo $row['kund'].", ";
     } ?></td>
    </tr>
    <tr>
     <td>Michael</td>
     <td><?php while ($row = pg_fetch_assoc($result_michael))
     {
       echo $row['kund'].", ";
     } ?></td>
    </tr>
    <tr>
     <td>Szabi</td>
     <td><?php while ($row = pg_fetch_assoc($result_szabi))
     {
       echo $row['kund'].", ";
     } ?></td>
    </tr>
   </table>
  </body>
</html>
