<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM discountvouchers")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo('<p>'.$novoucherstoedit.'</p></div>');
} else {
    echo ('
    <form action="voucheractions.php" method="POST">
    <div class="p-2 col-10" style="display:inline-flex;">
            <span class="navbar-toggler-icon"></span>
        </button>    <div class="col-2">
      <label for="selvoucherbyid" class="form-label">'.$intvouchid.'</label>
      <input type="number" class="form-control" name="selvoucherbyid" id="selvoucherbyid" aria-describedby="helpId" placeholder="'.$intvouchid.'" required>
    </div>
    <div class="col-2">
    <label for="newvouchername" class="form-label">'.$vouchcode.'</label>
    <input type="text" class="form-control" name="newvouchername" id="newvouchername" aria-describedby="helpId" placeholder="'.$vouchcode.'">
  </div>
  <div class="col-2">
      <label for="newvoucherpercent" class="form-label">'.$vouchdisc.'</label>
      <input type="number" max="100" class="form-control" name="newvoucherpercent" id="newvoucherpercent" aria-describedby="helpId" placeholder="'.$vouchdisc.'">
    </div>
    </div>
    <div class="p-2 col-10" style="display:inline-flex;">
            <span class="navbar-toggler-icon"></span>
        </button>    <div class="col-2">
      <label for="newcreationdate" class="form-label">'.$vouchdateadded.'</label>
      <input type="date" class="form-control" name="newcreationdate" id="newcreationdate" aria-describedby="helpId" placeholder="'.$vouchdateadded.'" required>
    </div>
    <div class="col-2">
    <label for="newfinaldate" class="form-label">'.$vouchfinaldate.'</label>
    <input type="date" class="form-control" name="newfinaldate" id="newfinaldate" aria-describedby="helpId" placeholder="'.$vouchfinaldate.'">
  </div>
  </div>
    <div class="col-10" style="display:inline-flex; padding-left:2em;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
'.$datacheck.$savebutton.$endconfirm.'      </label>
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