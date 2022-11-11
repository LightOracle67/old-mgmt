<?php
include '../private/codeexecution.php';
if ( isset( $_POST[ 'add' ] ) ) {
    addtax($_POST['taxname'],$_POST['taxpercent']);
} elseif ( isset( $_POST[ 'delete' ] ) ) {
    deltax($_POST['deltaxbyid'],$_POST['deltaxbyname']);
} elseif ( isset( $_POST[ 'edit' ] ) ) {
    edittax($_POST['seltaxbyid'],$_POST['newtaxname'],$_POST['newtaxpercent']);
}else{
    header('Location:taxes.php');
};
header( 'Location:taxes.php' );
?>