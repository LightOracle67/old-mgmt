<?php include "../private/databaseopts.php"; 
        include "../private/scheck.php";
include "../private/admincheck.php";
include "../locales/locales.php";?>
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
    <title><?php echo $webmgmt?></title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <?php include("../manager/navtopinternal.php"); ?>
    <div class="p-0 mb-4 bg-light rounded-3">
        <div class="container-fluid py-4 margin-0 padding-0">
            <div class="table-responsive bg-light" style="height:369px;overflow-y:scroll;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
                <h3><a href="../manager/webmanager.php"><i class="bi bi-arrow-left-circle"></i></a><?php echo $vouchers;?></h3>
                <table class="table table-striped table-hover table-borderless table-primary align-middle">
                    <thead>
                        <tr style="position: sticky; top:0;">
                            <th><?php echo $intvouchid;?></th>
                            <th><?php echo $vouchcode;?></th>
                            <th><?php echo $vouchdisc;?></th>
                            <th><?php echo $vouchdateadded;?></th>
                            <th><?php echo $vouchfinaldate;?></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                                if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM discountvouchers")) === 0){
                                echo ("<tr>");
                                echo("<td colspan=5>".$vouchnotfound."</td></tr>");
                                } else {
                                    $sqlvouchers = "select * from discountvouchers";
                                    $resultvouchers = ($con->query($sqlvouchers));
                                    $rowvouchers = [];
                                    if ($resultvouchers->num_rows > 0){$rowvouchers = $resultvouchers->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($rowvouchers)){
               foreach($rowvouchers as $rowsvouchers)
              {
                
              
            ?>
                        <tr>

                            <td><?php echo $rowsvouchers['vouchid']; ?></td>
                            <td><?php echo $rowsvouchers['voucher']; ?></td>
                            <td><?php echo ($rowsvouchers['vouchpercent'].$percent); ?></td>
                            <td><?php echo $rowsvouchers['creationdate']; ?></td>
                            <td><?php echo $rowsvouchers['finaldate']; ?></td>
                        </tr>
                        <?php };} ?>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="p-0 bg-light rounded-3" style="display: inline-flex;width:-webkit-fill-available">
            <div class="container-fluid  margin-0 padding-0" style="display: inline-flex;">
                <div class="table-responsive bg-light p-2" style="width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
                    <caption class="sticky-bottom p-2">
                        <?php echo("(".mysqli_fetch_array(mysqli_query($con,"SELECT count(*) from discountvouchers"))[0].$vouchers2show);?>
                    </caption>
                </div>
            </div>
        </div>
    </div>
    <?php if($administrator === true){
           echo('
    <nav class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-link" id="nav-addvoucher-tab" data-bs-toggle="tab" href="#nav-addvoucher" role="tab"
            aria-controls="nav-addvoucher" aria-selected="true">'.$addany." ".$voucherstring.'</a>
        <a class="nav-link" id="nav-deletevoucher-tab" data-bs-toggle="tab" href="#nav-deletevoucher" role="tab"
            aria-controls="nav-deletevoucher" aria-selected="false">'.$delany." ".$voucherstring.'</a>
        <a class="nav-link" id="nav-editvoucher-tab" data-bs-toggle="tab" href="#nav-editvoucher" role="tab"
            aria-controls="nav-editvoucher" aria-selected="false">'.$editany." ".$voucherstring.'</a>
    </nav>');}else{
        echo("<p class='m-2 p-2'>".$voucheradvoptsonlyforadms."</p>");
    }; ?>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-addvoucher" role="tabpanel"
            aria-labelledby="nav-addvoucher-tab">
            <?php include_once('addvoucher.php')?>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-deletevoucher" role="tabpanel"
            aria-labelledby="nav-deletevoucher-tab">
            <?php include_once('delvoucher.php')?>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-editvoucher" role="tabpanel"
            aria-labelledby="nav-editvoucher-tab">
            <?php include_once('editvoucher.php')?>
        </div>
    </div>
</body>

</html>