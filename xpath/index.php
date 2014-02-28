<?

include_once("../webpipe.php");
die(servePost());

// function isFullRow( $arr, $columns, $index ){
//   $ok = array();
//   for( $i=0; $i < $columns; ; ){
// 
//   }
// 
// }

// function getXpaths( $input, $paths, $html = false, $striphtml = true ){
//   $output = ""; $i = 0;
//   $results = array();
//   $rows    = array();
//   $pathsArr = explode(",", $paths );
//   foreach( $pathsArr as $path )
//     $results[] = explode("\n",getXpath( $input, $path, $html, $striphtml ));
//   if( count($results) ){
//     for( $i = 0; $i < results[0] ; $i++ ){
//       $rows[$i] = array();
//       $rows[$output] .= $results[0]
//       for( $j = 0; $j < count($pathsArr); $j++ ){
//         
//       }
//       $output .= "\n";
//     }
//   }
//   $results = array_merge_recursive( $results
//   while( isFullRow( $results, count($paths), $i ) {
//   }isset($results[$i]) &&   ){
// 
//   }
// }

function getXpath( $input, $path, $html = false, $striphtml = true ){
  $dom = new DOMDocument();
  if( !$html ) $dom->loadXML($input);
  else $dom->loadHTML($input);
  $xpath = new DOMXpath($dom);
  $result = $xpath->query($path);
  $str = "";
  foreach( $result as $node ){
    $line = sanitizeString( $striphtml ? $node->nodeValue : $node->ownerDocument->saveHTML($node) );
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
  if( isset($_GET['manual']) ) return file_get_contents("specification.plain").file_get_contents("manual.plain");
  if( isset($_GET['dumppath']) ) return dumpXpath( $input, false, isset($_GET['html'])  );
  if( isset($_GET['dumppathvalues']) ) return dumpXpath( $input, true, isset($_GET['html']) );
  if( !isset($_GET['1']) ) return serveOptions();
  return getXpath( $input, $_GET['1'], isset($_GET['html']), !isset($_GET['source']) );
}

?>
