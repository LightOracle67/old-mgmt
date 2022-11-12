<?php include '../private/codeexecution.php';
if ( isset( $_POST[ 'invoiceid' ] ) ) {
    $action = searchinvoicebyid($_POST['invoiceid']);
} elseif ( isset( $_POST[ 'selinvoicebyexactdate' ] ) ) {
    $action = searchinvoicebydate($_POST['selinvoicebydate']);
}elseif ( isset( $_POST[ 'selinvoicebydaterange' ] ) ) {
    $action = searchinvoicebyrange($_POST['mindaterange'],$_POST['maxdaterange']);
} elseif ( isset( $_POST[ 'selinvoicebyvoucher' ] ) ) {
    $action = searchinvoicebydiscountvoucher($_POST['vouchervalue']);
} else {
header('Location:invoicesearch.php');
}
$localestrings = locales(0);
navtop($localestrings);
search($action);
?>