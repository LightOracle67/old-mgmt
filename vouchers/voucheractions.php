<?php
include '../private/codeexecution.php';
if ( isset( $_POST[ 'add' ] ) ) {
    addvoucher($_POST['vouchername'],$_POST['voucherdiscount'],$_POST['finaldate']);
} elseif ( isset( $_POST[ 'delete' ] ) ) {
    delvoucher($_POST[ 'delvoucherbyid' ],$_POST[ 'delvoucherbyname' ]);
} elseif ( isset( $_POST[ 'edit' ] ) ) {
    editvoucher($_POST['selvoucherbyid'],$_POST['newvouchername'],$_POST['newvoucherpercent'],$_POST['newcreationdate'],$_POST['newfinaldate']);
} else {
    header('Location:vouchers.php');
};
header( 'Location:vouchers.php' );
?>