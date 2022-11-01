<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM typelist")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo "<p>".$notype.$delany.". ".$notype2."</p></div>";
} else {
    echo ('<form action="typeactions.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="deltypebyid" class="form-label">'.$intid.'</label>
      <input type="number" class="form-control" name="deltypebyid" id="deltypebyid" aria-describedby="helpId" placeholder="'.$intid.'" required>
      </div>
      <div class="col-2">
      <label for="deltypebyname" class="form-label">'.$type." ".$name.'</label>
      <input type="text" class="form-control" name="deltypebyname" id="deltypebyname" aria-describedby="helpId" placeholder="'.$typename.'" required>
    </div>
    </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
'.$datacheck.$delany." ".$type.$endconfirm.$actionnotreversible.'</label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
  </div>
  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$delany." ".$type.'</button>
  </div>
  </div>
</form>');
};
?>