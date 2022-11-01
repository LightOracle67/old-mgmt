<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM classlist")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo "<p>".$noclass.$editany.". ".$noclass2."</p></div>";
} else {
    echo ('
    <form action="classactions.php" method="POST">
    <div class="p-2 col-10" style="display:inline-flex;">
            <span class="navbar-toggler-icon"></span>
        </button>    <div class="col-2">
      <label for="selclassbyid" class="form-label">'.$intid.'</label>
      <input type="number" class="form-control" name="selclassbyid" id="selclassbyid" aria-describedby="helpId" placeholder="'.$intid.'" required>
    </div>
        <div class="col-2">
      <label for="newclassname" class="form-label">'.$classname.'</label>
      <input type="text" class="form-control" name="newclassname" id="newclassname" aria-describedby="helpId" placeholder="'.$classname.'">
    </div>
    <div class="col-4" style="padding-left:2em; padding-top:1em;">
    <label for="classivaperc" class="form-label">'.$classtaxperc.'</label>
<select class="form-control" name="classivaperc">');
$sqlivas = "select * from ivas;";
$resultivas = ($con->query($sqlivas));
$rowivas = [];
if ($resultivas->num_rows > 0){$rowivas = $resultivas->fetch_all(MYSQLI_ASSOC);};
if(!empty($rowivas))
foreach($rowivas as $rowsivas)
{ 
echo ("<option value=".$rowsivas['ivaid'].">".$rowsivas['ivatype']." (".$rowsivas['ivaperc']."%)</option>");
}else{
echo("
<option disabled>".$noivatypes."</option>
<option disabled>".$add1ormore."</option>");
}
echo('</select>
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
    </div>
    </div>

  <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
  <button style="width:20%" class="btn btn-primary" type="submit">Save Changes</button>
  </div>
  </div>
    </form>');
    };
    ?>