<?

include_once("../webpipe.php");
die(servePost());

function getXpath( $input, $path, $html = false ){
  $dom = new DOMDocument();
  if( !$html ) $dom->loadXML($input);
  else $dom->loadHTML($input);
  $xpath = new DOMXpath($dom);
  $result = $xpath->query($path);
  $str = "";
  foreach( $result as $node ){
    $line = trim( preg_replace( '/\s+/', ' ', $node->nodeValue) );
    $line = str_replace(array("\n","\t","\r"), "", $line );
    if( strlen($line) ) $str .= $line."\n";
  }
  return $str;
}

function dumpXpath( $input, $values = false, $html = false ){
  $dom = new DOMDocument();
  if( !$html ) $dom->loadXML($input);
  else $dom->loadHTML($input);
  $str = ""; $xpathsize = 0;
  // Print XPath for each element
  foreach ($dom->getElementsByTagName('*') as $node) 
    $str .= $values ? sprintf("%s ::: %s\n",$node->getNodePath(),$node->nodeValue)
                    : sprintf("%s\n",$node->getNodePath());
  return $str;
}

function process( $input ){

  if( isset($_GET['dumppath']) ) return dumpXpath( $input, false, isset($_GET['html'])  );
  if( isset($_GET['dumppathvalues']) ) return dumpXpath( $input, true, isset($_GET['html']) );
  if( !isset($_GET['1']) ) return serveOptions();
  return getXpath( $input, $_GET['1'], isset($_GET['html'])  );
}

?>
