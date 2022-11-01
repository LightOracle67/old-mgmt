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

if($delete==='on' && $add === '' && $edit === ''){
    $id = $_POST['deltaxbyid'];
    $name = $_POST['deltaxbyname'];
    $action = "DELETE FROM ivas WHERE ivaid = ".$id." AND ivatype = '".$name."';";
}elseif($add === 'on' && $delete === '' && $edit === ''){
    $action = "INSERT INTO ivas VALUES ('','".$_POST['taxname']."',".$_POST['taxpercent'].")";
}elseif($add === '' && $delete==='' && $edit==='on'){
    if($_POST['newtaxname']===''){
        $newtaxname = mysqli_fetch_array(mysqli_query($con,"SELECT ivatype from ivas WHERE ivaid = ".$_POST['seltaxbyid'].";"))[0];
    }else{
        $newtaxname = $_POST['newtaxname'];
    };
    if($_POST['newtaxpercent']===''){
        $newvtaxpercent = mysqli_fetch_array(mysqli_query($con,"SELECT ivaperc from ivas WHERE ivaid = ".$_POST['seltaxbyid'].";"))[0];
    }else{
        $newtaxpercent = $_POST['newtaxpercent'];
    };
    $action = "UPDATE ivas set ivatype ='".$newtaxname."', ivaperc = ".$newtaxpercent." WHERE ivaid = ".$_POST['seltaxbyid'].";";
};
mysqli_real_query($con,$action);
header("Location:taxes.php");
?>