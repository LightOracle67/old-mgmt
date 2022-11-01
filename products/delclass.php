<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM classlist")) === 0){
echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
echo "<p>".$noclass.$delany.". ".$noclass2."</p></div>";
} else {
    echo ('<form action="classactions.php" enctype="multipart/form-data" method="POST">
    <div class="col-12" style="padding-left:2em; padding-top:1em; display:inline-flex;">
        <div class="col-2">
        <label for="delclassbyid" class="form-label">'.$classident.'</label>
      <input type="number" class="form-control" name="delclassbyid" id="delclassbyid" aria-describedby="helpId" placeholder="'.$classident.'" required>
      </div>
      <div class="col-2">
      <label for="delclassbyname" class="form-label">'.$classname.'</label>
      <input type="text" class="form-control" name="delclassbyname" id="delclassbyname" aria-describedby="helpId" placeholder="'.$classname.'" required>
    </div>
    </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="delete" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
     '.$datacheck.$delany." ".$class.$endconfirm.$actionnotreversible.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
  </div>
  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$delany." ".$class.'</button>
  </div>
  </div>
</form>');
};
?>