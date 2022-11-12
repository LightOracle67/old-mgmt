<?php include '../private/codeexecution.php';
$localestrings = locales(0);
navtop($localestrings);
advancedinvoiceinfo($_POST['invoiceid']);
?>
