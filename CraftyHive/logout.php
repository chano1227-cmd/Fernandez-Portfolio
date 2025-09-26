<?php
session_start();
session_unset();    
session_destroy();  
header("refresh: 3; url=index.php");  // redirect to homepage
exit();
