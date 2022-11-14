<?php
include "../private/codeexecution.php";
$localestrings = locales(0);
$con = dbaccess();
navtop($localestrings);
productsbyclass();
if(isset($_POST['newinvoice'])){
newinvoice();
$lastinvoice = mysqli_fetch_Array(mysqli_query($con,"SELECT max(invoiceid) from invoices where userid = (SELECT userid from users where username = '".$_SESSION['name']."');"))[0];
invoice($lastinvoice);
}else{
if(!isset($_POST['actualinvoiceid'])){
    if(!isset($_POST['changeinvoice'])){
        invoice('N/A');
    }else{
        invoice($_POST['changeinvoice']);
    }
}else{
    invoice($_POST['actualinvoiceid']);
}
}
?>
