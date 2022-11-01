<form action="classactions.php" method="POST">
    <div class="col-10" style="display: inline-flex;">
    <div class="col-4" style="padding-left:2em; padding-top:1em; ">

<label for="classname" class="form-label"><?php echo $classname;?></label>
<input type="text" class="form-control" name="classname" id="classname" aria-describedby="helpId"
    placeholder="<?php echo $classname;?>" required />
</div>
<div class="col-4" style="padding-left:2em; padding-top:1em;">

<label for="classivaperc" class="form-label"><?php echo $classtaxperc;?></label>
<select class="form-control" name="classivaperc">
<?php
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

?>
</select>
</div>
    </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
                <label class="form-check-label" for="invalidCheck">
<?php echo $datacheck.$addany." ".$class.$endconfirm;?>
            </label>
                <div class="invalid-feedback">
<?php echo $agreement;?>                </div>
            </div>
        </div>
        <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
            <button style="width:20%;" class="btn btn-primary" type="submit"><?php echo $addany." ".$class;?></button>
        </div>
    </div>
</form>