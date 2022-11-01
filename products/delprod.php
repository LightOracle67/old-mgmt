<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM products")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo("<p>".$noprods.$delany.".".$noprods2."</p></div>");
} else {
    echo ('
    <form action="productactions.php" method="POST">
    <div class="col-10"  style="display:inline-flex; padding-left:2em;></button>
            <span class="navbar-toggler-icon"></span>
           <div class="col-2">
      <label for="delprodbyid" class="form-label">'.$intid.'</label>
      <input type="number" class="form-control" name="delprodbyid" id="delprodbyid" aria-describedby="helpId" placeholder="'.$intid.'" required>
    </div>
    <div class="col-2">
      <label for="delprodbyname" class="form-label">'.$tableprodname.'</label>
      <input type="text" class="form-control" name="delprodbyname" id="delprodbyname" aria-describedby="helpId" placeholder="'.$tableprodname.'" required>
    </div>    
</div>
  <div class="col-10 pt-2"  style="display:inline-flex; padding-left:2em;>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="delete" id="delete" required>
      <label class="form-check-label" for="delete">
        '.$datacheck.$delany." ".$product.$endconfirm.$actionnotreversible.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
    <button style="width:20%" class="btn btn-primary" type="submit">'.$delany." ".$product.'</button>
  </div>
  </div>
</form>
');
};
?>