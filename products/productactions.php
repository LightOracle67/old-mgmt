<?php
include '../private/codeexecution.php';
$localestrings = locales(0);
$con = dbaccess();
if (!isset($_POST['add']) && !isset($_POST['delete']) && !isset($_POST['edit'])) {
    header('Location:products.php');
    exit();
} elseif (isset($_POST['add'])) {
    foreach ($_FILES['prodimage']['error'] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmpName = $_FILES['prodimage']['tmp_name'][$key];
            $prodimage = basename($_FILES['prodimage']['name'][$key]);
            move_uploaded_file($tmpName, "./prodimages/$prodimage");
        }
    }
    addprod($_POST['extprodid'], $_POST['prodname'], $_POST['fullname'], $_POST['description'], $_POST['dateadded'], $_POST['price'], $_POST['prodclass'], $_POST['prodtype'], $prodimage);
    header('Location:products.php');
    exit();
} elseif (isset($_POST['delete'])) {
    if ($_POST['delprodbyid'] === null || $_POST['delprodbyname'] === null) {
        exit();
    } else {
        delprod($_POST['delprodbyid'], $_POST['delprodbyname']);
        header('Location:products.php');
        exit();
    }
    ;
} elseif (isset($_POST['edit'])) {
    if (!isset($_POST['selprodbyid'])) {
        header('Location:products.php');
        exit();
    } else {
        $selprodbyid = $_POST['selprodbyid'];
    
    if ($_POST['newrealid']==='') {
        $newrealid = mysqli_fetch_array(mysqli_query($con, 'SELECT realid from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newrealid = $_POST['newrealid'];
    }
    if ($_POST['newprodname']==='') {
        $newprodname = mysqli_fetch_array(mysqli_query($con, 'SELECT prodname from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newprodname = $_POST['newprodname'];
    }
    if ($_POST['newfullname']==='') {
        $newfullname = mysqli_fetch_array(mysqli_query($con, 'SELECT fullname from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newfullname = $_POST['newfullname'];
    }
    if ($_POST['newproddesc']==='') {
        $newproddesc = mysqli_fetch_array(mysqli_query($con, 'SELECT proddesc from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newproddesc = $_POST['newproddesc'];
    }
    if ($_POST['newdate']==='') {
        $newdateadded = mysqli_fetch_array(mysqli_query($con, 'SELECT dateadded from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newdateadded = $_POST['newdate'];
    }
    if ($_POST['newprice']==='') {
        $newprice = mysqli_fetch_array(mysqli_query($con, 'SELECT price from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newprice = $_POST['newprice'];
    }
    if ($_POST['prodclass']==='') {
        $newclass = mysqli_fetch_array(mysqli_query($con, 'SELECT class from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newclass = $_POST['prodclass'];
    }
    if ($_POST['prodtype']===''){
        $newtype = mysqli_fetch_array(mysqli_query($con, 'SELECT type from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    } else {
        $newtype = $_POST['prodtype'];
    };
    if(empty($_FILES['newprodimage'])){
        $prodimage = mysqli_fetch_array(mysqli_query($con, 'SELECT image from products WHERE prodid = ' . $selprodbyid . ';'))[0];
    }else{
    foreach ($_FILES['newprodimage']['error'] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmpName = $_FILES['newprodimage']['tmp_name'][$key];
            $prodimage = basename($_FILES['newprodimage']['name'][$key]);
            move_uploaded_file($tmpName, "./prodimages/$prodimage");
        };
    };
};
    editprod($selprodbyid, $newrealid, $newprodname, $newfullname, $newproddesc, $newdateadded, $newprice, $newclass, $newtype, $prodimage);
    header('Location:products.php');
exit();
    };
};
