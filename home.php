<?php

clearstatcache();
session_start();
if(!isset($_SESSION['uname'])){
    header('Location: login.php');
}
$_SESSION['kw'] = (int)date("W");
#$_SESSION['kw'] = 5;
$kw = $_SESSION['kw'];
$letzte_woche = ($kw - 1);
#echo $letzte_woche;

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

$query_kunden_list = "select kunde from kunden full outer join checks_$kw on kunden.kunde = checks_$kw.kund where checks_$kw.wer is null order by kunde asc";
$result_kunden_list = pg_query($dbconn, $query_kunden_list) or die ("Cannot execute query_kunden_list");
$query_to_delete_list = "select kund from checks_$kw where wer = '$uname'";
$result_to_delete_list = pg_query($dbconn, $query_to_delete_list) or die ("Cannot execute query_delete_to_list");

#QUERIES
$query_benny = "select kund from checks_$kw where wer = 'Benny' order by kund asc";
$query_gerhard = "select kund from checks_$kw where wer = 'Gerhard' order by kund asc";
#$query_gernot = "select kund from checks_$kw where wer = 'Gernot' order by kund asc";
$query_marko = "select kund from checks_$kw where wer = 'Marko' order by kund asc";
$query_michael = "select kund from checks_$kw where wer = 'Michael' order by kund asc";
$query_szabi = "select kund from checks_$kw where wer = 'Szabi' order by kund asc";
$query_nicht_gewahlt = "select kunde from kunden full outer join checks_$kw on kunden.kunde = checks_$kw.kund where checks_$kw.wer is null order by kunde asc";
$query_letzte_woche = "select kund from checks_$letzte_woche where wer = '$uname'";
#RESULTS
$result_benny = pg_query($dbconn, $query_benny) or die ("Cannot execute query_benny");
$result_gerhard = pg_query($dbconn, $query_gerhard) or die ("Cannot execute query_gerhard");
#$result_gernot = pg_query($dbconn, $query_gernot) or die ("Cannot execute query_gernot");
$result_marko = pg_query($dbconn, $query_marko) or die ("Cannot execute query_marko");
$result_michael = pg_query($dbconn, $query_michael) or die ("Cannot execute query_michael");
$result_szabi = pg_query($dbconn, $query_szabi) or die ("Cannot execute query_szabi");
$result_nicht_gewahlt = pg_query($dbconn, $query_nicht_gewahlt) or die ("Cannot execute query_nicht_gewahlt");
$result_letzte_woche = pg_query($dbconn, $query_letzte_woche) or die ("Cannot execute query_letzte_woche");

# FUNCTIONS=====================================================================
#
#function submitForm() {
#  var frm = document.getElementsByName('contact-form')[0];
#  frm.submit();
#  frm.reset();
#  return false;
#}

function insert_into(){
  $host = "localhost";
  $port = "5432";
  $dbname = "wochencheks";
  $user = "sami";
  $password = "Sami123";
  $connection = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
  $dbconn = pg_connect($connection) or die ("Can not connect to server\n");

  $uname = $_SESSION['uname'];
  $ins_kunde = $_POST['ins_kunde'];
  $kw = $_SESSION['kw'];

  $query_insert = "insert into checks_$kw (wer, kund) values ('$uname','$ins_kunde')";
  $query_check_doppelt = "select * from checks_$kw where kund = '$ins_kunde'";
  $query_richtig = "select * from kunden where kunde = '$ins_kunde'";
  $result_check_doppelt = pg_query($dbconn, $query_check_doppelt) or die ("Cannot execute query_check_doppelt");
  $result_check_richtig = pg_query($dbconn, $query_richtig) or die ("Cannot execute query_check_richtig");
  if (pg_num_rows($result_check_doppelt) !=1  ) {
      if (pg_num_rows($result_check_richtig) !=1  ) {
          echo "<h1>Wir haben den Kunde nicht</h1>";
        }
      else {
          pg_query($dbconn, $query_insert) or die ("Cannot execute query_insert");
      }
  }
  else {
      error_insert();
  }
  pg_close($dbconn);
  }

function delete(){
  $host = "localhost";
  $port = "5432";
  $dbname = "wochencheks";
  $user = "sami";
  $password = "Sami123";
  $connection = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
  $dbconn = pg_connect($connection) or die ("Can not connect to server\n");

  $del_kunde = $_POST['del_kunde'];
  $kw = $_SESSION['kw'];
  $query_delete = "delete from checks_$kw where kund = '$del_kunde'";
  pg_query($dbconn, $query_delete) or die ("Cannot execute query_delete");
  pg_close($dbconn);
  }

function truncate_checks(){
  $host = "localhost";
  $port = "5432";
  $dbname = "wochencheks";
  $user = "sami";
  $password = "Sami123";
  $connection = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
  $dbconn = pg_connect($connection) or die ("Can not connect to server\n");

  $kw = $_SESSION['kw'];
  $query_truncate = "truncate table checks_$kw";
  pg_query($dbconn, $query_truncate) or die ("Cannot execute query_truncate");
  pg_close($dbconn);
  }

function clear_meine(){
  $host = "localhost";
  $port = "5432";
  $dbname = "wochencheks";
  $user = "sami";
  $password = "Sami123";
  $connection = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
  $dbconn = pg_connect($connection) or die ("Can not connect to server\n");

  $uname = $_SESSION['uname'];
  $kw = $_SESSION['kw'];

  $query_clear_meine = "delete from checks_$kw where wer = '$uname'";
  pg_query($dbconn, $query_clear_meine) or die ("Cannot execute query_clear_meine");
  pg_close($dbconn);
  }


function error_insert() {
   echo "<h1>Das macht schon wer</h1>";
  }

