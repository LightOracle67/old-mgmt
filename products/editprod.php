<?php
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM products")) === 0){
  echo ("<div class='col-12' style='padding-left:2em; padding-top:1em; display:inline-flex;'>");
  echo("<p>".$noprods.$editany.".".$noprods2."</p></div>");
} else {
    echo ('
    <form action="productactions.php" method="POST">
    <div class="col-10" style="display:inline-flex; padding-left:2em;">
            <span class="navbar-toggler-icon"></span>
        </button>    <div class="col-2">
      <label for="selprodbyid" class="form-label">'.$intid.$to.$editany.'</label>
      <input type="number" class="form-control" name="selprodbyid" id="selprodbyid" aria-describedby="helpId" placeholder="'.$intid.$to.$editany.'" required>
    </div>
    <div class="col-2">
      <label for="newrealid" class="form-label">'.$extid.'</label>
      <input type="text" class="form-control" name="newrealid" id="newrealid" aria-describedby="helpId" placeholder="'.$extid.'">
    </div>
    <div class="col-2">
      <label for="newprodname" class="form-label">'.$tableprodname.'</label>
      <input type="text" class="form-control" name="newprodname" id="newprodname" aria-describedby="helpId" placeholder="'.$tableprodname.'">
    </div>
    <div class="col-3">
      <label for="newfullname" class="form-label">'.$tableprodfullname.'</label>
      <input type="text" class="form-control" name="newfullname" id="newfullname" aria-describedby="helpId" placeholder="'.$tableprodfullname.'">
    </div>
    <div class="col-3">
      <label for="newproddesc" class="form-label">'.$tableproddesc.'</label>
      <textarea class="form-control" name="newproddesc" id="newproddesc" aria-describedby="helpId" placeholder="'.$tableproddesc.'"></textarea>
    </div>
    </div>
    <div class="col-9" style="display:inline-flex; padding-left:2em;">
    <div class="col-1.5">
    <label for="newdate" class="form-label">'.$tableproddateadded.'</label>
    <input type="date" class="form-control" name="newdate" id="newdate" aria-describedby="helpId" placeholder="'.$tableproddateadded.'">
  </div>
    <div class="col-3">
      <label for="newprice" class="form-label">'.$tableprodprice.'</label>
      <input type="number" class="form-control" name="newprice" id="newprice" aria-describedby="helpId" step="any" placeholder="'.$tableprodprice.'">
    </div>
    <div class="col-2">
    <label for="prodclass" class="form-label">'.$tableprodclass.'</label>
    <select class="form-select form-select-lg" name="prodclass" id="prodclass" required>');
    if (mysqli_num_rows(mysqli_query($con,"SELECT classid FROM classlist;"))<=0){
      echo ("<option disabled selected>");
      echo $noclassesfound;
      echo ("</option>");
      echo ("<option disabled>");
      echo $add1ormore;
      echo ("</option>");
    }else{
    $classes = mysqli_fetch_all(mysqli_query($con,"SELECT classid,classname FROM classlist"));
    for($x=0;$x<mysqli_num_rows(mysqli_query($con,"SELECT classid FROM store.classlist;"));$x++){
        echo ("<option value='").$classes[$x][0].("'>");
        echo $classes[$x][1];
        echo ("</option>");
    }};
    echo("</select>   
    </div>
    <div class='col-2'>
    <label for='prodtype' class='form-label'>Product Type</label>
    <select class='form-select form-select-lg' name='prodtype' id='UsernameInput' required>");
    if (mysqli_num_rows(mysqli_query($con,"SELECT typeid FROM typelist;"))<=0){
      echo ("<option disabled selected>");
      echo $notypesfound;
      echo ("</option>");
      echo ("<option disabled>");
      echo $add1ormore;
      echo ("</option>");
    }else{
    $types = mysqli_fetch_all(mysqli_query($con,'SELECT typeid,typename FROM typelist'));
    for($x=0;$x<mysqli_num_rows(mysqli_query($con,"SELECT typeid FROM store.typelist;"));$x++){
        echo ("<option value='").$types[$x][0].("'>");
        echo $types[$x][1];
        echo ("</option>");}};
        echo("</select>
        </div>
        
        <div class='col-3'>
        <label for='newprodimage[]' class='form-label'>".$tableprodimage."</label>
        <input type='file' class='form-control' name='newprodimage[]' id='newprodimage[]' aria-describedby='helpId' placeholder='".$tableprodimage."' value='' default=''>
      </div>
        </div>
    
      <div class='col-10' style='display:inline-flex; padding-left:2em;'>
        <div class='form-check'>
          <input class='form-check-input' type='checkbox' name='edit' id='invalidCheck' required>
          <label class='form-check-label' for='invalidCheck'>
            ".$datacheck.$savebutton.$endconfirm."
          </label>
          <div class='invalid-feedback'>
".$agreement."          </div>
        </div>      </div>

      <div class='col-12' style='display:inline-flex; padding-left:2em; padding-top:1em;'>
      <button style='width:20%' class='btn btn-primary' type='submit'>".$savebutton."</button>
      </div>
      </div>
    </form>");
    };
    