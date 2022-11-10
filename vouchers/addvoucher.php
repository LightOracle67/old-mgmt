<form action="voucheractions.php" method="POST">
    <div class="col-10" style=" display:inline-flex;">
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="vouchername" class="form-label"><?php echo $vouchcode;?></label>
            <input type="text" class="form-control" name="vouchername" id="vouchername" aria-describedby="helpId"
                placeholder="<?php echo $vouchcode;?>" required />
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="voucherdiscount" class="form-label"><?php echo $vouchdisc?></label>
            <input type="number" max="100" class="form-control" name="voucherdiscount" id="voucherdiscount"
                aria-describedby="helpId" placeholder="<?php echo $vouchdisc?>" required />
        </div>
        <div class="col-4" style="padding-left:2em; padding-top:1em;">
            <label for="finaldate" class="form-label"><?php echo $vouchfinaldate?></label>
            <input type="date" class="form-control" name="finaldate" id="finaldate" aria-describedby="helpId"
                placeholder="<?php echo $vouchfinaldate?>" required />
        </div>
    </div>
    <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;display:block">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
            <label class="form-check-label" for="invalidCheck">
                <?php echo $datacheck.$addany." ".$vouchers.$endconfirm ?>
            </label>
            <div class="invalid-feedback">
                <?php echo $agreement;?> </div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;display:Block">
        <button style="width:20%;" class="btn btn-primary" type="submit"><?php echo $addany." ".$vouchers?></button>
    </div>
    </div>
</form>