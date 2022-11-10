<?php include '../private/databaseopts.php';


?>
<!DOCTYPE html>
<html class = 'bg-light' lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>

<title><?php echo $webmgmt;
?></title>
</head>

<body class = 'bg-light'>
<?php include( '../manager/navtopinternal.php' );
?>
<div class = 'p-x m-x'>
<div class = 'p-0 mb-4 bg-light rounded-3'>
<div class = 'container-fluid py-4 margin-0 padding-0'>
<h3><a href = '../manager/webmanager.php'><i class = 'bi bi-arrow-left-circle'></i></a><?php echo $userinfo;
?></h3>

<div class = 'table-responsive bg-light' style = 'height:-webkit-fill-available;height:-moz-fill-available;height:100%;'>
<table class = 'table table-striped table-hover table-borderless table-primary align-middle'>
<thead>
<tr style = 'position: sticky; top:0;'>
<th><?php echo $userid?></th>
<th><?php echo $username?></th>
<th><?php echo $userdesc?></th>
<th><?php echo $userpass?></th>
</tr>
</thead>
<tbody class = 'table-group-divider'>
<?php
if ( mysqli_num_rows( mysqli_query( $con, 'SELECT * FROM users' ) ) === 0 ) {
    echo( '<tr><td colspan=10>'.$msguser1.'</td></tr>' );
    echo( '<tr><td colspan=10>'.$msguser2.'</td></tr>' );
    echo( '<tr><td colspan=10>'.$msguser3.'</td></tr>' );
} else {
    $sql = "select * from users where username = '".$_SESSION[ 'name' ]."';";
    $result = ( $con->query( $sql ) );
    $row = [];
    if ( $result->num_rows > 0 ) {
        $row = $result->fetch_all( MYSQLI_ASSOC );
    }
    ;
}
;
if ( !empty( $row ) ) {
    foreach ( $row as $rows )
 {

        ?>
        <tr>

        <td><?php echo $rows[ 'userid' ];
        ?></td>
        <td><?php echo $rows[ 'username' ];
        ?></td>
        <td><?php echo $rows[ 'realname' ];
        ?></td>
        <td><?php echo '*****' ?></td>

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
    </div></div></div>

    <nav class = 'nav nav-pills p-3' id = 'nav-tab' role = 'tablist'>
    <a class = 'nav-link active' id = 'nav-edituser-tab' data-bs-toggle = 'tab' href = '#nav-edituser' role = 'tab' aria-controls = 'nav-edituser' aria-selected = 'false'><?php echo $editany.' '.$user?></a>
    </nav>
    </div>
    <footer class = 'sticky sticky-bottom p-2' style = 'bottom:0%; z-index:10000;';
    >
    <div class = 'tab-content' id = 'nav-tabContent'>
    <div class = 'bg-white tab-pane fade show active' id = 'nav-edituser' role = 'tabpanel' aria-labelledby = 'nav-edituser-tab'>
    <?php include_once( 'edituser.php' )?>
    </div>
    </div>
    </footer>
    </body>

    </html>