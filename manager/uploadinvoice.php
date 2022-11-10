<?php
include '../private/codeexecution.php';
$localestrings = locales(0);
uploadinvoice($_POST['actualinvoiceid'],$_POST['timestamp'],$_POST['vouchervalue'],$localestrings['userid']);
?>