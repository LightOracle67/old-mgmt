<?php             if(!isset($_POST['actualinvoiceid']) || $_POST['actualinvoiceid'] === ''){
    header('Location: webmanager.php');
}
include "../private/databaseopts.php"; 
include "../private/scheck.php";
include "../private/admincheck.php";
include "../locales/locales.php";
?>
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
<title><?php echo $webmgmt;?></title>
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
if(empty($_POST['vouchervalue']) || $_POST['vouchervalue'] === 0){
    $voucher=0;
}else{
    if($_POST['vouchervalue']===0){
        $voucher=0;
    }
    $voucher=$_POST['vouchervalue'];
}
if(empty($_POST['ivavalue']) || $_POST['ivavalue'] === 0){
    $iva=0;
}else{
    if($_POST['ivavalue']===0){
        $iva=0;
    }
    $iva=$_POST['ivavalue'];
}
?>
        <h3 class="m-2 p-1 border-bottom"><b><a href="webmanager.php"><i class="bi bi-arrow-left-circle"></i></a><?php echo "  ".$invoicestep3;?></b></h3>
<?php include_once "invoiceforprint.php";?>
<tr>
                                <td scope="col" colspan="5">
                                    <form action="uploadinvoice.php" method="POST">
                                <button type="submit" name="subinv"><?php echo $updinvoice;?></button>
                                <input type="hidden" value="<?php echo $invoiceid; ?>" name="actualinvoiceid"></input>                            
                                <input type="hidden" value="<?php echo $voucher; ?>" name="vouchervalue"></input>
                                <input type="hidden" value="<?php echo $totalcheckoutplusivalessvoucher; ?>" name="finalprice"></input>
                                    </form>
                                </td>
            </tr>
          </tfoot>
    </table>

</div>
</div>        
</div>
</body>
</html>