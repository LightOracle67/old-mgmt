<?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * FROM LOCALES' ) ) === 0 ) {
    echo ( "<div class='col-12' style='padding-left:2em; padding-top:1em;'>" );
    echo( '<p>'.$msginvoice1.'</p>' );
} else {
    echo ( '<form action="completelangchange.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="textlangid" class="form-label">'.$textlangid.'</label>
        <select class="form-select" name="textlangid" id="textlangid" aria-label='.$textlangid.'>' );
    $sqllocales = 'select * from locales;';
    $resultlocales = ( $con->query( $sqllocales ) );
    $rowlocales = [];
    if ( $resultlocales->num_rows > 0 ) {
        $rowlocales = $resultlocales->fetch_all( MYSQLI_ASSOC );
    }
    ;
    if ( !empty( $rowlocales ) )
    foreach ( $rowlocales as $rowslocales )
 {

        echo ( '<option value='.$rowslocales[ 'localeid' ].'>'.$rowslocales[ 'localetextid' ].'</option>' );
    } else {
        echo( "
<option disabled value='0'>".$msglocales1."</option>
<option disabled>".$msglocales1.'</option>' );
    }
    echo( '</select>
      </div>
      </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="changelang" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        '.$datacheck.$changelang.$endconfirm.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
  </div>
  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$changelang.'</button>
  </div>
  </div>
</form>' );
}
;
?>