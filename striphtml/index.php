<?

include_once("../webpipe.php");

die( $_SERVER['REQUEST_METHOD'] == "POST" ? servePost() : serveOptions() );
// every webpipe starts in the process function

process("<B>flop</B>");

function process( $input ){
  if( !$input ) return serveOptions();
  return trim( strip_tags($input) );
}

?>
