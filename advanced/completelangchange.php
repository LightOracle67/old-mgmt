<?php include '../private/codeexecution.php';
$con = dbaccess();
if (isset($_POST['textlangid'])){
    mysqli_real_query($con, 'UPDATE locales SET selected = NULL WHERE selected = 1;');
    mysqli_real_query($con, 'UPDATE locales set selected = 1 WHERE localeid = ' . $_POST['textlangid'] . ';');
} else {
    header('Location:langchange.php');
}
header('Location:langchange.php');
?>