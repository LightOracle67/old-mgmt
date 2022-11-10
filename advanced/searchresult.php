<?php include '../private/databaseopts.php';



if ( isset( $_POST[ 'selinvoicebyid' ] ) ) {
    $byid = $_POST[ 'selinvoicebyid' ];
} else {
    $byid = 'off';
}
if ( isset( $_POST[ 'selinvoicebyexactdate' ] ) ) {
    $byexactdate = $_POST[ 'selinvoicebyexactdate' ];
} else {
    $byexactdate = 'off';
}
if ( isset( $_POST[ 'selinvoicebydaterange' ] ) ) {
    $byrangedate = $_POST[ 'selinvoicebydaterange' ];
} else {
    $byrangedate = 'off';
}
if ( isset( $_POST[ 'selinvoicebyvoucher' ] ) ) {
    $byvoucher = $_POST[ 'selinvoicebyvoucher' ];
} else {
    $byvoucher = 'off';
}
if ( $byid === 'on' ) {
    $searchinvoiceid = $_POST[ 'invoiceid' ];
    $searchquery = ( 'SELECT * FROM invoices where invoiceid = '.$searchinvoiceid.';' );
} elseif ( $byexactdate === 'on' ) {
    $searchinvoicedate = $_POST[ 'selinvoicebydate' ];
    $searchquery = "SELECT * FROM invoices where invoicedate LIKE '".$searchinvoicedate."%';";
} elseif ( $byrangedate === 'on' ) {
    $searchinvoicerangemin = $_POST[ 'mindaterange' ];
    $searchinvoicerangemax = $_POST[ 'maxdaterange' ];
    $searchquery = "SELECT * FROM invoices where invoicedate BETWEEN '".$searchinvoicerangemin."%' and '".$searchinvoicerangemax."%';";
} elseif ( $byvoucher === 'on' ) {
    $searchinvoicebyvoucher = $_POST[ 'vouchervalue' ];
    if ( $searchinvoicebyvoucher === 'disabled' ) {
        $searchquery = 'SELECT * FROM invoices where discountid = NULL;';
    } else {
        $searchquery = 'SELECT * FROM invoices where discountid = '.$searchinvoicebyvoucher.';';
    }
} else {
    $searchquery = 'SELECT * from invoices';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset = 'UTF-8'>
<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<link rel = 'icon' href = '../src/images/favicon/favicon.svg'/>
<title><?php echo $webmgmt?></title>
</head>
<body>
<?php include( '../manager/navtopinternal.php' );
?>

<form action = 'moreinformationinvoice.php' method = 'POST'>
<div class = 'p-0 mb-4 bg-light rounded-3'>
<div class = 'container-fluid py-4 margin-0 padding-0'>
<h3><a href = 'invoicesearch.php'><i class = 'bi bi-arrow-left-circle'></i></a><?php echo $invoicesopts;
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

if ( mysqli_num_rows( mysqli_query( $con, $searchquery ) ) === 0 ) {
    echo( '<tr><td colspan=10>'.$msginvoice1.'</td></tr>' );
} else {
    $sql = $searchquery;
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
    </form>
    </div>
    <caption class = 'sticky-bottom'><?php echo( '('.mysqli_num_rows( mysqli_query( $con, $searchquery ) ).$invoices2show );
    ?></caption>

    </div>
    </div>
    <?php
    if ( mysqli_num_rows( mysqli_query( $con, $searchquery ) ) != 0 ) {
        if ( $administrator === true ) {
            echo( '
  <nav class="nav nav-pills" id="nav-tab" role="tablist">
  <a class="nav-link" id="nav-selectinvoiceid-tab" data-bs-toggle="tab" href="#nav-selectinvoiceid" role="tab" aria-controls="nav-selectinvoiceid" aria-selected="false">'.$invoiceselect.'</a>
  </nav>' );
        } else {
            echo( "<p class='m-2 p-2'>".$advuseroptsonlyforadms.'</p>' );
        }
    };
    ?>
    <div class = 'tab-content' id = 'nav-tabContent'>
    <div class = 'bg-white tab-pane fade show' id = 'nav-selectinvoiceid' role = 'tabpanel' aria-labelledby = 'nav-selectinvoiceid-tab'>
    <?php include_once( 'selectinvoiceid.php' )?>
    </div>
    </div>
    </body>
    </html>