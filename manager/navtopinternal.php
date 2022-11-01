<script type="text/javascript">
const zeroFill = n => {
    return ('0' + n).slice(-2);
}
const interval = setInterval(() => {
    const now = new Date();
    const dateTime = '  ' + zeroFill(now.getUTCDate()) + '/' + zeroFill((now.getMonth() + 1)) + '/' + now
    .getFullYear() + ' ' + zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes()) + ':' + zeroFill(now
            .getSeconds());
    document.getElementById('date-time').innerHTML = dateTime;
}, 0500);
</script>
<style>
a#menus {
    border-bottom: 2px solid transparent;
}

a#menus:hover {
    border-bottom: 2px solid black;
}

a#menubrand {
    border-bottom: 2px solid transparent;
}
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top" style="z-index:10000;">
    <div class="container pb-2"
        style="display: flex;justify-content: space-around;flex-wrap: wrap;flex-direction: column;align-content: stretch;align-items: center;">
        <a class="navbar-brand" id="menubrand" href="#"><?php echo $webmgmt;?></a>
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
            aria-label="Toggle navigation" style="margin:0 auto;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mb-1" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a id="menus" class="nav-link" href="../manager/webmanager.php" aria-current="page"><?php echo $home;?></a>
                </li>
                <li class="nav-item dropdown">
                    <a id="menus" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false"><?php echo $productrelated;?></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../products/products.php"><?php echo $advancedproductinfo;?></a>
                        </li>
                        <li><a class="dropdown-item" href="../products/classtypes.php"><?php echo $productclassesandtypes;?></a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="menus" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false"><?php echo $taxesanddiscounts;?></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../taxes/taxes.php"><?php echo $taxes;?></a></li>
                        <li><a class="dropdown-item" href="../vouchers/vouchers.php"><?php echo $discountvouchers;?></a></li>
                    </ul>
                </li>



                <?php if($administrator===true){
           echo('
           <li class="nav-item dropdown">
                    <a id="menus" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">'.$advsetts.'</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../advanced/advancedsettings.php">'.$advsetts.'</a></li>
                        <li><a class="dropdown-item" href="../advanced/users.php">'.$usernavtop.'</a></li>
                        <li><a class="dropdown-item" href="../advanced/invoicesearch.php">'.$invoicestop.'</a></li>
                        <li><a class="dropdown-item" href="../advanced/langchange.php">'.$language.'</a></li>
                    </ul>
                </li>
           '); 
        }else{
              };
        ?>
            </ul>
        </div>

        <div>
            <a href="../advanced/profile.php"><button type="button" class="btn btn-warning"><i class="bi bi-person-fill"></i>
                    <?php echo mysqli_fetch_array(mysqli_Query($con,"SELECT realname from users where username = '".$_SESSION['name']."'"))[0] ?></button></a>
            <a href="../login/logout.php"><button type="button" class="btn btn-warning"><i class="bi bi-upload"></i>
                    <?php echo $logout;?></button></a>
            <button type="button" class="btn btn-dark"><i class="bi bi-clock"></i><span id="date-time"><?php echo $loadingtime;?></span></button>
            <?php if($administrator === true){
                echo ('<a href="../advanced/langchange.php"><button type="button" class="btn btn-dark"><i class="bi bi-translate"></i>'.'  '.$locale.'</button></a>');
            }else{
                echo ('<button type="button" class="btn btn-dark"><i class="bi bi-translate"></i>'."  ".$locale.'</button>');
            };?>  
        </div>
    </div>

</nav>