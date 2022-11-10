<?php include '../private/databaseopts.php';


$administrator = 0;
if ( $_SESSION[ 'name' ] === mysqli_fetch_array( mysqli_query( $con, 'SELECT username from users where username = "administrator"' ) )[ 0 ] ) {
    $administrator = true;
} else {
    $administrator = false;
    header( 'Location:../manager/webmanager.php' );
}
;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php echo $webmgmt;
?></title>
</head>

<body class='bg-light'>
    
    
    <?php include( '../manager/navtopinternal.php' );
?>

</body>

</html>