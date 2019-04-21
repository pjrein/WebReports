<?php
include_once('insert.php');
if(isset($_POST['submit']))
{
     $name = $_POST['name'];
     $email = $_POST['email'];
     $address = $_POST['address'];
     $adm= $_POST['admission'];
    mysqli_query("INSERT INTO students_recrod(name,email,address,joining_date) VALUES ('$name', '$email','$address', '$adm')");
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Sign up form</title>
</head>
<body>
<form action="" method="post" id="">
<label>Name</label><br>
<input type="text" name="name" id=""><br>

<label>Email</label><br>
<input type="text" name="email" id=""><br>

<label>Address</label><br>
<input type="text" name="address" id=""><br>

<label>Admission date</label><br>
<input type="text" name="admission" id=""><br><br>

<input type="submit" name="submit" id="">
</form>
</body>
</html>