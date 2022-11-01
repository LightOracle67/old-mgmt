<form action="typeactions.php" method="POST">
    <div class="col-10">
        <div class="col-4" style="padding-left:2em; padding-top:1em;">

            <label for="typename" class="form-label"><?php echo $typename;?></label>
            <input type="text" class="form-control" name="typename" id="typename" aria-describedby="helpId"
                placeholder="<?php echo $typename;?>" required />
        </div>
        <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
                <label class="form-check-label" for="invalidCheck">
                    <?php echo $datacheck.$addany." ".$type.$endconfirm?>
                </label>
                <div class="invalid-feedback">
<?php echo $agreement;?>
                </div>
            </div>
        </div>
        <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
            <button style="width:20%;" class="btn btn-primary" type="submit"><?php echo $addany." ".$type;?></button>
        </div>
    </div>
</form>