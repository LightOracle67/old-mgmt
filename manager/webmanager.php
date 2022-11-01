<?php include "../private/databaseopts.php"; 
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
    <title><?php echo $webmgmt;?></title>
</head>

<body class="bg-light">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <?php include("../manager/navtopinternal.php"); ?>
    <div style="width: 100%; height: 100%;">
    <div class="m-0 p-3 bg-light rounded-3"  style="height:450px;overflow-y:scroll;">
        <form method="POST" action="invoice.php" class="sticky-top">
        <h3 class="p-3 border-bottom bg-light sticky-top"><?php echo $prodselection;?></h3>
            <?php
            $userid = mysqli_fetch_array(mysqli_query($con,"SELECT userid from users where username = '".$_SESSION['name']."';"))[0];
            $invoiceid = mysqli_fetch_array(mysqli_query($con,"SELECT max(invoiceid) from actualinvoice where userid = ".$userid.";"))[0];
            $sqlclasses = "SELECT * FROM classlist";
            $resultclasses = $con->query($sqlclasses);
if ($resultclasses->num_rows > 0) {
    while($rowsclasses = $resultclasses->fetch_assoc()) {
        echo("<div class='m-2 bg-light'>");
        echo("<h4 class='border-bottom'> · ".$rowsclasses['classname']."</h4>");
        $sqlprods = "SELECT * FROM products where class = ".$rowsclasses['classid'].";";
        $resultprods = $con->query($sqlprods);
        if ($resultprods->num_rows > 0) {
            while($rowsprods = $resultprods->fetch_assoc()) {
                echo("<button type='submit' name='productsel' value=".mysqli_fetch_array(mysqli_query($con,"SELECT prodid from products where prodname = '".$rowsprods['prodname']."';"))[0]." class='m-2 btn btn-secondary'>");
                echo("<image src='../products/prodimages/".$rowsprods['image']."' width=75px height=75px/>");
                echo("<p class='m-1 p-0'>".$rowsprods['prodname']."</p>");
                echo("<p class='small m-1 p-0'>".$rowsprods['fullname']."</p>");
                echo("<span class='badge bg-success'>".$rowsprods['price']."€</span>");
                echo("<br>");
                echo("<span class='badge bg-warning text-dark'>Type : ".mysqli_fetch_array(mysqli_query($con,"SELECT typename FROM typelist WHERE typeid = ".$rowsprods['type'].";"))[0]."</span>");
                echo("</button>");
            }
          } else {
            echo("<div class='p-2 bg-light'>");
            echo("<h5>".$prodnotfoundinclass."</h5>");
            echo("<p>".$prodnotfoundinclass2."</p>");
            echo("</div>");
          }
     echo("</div>");
    }
  } else {
    echo("<div class='p-2 border-bottom'>");
    echo("<h4>".$noclassesfound."</h4>");
    echo("<p>".$noclassesfound2."</p>");
    echo("</div>");
  };?>

    </div>
    </div>
    <div id="checkout" class="border-top bg-light bottom sticky sticky-bottom" style="height: 250px; overflow-y:scroll;">
        <h3 class="m-3 p-0"><?php echo $invoicenumber.$invoiceid; ?></h3><h5 class="m-2 p-1"><?php echo $employee.mysqli_fetch_array(mysqli_Query($con,"SELECT realname from users where username = '".$_SESSION['name']."'"))[0];?></h5>
            <input type="hidden" value="<?php echo $invoiceid; ?>" name="actualinvoiceid"></input>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr">
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
                echo("<h5>".$rowsinvoice['quantity']."<button name='delprod' value=".$rowsinvoice['prodid'].">-</button></h5>");
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
                        <tr>
                            <td scope="col">
                            <button type="submit" name="delinv"><?php echo $deleteinv;?></button>
                                </td>
                                </form>
                                <td scope="col" colspan="3"></td>
                                <td scope="col">
                                    <form action="invoicecomplete.php" method="POST">
                                <button type="submit" name="subinv"><?php echo $submitinv;?></button>
                                <input type="hidden" value="<?php echo $invoiceid; ?>" name="actualinvoiceid"></input>
                                <input type="hidden" value="<?php echo $userid; ?>" name="userid"></input>
                                    </form>
                                </td>
                        </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>                    
</body>

</html>