<?php
include '../private/databaseopts.php';



$administrator = 0;
if ( $_SESSION[ 'name' ] === mysqli_fetch_array( mysqli_query( $con, 'SELECT username from users where username = "administrator"' ) )[ 0 ] ) {
    $administrator = true;
} else {
    $administrator = false;
    header( 'Location:../manager/webmanager.php' );
}
;
if ( !isset( $_POST[ 'add' ] ) ) {
    $add = '';
} else {
    $add = $_POST[ 'add' ];
}
if ( !isset( $_POST[ 'delete' ] ) ) {
    $delete = '';
} else {
    $delete = $_POST[ 'delete' ];
}
if ( !isset( $_POST[ 'edit' ] ) ) {
    $edit = '';
} else {
    $edit = $_POST[ 'edit' ];
}

if ( $delete === 'on' && $add === '' && $edit === '' ) {
    $id = $_POST[ 'delvoucherbyid' ];
    $name = $_POST[ 'delvoucherbyname' ];
    $action = 'DELETE FROM discountvouchers WHERE vouchid = '.$id." AND voucher = '".$name."';";
} elseif ( $add === 'on' && $delete === '' && $edit === '' ) {
    $action = "INSERT INTO discountvouchers VALUES ('','".$_POST[ 'vouchername' ]."',".$_POST[ 'voucherdiscount' ].",'".mysqli_fetch_array( mysqli_query( $con, 'SELECT date(now());' ) )[ 0 ]."','".$_POST[ 'finaldate' ]."')";
} elseif ( $add === '' && $delete === '' && $edit === 'on' ) {
    if ( $_POST[ 'newvouchername' ] === '' ) {
        $newvouchername = mysqli_fetch_array( mysqli_query( $con, 'SELECT voucher from discountvouchers WHERE vouchid = '.$_POST[ 'selvoucherbyid' ].';' ) )[ 0 ];
    } else {
        $newvouchername = $_POST[ 'newvouchername' ];
    }
    ;
    if ( $_POST[ 'newvoucherpercent' ] === '' ) {
        $newvoucherpercent = mysqli_fetch_array( mysqli_query( $con, 'SELECT vouchpercent from discountvouchers WHERE vouchid = '.$_POST[ 'selvoucherbyid' ].';' ) )[ 0 ];
    } else {
        $newvoucherpercent = $_POST[ 'newvoucherpercent' ];
    }
    ;
    if ( $_POST[ 'newcreationdate' ] === '' ) {
        $newcreationdate = mysqli_fetch_array( mysqli_query( $con, 'SELECT creationdate from discountvouchers WHERE vouchid = '.$_POST[ 'selvoucherbyid' ].';' ) )[ 0 ];
    } else {
        $newcreationdate = $_POST[ 'newcreationdate' ];
    }
    ;
    if ( $_POST[ 'newfinaldate' ] === '' ) {
        $newfinaldate = mysqli_fetch_array( mysqli_query( $con, 'SELECT finaldate from discountvouchers WHERE vouchid = '.$_POST[ 'selvoucherbyid' ].';' ) )[ 0 ];
    } else {
        $newfinaldate = $_POST[ 'newfinaldate' ];
    }
    ;
    $action = "UPDATE discountvouchers set voucher ='".$newvouchername."', vouchpercent = ".$newvoucherpercent.", creationdate = '".$newcreationdate."',finaldate = '".$newfinaldate."' WHERE vouchid = ".$_POST[ 'selvoucherbyid' ].';';
}
;
mysqli_real_query( $con, $action );
header( 'Location:vouchers.php' );
?>