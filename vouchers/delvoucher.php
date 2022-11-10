<?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * FROM discountvouchers' ) ) === 0 ) {
    echo ( "<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>" );
    echo( '<p>'.$novoucherstodel.'</p></div>' );
} else {
    echo ( '<form action="voucheractions.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="delvoucherbyid" class="form-label">'.$intvouchid.'</label>
      <input type="number" class="form-control" name="delvoucherbyid" id="delvoucherbyid" aria-describedby="helpId" placeholder="'.$intvouchid.'" required>
      </div>
      <div class="col-2">
      <label for="delvoucherbyname" class="form-label">'.$vouchcode.'</label>
      <input type="text" class="form-control" name="delvoucherbyname" id="delvoucherbyname" aria-describedby="helpId" placeholder="'.$vouchcode.'" required>
    </div>
    </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        '.$datacheck.$delany.' '.$vouchers.$endconfirm.$actionnotreversible.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
  </div>
  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$delany.' '.$vouchers.'</button>
  </div>
  </div>
</form>' );
}
;
?>