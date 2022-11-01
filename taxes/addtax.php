<form action="taxactions.php" method="POST">
    <div class="col-10" style=" display:inline-flex;">
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="taxname" class="form-label"><?php echo $taxname;?></label>
            <input type="text" class="form-control" name="taxname" id="taxname" aria-describedby="helpId"
                placeholder="<?php echo $taxname?>" required />
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="taxpercent" class="form-label"><?php echo $taxpercent;?></label>
            <input type="number" max="100" class="form-control" name="taxpercent" id="taxpercent"
                aria-describedby="helpId" placeholder="<?php echo $taxpercent;?>" required />
        </div>
    </div>
    <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;display:block">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
            <label class="form-check-label" for="invalidCheck">
                <?php echo $datacheck.$addany." ".$tax.$endconfirm;?>
            </label>
            <div class="invalid-feedback">
<?php echo $agreement;?>            </div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;display:Block">
        <button style="width:20%;" class="btn btn-primary" type="submit"><?php echo $addany." ".$tax?></button>
    </div>
</form>