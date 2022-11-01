<?php include "../private/databaseopts.php"; 
        include "../private/scheck.php";
include "../private/admincheck.php";
include "../locales/locales.php";
if(isset($_POST['invoiceid'])){
    $invoicedetail = $_POST['invoiceid'];
}else{
    $invoicedetail = 'NULL';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="../src/images/favicon/favicon.svg"/>
    <title><?php echo $webmgmt?></title>
</head>
<body class="bg-light"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<?php include("../manager/navtopinternal.php"); ?>

<form action="searchresult.php" method="POST">
<div class="p-0 mb-4 bg-light rounded-3">
    <div class="container-fluid py-4 margin-0 padding-0">
    <h3><a href="invoicesearch.php"><i class="bi bi-arrow-left-circle"></i></a><?php echo $detailinvoiceinfo;?></h3>
  <div class="table-responsive bg-light">
  <h5><?php echo $username.": ".mysqli_fetch_array(mysqli_query($con,"SELECT realname from users where userid = (SELECT distinct(userid) from detailinvoice where invoiceid = ".$invoicedetail.");"))[0];?></h5>
  <h5><?php echo $invoiceid.": ".$invoicedetail;?></h5>
    <div class="table-responsive bg-light">
                    <table class="table table-striped table-hover table-borderless table-primary align-middle">
                        <thead>
                            <tr style="position: sticky; top:0;">
                                <th><?php echo $invoiceid?></th>
                                <th><?php echo $voucherstring?></th>
                                <th><?php echo $vouchdateadded?></th>
                                <th><?php echo $topayfinalprice;?></th>
                            </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                  
                                  
                                if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM invoices where invoiceid = ".$invoicedetail.";")) === 0){
                                echo("<tr><td colspan=10>".$msginvoice1."</td></tr>");
                                } else {
                                    $sql = "SELECT * FROM invoices where invoiceid = ".$invoicedetail.";";
                                    $result = ($con->query($sql));
                                    $row = [];
                                    if ($result->num_rows > 0){$row = $result->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($row)){
               foreach($row as $rows)
              {
                
              
            ?>
            <tr>
  
                <td><?php echo $rows['invoiceid']; ?></td>
                <?php if($rows['discountid'] === NULL){
                echo "<td>".$invoicenodisc."</td>";
                }else{
                    echo ("<td>".mysqli_fetch_array(mysqli_query($con,"SELECT voucher from discountvouchers where vouchid = ".$rows['discountid'].";"))[0]." ".mysqli_fetch_array(mysqli_query($con,"SELECT vouchpercent FROM discountvouchers where vouchid = ".$rows['discountid'].";"))[0]."(%)</td>");
                    };?>
                <td><?php echo $rows['invoicedate']; ?></td>
                <td><?php echo $rows['totalprice'].$currencies ?></td>
                            </tr>
            <?php };} ?>  
                                </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                    </table>
                    </form>
                    <table class="table table-striped table-hover table-borderless table-primary align-middle">
                        <thead>
                            <tr style="position: sticky; top:0;">
                                <th><?php echo $intid?></th>
                                <th><?php echo $prodname;?></th>
                                <th><?php echo $prodprice;?></th>
                                <th><?php echo $quantity;?></th>
                                <th><?php echo $checkout;?></th>
                                <th><?php echo $checkoutiva;?></th>
                            </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                  
                                  
                                if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM detailinvoice where invoiceid = ".$invoicedetail.";")) === 0){
                                echo("<tr><td colspan=10>".$msginvoice1."</td></tr>");
                                } else {
                                    $sql2 = "SELECT * FROM detailinvoice where invoiceid = ".$invoicedetail.";";
                                    $result2 = ($con->query($sql2));
                                    $row2 = [];
                                    if ($result2->num_rows > 0){$row2 = $result2->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($row2)){
               foreach($row2 as $rows2)
              {
                
              
            ?>
            <tr>
  
                <td><?php echo $rows2['prodid']; ?></td>
                <td><?php echo mysqli_fetch_array(mysqli_query($con,"SELECT prodname from products where prodid = ".$rows2['prodid'].";"))[0];?></td>
                <td><?php echo $rows2['price'].$currencies ?></td>
                <td><?php echo $rows2['quantity']; ?></td>
                <td><?php echo $rows2['checkout']; ?></td>
                <td><?php echo $rows2['checkoutplusiva']; ?></td>
            </tr>
            <?php };} ?>  
                                </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                    </table>
                    </form>
                </div>
                <caption class="sticky-bottom"><?php echo("(".mysqli_fetch_array(mysqli_query($con,"SELECT count(*) FROM detailinvoice where invoiceid = ".$invoicedetail.";"))[0].$details2show);?></caption>
    </div></div>
    </div>
</body>
</html>