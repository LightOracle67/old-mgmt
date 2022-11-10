<?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * FROM invoices' ) ) === 0 ) {
    echo ( "<div class='col-12' style='padding-left:2em; padding-top:1em;'>" );
    echo( '<p>'.$msginvoice1.'</p>' );
} else {
    echo ( '<form action="searchresult.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="invoiceid" class="form-label">'.$vouchers.'</label>
        <select class="form-select" name="vouchervalue" id="vouchervalue" aria-label='.$selvouchlist.'>' );
    $sqlvouchers = 'select * from discountvouchers;';
    $resultvouchers = ( $con->query( $sqlvouchers ) );
    $rowvouchers = [];
    if ( $resultvouchers->num_rows > 0 ) {
        $rowvouchers = $resultvouchers->fetch_all( MYSQLI_ASSOC );
    }
    ;
    if ( !empty( $rowvouchers ) )
    foreach ( $rowvouchers as $rowsvouchers )
 {

        echo ( '<option value='.$rowsvouchers[ 'vouchid' ].'>'.$rowsvouchers[ 'voucher' ].' ('.$rowsvouchers[ 'vouchpercent' ].'%)</option>' );
    } else {
        echo( "
<option disabled value='0'>".$nodiscvouchers."</option>
<option disabled>".$nodiscvouchers2.'</option>' );
    }
    echo( "<option value='disabled'>".$novoucherapplied.'</option>' );
    echo( '</select>
      </div>
      </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="selinvoicebyvoucher" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        '.$datacheck.' '.$search.$endconfirm.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
  </div>
  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$search.'</button>
  </div>
  </div>
</form>' );
}
;
?>