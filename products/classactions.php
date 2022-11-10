<?php
include '../private/databaseopts.php';



$administrator = 0;
if ( $_SESSION[ 'name' ] === mysqli_fetch_array( mysqli_query( $con, 'SELECT username from users where username = "administrator"' ) )[ 0 ] ) {
    $administrator = true;
} else {
    $administrator = false;
    header( 'Location:../manager/webmanager.php' );
}
;
if ( !isset( $_POST[ 'add' ] ) ) {
    $add = '';
} else {
    $add = $_POST[ 'add' ];
}
if ( !isset( $_POST[ 'delete' ] ) ) {
    $delete = '';
} else {
    $delete = $_POST[ 'delete' ];
}
if ( !isset( $_POST[ 'edit' ] ) ) {
    $edit = '';
} else {
    $edit = $_POST[ 'edit' ];
}

if ( $delete === 'on' && $add === '' && $edit === '' && isset( $_POST[ 'delclassbyid' ] ) && isset( $_POST[ 'delclassbyname' ] ) ) {
    $id = $_POST[ 'delclassbyid' ];
    $name = $_POST[ 'delclassbyname' ];
    $action = 'DELETE FROM classlist WHERE classid = '.$id." AND classname = '".$name."';";
} elseif ( $add === 'on' && $delete === '' && $edit === '' ) {
    $action = "INSERT INTO classlist VALUES ('','".$_POST[ 'classname' ]."','".$_POST[ 'classivaperc' ]."');";
} elseif ( $add === '' && $delete === '' && $edit === 'on' ) {
    if ( $_POST[ 'newclassname' ] === '' ) {
        $newclassname = mysqli_fetch_array( mysqli_query( $con, 'SELECT classname from classlist WHERE classid = '.$_POST[ 'selclassbyid' ].';' ) )[ 0 ];
    } else {
        $newclassname = $_POST[ 'newclassname' ];
    }
    ;
    $action = "UPDATE classlist set classname ='".$newclassname."', ivaperclass ='".$_POST[ 'classivaperc' ]."' WHERE classid = ".$_POST[ 'selclassbyid' ].';';
}
;
mysqli_real_query( $con, $action );
header( 'Location:classtypes.php' );
mysqli_close( $con );
?>