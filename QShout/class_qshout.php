<?php
/**Author: Boris Ding P H 
 * Class Qshout, process queries
 */

// clear browser's cache
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/plain; charset=utf-8");
//Db connection is required
require_once('class_connect_db.php');

 class QshoutQuery extends QshoutDb{
  private $maxRow;
  
  public $ip; 
  public $user;
  public $message;
  public $url;

  public $pathToSmiley = 'smiley/';
  
  public function getChat(){
   $this->maxRow = $_GET["maxRow"];
   $sql = 'SELECT *, DATE_FORMAT(date_post,"%Y-%m-%d %k:%i %p") AS date_chat
           FROM
           tbl_qshout
           ORDER BY chat_id
           DESC
           LIMIT 0,'. $this->maxRow;
   $jsonData = '{"chat": {';
   
   $fetch = parent::$conn->query($sql);
   
   if( $fetch->fetchColumn() > 0 ){
   $jsonData .=  '"message":[';

   foreach( parent::$conn->query($sql) as $row ){
      $chat_id = $row['chat_id'];
      $user = stripslashes($row['user']);
      $message = stripslashes($row['message']);
      //replace double quotes, make sure is replaced with encoded %22 before JSON
      //for those who wanted to upgrade from v1.0
      $message = $this->replaceQuotes($message);
      $url = $row['url'];
      $date_post = $row['date_chat'];
      $ip = $row['ip'];

  $jsonData .= '{';
  $jsonData .= '"id": "' .$chat_id. '",';
  $jsonData .= '"user": "' . $user  . '",';
  $jsonData .= '"text": "' . $message . '",';
  $jsonData .= '"time": "' . $date_post  . '",';
  $jsonData .= '"url": "' . $url  . '",';
  $jsonData .= '"ip": "' . $ip  . '"';
  $jsonData .= '},';

    }//end foreach

   $jsonData = substr($jsonData,0,(strlen($jsonData)-1));
   $jsonData .= ']';
    }else{
      $jsonData .=  '"message":[]';
    }

  $jsonData .= '}}';
  echo $jsonData;
   }

   //inserting user inputs
   public function insertChat(){
   $sql = 'INSERT
           INTO
           tbl_qshout(user, message, url, ip, date_post)
	   VALUES ("'.$this->user.'", "'.$this->message.'",
                   "'.$this->url.'", "'.$this->ip.'", NOW())';
    $count = parent::$conn->exec($sql);
    if( $count == 1 ){
        echo 'done';
    }
  }
   
   //cleaning message
   public function clean($input){
     //remove extra white space
     $input = preg_replace('/\s\s+/', ' ', $input);    
     //detag input, remove backslashes from detagged, and escape by adding slashes.
     $detagged = strip_tags($input);
     $stripped = stripslashes($detagged);
     $escaped = addslashes($stripped);
	return $escaped;
     }

   //replace smiley
   public function replaceSmiley($msg){
     if( $msg != '' ){
       $sql = 'SELECT *
               FROM
               tbl_smiley';
       foreach( parent::$conn->query($sql) as $row ){
         $smiley = $row['smiley'];
         $desc = $row['desc'];
         $icon_name = $row['icon_name'];

         $msg = str_replace($smiley, '<img src='.$this->pathToSmiley.$icon_name.' title='.$desc.' />', $msg);
       }
       return $msg;
     }
   }

   //Parse http/https string and turn it into activated hyperlink
   public function parseStringToHTTP($input){
     return $nInput = eregi_replace("([[:alnum:]]+://[^[:space:]]*[[:alnum:]#?/&= +%_:]]*)",
                                "<a href='\\1' title='\\1'>@link</a>",$input);
    }

   //replace double quotes with '%22'
    public function replaceQuotes($input){
      return $replacedInput = str_replace('"', '%22', $input);
    }
  }
?>

<?php
//get db connection
   QshoutDb::connect();
//create class instance
   $obj = new QshoutQuery;
//check action
  if( isset($_POST['action']) && $_POST['action'] === 'send' ){
       $obj->ip = $_SERVER['REMOTE_ADDR']; 
       //replace double quote with single for user's name.
       $obj->user = str_replace('"', "'", $_POST['user']);
       $obj->user = $obj->clean($obj->user);
       //encode double quotes fetched from front-end
       //will be decode in front-end later
       $obj->message = $obj->replaceQuotes($_POST['message']);
       $obj->message = $obj->parseStringToHTTP($obj->clean($obj->message));
       $obj->message = $obj->replaceSmiley($obj->message);
       
       $obj->url = $_POST['url'];
       //insert
       $obj->insertChat();
       
   }else if( isset($_GET["action"]) && $_GET["action"] === "get" ){
     // retrieve chat
     $obj->getChat();
 }else{
   die("Failed to load Qshout!");
 }
?>
