<?php

include("config.php");
include_once("lib/xmlDbConnection.class.php");


$myargs = $tamino_args;
$myargs{"debug"} = false;
$tamino = new xmlDbConnection($myargs);

$xquery = '<result>
{let $t := input()/TEI.2/teiHeader/fileDesc/titleStmt
return $t}
{for $a in input()/TEI.2//div
return <div>{$a/@id}{$a/@type}
{$a/head}
<parent>{$a/../@id}{local-name($a/..)}</parent>
</div>}
</result>';

$xsl = "contents.xsl"; 

$tamino->xquery($xquery);
$tamino->xslTransform($xsl);

print "<html>
  <head> 
    <link rel='stylesheet' type='text/css' href='merton.css'>
    <title>Merton's Red Diary : Contents</title> 
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'> 
    <base href='$base_url'> 
  </head> 
<body> 
";

include("nav.xml");
include("header.xml");
print "<div class='content'>";
$tamino->printResult();
print "</div>
    </body>
    </html>";

?>