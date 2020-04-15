<!DOCTYPE html>
<html>
<head>
	<?php include 'header.php';?>
</head>
<body>
	<a href="index.php"><button type="button">HOME</button></a>
	<div class="center-element-page">
		<form action="get_patients.php" method="post">
			Patient's name:<br>
			<input type="text" name="patient_name">
			<input type="submit" name="search" value="search">
		</form>
	</div>

</body>
</html>