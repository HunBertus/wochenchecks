<?php
session_start();
$_SESSION['uname'] = $_POST['uname'];
$host = "localhost";
$port = "5432";
$dbname = "wochencheks";
$user = "sami";
$password = "Sami123";
$connection = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$dbconn = pg_connect($connection) or die ("Can not connect to server\n");

#========Neue Table für die Woche================================================
$kw = (int)date("W");
$query_wochen = "select * from wochen where kw = '$kw'";
$result_wochen = pg_query($dbconn, $query_wochen) or die ("error query_wochen");
$query_neu_kwtable = "create table checks_$kw as table checks with no data";
$query_kw_insert = "insert into wochen (kw) values ($kw)";

if (pg_num_rows($result_wochen) !=1 ) {
    pg_query($dbconn, $query_neu_kwtable) or die ("error new table");
    pg_query($dbconn, $query_kw_insert) or die ("error kw insert");
}


$query_nicht_gewahlt = "select kunde from kunden full outer join checks_$kw on kunden.kunde = checks_$kw.kund where checks_$kw.wer is null order by kunde asc";
$result_nicht_gewahlt = pg_query($dbconn, $query_nicht_gewahlt) or die ("Cannot execute query_nicht_gewahlt");
$number = pg_num_rows($result_nicht_gewahlt);
if ($number !=0) {
  $text = "Noch $number Kunden zu machen";
}
else {
  $text = "Da is nix!";
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>LOGIN</title>
  <link rel="stylesheet"
   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="main.css">

</head>

<body>
<!-- HEADER===================================================================== -->
  <div class="container-fluid">
    <div class="col-md-4" style="text-align: left">
     <img src="logo.jpg" alt="logo">
    </div>
    <div class="col-md-4" style="text-align: center">
     <h2>Wochenchecks <strong>KW<?php echo date("W"); ?></strong></h2>
    </div>
    <div class="col-md-4" style="text-align: right">
     <h4>Heute ist: <?php echo date("d.m.Y  l"); ?></h4>
    </div>
  </div>
  <br>


 <div class="container">
   <div class="col-md-12">
     <form action="auth.php" method="POST">
       <fieldset>
        <Legend style="font-size: 22px"><?php echo $text ?> </Legend>
          <input list="username" name="uname" placeholder="Mein Name ist" class="insdel">
            <datalist id="username">
                <option value="Benny">
                <option value="Gerhard">
                <option value="Gernot">
                <option value="Marko">
                <option value="Michael">
                <option value="Szabi">
            </datalist>
           <input type="submit" value="Ich möchte Wochencheks machen!" class="button">
       </fieldset>
      </form>
     </div>
   </div>
</body>
</html>
