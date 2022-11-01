<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM ivas")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo('<p>'.$notaxestodel.'</p></div>');
} else {
    echo ('<form action="taxactions.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="deltaxbyid" class="form-label">'.$inttaxid.'</label>
      <input type="number" class="form-control" name="deltaxbyid" id="deltaxbyid" aria-describedby="helpId" placeholder="'.$inttaxid.'" required>
      </div>
      <div class="col-2">
      <label for="deltaxbyname" class="form-label">'.$taxname.'</label>
      <input type="text" class="form-control" name="deltaxbyname" id="deltaxbyname" aria-describedby="helpId" placeholder="'.$taxname.'" required>
    </div>
    </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
'.$datacheck.$delany." ".$tax.$endconfirm.$actionnotreversible.'
     </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
  </div>
  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$delany." ".$tax.'</button>
  </div>
  </div>
</form>');
};
?>