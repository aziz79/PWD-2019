 <?php
 $server = "localhost";
 $user   ="root";
 $password = "";
 $db_name = "belajar";
 mysql_connect($server,$user,$password);
 mysql_select_db($db_name)or die ("koneksi kedatabese gagal");
 
 ?>