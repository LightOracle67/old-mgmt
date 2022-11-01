<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM users")) === 0){
echo ("<div class='col-12' style='padding-left:2em; padding-top:1em;'>");
echo('<p>'.$msgdeluser1.'</p>');
echo('<p>'.$msgdeluser2.'</p>');
echo('<p>'.$msgdeluser3.'</p></div>');
} else {
    echo ('<form action="useractions.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="deluserbyid" class="form-label">'.$userid.'</label>
      <input type="number" class="form-control" name="deluserbyid" id="deluserbyid" aria-describedby="helpId" placeholder="'.$userid.'" required>
      </div>
      <div class="col-2">
      <label for="deluserbyname" class="form-label">'.$username.'</label>
      <input type="text" class="form-control" name="deluserbyname" id="deluserbyname" aria-describedby="helpId" placeholder="'.$username.'" required>
    </div>
    </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        '.$datacheck.$delany." ".$user.$endconfirm.$actionnotreversible.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
  </div>
  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$delany." ".$user.'</button>
  </div>
  </div>
</form>');
};
?>