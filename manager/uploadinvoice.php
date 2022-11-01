<?php
include '../private/databaseopts.php';
$invoiceid = $_POST['actualinvoiceid'];
$discountid = $_POST['vouchervalue'];
$finalprice = $_POST['finalprice'];
if(empty($discountid)){
    $discountid = "NULL";
}else{
    $discountid = $_POST['vouchervalue'];
}
$userid = mysqli_fetch_array(mysqli_query($con,"SELECT userid from users where username = '".$_SESSION['name']."';"))[0];
mysqli_real_query($con,"INSERT INTO detailinvoice (SELECT distinct * from actualinvoice where userid = ".$userid." and invoiceid = ".$invoiceid.");");   
mysqli_real_query($con,"INSERT INTO invoices (invoiceid,discountid,totalprice) VALUES (".$invoiceid.",".$discountid.",".$finalprice.")");
mysqli_real_query($con,"DELETE from actualinvoice where userid = ".$userid." and invoiceid = ".$invoiceid.";");
header('Location:webmanager.php');
?>