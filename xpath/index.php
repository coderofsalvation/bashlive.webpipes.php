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
    $line = sanitizeString( $node->nodeValue );
    if( strlen($line) ) $str .= $line."\n";
  }
  return $str;
}

function sanitizeString( $str ){
  $line = trim( preg_replace( '/\s+/', ' ', $str ) );
  $line = str_replace(array("\n","\t","\r"), "", $line );
  return $line;
}

function dumpXpath( $input, $values = false, $html = false ){
  $dom = new DOMDocument();
  if( !$html ) $dom->loadXML($input);
  else $dom->loadHTML($input);
  $str = ""; $xpathsize = 0;
  // Print XPath for each element
  foreach ($dom->getElementsByTagName('*') as $node) 
    $str .= $values ? sprintf("%s ::: %s\n",$node->getNodePath(),sanitizeString($node->nodeValue))
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
