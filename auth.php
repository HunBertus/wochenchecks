<?php
session_start();
$_SESSION['uname'] = $_POST['uname'];
$uname = $_SESSION['uname'];

$host = "localhost";
$port = "5432";
$dbname = "wochencheks";
$user = "sami";
$password = "Sami123";
$connection = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$dbconn = pg_connect($connection) or die ("Can not connect to server\n");

$query = "select * from users where username = '$uname'";
$result = pg_query($dbconn, $query) or die ("Cannot execute query");

# Checking user identity
if(pg_num_rows($result) != 1) {
    falsch_login();
}
else {
    header('Location: home.php');
}

pg_close($dbconn);
function falsch_login(){
  echo "<h3>Du bist kein Teccons Mitarbeiter... Probier es nochmal</h3>";
}
if (isset($_POST['login'])){
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="post">
      <input type="submit" name="login" value="Nochmal Probieren">
    </form>
  </body>
</html>
