<form action="useractions.php" method="POST">
    <div class="col-10">
        <div class="col-4" style="padding-left:2em; padding-top:1em;display:inline-flex;">
            <div class="col-6">
                <label for="newusern" class="form-label"><?php echo $username;?></label>
                <input type="text" class="form-control" name="newusern" id="newusern" aria-describedby="helpId"
                    placeholder="<?php echo $username;?>" required />
            </div>
            <div class="col-6">
                <label for="newuserdesc" class="form-label"><?php echo $userdesc;?></label>
                <input type="text" class="form-control" name="newuserdesc" id="newuserdesc" aria-describedby="helpId"
                    placeholder="<?php echo $userdesc;?>" required />
            </div>
            <div class="col-6">
                <label for="newuserpass" class="form-label"><?php echo $userpass;?></label>
                <input type="password" class="form-control" name="newuserpass" id="newuserpass"
                    aria-describedby="helpId" placeholder="<?php echo $userpass;?>" required />
            </div>
        </div>
    </div>
    <div class="col-10 pt-2" style="display:inline-flex; padding-left:2em;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="add" id="invalidCheck" required />
            <label class="form-check-label" for="invalidCheck">
                <?php echo $datacheck.$addany." ".$user.$endconfirm ?>
            </label>
            <div class="invalid-feedback">
                <?php echo $agreement?> </div>
        </div>
    </div>
    <div class="col-12" style="display:inline-flex; padding-left:2em; padding-top:1em;">
        <button style="width:20%;" class="btn btn-primary" type="submit"><?php echo $addany." ".$user?></button>
    </div>
    </div>
</form>