<?

include_once("../webpipe.php");

die( $_SERVER['REQUEST_METHOD'] == "POST" ? servePost() : serveOptions() );
// every webpipe starts in the process function

function process( $input ){
  if( !$input ) return serveOptions();
  echo xmlToNative($input);
}

/**
 * jsonPrepareXml makes sure nodevalues will not override attributes during dataconversion
 * 
 * @param mixed $domNode 
 * @access public
 * @return void
 */
function prepareXml( $domNode ){
  foreach( $domNode->childNodes as $node)
    if($node->hasChildNodes()) prepareXml($node);
  if( $domNode->hasAttributes() && strlen($domNode->nodeValue) ){
    $domNode->setAttribute("nodeValue", $node->textContent );
    $node->nodeValue = "";
  }
  return $node;
}

/**
 * xmlToNative 
 * 
 * @param mixed $xmlStr
 * @access public
 * @return void
 */
function xmlToNative( $xmlStr ){
  $dom = new DOMDocument();
  $dom->loadXML( $xmlStr );
  prepareXML($dom);
  $sxml = simplexml_load_string( $dom->saveXML(), "SimpleXMLElement", LIBXML_NOCDATA );
  $items = json_decode( json_encode( $sxml ) );
  # array fix ( 1 element vs more )
  foreach( $items as $k => $v ) if( !is_array($v) )$items->$k = array($v);
  return json_encode($items);
}


?>
