<?php include '../private/databaseopts.php';


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title><?php echo $webmgmt;
?></title>
</head>

<body>

    <?php include( '../manager/navtopinternal.php' );
?>

    <div class='container-fluid py-4 margin-0 padding-0 bg-light'>
        <div class='table-responsive bg-light' style="height:369px;overflow-y:scroll;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
            <h3><a href='../manager/webmanager.php'><i class='bi bi-arrow-left-circle'></i></a><?php echo $inttaxes;
?></h3>
            <table class='table table-striped table-hover table-borderless table-primary align-middle'>
                <thead>
                    <tr style='position: sticky; top:0;'>
                        <th><?php echo $inttaxid;
?></th>
                        <th>$localestrings['tax'].' '.$localestrings['name']
?></th>
                        <th><?php echo $taxpercent;
?></th>
                    </tr>
                </thead>
                <tbody class='table-group-divider'>
                    <?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * FROM ivas' ) ) === 0 ) {
    echo ( '<tr>' );
    echo( '<td colspan=3>'.$notaxtytes.'</td></tr>' );
} else {
    $sqltaxes = 'select * from ivas';
    $resulttaxes = ( $con->query( $sqltaxes ) );
    $rowtaxes = [];
    if ( $resulttaxes->num_rows > 0 ) {
        $rowtaxes = $resulttaxes->fetch_all( MYSQLI_ASSOC );
    }
    ;
}
;
if ( !empty( $rowtaxes ) ) {
    foreach ( $rowtaxes as $rowstaxes )
 {
        ?>
                    <tr>

                        <td><?php echo $rowstaxes[ 'ivaid' ];
        ?></td>
                        <td><?php echo $rowstaxes[ 'ivatype' ];
        ?></td>
                        <td><?php echo ( $rowstaxes[ 'ivaperc' ].' (%)' );
        ?></td>
                    </tr>
                    <?php }
        ;
    }
    ?>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>

        <div class='p-0 bg-light rounded-3' style="display: inline-flex;width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
            <div class='container-fluid  margin-0 padding-0' style='display: inline-flex;'>
                <div class='table-responsive bg-light p-2' style="width: 100%;
    width: -moz-available;          /* WebKit-based browsers will ignore this. */
    width: -webkit-fill-available;  /* Mozilla-based browsers will ignore this. */
    width: fill-available;">
                    <caption class='sticky-bottom p-2'>
                        <?php echo( '('.mysqli_fetch_array( mysqli_query( $con, 'SELECT count(*) from ivas' ) )[ 0 ].$taxes2show );
    ?>
                    </caption>
                </div>
            </div>
        </div>
    </div>
    <?php if ( $administrator === true ) {
        echo( '
    <nav class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-link" id="nav-addtax-tab" data-bs-toggle="tab" href="#nav-addtax" role="tab"
            aria-controls="nav-addtax" aria-selected="true">'.$addany.' '.$tax.'</a>
        <a class="nav-link" id="nav-deletetax-tab" data-bs-toggle="tab" href="#nav-deletetax" role="tab"
            aria-controls="nav-deletetax" aria-selected="false">'.$delany.' '.$tax.'</a>
        <a class="nav-link" id="nav-edittax-tab" data-bs-toggle="tab" href="#nav-edittax" role="tab"
            aria-controls="nav-edittax" aria-selected="false">'.$editany.' '.$tax.'</a>
    </nav>' );
    } else {
        echo( "<p class='m-2 p-2'>".$advtaxoptsonlyforadms.'</p>' );
    }
    ;
    ?>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-addtax' role='tabpanel' aria-labelledby='nav-addtax-tab'>
            <?php include_once( 'addtax.php' )?>
        </div>
    </div>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-deletetax' role='tabpanel' aria-labelledby='nav-deletetax-tab'>
            <?php include_once( 'deltax.php' )?>
        </div>
    </div>
    <div class='tab-content' id='nav-tabContent'>
        <div class='bg-white tab-pane fade show' id='nav-edittax' role='tabpanel' aria-labelledby='nav-edittax-tab'>
            <?php include_once( 'edittax.php' )?>
        </div>
    </div>
</body>

</html>