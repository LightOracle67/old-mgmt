<?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * FROM invoices' ) ) === 0 ) {
    echo ( "<div class='col-12' style='padding-left:2em; padding-top:1em;'>" );
    echo( '<p>'.$msginvoice1.'</p>' );
} else {
    echo ( '<form action="searchresult.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="selinvoicebydate" class="form-label">'.$dateadded.'</label>
      <input type="date" class="form-control" name="selinvoicebydate" id="selinvoicebydate" aria-describedby="helpId" placeholder="'.$invoiceid.'" required>
      </div>
      </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="selinvoicebyexactdate" id="invalidCheck" required>
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
?>