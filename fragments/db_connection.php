<?php
 
// DATABASE connection script  
 
// database Connection variables
if ($_SERVER['HTTP_HOST'] == 'k1-cptools.rhcloud.com')  {
define('HOST', getenv('OPENSHIFT_MYSQL_DB_HOST')); // Database host name ex. localhost
define('USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME')); // Database user. ex. root ( if your on local server)
define('PASSWORD', getenv('OPENSHIFT_MYSQL_DB_PASSWORD')); // Database user password  (if password is not set for user then keep it empty )
define('DATABASE', getenv('OPENSHIFT_GEAR_NAME')); // Database name
define('CHARSET', 'utf8');	
}
else  {
define('HOST', 'localhost'); // Database host name ex. localhost
define('USER', 'root'); // Database user. ex. root ( if your on local server)
define('PASSWORD', 'root.t3sn'); // Database user password  (if password is not set for user then keep it empty )
define('DATABASE', 'k1'); // Database name
define('CHARSET', 'utf8');	

//define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));

}


function DB()
{
    static $instance;
    if ($instance === null) {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE,
        );
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=' . CHARSET;
        $instance = new PDO($dsn, USER, PASSWORD, $opt);
    }
    return $instance;
}
 
?>