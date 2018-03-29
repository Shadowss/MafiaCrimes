<?
  include( str_replace('//','/',dirname(__FILE__).'/') .'../config.php');
  define('DB_SERVER', $_CONFIG['hostname']);
  define('DB_SERVER_USERNAME', $_CONFIG['username']);
  define('DB_SERVER_PASSWORD', $_CONFIG['password']);
  define('DB_DATABASE', $_CONFIG['database']);
  define('ADMIN_USERS', 'parazitii');
// Additional administrators can be added by seperating admin usernames with commas.
?>