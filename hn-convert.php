<?php
// capture and pass any get variables
$page = $_GET["p"];
$source = "https://news.ycombinator.com/news";
if(isset($page)){
	$source .= "?p=" . $page;
}
// get the hacker news page
$string = file_get_contents($source);

// insert string1 into header
$string = str_replace("</head>", "<style>
#y-gif{-ms-transform: rotate(180deg); /* IE 9 */ -webkit-transform: rotate(180deg); /* Chrome, Safari, Opera */ transform: rotate(180deg);
</style></head>", $string);
// insert string2 into header
$string = str_replace("</head>", "<script src=\"//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script></head>", $string);
// insert string3 into header
$jqueryTargetBlank = "
	\$(document).ready(function() {
		\$(\"a[href^='http']:not([href^='http://www.mysite.com'])\").attr(\"target\",\"_blank\");
	});
";
$string = str_replace("</head>", "<script>$jqueryTargetBlank</script></head>", $string);

// replace relative css link with absolute link
$string = str_replace("href=\"news.css", "href=\"https://news.ycombinator.com/news.css", $string);
// replace next page link with link to "modified" next page
$nextPageString = "index.php?p=" . $nextPage;
$string = str_replace("news?p=", $nextPageString, $string);
// replace icon link
$string = str_replace("<img src=\"y18.gif\" width=\"18\" height=\"18\" style=\"border:1px #ffffff solid;\">",
	"<img id=\"y-gif\" src=\"https://news.ycombinator.com/y18.gif\" width=\"18\" height=\"18\" style=\"border:1px #ffffff solid;\">",
	$string);
$string = str_replace("â€™","&#39",$string);
// echo the modified HNews page
echo $string;
?>