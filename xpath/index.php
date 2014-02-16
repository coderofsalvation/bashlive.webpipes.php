<?

include_once("../webpipe.php");
die(servePost());

function getXpath( $input, $path ){
  $xml = new SimpleXMLElement( $input );
  $result = $xml->xpath($path);
  $str = "";
  foreach( $result as $node ) 
    $str .= (string)$node."\n";
  return $str;
}

function dumpXpath( $input, $values = false ){
  $dom = new DOMDocument();
  $dom->loadXML( $input );
  $str = ""; $xpathsize = 0;
  // Print XPath for each element
  foreach ($dom->getElementsByTagName('*') as $node) 
    $str .= $values ? sprintf("%s ::: %s\n",$node->getNodePath(),$node->nodeValue)
                    : sprintf("%s\n",$node->getNodePath());
  return $str;
}

function process( $input ){
  if( isset($_GET['dumppath']) ) return dumpXpath( $input );
  if( isset($_GET['dumppathvalues']) ) return dumpXpath( $input, true );
  if( !isset($_GET['1']) ) return serveOptions();
  return getXpath( $input, $_GET['1'] );
}

?>
