<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM typelist")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo("<p>".$notype.$editany.".".$notype2."</p></div>");
} else {
    echo ('
    <form action="typeactions.php" method="POST">
    <div class="p-2 col-10" style="display:inline-flex;">
            <span class="navbar-toggler-icon"></span>
        </button>    <div class="col-2">
      <label for="seltypebyid" class="form-label">'.$intid.'</label>
      <input type="number" class="form-control" name="seltypebyid" id="seltypebyid" aria-describedby="helpId" placeholder="'.$intid.'" required>
    </div>
        <div class="col-2">
      <label for="newtypename" class="form-label">'.$prodname.'</label>
      <input type="text" class="form-control" name="newtypename" id="newtypename" aria-describedby="helpId" placeholder="'.$prodname.'">
    </div>
    </div>
    <div class="col-10" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        '.$datacheck.$savebutton.$endconfirm.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>      </div>

  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
  <button style="width:20%" class="btn btn-primary" type="submit">'.$savebutton.'</button>
  </div>
  </div>
    </form>');
    };
    ?>