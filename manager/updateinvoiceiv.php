<?php
include "../private/codeexecution.php";
if ( !isset( $_POST[ 'actualinvoiceid' ] ) || $_POST[ 'actualinvoiceid' ] === '' ) {
    header( 'Location: webmanager.php' );
    exit();
} else {
$localestrings = locales(0);
navtop($localestrings);
printinginvoice($_POST['timestamp'],$_POST['actualinvoiceid'],$_POST['vouchervalue']);
};
?>