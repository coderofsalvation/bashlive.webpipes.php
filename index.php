<?

// the index.php in the root always displays all available webpipe-urls

// display errors
if( isset($_GET['verbose']) ) ini_set("display_errors", 1); 
// get a rooturl
$rooturl  = "http://".$_SERVER['HTTP_HOST'];
$subdir   = $_SERVER['REQUEST_URI'];
$rooturl .= ($subdir[ strlen($subdir)-1 ] != "/") ? "/" : $subdir;
// trailing space to not lose POST-data because of apache 301 redirect
$trail    = strstr( $_SERVER['HTTP_HOST'], "appspot" ) ? "" : "/";
$webpipes = array();
$files = scandir( dirname(__FILE__) );
foreach ($files as $file) {
    if ($file === '.' or $file === '..' or $file === '.git' ) continue;
    if (is_dir($file)) $webpipes[]= $rooturl.$file.$trail;
}

printf("%s", implode("\n",$webpipes) );

?>
