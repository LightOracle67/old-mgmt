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
            <tr>
                <th scope="col" colspan="4"><h5><?php echo $voucherstring;?></h5></th>
                <th><h5><?php
                if($voucher===0){
                    echo "<p>".$notselected."</p>";
                    $vouchertotal = round($totalcheckoutplusiva*(0/100),2);
                    $voucher=null;
                }else{
                    $voucherpercentdiscount = mysqli_fetch_array(mysqli_query($con,"SELECT vouchpercent FROM discountvouchers where vouchid = ".$voucher.";"))[0];
                    $vouchercodefromdb = mysqli_fetch_array(mysqli_query($con,"SELECT voucher FROM discountvouchers where vouchid = ".$voucher.";"))[0];
                    $vouchertotal = round($totalcheckoutplusiva*($voucherpercentdiscount/100),2);
                    echo $vouchercodefromdb.("  (").$voucherpercentdiscount.("%) - ").$vouchertotal.$currencies;
                }?></h5></th>
            </tr>
            
            <tr>
            <th scope="col" colspan="4"><h5><b><?php echo $topayfinalprice;?></b><div style="border-bottom:2px dotted black;width:100%;display:inline-flex;"></div></h5></th>
            <th scope="col"><h5><b><?php 
            $totalcheckoutplusiva= mysqli_fetch_array(mysqli_query($con,"SELECT SUM(CHECKOUTPLUSIVA) from actualinvoice where userid = ".$userid." and invoiceid = ".$invoiceid.";"))[0];
            $totalcheckoutplusivalessvoucher = $totalcheckoutplusiva-$vouchertotal;
            echo $totalcheckoutplusivalessvoucher.$currencies;?></b></h5></th>
            </tr>
            