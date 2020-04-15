<?php
include 'connection.php';
echo '<a href="index.php"><button type="button">HOME</button></a>';
echo "<p>snum: ";
echo $_REQUEST['snum'];
echo "</p><p>snumOld: ";
echo $_REQUEST['snumOld'];
echo "</p><p>startOld: ";
echo $_REQUEST['startOld'];
echo "</p><p>manuf: ";
echo $_REQUEST['manuf'];
echo "</p><p>start: ";
echo $_REQUEST['start'];
echo "</p><p>endt: ";
echo $_REQUEST['endt'];
echo "</p><p>patient id: ";
echo $_REQUEST['patient'];
echo "</p>";

echo('Current date: ' . date("Y-m-d H:i:s"));

// .= is used to concatenate strings
/*$sql1 = "start transaction;";*/

$sql2 = "INSERT INTO Period VALUES('";
$sql2 .= $_REQUEST['startOld'];
$sql2 .= "', '";
$sql2 .= date('Y-m-d H:i:s', strtotime('+2 seconds'));
$sql2 .= "');";

$sql3 = "UPDATE Wears SET endt = '";
$sql3 .= date('Y-m-d H:i:s', strtotime('+2 seconds'));
$sql3 .= "' WHERE snum = '";
$sql3 .= $_REQUEST['snumOld'];
$sql3 .= "' AND manuf = '";
$sql3 .= $_REQUEST['manuf'];
$sql3 .= "' AND start = '";
$sql3 .= $_REQUEST['startOld'];
$sql3 .= "';";

$sql4 = "INSERT INTO Period VALUES('";
$sql4 .= date('Y-m-d H:i:s', strtotime('+3 seconds'));
$sql4 .= "', ";
$sql4 .= "'2200-01-01 00:00:00');";

$sql5 = "INSERT INTO Wears VALUES('";
$sql5 .= date('Y-m-d H:i:s', strtotime('+3 seconds'));
$sql5 .= "', ";
$sql5 .= "'2200-01-01 00:00:00'";
$sql5 .= ", '";
$sql5 .= $_REQUEST['patient'];
$sql5 .= "', '";
$sql5 .= $_REQUEST['snum'];
$sql5 .= "', '";
$sql5 .= $_REQUEST['manuf'];
$sql5 .= "');";

/*$sql6 = "commit;";*/

/*echo '<p>' . $sql1 . '</p>';*/
echo '<p>' . $sql2 . '</p>';
echo '<p>' . $sql3 . '</p>';
echo '<p>' . $sql4 . '</p>';
echo '<p>' . $sql5 . '</p>';
/*echo '<p>' . $sql6 . '</p>';*/

/*$result = $connection->query($sql1);*/
$result = $connection->query($sql2);
$result = $connection->query($sql3);
$result = $connection->query($sql4);
$result = $connection->query($sql5);
/*$result = $connection->query($sql6);*/
if ($result == FALSE)
{
$info = $connection->errorInfo();
echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
exit();
}
else{
	echo "<p><strong>Device successfully changed</strong></p>";
}

//close connection
$connection = NULL;

?>