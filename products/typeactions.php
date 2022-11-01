<?php
include "../private/databaseopts.php"; 
include "../private/scheck.php";
include "../private/admincheck.php";
$administrator = 0;
if($_SESSION['name'] === mysqli_fetch_array(mysqli_query($con,'SELECT username from users where username = "administrator"'))[0]){
    $administrator=true;
}else{
    $administrator=false;
    header('Location:../manager/webmanager.php');
};
if(!isset($_POST['add'])){
    $add = '';
}else{
    $add = $_POST['add'];
}
if(!isset($_POST['delete'])){
    $delete = '';
}else{
    $delete = $_POST['delete'];
}
if (!isset($_POST['edit'])){
    $edit = '';
}else{
    $edit = $_POST['edit'];
}

if($delete==='on' && $add === '' && $edit === '' && isset($_POST['deltypebyid']) && isset($_POST['deltypebyname'])){
    $id = $_POST['deltypebyid'];
    $name = $_POST['deltypebyname'];
    $action = "DELETE FROM typelist WHERE typeid = ".$id." AND typename = '".$name."';";
}elseif($add === 'on' && $delete === '' && $edit === ''){
    $action = "INSERT INTO typelist VALUES ('','".$_POST['typename']."')";
}elseif($add === '' && $delete==='' && $edit==='on'){
    if($_POST['newtypename']===''){
       $newtypename = mysqli_fetch_array(mysqli_query($con,"SELECT typename from typelist WHERE typeid = ".$_POST['seltypebyid'].";"))[0];
   }else{
       $newtypename = $_POST['newtypename'];
   };
    $action = "UPDATE typelist set typename ='".$newtypename."' WHERE typeid = ".$_POST['seltypebyid'].";";
};
mysqli_real_query($con,$action);
header("Location:classtypes.php");
mysqli_close($con);

?>