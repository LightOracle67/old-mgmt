<form action="productactions.php" enctype="multipart/form-data" method="POST">
    <div class="col-10" style="display:inline-flex; padding-left:2em;">
        </button>
        <div class="col-2">
            <label for="extprodid" class="form-label"><?php echo $extid;?></label>
            <input type="number" class="form-control" name="extprodid" id="extprodid" aria-describedby="helpId"
                placeholder="<?php echo $extid;?>" required>
        </div>
        <div class="col-2">
            <label for="prodname" class="form-label"><?php echo $tableprodname;?></label>
            <input type="text" class="form-control" name="prodname" id="prodname" aria-describedby="helpId"
                placeholder="<?php echo $tableprodname;?>" required>
        </div>
        <div class="col-3">
            <label for="fullname" class="form-label"><?php echo $tableprodfullname;?></label>
            <input type="text" class="form-control" name="fullname" id="fullname" aria-describedby="helpId"
                placeholder="<?php echo $tableprodfullname;?>" required>
        </div>
        <div class="col-3">
            <label for="description" class="form-label"><?php echo $tableproddesc;?></label>
            <textarea class="form-control" name="description" id="description" aria-describedby="helpId"
                placeholder="<?php echo $tableproddesc;?>" required></textarea>
        </div>
    </div>
    <div class=" col-9" style="display:inline-flex; padding-left:2em;">
        <div class="col-1.5">
            <label for="dateadded" class="form-label"><?php echo $tableproddateadded;?></label>
            <input type="date" class="form-control" name="dateadded" id="dateadded" aria-describedby="helpId"
                placeholder="<?php echo $tableproddateadded;?>">
        </div>
        <div class="col-2">
            <label for="price" class="form-label"><?php echo $tableprodprice;?></label>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="helpId" step="any"
                placeholder="<?php echo $tableprodprice;?>" required>
        </div>
        <div class="col-2">
            <label for="prodclass" class="form-label"><?php echo $tableprodclass;?></label>
            <select class="form-select form-select-lg" name="prodclass" id="UsernameInput" required>
                <?php
    if (mysqli_num_rows(mysqli_query($con,"SELECT classid FROM classlist;"))<=0){
        echo ("<option disabled selected>");
        echo $noclassesfound;
        echo ("</option>");
        echo ("<option disabled>");
        echo $add1ormore;
        echo ("</option>");
    }else{
    $classes = mysqli_fetch_all(mysqli_query($con,'SELECT classid,classname FROM classlist'));
    for($x=0;$x<mysqli_num_rows(mysqli_query($con,"SELECT classid FROM store.classlist;"));$x++){
        echo ("<option value='").$classes[$x][0].("'>");
        echo $classes[$x][1];
        echo ("</option>");
    }}
            ?>
            </select>
        </div>
        <div class="col-2">
            <label for="prodtype" class="form-label"><?php echo $tableprodtype;?></label>
            <select class="form-select form-select-lg" name="prodtype" id="UsernameInput" required>
                <?php
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
        echo ("</option>");

    }}
            ?>
            </select>
        </div>
        <div class="col-3">
            <label for="prodimage[]" class="form-label"><?php echo $tableprodimage;?></label>
            <input type="file" class="form-control" name="prodimage[]" id="prodimage[]" aria-describedby="helpId"
                placeholder="<?php echo $tableprodimage;?>" value="default.png" default="default.png">
        </div>
    </div>

    <div class="col-10" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required>
            <label class="form-check-label" for="invalidCheck">
                <?php echo $datacheck.$addany." ".$product.$endconfirm; ?>
            </label>
            <div class="invalid-feedback">
                <?php echo $agreement;?>
            </div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%" class="btn btn-primary" type="submit"><?php echo $addany." ".$product;?></button>
    </div>
    </div>
</form>