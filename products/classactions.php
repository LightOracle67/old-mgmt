<?php
include '../private/codeexecution.php';
if($_POST['add']==='on'){
    addclass($_POST['classname'],$_POST['classivaperc']);
}elseif($_POST['delete']==='on'){
    delclass($_POST['delclassbyid'],$_POST['delclassbyname']);
}elseif($_POST['edit']==='on'){
    editclass($_POST['selclassbyid'],$_POST['newclassname'],$_POST['newclassivaperc']);
}else{
    header('Location:classtypes.php');
}
?>