<?php include "../private/databaseopts.php"; 
        include "../private/scheck.php";
include "../private/admincheck.php";
include "../locales/locales.php";?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="../src/images/favicon/favicon.svg"/>
    <title><?php echo $webmgmt?></title>
</head>
<body><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<?php include("../manager/navtopinternal.php"); ?>


<div class="p-0 mb-4 bg-light rounded-3">
    <div class="container-fluid py-4 margin-0 padding-0">
    <h3><a href="../manager/webmanager.php"><i class="bi bi-arrow-left-circle"></i></a><?php echo $userinfo;?></h3>
    <div class="table-responsive bg-light" style="height:369px;overflow-y:scroll;">
                    <table class="table table-striped table-hover table-borderless table-primary align-middle">
                        <thead>
                            <tr style="position: sticky; top:0;">
                                <th><?php echo $userid?></th>
                                <th><?php echo $username?></th>
                                <th><?php echo $userdesc?></th>
                                <th><?php echo $userpass?></th>
                            </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM users")) === 0){
                                echo("<tr><td colspan=10>".$msguser1."</td></tr>");
                                echo("<tr><td colspan=10>".$msguser2."</td></tr>");
                                echo("<tr><td colspan=10>".$msguser3."</td></tr>");
                                } else {
                                    $sql = "select * from users";
                                    $result = ($con->query($sql));
                                    $row = [];
                                    if ($result->num_rows > 0){$row = $result->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($row)){
               foreach($row as $rows)
              {
                
              
            ?>
            <tr>
  
                <td><?php echo $rows['userid']; ?></td>
                <td><?php echo $rows['username']; ?></td>
                <td><?php echo $rows['realname']; ?></td>
                <td><?php echo "*****" ?></td>

  
            </tr>
            <?php };} ?>  
                                </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                    </table>
                </div>
                <caption class="sticky-bottom"><?php echo("(".mysqli_fetch_array(mysqli_query($con,"SELECT count(*) from users"))[0].$users2show);?></caption>
   
    </div>
  </div>
  <?php  if($administrator === true){
    echo('
  <nav class="nav nav-pills" id="nav-tab" role="tablist">
  <a class="nav-link" id="nav-adduser-tab" data-bs-toggle="tab" href="#nav-adduser" role="tab" aria-controls="nav-adduser" aria-selected="true">'.$addany." ".$user.'</a>
  <a class="nav-link" id="nav-deleteuser-tab" data-bs-toggle="tab" href="#nav-deleteuser" role="tab" aria-controls="nav-deleteuser" aria-selected="false">'.$delany." ".$user.'</a>
</nav>');}else{
  echo("<p class='m-2 p-2'>".$advuseroptsonlyforadms."</p>");
};?>
<div class="tab-content" id="nav-tabContent">
<div class="bg-white tab-pane fade show" id="nav-adduser" role="tabpanel" aria-labelledby="nav-adduser-tab">
<?php include_once("adduser.php")?>
</div>
</div>
<div class="tab-content" id="nav-tabContent">
  <div class="bg-white tab-pane fade show" id="nav-deleteuser" role="tabpanel" aria-labelledby="nav-deleteuser-tab">
  <?php include_once("deluser.php")?>
</div>
</div>

</body>
</html>