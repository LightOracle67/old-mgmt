<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM ivas")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo('<p>'.$notaxestodel.'</p></div>');
} else {
    echo ('
    <form action="taxactions.php" method="POST">
    <div class="p-2 col-10" style="display:inline-flex;">
            <span class="navbar-toggler-icon"></span>
        </button>    <div class="col-2">
      <label for="seltaxbyid" class="form-label">'.$inttaxid.'</label>
      <input type="number" class="form-control" name="seltaxbyid" id="seltaxbyid" aria-describedby="helpId" placeholder="'.$inttaxid.'" required>
    </div>
    <div class="col-2">
    <label for="newtaxname" class="form-label">'.$taxname.'</label>
    <input type="text" class="form-control" name="newtaxname" id="newtaxname" aria-describedby="helpId" placeholder="'.$taxname.'">
  </div>
  <div class="col-2">
      <label for="newtaxpercent" class="form-label">'.$taxpercent.'</label>
      <input type="number" max="100" class="form-control" name="newtaxpercent" id="newtaxpercent" aria-describedby="helpId" placeholder="'.$taxpercent.'">
    </div>
  </div>
    <div class="col-10" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
'.$datacheck.$savebutton.$endconfirm.'      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>
          </div>

  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
  <button style="width:20%" class="btn btn-primary" type="submit">'.$savebutton.'</button>
  </div>
  </div>
    </form>');
    };
    ?>