<?php include '../private/codeexecution.php';
$localestrings = locales(0);
navtop($localestrings);
$administrator = admincheck();
if($administrator === true){
advancedinvoiceinfo($_POST['invoiceid']);
}
?>
