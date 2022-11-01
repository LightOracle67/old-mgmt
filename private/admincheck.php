<?php
if($_SESSION['name']===mysqli_fetch_array(mysqli_query($con,"SELECT username from users where username = '".$_SESSION['name']."' and username LIKE ('%admin%');"))[0]){
    $administrator=true;
}else{
    $administrator=false;
};
?>