<?php include '../private/databaseopts.php';



?>
<!DOCTYPE html>
<html>
<head>
<meta charset = 'UTF-8'>
<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<link href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel = 'stylesheet' integrity = 'sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin = 'anonymous'>
<link rel = 'stylesheet' href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css'>
<link rel = 'icon' href = '../src/images/favicon/favicon.svg'/>
<title><?php echo $webmgmt?></title>
</head>
<body>
<?php include( '../manager/navtopinternal.php' );
?>

<div class = 'p-0 mb-4 bg-light rounded-3'>
<div class = 'container-fluid py-4 margin-0 padding-0'>
<h3><a href = '../manager/webmanager.php'><i class = 'bi bi-arrow-left-circle'></i></a><?php echo $invoicesopts;
?></h3>
<div class = 'table-responsive bg-light' style = 'height:369px;overflow-y:scroll;'>
<table class = 'table table-striped table-hover table-borderless table-primary align-middle'>
<thead>
<tr style = 'position: sticky; top:0;'>
<th><?php echo $invoiceid?></th>
<th><?php echo $vouchers?></th>
<th><?php echo $vouchdateadded?></th>
<th><?php echo $topayfinalprice;
?></th>
</tr>
</thead>
<tbody class = 'table-group-divider'>
<?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * from invoices' ) ) === 0 ) {
    echo( '<tr><td colspan=10>'.$msginvoice1.'</td></tr>' );
} else {
    $sql = 'SELECT * from invoices';
    $result = ( $con->query( $sql ) );
    $row = [];
    if ( $result->num_rows > 0 ) {
        $row = $result->fetch_all( MYSQLI_ASSOC );
    }
    ;
}
;
if ( !empty( $row ) ) {
    foreach ( $row as $rows )
 {

        ?>
        <tr>

        <td><?php echo $rows[ 'invoiceid' ];
        ?></td>
        <?php if ( $rows[ 'discountid' ] === NULL ) {
            echo '<td>'.$invoicenodisc.'</td>';
        } else {
            echo ( '<td>'.mysqli_fetch_array( mysqli_query( $con, 'SELECT voucher from discountvouchers where vouchid = '.$rows[ 'discountid' ].';' ) )[ 0 ].' '.mysqli_fetch_array( mysqli_query( $con, 'SELECT vouchpercent FROM discountvouchers where vouchid = '.$rows[ 'discountid' ].';' ) )[ 0 ].'(%)</td>' );
        }
        ;
        ?>
        <td><?php echo $rows[ 'invoicedate' ];
        ?></td>
        <td><?php echo $rows[ 'totalprice' ].$currencies ?></td>
        </tr>
        <?php }
        ;
    }
    ?>
    </tr>
    </tbody>
    <tfoot>
    </tfoot>
    </table>
    </div>
    <caption class = 'sticky-bottom'><?php echo( '('.mysqli_fetch_array( mysqli_query( $con, 'SELECT count(*) from invoices' ) )[ 0 ].$invoices2show );
    ?></caption>

    </div>
    </div>
    <?php  if ( $administrator === true ) {
        echo( '
  <nav class="nav nav-pills" id="nav-tab" role="tablist">
  <a class="nav-link" id="nav-searchinvoicebyid-tab" data-bs-toggle="tab" href="#nav-searchinvoicebyid" role="tab" aria-controls="nav-searchinvoicebyid" aria-selected="false">'.$invoicesearch.' '.$intid.'</a>
  <a class="nav-link" id="nav-searchinvoicebydate-tab" data-bs-toggle="tab" href="#nav-searchinvoicebydate" role="tab" aria-controls="nav-searchinvoicebydate" aria-selected="false">'.$invoicesearch.' '.$date.'</a>
  <a class="nav-link" id="nav-searchinvoicebydaterange-tab" data-bs-toggle="tab" href="#nav-searchinvoicebydaterange" role="tab" aria-controls="nav-searchinvoicebydaterange" aria-selected="false">'.$invoicesearch.' '.$daterange.'</a>
  <a class="nav-link" id="nav-searchinvoicebydiscountvoucher-tab" data-bs-toggle="tab" href="#nav-searchinvoicebydiscountvoucher" role="tab" aria-controls="nav-searchinvoicebydiscountvoucher" aria-selected="false">'.$invoicesearch.' '.$vouchers.'</a>
</nav>' );
    } else {
        echo( "<p class='m-2 p-2'>".$advuseroptsonlyforadms.'</p>' );
    }
    ;
    ?>
    <div class = 'tab-content' id = 'nav-tabContent'>
    <div class = 'bg-white tab-pane fade show' id = 'nav-searchinvoicebyid' role = 'tabpanel' aria-labelledby = 'nav-searchinvoicebyid-tab'>
    <?php include_once( 'searchinvoiceid.php' )?>
    </div>
    </div>
    <div class = 'tab-content' id = 'nav-tabContent'>
    <div class = 'bg-white tab-pane fade show' id = 'nav-searchinvoicebydate' role = 'tabpanel' aria-labelledby = 'nav-searchinvoicebydate-tab'>
    <?php include_once( 'searchinvoicedate.php' )?>
    </div>
    </div>
    <div class = 'tab-content' id = 'nav-tabContent'>
    <div class = 'bg-white tab-pane fade show' id = 'nav-searchinvoicebydaterange' role = 'tabpanel' aria-labelledby = 'nav-searchinvoicebydaterange-tab'>
    <?php include_once( 'searchinvoicedaterange.php' )?>
    </div>
    </div>
    <div class = 'tab-content' id = 'nav-tabContent'>
    <div class = 'bg-white tab-pane fade show' id = 'nav-searchinvoicebydiscountvoucher' role = 'tabpanel' aria-labelledby = 'nav-searchinvoicebydiscountvoucher-tab'>
    <?php include_once( 'searchinvoicebydiscountvoucher.php' )?>
    </div>
    </div>
    </body>
    </html>