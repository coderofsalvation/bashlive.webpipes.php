<?

include_once("../webpipe.php");

die( $_SERVER['REQUEST_METHOD'] == "POST" ? servePost() : serveOptions() );
// every webpipe starts in the process function

function process( $input ){
  if( $_SERVER['CONTENT_TYPE'] != "application/json" ) $input = json_decode($input);
  if( !$input ) return "invalid input";

  $f = fopen('php://output', 'w');
  $firstLineKeys = 
  $i=0;
  ob_start();
  $delimiter = isset($_GET['delimiter']) ? $_GET['delimiter'] : ",";
  foreach ($input as $line){
    if( ++$i == 1 && isset($_GET['ignorecolumns']) ) continue;
    fputcsv($f, $line, $delimiter); 
  }
  $str = ob_get_contents();
  ob_end_clean();
  return $str;
}

?>
