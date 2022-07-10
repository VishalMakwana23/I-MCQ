<?php
session_start();
if ($_SESSION['who'] == "admin") 
{								
unset($_SESSION['aid']);
unset($_SESSION['type']);
unset($_SESSION['admin_sub']);
unset($_SESSION['sub_div']);
unset($_SESSION['co_dept']);
unset($_SESSION['who']);
}
if ($_SESSION['who'] == "fact") {
unset($_SESSION['fid']);
unset($_SESSION['type']);
unset($_SESSION['admin_sub']);
unset($_SESSION['sub_div']);
unset($_SESSION['co_dept']);
unset($_SESSION['who']);	
}
header("location:./");
?>