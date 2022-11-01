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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="../src/images/favicon/favicon.svg" />
    <title><?php echo $webmgmt;?></title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <?php include("../manager/navtopinternal.php"); ?>


    <div class="p-0 mb-4 bg-light rounded-3">
    <h3 class="p-2"><a href="../manager/webmanager.php"><i class="bi bi-arrow-left-circle"></i></a><?php echo $classesandtypes;?></h3>
    <div class="container-fluid py-4 margin-0 padding-0" style="display: inline-flex;">
            <div class="table-responsive bg-light" style="height:369px;overflow-y:scroll;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
                <h3><?php echo $tableprodclass2;?></h3>
                <table class="table table-striped table-hover table-borderless table-primary align-middle">
                    <thead>
                        <tr style="position: sticky; top:0;">
                            <th><?php echo $class." ".$intid?></th>
                            <th><?php echo $classname;?></th>
                            <th><?php echo $iva." ".$typeper." ".$class;?></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                                if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM classlist")) === 0){
                                echo ("<tr>");
                                echo("<td colspan=10>".$noclassesontable."</td></tr>");
                                } else {
                                    $sqlclass = "select * from classlist";
                                    $resultclass = ($con->query($sqlclass));
                                    $rowclass = [];
                                    if ($resultclass->num_rows > 0){$rowclass = $resultclass->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($rowclass)){
               foreach($rowclass as $rowsclass)
              {
                
              
            ?>
                        <tr>

                            <td><?php echo $rowsclass['classid']; ?></td>
                            <td><?php echo $rowsclass['classname']; ?></td>
                            <td><?php echo mysqli_fetch_array(mysqli_query($con,"SELECT ivatype from ivas where ivaid = ".$rowsclass['ivaperclass'].";"))[0].(" (").(mysqli_fetch_array(mysqli_query($con,"SELECT ivaperc from ivas where ivaid = ".$rowsclass['ivaperclass'].";"))[0]).(" %)"); ?></td>
                        </tr>
                        <?php };} ?>
                        </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>

            <div class="table-responsive bg-light" style="height:369px;overflow-y:scroll;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
                <h3><?php echo $tableprodtype2;?></h3>
                <table class="table table-striped table-hover table-borderless table-primary align-middle">
                    <thead>
                        <tr style="position: sticky; top:0;">
                            <th><?php echo $intid;?></th>
                            <th><?php echo $typename;?></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                                if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM typelist")) === 0){
                                echo ("<tr>");
                                echo("<td colspan=10>".$notypesontable."</td></tr>");
                                } else {
                                    $sqltypes = "select * from typelist";
                                    $resulttypes = ($con->query($sqltypes));
                                    $rowtypes = [];
                                    if ($resulttypes->num_rows > 0){$rowtypes = $resulttypes->fetch_all(MYSQLI_ASSOC);};
                                };
                                if(!empty($rowtypes)){
               foreach($rowtypes as $rowstypes)
              {
                
              
            ?>
                        <tr>

                            <td><?php echo $rowstypes['typeid']; ?></td>
                            <td><?php echo $rowstypes['typename']; ?></td>
                        </tr>
                        <?php };} ?>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="p-0 bg-light rounded-3" style="display: inline-flex;width:100%;">
            <div class="container-fluid  margin-0 padding-0" style="display: inline-flex;">
                <div class="table-responsive bg-light p-2" style="width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
                    <caption class="sticky-bottom p-2">
                        <?php echo("(".mysqli_fetch_array(mysqli_query($con,"SELECT count(*) from classlist"))[0].$classes2show);?>
                    </caption>

                </div>
            </div>
            <div class="table-responsive bg-light p-2" style="width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
                <caption class="sticky-bottom">
                    <?php echo("(".mysqli_fetch_array(mysqli_query($con,"SELECT count(*) from typelist"))[0].$types2show);?>
                </caption>

            </div>
        </div>
    </div>
    <?php if($administrator === true){echo('
    <nav class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-link" id="nav-addclass-tab" data-bs-toggle="tab" href="#nav-addclass" role="tab"
            aria-controls="nav-addclass" aria-selected="true">'.$addclass.'</a>
        <a class="nav-link" id="nav-deleteproduct-tab" data-bs-toggle="tab" href="#nav-deleteclass" role="tab"
            aria-controls="nav-deleteclass" aria-selected="false">'.$delclass.'</a>
        <a class="nav-link" id="nav-editproduct-tab" data-bs-toggle="tab" href="#nav-editclass" role="tab"
            aria-controls="nav-editclass" aria-selected="false">'.$editclass.'</a>
        <a class="nav-link " id="nav-addtype-tab" data-bs-toggle="tab" href="#nav-addtype" role="tab"
            aria-controls="nav-addtype" aria-selected="true">'.$addtype.'</a>
        <a class="nav-link" id="nav-deletetype-tab" data-bs-toggle="tab" href="#nav-deletetype" role="tab"
            aria-controls="nav-deletetype" aria-selected="false">'.$deltype.'</a>
        <a class="nav-link" id="nav-edittype-tab" data-bs-toggle="tab" href="#nav-edittype" role="tab"
            aria-controls="nav-edittype" aria-selected="false">'.$edittype.'</a>
    </nav>');}else{
        echo("<p class='p-2 m-2'>".$admoptsclasses."</p>");
        echo("<p class='p-2 m-2'>".$admoptstypes."</p>");
    }; ?>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-addclass" role="tabpanel"
            aria-labelledby="nav-addclass-tab">
            <?php include_once("addclass.php")?>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-deleteclass" role="tabpanel"
            aria-labelledby="nav-deleteclass-tab">
            <?php include_once("delclass.php")?>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-editclass" role="tabpanel" aria-labelledby="nav-editclass-tab">
            <?php include_once("editclass.php")?>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-addtype" role="tabpanel" aria-labelledby="nav-addtype-tab">
            <?php include_once("addtype.php")?>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-deletetype" role="tabpanel"
            aria-labelledby="nav-deletetype-tab">
            <?php include_once("deltype.php")?>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="bg-white tab-pane fade show" id="nav-edittype" role="tabpanel" aria-labelledby="nav-edittype-tab">
            <?php include_once("edittype.php")?>
        </div>
    </div>
</body>

</html>