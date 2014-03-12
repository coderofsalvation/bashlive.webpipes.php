<?

include_once("../webpipe.php");
include_once('php-selector/selector.inc');

die(servePost());
// every webpipe starts in the process function
  
function process( $input = ""){
  if( !isset($_GET['1']) ) return serveOptions();
  $output = isset($_GET['output']) ? $_GET['output'] : "json";
  $result = "";
  switch($output){
    case "json":  $result = select_elements($_GET['1'],$input); break;
    case "xpath": return selector_to_xpath($_GET['1']); break;
  }
  $result = isset($_GET['source']) ? convertToSource($result) : json_encode( (object)array("items"=>$result) );
  return $result;
}

function convertToSource($result){
  $tmp = array();
  foreach( $result as $k => $v ) $tmp[] = $v;
  return json_encode($tmp);
}

?>