#INSERT INTO TABLE CHECKS
if (isset($_POST['insert'])){
 insert_into();
}
#DELETE FROM TABLE CHECKS
if (isset($_POST['delete'])){
  delete();
}
#TRUNCATE TABLE CHECKS
if (isset($_POST['clear_all'])){
  truncate_checks();
}
#MEINE LISTE löschen
if (isset($_POST['clear_meine'])){
  clear_meine();
}
#LOGOUT
if(isset($_POST['logout'])){
    session_destroy();
    header('Location: logout.php');
}
?>
<!-- END OF PHP================================================================= -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
  <meta charset="utf-8">
   <title>Wochencheks</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <link rel="stylesheet" type="text/css" href="main.css">
 </head>
 <body>
 <!--HEADER=====================================================================  -->
  <div class="container-fluid">
   <div class="row1">
    <div class="col-md-4" style="text-align: left">
     <img src="logo.jpg" alt="logo">
     <?php echo $txt ?>
    </div>
    <div class="col-md-4" style="text-align: center">
     <h2>Wochenchecks <strong>KW<?php echo date("W"); ?></strong></h2>
    </div>
    <div class="col-md-4" style="text-align: right">
     <h4>Angemeldet als <strong><?php echo $uname; ?></strong></h4>
     <h4><?php echo date("d.m.Y  l"); ?></h4>
    </div>
   </div>
  </div>
  <br>
<!-- ========ASIDE============================================================== -->
  <div>
   <aside>
   <!-- INSERT -->
   <form method="post">
    <fieldset>
      <input list="ins_kunde" name="ins_kunde" placeholder="Kunde zu checken " class="insdel" required>
       <datalist id="ins_kunde">
        <?php
             while ($row = pg_fetch_assoc($result_kunden_list))
              {
                echo "<option value='" .$row['kunde']."'>";
              }
        ?>
      </datalist>
     <input type="submit" name="insert" value="I check em" class="button" required>
   </fieldset>
  </form>
  <br>
  <!-- DELETE -->
  <form method="post">
   <fieldset>
       <input type="text" list="del_kunde" name="del_kunde" placeholder="Kunde zu löschen " class="insdel" required>
         <datalist id="del_kunde">
          <?php
               while ($row1 = pg_fetch_assoc($query_to_delete_list))
                {
                  echo "<option value='" .$row1['kunde']."'>";
                }
          ?>
         </datalist>
       <input type="submit" name="delete" value="Den wü I ned" class="button" required>
     </fieldset>
   </form>
   <br>
   <br>
   <br>
   <br>

   <!-- BUTTONS -->
    <form method="post">
     <input type="submit" value="Refresh" class="button">
    </form>
    <br>
    <form method="post">
     <input type="submit" name=clear_meine value="Meine Liste löschen" class="button">
    </form>
    <br>
    <!-- <form method="post">
     <input type="submit" name=clear_all value="Clear All">
    </form>
    <br> -->
    <br><br><br>
    <form method="post">
     <input type="submit" name=logout value="Abmelden" class="button">
    </form>
   </aside>
  </div>
<!-- =====================BENNY================================================= -->
  <br>
   <div class="container">
    <div class="col-md-10">
     <div class="row">
      <fieldset>Benny:
        <?php
             while ($row = pg_fetch_assoc($result_benny))
              {
                echo $row['kund'].", ";
              }
         ?>
       </fieldset>
      </div>
<!-- ====================GERHARD================================================ -->
  <br>
   <div class="row">
     <fieldset>Gerhard:
       <?php
             while ($row = pg_fetch_assoc($result_gerhard))
              {
                echo $row['kund'].", ";
              }
        ?>
   </fieldset>
  </div>
<!-- ====================GERNOT================================================= -->
<!--
  <br>
    <div class="row">
      <fieldset>Gernot:
        <?php
              while ($row = pg_fetch_assoc($result_gernot))
                {
                  echo $row['kund'].", ";
                }
        ?>
     </fieldset>
    </div>
-->
<!-- ====================MARKO================================================== -->
  <br>
   <div class="row">
     <fieldset>Marko:
            <?php
                  while ($row = pg_fetch_assoc($result_marko))
                   {
                    echo $row['kund'].", ";
                   }
            ?>
        </fieldset>
       </div>
<!-- ====================MICHAEL================================================ -->
  <br>
   <div class="row">
     <fieldset>Michael:
       <?php
             while ($row = pg_fetch_assoc($result_michael))
              {
               echo $row['kund'].", ";
              }
        ?>
     </fieldset>
   </div>
<!-- ====================SZABI================================================== -->
  <br>
   <div class="row">
     <fieldset>Szabi:
       <?php
             while ($row = pg_fetch_assoc($result_szabi))
              {
                echo $row['kund'].", ";
              }
        ?>
     </fieldset>
    </div>
   </div>
  </div>
<!-- ====================NOCH NICHT GEWÄHLT===================================== -->
  <br>
    <div class="container">
     <div class="col-md-10">
      <fieldset><strong>Nicht gewält:</strong>
       <?php
             while ($row = pg_fetch_assoc($result_nicht_gewahlt))
              {
                echo $row['kunde'].", ";
              }
        ?>
       </fieldset>
     </div> 
    </div> 
<!-- ====================LETZTE WOCHE===================================== -->
  <br>
    <div class="container">
     <div class="col-md-10">
      <fieldset><strong>Letzte Woche gecheckt:</strong>
       <?php
             while ($row = pg_fetch_assoc($result_letzte_woche))
              {
                echo $row['kund'].", ";
              }
        ?>
       </fieldset>
     </div>
    </div>
  </body>
 </html>
