<?php
include "../private/databaseopts.php"; 
include "../private/scheck.php";
include "../private/admincheck.php";
include "../private/admincheck.php";
$actualinvoiceid = $_POST['actualinvoiceid'];
$userid = mysqli_fetch_array(mysqli_Query($con,"SELECT userid from users where username = '".$_SESSION['name']."'"))[0];
if(empty($actualinvoiceid)){
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM actualinvoice;"))===0 && mysqli_num_rows(mysqli_query($con,"SELECT * FROM invoices;"))===0){
    $actualinvoiceid=1;
}elseif(mysqli_fetch_array(mysqli_query($con,"SELECT max(invoiceid) from actualinvoice;"))[0] > mysqli_fetch_array(mysqli_query($con,"SELECT max(invoiceid) from invoices;"))[0]){
    $oldinvoiceid = mysqli_fetch_array(mysqli_query($con,"SELECT max(invoiceid) from actualinvoice;"))[0];
    $actualinvoiceid = $oldinvoiceid + 1;
}else{
    $oldinvoiceid = mysqli_fetch_array(mysqli_query($con,"SELECT max(invoiceid) from invoices;"))[0];
    $actualinvoiceid = $oldinvoiceid + 1; 
};
}else{
    $actualinvoiceid = $_POST['actualinvoiceid'];
}
if(isset($_POST['productsel'])){
$prodid = $_POST['productsel'];
$price = mysqli_fetch_array(mysqli_query($con,"SELECT price from products where prodid = ".$prodid.";"))[0];

if(mysqli_num_rows(mysqli_Query($con,"SELECT prodid from actualinvoice where prodid = ".$prodid." and userid = ".$userid." AND invoiceid = ".$actualinvoiceid.";"))===0){
    $quantity=1;
    $checkout = $price * $quantity;
    $checkoutplusiva = $checkout+($checkout*(mysqli_fetch_array(mysqli_query($con,"SELECT ivaperc FROM ivas where ivaid = (SELECT ivaperclass from classlist where classid =(SELECT class from products where prodid =".$prodid."))")))[0]/100);
    mysqli_real_query($con,"INSERT INTO actualinvoice VALUES (".$userid.",".$actualinvoiceid.",".$prodid.",".$price.",".$quantity.",".$checkout.",".$checkoutplusiva.");");
}else{
    $oldquantity = mysqli_fetch_array(mysqli_query($con,"SELECT quantity from actualinvoice where userid = ".$userid." AND invoiceid = ".$actualinvoiceid." AND prodid = ".$prodid.";"))[0];
    $quantity = $oldquantity + 1;
    $checkout = $price * $quantity;
    $checkoutplusiva = $checkout+($checkout*(mysqli_fetch_array(mysqli_query($con,"SELECT ivaperc FROM ivas where ivaid = (SELECT ivaperclass from classlist where classid =(SELECT class from products where prodid =".$prodid."))")))[0]/100);
    mysqli_real_query($con,"UPDATE actualinvoice set quantity = ".$quantity.", checkout = ".$checkout.", checkoutplusiva = ".$checkoutplusiva." WHERE prodid = ".$prodid." and userid = ".$userid." and invoiceid = ".$actualinvoiceid.";");
}
   
}elseif(isset($_POST['delinv'])){
    mysqli_real_query($con,"DELETE FROM actualinvoice where userid = ".$userid." and invoiceid = ".$actualinvoiceid.";");
}elseif(isset($_POST['delprod'])){
    $oldquantity = mysqli_fetch_array(mysqli_query($con,"SELECT quantity from actualinvoice where prodid = ".$_POST['delprod']." and userid = ".$userid." and invoiceid = ".$actualinvoiceid.";"))[0];
    $quantity = $oldquantity - 1;
    $prodid = $_POST['delprod'];
    $price = mysqli_fetch_array(mysqli_query($con,"SELECT price from products where prodid = ".$prodid.";"))[0];
    $checkout = $price * $quantity;
    $checkoutplusiva = $checkout+($checkout*(mysqli_fetch_array(mysqli_query($con,"SELECT ivaperc FROM ivas where ivaid = (SELECT ivaperclass from classlist where classid =(SELECT class from products where prodid =".$prodid."))")))[0]/100);
    $totalprice = $checkout+($checkout*($ivavalue/100))-($checkout*($discountvalue/100));
    mysqli_real_query($con,"UPDATE actualinvoice set quantity = ".$quantity.", checkout = ".$checkout.", checkoutplusiva = ".$checkoutplusiva." WHERE prodid = ".$prodid." and userid = ".$userid." and invoiceid = ".$actualinvoiceid.";");
    if(mysqli_fetch_array(mysqli_query($con,"SELECT quantity from actualinvoice where prodid = ".$prodid." and invoiceid = ".$actualinvoiceid." and userid = ".$userid.";"))[0]<=0){
        mysqli_real_query($con,"DELETE FROM actualinvoice where prodid = ".$prodid." and invoiceid = ".$actualinvoiceid.";");
    }
};
header('Location:webmanager.php');
?>