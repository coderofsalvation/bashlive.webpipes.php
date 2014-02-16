<?

include_once("../webpipe.php");

die( $_SERVER['REQUEST_METHOD'] == "POST" ? servePost() : serveOptions() );
// every webpipe starts in the process function

function to_link($string){ 
  return preg_replace("~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~", '<a href="$1://$2">$1://$2</a>$3',$string); 
} 

function to_target($input){
  if( !isset($_GET['target']) ) return $input;
  return str_replace("a href=", "a target='".$_GET['target']."' href=", $input );
}
  
function process( $input ){
  if( !$input ) return serveOptions();
  return to_target( to_link($input) );
}

?>
