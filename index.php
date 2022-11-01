<?php include "private/databaseopts.php";
include "locales/locales.php";
?>
<!DOCTYPE html>
<html class="bg-light" lang="en">
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

    <nav class="navbar navbar-expand-lg navbar-light bg-light border border-bottom border-bottom-2 sticky-top">
        <p class="h4"><?php echo $webmgmt;?></h3>

    </nav>
    <div class="bg-light">
        <form style="width:40%;margin: 0 auto;padding:1em" class="border border-bottom" action="login/checkin.php"
            method="POST">
            <div class="alert alert-primary text-center" role="alert">
                <?php echo $syslogin;?></div>
            <hr>
            <div class="form-group">
                <div class="mb-3">
                <label for="UsernameInput"><?php echo $username;?></label>
                    <select class="form-select form-select-lg" name="username" id="UsernameInput">
                        <?php
if ( mysqli_connect_errno() ) {
    exit ("<div class='alert alert-danger' role='alert'>Error, could not connect to DataBase Host.</div>");
    };
    if (mysqli_num_rows(mysqli_query($con,"SELECT userid FROM users;"))<=0){
        echo ("<option disabled selected>");
        echo $usersnotfound;
        echo ("</option>");
        echo ("<option disabled>");
        echo $contactadmin;
        echo ("</option>");
    }else{
    echo ("<option selected>");
    echo $selectusername;
    echo("</option>");
    $usernames = mysqli_fetch_all(mysqli_query($con,'SELECT userid,username FROM users'));
    for($x=0;$x<mysqli_num_rows(mysqli_query($con,"SELECT userid FROM store.users;"));$x++){
        echo ("<option value='").$usernames[$x][1].("'>");
        echo $usernames[$x][1];
        echo ("</option>");

    }}
            ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"><?php echo $yourpasswd;?></label>
                <input type="password" name="password" class="form-control" id="examplePasswordInput1"
                    placeholder="<?php echo $password;?>" required>
            </div>
            <hr>
            <button style="margin: 0 auto;" type="submit" class="btn btn-primary"><?php echo $login;?></button>
            <button style="margin: 0 auto;" type="reset" class="btn btn-primary"><?php echo $reset?></button>
        </form>
    </div>
</body>

</html>