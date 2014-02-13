<?

// the index.php in the root always displays all available webpipe-urls

$rooturl  = str_replace("//","/", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/" );
$webpipes = array();
$files = scandir( dirname(__FILE__) );
foreach ($files as $file) {
    if ($file === '.' or $file === '..' or $file === '.git' ) continue;
    if (is_dir($file)) $webpipes[]= $rooturl.$file."/"; // trailing space to not lose POST-data because of 301 redirect
}
printf("%s", implode("\n",$webpipes) );

?>
