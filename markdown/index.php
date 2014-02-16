<?

include_once("../webpipe.php");
include_once("Parsedown.php");

die( $_SERVER['REQUEST_METHOD'] == "POST" ? servePost() : serveOptions() );
// every webpipe starts in the process function

function process( $input ){
  if( !$input ) return serveOptions();
  return Parsedown::instance()->parse($input);
}

?>
