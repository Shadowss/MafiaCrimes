<?php
/**Author: Boris Ding P H 
 * Class to connect MySQL Database
 * Using PHP's PDO
 */
class QshoutDb{
   //database info
   static $hname = 'localhost';
   static $dbname = 'qshout_db';
   static $username = 'root';
   static $password = '';
   static $conn;

   static public function connect() {   
     try{
        self::$conn = new PDO('mysql:host='.self::$hname.';dbname='.self::$dbname,
                         self::$username,
                         self::$password);         
      }catch(PDOException $e){
          echo $e->getMessage();
      }
     }
   }
?>

