<?

include_once("../webpipe.php");

die( $_SERVER['REQUEST_METHOD'] == "POST" ? servePost() : serveOptions() );
// every webpipe starts in the process function

function process( $input ){
  if( $_SERVER['CONTENT_TYPE'] != "application/json" ) $input = json_decode($input);
  if( !$input ) return "invalid input";
  return print_r($input,true);
}

?>
