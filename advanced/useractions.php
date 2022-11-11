<?php
include '../private/codeexecution.php';
if ( isset( $_POST[ 'add' ] ) ) {
adduser($_POST['username'],$_POST['realname'],$_POST['userpass']);
} elseif ( isset( $_POST[ 'delete' ] ) ) {
    deluser($_POST['deluserbyid'],$_POST['deluserbyname']);
} elseif ( isset( $_POST[ 'edit' ] ) ) {
    useredit($_POST['newuserdesc'],$_POST['newuserpass']);
} else {
    header('Location:profile.php');
};
?>