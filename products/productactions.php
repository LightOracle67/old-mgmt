<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="../src/images/favicon/favicon.svg"/>
    <title><?php echo $webmgmt;?></title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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
if($_POST['dateadded'] === '' || $_POST['newdate'] === ''){
    $dateadded = date('Y-m-d');
    $newdateadded = date('Y-m-d');
}else{
    $dateadded = $_POST['dateadded'];
    $newdateadded = $_POST['newdate'];

}
if($_POST['prodimage'] === NULL){
    $prodimage = "default.png";
}else{
    $prodimage = $_POST['prodimage'];
}
if($delete==='on' && isset($_POST['delprodbyid']) && isset($_POST['delprodbyname'])){
    $id = $_POST['delprodbyid'];
    $name = $_POST['delprodbyname'];
    $action = "DELETE FROM products WHERE prodid = ".$id." AND prodname = '".$name."';";
}
if($add === 'on' && $delete === '' && $edit === ''){
    foreach ($_FILES['prodimage']['error'] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmpName = $_FILES['prodimage']['tmp_name'][$key];
            $prodimage = basename($_FILES['prodimage']['name'][$key]);
            move_uploaded_file($tmpName, "./prodimages/$prodimage");
        }
    }
    $action = "INSERT INTO products VALUES ('',".$_POST['extprodid'].",'".$_POST['prodname']."','".$_POST['fullname']."','".$_POST['description']."','".$_POST['dateadded']."',".$_POST['price'].",".$_POST['prodclass'].",".$_POST['prodtype'].",'".$prodimage."')";
}elseif($add === '' && $delete==='' && $edit==='on'){
    if($_POST['newrealid']===''){
        $newrealid = mysqli_fetch_array(mysqli_query($con,"SELECT realid from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newrealid = $_POST['newrealid'];
   }
   if($_POST['newprodname']===''){
       $newprodname = mysqli_fetch_array(mysqli_query($con,"SELECT prodname from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newprodname = $_POST['newprodname'];
   }
   if($_POST['newfullname']===''){
       $newfullname = mysqli_fetch_array(mysqli_query($con,"SELECT fullname from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newfullname = $_POST['newfullname'];
   }
   if($_POST['newproddesc']===''){
       $newproddesc = mysqli_fetch_array(mysqli_query($con,"SELECT proddesc from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newproddesc = $_POST['newproddesc'];
   }
   if($_POST['newdate']===''){
       $newdateadded = mysqli_fetch_array(mysqli_query($con,"SELECT dateadded from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newdateadded = $_POST['newdate'];
   }
   if($_POST['newprice']===''){
       $newprice = mysqli_fetch_array(mysqli_query($con,"SELECT price from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newprice = $_POST['newprice'];
   }
   if($_POST['newclass']===NULL){
       $newclass = mysqli_fetch_array(mysqli_query($con,"SELECT class from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newclass = $_POST['newclass'];
   }
   if($_POST['newtype']===NULL){
       $newtype = mysqli_fetch_array(mysqli_query($con,"SELECT type from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
       $newtype = $_POST['newtype'];
   }
   if($_FILES['newprodimage']===null){
       $newprodimage = mysqli_fetch_array(mysqli_query($con,"SELECT image from products WHERE prodid = ".$_POST['selprodbyid'].";"))[0];
   }else{
    foreach ($_FILES['newprodimage']['error'] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmpName = $_FILES['newprodimage']['tmp_name'][$key];
            $newprodimage = basename($_FILES['newprodimages']['name'][$key]);
            move_uploaded_file($tmpName, "./prodimages/$newprodimage");
        }
    }   }
   
    
    $action = "UPDATE products set realid =".$newrealid.", prodname ='".$newprodname."', fullname ='".$newfullname."', proddesc = '".$newproddesc."',dateadded ='".$newdateadded."', price ='".$newprice."', class = '".$newclass."', type = '".$newtype."', image = '".$newprodimage."' WHERE prodid ='".$_POST['selprodbyid']."';";
};
mysqli_real_query($con,$action);
mysqli_close($con);
header('Location:products.php');
?>
</body></html>