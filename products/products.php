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
    <title><?php echo $webmgmt;?></title>
</head>
<body><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<?php include("../manager/navtopinternal.php"); ?>


<div class="p-0 mb-4 bg-light rounded-3">
    <div class="container-fluid py-4 margin-0 padding-0">
    <h3><a href="../manager/webmanager.php"><i class="bi bi-arrow-left-circle"></i></a><?php echo $advancedproductinfo;?></h3>
    <div class="table-responsive bg-light" style="height:369px;overflow-y:scroll;">
                    <table class="table table-striped table-hover table-borderless table-primary align-middle">
                        <thead>
                            <tr style="position: sticky; top:0;">
                                <th><?php echo $intid;?></th>
                                <th><?php echo $extid;?></th>
                                <th><?php echo $tableprodname;?></th>
                                <th><?php echo $tableprodfullname;?></th>
                                <th><?php echo $tableproddesc;?></th>
                                <th><?php echo $tableproddateadded;?></th>
                                <th><?php echo $tableprodprice;?></th>
                                <th><?php echo $tableprodclass;?></th>
                                <th><?php echo $tableprodtype;?></th>
                                <th><?php echo $tableprodimage;?></th>
                            </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM products")) === 0){
                                echo ("<tr>");
                                echo("<td colspan=10>".$noprodsontable."</td></tr>");
                                } else {
                                    $sql = "select * from products";
                                    $result = ($con->query($sql));
                                    $row = [];
                                    if ($result->num_rows > 0){$row = $result->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($row)){
               foreach($row as $rows)
              {
                
              
            ?>
            <tr>
                <td><?php echo $rows['prodid']; ?></td>
                <td><?php echo $rows['realid']; ?></td>
                <td><?php echo $rows['prodname']; ?></td>
                <td><?php echo $rows['fullname']; ?></td>
                <td><?php echo $rows['proddesc']; ?></td>
                <td><?php echo $rows['dateadded']; ?></td>
                <td><?php echo $rows['price'].$currencies; ?></td>
                <td><?php ; echo mysqli_fetch_array(mysqli_query($con,"SELECT classname from classlist,products WHERE ".$rows['class']." = classlist.classid;"))[0];?></td>
                <td><?php echo mysqli_fetch_array(mysqli_query($con,"SELECT typename,type from typelist,products WHERE ".$rows['type']." = typelist.typeid;"))[0];?></td>
                <td><?php echo ("<img src=./prodimages/".$rows['image']." width=45px height=45px/>"); ?></td>
            </tr>
            <?php };} ?>  
                            </tbody>
                            <tfoot>
                            </tfoot>
                    </table>
                </div>
                <caption class="sticky-bottom"><?php echo $countprods;?></caption>
   
    </div>
  </div>
  <?php  if($administrator === true){echo('
  <nav class="nav nav-pills" id="nav-tab" role="tablist">
  <a class="nav-link" id="nav-addproduct-tab" data-bs-toggle="tab" href="#nav-addproduct" role="tab" aria-controls="nav-addproduct" aria-selected="true">'.$addproduct.'</a>
  <a class="nav-link" id="nav-deleteproduct-tab" data-bs-toggle="tab" href="#nav-deleteproduct" role="tab" aria-controls="nav-deleteproduct" aria-selected="false">'.$delproduct.'</a>
  <a class="nav-link" id="nav-editproduct-tab" data-bs-toggle="tab" href="#nav-editproduct" role="tab" aria-controls="nav-editproduct" aria-selected="false">'.$editproduct.'</a>
</nav>');}else{
  echo("<p class='m-2 p-2'>".$adminoptsforadminusers."</p>");
};?>
<div class="tab-content" id="nav-tabContent">
<div class="bg-white tab-pane fade show" id="nav-addproduct" role="tabpanel" aria-labelledby="nav-addproduct-tab">
<?php include_once("addprod.php")?>
</div>
</div>
<div class="tab-content" id="nav-tabContent">
  <div class="bg-white tab-pane fade show" id="nav-deleteproduct" role="tabpanel" aria-labelledby="nav-deleteproduct-tab">
  <?php include_once("delprod.php")?>
</div>
</div>
<div class="tab-content" id="nav-tabContent">
  <div class="bg-white tab-pane fade show" id="nav-editproduct" role="tabpanel" aria-labelledby="nav-editproduct-tab">
  <?php include_once("editprod.php")?>
</div>
</div>
</body>
</html>