<?

include_once("../webpipe.php");

die( $_SERVER['REQUEST_METHOD'] == "POST" ? servePost() : serveOptions() );
// every webpipe starts in the process function

function process( $input ){
  if( !$input ) return serveOptions();
  $delimiter = isset($_GET['delimiter']) ? $_GET['delimiter'] : ",";
  $arr = array();
  $lines = explode("\n", $input );
  foreach( $lines as $line ) $arr[] = str_getcsv( $line, $delimiter );
  return json_encode($arr);
}

?>
