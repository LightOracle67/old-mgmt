<?php
include '../private/codeexecution.php';
if ( isset( $_POST[ 'add' ] ) ) {
    addtype($_POST['typename']);
} elseif ( isset( $_POST[ 'delete' ] )){
    deltype($_POST['deltypebyid'],$_POST['deltypebyname']);
}if ( isset( $_POST[ 'edit' ] ) ) {
    edittype($_POST['seltypebyid'],$_POST['newtypename']);
} else {
header('Location:classtypes.php');
};
?>