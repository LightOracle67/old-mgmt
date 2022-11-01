<?php
include "../private/databaseopts.php"; 
include "../private/scheck.php";
include "../private/admincheck.php";
include "../locales/locales.php";
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

if($delete==='on' && $add === '' && $edit === '' && isset($_POST['deluserbyid']) && isset($_POST['deluserbyname'])){
    $id = $_POST['deluserbyid'];
    $name = $_POST['deluserbyname'];
    if($id == mysqli_fetch_array(mysqli_query($con,"SELECT userid from users where username = 'administrador'"))[0]){
        echo '<script>alert("You can not delete that user!")</script>';
    header('Location:users.php');    
    }else{
    $action = "DELETE FROM users WHERE userid = ".$id." AND username = '".$name."';";};
}elseif($add === 'on' && $delete === '' && $edit === ''){
    $action = "INSERT INTO users VALUES ('','".$_POST['newusern']."','".$_POST['newuserdesc']."','".hash("sha512",$_POST['newuserpass'])."')";
}elseif($add === '' && $delete==='' && $edit==='on'){
    $id = $_POST['seluserbyid'];
    if($_POST['newusername']===''){
        $newusername = mysqli_fetch_array(mysqli_query($con,"SELECT username from users WHERE userid = ".$_POST['newusername'].";"))[0];
    }else{
        $newusername = $_POST['newusername'];
    };
    if($_POST['newuserdesc']===''){
        $newuserdesc = mysqli_fetch_array(mysqli_query($con,"SELECT userdesc from users WHERE userid = ".$_POST['newusername'].";"))[0];
    }else{
        $newuserdesc = $_POST['newuserdesc'];
    };
    if($_POST['newuserpass']===''){
        $newuserpass = mysqli_fetch_array(mysqli_query($con,"SELECT password from users WHERE userid = ".$_POST['newusername'].";"))[0];
    }else{
        $newuserpass = hash("sha512",$_POST["newuserpass"]);
    };
    $action = "UPDATE users set realname = '".$newuserdesc."', password = '".hash("sha512",$newuserpass)."' WHERE username = '".$_SESSION['name']."';";
};
mysqli_real_query($con,$action);
header("Location:../manager/webmanager.php");
?>