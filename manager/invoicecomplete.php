<?php             if(!isset($_POST['actualinvoiceid']) || $_POST['actualinvoiceid'] === ''){
                header('Location: webmanager.php');
            }
include "../private/databaseopts.php"; 
        include "../private/scheck.php";
include "../private/admincheck.php";
include "../locales/locales.php";?>
<!DOCTYPE html>
<html style="height:-webkit-fill-available" class="bg-light" lang="en">

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

<body class="bg-light">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <?php include("../manager/navtopinternal.php"); ?>
            <?php
            $userid = $_POST['userid'];
            $invoiceid = $_POST['actualinvoiceid'];
            ?>
                    <h3 class="m-2 p-1 border-bottom"><b><a href="invoicecomplete.php"><i class="bi bi-arrow-left-circle"></i></a><?php echo "  ".$invoicestep2?></b></h3>

                <form method="POST" action="updateinvoiceiv.php" class="sticky-top"> 

                <div id="checkout" class="bg-light bottom sticky-bottom mx-3">
        <h3 class="m-2 p-1"><?php echo $invoicenumber.$invoiceid; ?></h3><h5 class="m-2 p-1">
            <?php echo $employee.mysqli_fetch_array(mysqli_Query($con,"SELECT realname from users where username = '".$_SESSION['name']."'"))[0];?></h5>
            <input type="hidden" value="<?php echo $invoiceid; ?>" name="actualinvoiceid"></input>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col"><h5><b><?php echo $prodname;?></b></h5></th>
                            <th scope="col"><h5><b><?php echo $prodprice;?></b></h5></th>
                            <th scope="col"><h5><b><?php echo $quantity;?></b></h5></th>
                            <th scope="col"><h5><b><?php echo $checkout;?></b></h5></th>
                            <th scope="col"><h5><b><?php echo $checkoutiva?></b></h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM actualinvoice where userid = ".$userid.";")) === 0){
                                echo("<th scope='row' colspan=6>There are no products added to this invoice. Please add one or more by clicking them and try again.</th>");
                                } else {
                                    $sqlinvoice = "select * from actualinvoice where userid = ".$userid." and invoiceid = ".$invoiceid.";";
                                    $resultinvoice = ($con->query($sqlinvoice));
                                    $rowinvoice = [];
                                    if ($resultinvoice->num_rows > 0){$rowinvoice = $resultinvoice->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($rowinvoice))
               foreach($rowinvoice as $rowsinvoice)
              { 
                echo("<tr>");
                echo("<td scope='col'>");
                echo("<h5>".mysqli_fetch_array(mysqli_query($con,"SELECT prodname from products where prodid = ".$rowsinvoice['prodid'].";"))[0]."</h5>");
                echo("</td>");
                echo("<td scope='col'>");
                echo("<h5>".$rowsinvoice['price']).$currencies.("</h5>");
                echo("</td>");
                echo("<td scope='col'>");
                echo("<h5>".$rowsinvoice['quantity']."</h5>");
                echo("</td>");
                echo("<td scope='col'>");
                echo("<h5>".$rowsinvoice['checkout'].$currencies."</h5>");
                echo("</td>");
                echo("<td scope='col'>");
                echo("<h5>".$rowsinvoice['checkoutplusiva'].$currencies." - (".mysqli_fetch_array(mysqli_query($con,"SELECT ivaperc FROM ivas where ivaid = (SELECT ivaperclass from classlist where classid =(SELECT class from products where prodid =".$rowsinvoice['prodid']."))"))[0]."% IVA)</h5>");
                echo("</td>");
            } ?>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th scope="col" colspan="3"><h5><b><?php echo $totalcheckout;?></b><div style="border-bottom:2px dotted black;width:100%;display:inline-flex;"></div></h5></th>
                                    <?php
               
                if(empty($invoiceid)){
                    echo("<th scope='col'><h5><b>".$noprice."</b></h5></th>");
                    echo("<th scope='col'><h5><b>".$noprice."</b></h5></th>");
                }elseif(mysqli_num_rows(mysqli_query($con,"SELECT checkout FROM actualinvoice where userid = ".$userid." and invoiceid = ".$invoiceid.";")) === 0){
                    echo("<th scope='col'><h5><b>".$noprice."</b></h5></th>");
                    echo("<th scope='col'><h5><b>".$noprice."</b></h5></th>");
                } else {
                                        echo("<th scope='col'>");
                                        $totalcheckout= mysqli_fetch_array(mysqli_query($con,"SELECT SUM(CHECKOUT) from actualinvoice where userid = ".$userid." and invoiceid = ".$invoiceid.";"))[0];
                                        echo ("<h5><b>".$totalcheckout.$currencies."<b></h5>");
                                        echo("</th>");
                                        echo("<th scope='col'>");
                                        $totalcheckoutplusiva= mysqli_fetch_array(mysqli_query($con,"SELECT SUM(CHECKOUTPLUSIVA) from actualinvoice where userid = ".$userid." and invoiceid = ".$invoiceid.";"))[0];
                                        echo ("<h5><b>".$totalcheckoutplusiva.$currencies."<b></h5>");
                                        echo("</th>");

                                    };
                ?>
                        </tr>
                                </form>
                                
                        </tfoot>
                </table>
            </div>
        </div>
    </div>
    <h5 class="m-2 p-1 border-bottom"><b></b></h5>

<div class="col-9 p-2 m-2 " style="display: inline-flex;">
                <div class="form-floating col-3">
  <select class="form-select" name="vouchervalue" id="vouchervalue" aria-label="<?php echo $selvouchlist;?>">
                        <?php
                        $sqlvouchers = "select * from discountvouchers where finaldate >= CURRENT_DATE;";
                        $resultvouchers = ($con->query($sqlvouchers));
                        $rowvouchers = [];
                        if ($resultvouchers->num_rows > 0){$rowvouchers = $resultvouchers->fetch_all(MYSQLI_ASSOC);};
                    if(!empty($rowvouchers))
   foreach($rowvouchers as $rowsvouchers)
  { 
    echo ("<option value=".$rowsvouchers['vouchid'].">".$rowsvouchers['voucher']." (".$rowsvouchers['vouchpercent']."%)</option>");
}else{
        echo("
        <option disabled value='0'>".$nodiscvouchers."</option>
        <option disabled>".$nodiscvouchers2."</option>");
}
echo("<option selected value='0'>".$dontapplyvoucher."</option>");
?>
                </select>
                <label for="vouchervalue"><?php echo $selvouchlist;?></label>
                </div>
</div>
<div class="col-9 p-2 m-2" style="display: inline-flex;">
<div class="form-floating col-3">
<input type="hidden" name="actualinvoiceid" value="<?php echo $invoiceid;?>"></input>
<input type="hidden" name="userid" value="<?php echo $userid;?>"></input>

<button type="submit" class="btn btn-warning"><?php echo $calcvals;?></button>

</div>
</div>
 </form>
</body>
</html>
