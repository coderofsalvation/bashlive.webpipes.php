<?

include_once("../webpipe.php");
include_once("jsonpath.php");

die(servePost());

function process( $input ){
  if( $_SERVER['CONTENT_TYPE'] != "application/json" ){
    $input = str_replace("\n","", $input );
    $input = (array)json_decode($input);
  }
  if( isset($_GET['manual']) ) return file_get_contents("specification.plain").file_get_contents("manual.plain");
  if( !isset($_GET['1']) ) return serveOptions();
  $path = $_GET['1'];
  $opts = isset($_GET['dumppath']) ? array("resultType"=>"PATH") : null;
  $result = jsonpath( $input, $path, $opts );
  return is_string($result) ?  implode("\n", $result ) : json_encode($result);
}

?>
