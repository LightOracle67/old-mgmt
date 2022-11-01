<?php include "../private/databaseopts.php"; 
        include "../private/scheck.php";
include "../private/admincheck.php";
include "../locales/locales.php";
        $administrator = 0;
if($_SESSION['name'] === mysqli_fetch_array(mysqli_query($con,'SELECT username from users where username = "administrator"'))[0]){
    $administrator=true;
}else{
    $administrator=false;
    header('Location:../manager/webmanager.php');
};?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="../src/images/favicon/favicon.svg" />
    <title><?php echo $webmgmt;?></title>
</head>

<body class="bg-light">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <?php include("../manager/navtopinternal.php"); ?>



</body>

</html>