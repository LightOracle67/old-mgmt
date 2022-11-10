<?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * FROM users' ) ) === 0 ) {
    echo ( "<div class='col-12 bg-light'>" );
    echo( '<p>'.$msgdeluser1.'</p>' );
    echo( '<p>'.$msgdeluser2.'</p>' );
    echo( '<p>'.$msgdeluser3.'</p></div>' );
} else {
    echo ( '
    <form class="bg-light" action="useractions.php" method="POST">
    <div class="p-4 col-10" style="display:inline-flex;">
            <span class="navbar-toggler-icon"></span>
        </button>    
  <div class="col-2">
      <label for="newuserdesc" class="form-label">'.$userdesc.'</label>
      <input type="text" class="form-control" name="newuserdesc" id="newuserdesc" aria-describedby="helpId" placeholder="'.$userdesc.'">
    </div>
    <div class="col-2">
    <label for="newuserpass" class="form-label">'.$userpass.'</label>
    <input type="password" class="form-control" name="newuserpass" id="newuserpass" aria-describedby="helpId" placeholder="'.$userpass.'">
  </div>
    </div>
    <div class="col-10 p-4" style="display:inline-flex;">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="edit" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        '.$datacheck.$savebutton.$endconfirm.'
      </label>
      <div class="invalid-feedback">
'.$agreement.'      </div>
    </div>      </div>

  <div class="col-12 p-4" style="display:inline-flex; padding-left:2em; padding-top:1em;">
  <button style="width:20%" class="btn btn-primary" type="submit">'.$savebutton.'</button>
  </div>
  </div>
    </form>' );
}
;
?>