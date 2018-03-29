<?php 

if(!file_exists("config.php")) 
{ 
die("Configuration file not found !"); 
} 

if(!file_exists("footer.php")) 
{ 
die("Footer file not found !"); 
} 

if(!file_exists("lfooter.php")) 
{ 
die("Footer file not found !"); 
} 

require "config.php"; 

?>