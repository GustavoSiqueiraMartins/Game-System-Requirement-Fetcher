<!DOCTYPE html>

<!--
Game minimum system requirements api by 
Shivram N Gowtham
CSE 1st yr
IIT Guwahati
-->



<html lang="en">
<head>
<title>GAME API</title>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<strong>Game:</strong> <input type="text" name="game_name" />
	 <input type="submit" name="submit" value="Submit"> 
	</form>
	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$name=$_POST["game_name"];
		if($name=='') exit("enter a game name");
		$query = $name.' system requirements';
		$url = "https://in.search.yahoo.com/search?p=".str_replace(' ', '+',$query)."&fr=yfp-t-100";
		$auth = base64_encode('shivram.gowtham:GCvd5AU7');
		$aContext = array(
		    'http' => array(
			'proxy' => 'tcp://202.141.80.24:3128',
			'request_fulluri' => true,
			'header' => "Proxy-Authorization: Basic $auth",
		    ),
		);
		$cxContext = stream_context_create($aContext);
		$html= file_get_contents($url, False, $cxContext);
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		$position=-1;$reqlink="";
		for ($i = 0; $i < $hrefs->length; $i++) {
			$href = $hrefs->item($i);
			$link = $href->getAttribute('href');
			if(strpos($link,"www.game-debate.com/games/index.php?g_id=")==true) {
				$position=1;
				$reqlink=$link;
				break;
			}	
		}
		if($position==-1) exit("game not found..sorry :(");
		$gamepage=file_get_contents($reqlink, False, $cxContext);
		$dompage = new DOMDocument();
		@$dompage->loadHTML($gamepage);
		$xpathpage = new DOMXPath($dompage);
		$hrefspage = $xpathpage->evaluate("/html/body//a");
		$it=0;$data_present=0;$game_orig_name="";
		while ($it < $hrefspage->length) {
			$hrefpage = $hrefspage->item($it);
			$linktitle = $hrefpage->getAttribute('title');
			$vv=strpos($linktitle,"Gaming CPU Can play");$vv--;
			if($vv==true) {
				echo '<br><strong><font color="blue">';
				for($j=$vv+20;$j<strlen($linktitle);$j++) $game_orig_name=$game_orig_name.$linktitle[$j];
				echo $game_orig_name;
				echo '   Minimum System Requirements:</strong></ font><br> <br>';
				echo '<strong><font color="red">INTEL CPU:</font></strong> '.substr($linktitle,0,$vv).'<br>';
				$data_present=1;
				break;
			}
			$it++;	
		}
		if(!$data_present) exit("no data available on the game probably a very old one :(");
		$it++;
		while ($it < $hrefspage->length) {
			$hrefpage = $hrefspage->item($it);
			$linktitle = $hrefpage->getAttribute('title');
			$vv=strpos($linktitle,"Gaming CPU Can play");$vv--;
			if($vv==true) {echo '<strong><font color="red">AMD CPU:</font></strong> '.substr($linktitle,0,$vv).'<br>';break;}
			$it++;
		}
		$it++;
		while ($it < $hrefspage->length) {
			$hrefpage = $hrefspage->item($it);
			$linktitle = $hrefpage->getAttribute('title');
			$vv=strpos($linktitle,"Gaming CPU Can play");$vv--;
			if($vv==true) {echo '<strong><font color="red">NVIDIA GPU: </font></strong>'.substr($linktitle,0,$vv).'<br>';break;}
			$it++;
		}
			$it++;
		while ($it < $hrefspage->length) {
			$hrefpage = $hrefspage->item($it);
			$linktitle = $hrefpage->getAttribute('title');
			$vv=strpos($linktitle,"Gaming CPU Can play");$vv--;
			if($vv==true) {echo '<strong><font color="red">AMD GPU:</font> </strong>'.substr($linktitle,0,$vv).'<br>';break;}
			$it++;
		}
		$spanspage = $xpathpage->evaluate("/html/body//span");
		$it_span=0;
		while ($it_span < $spanspage->length) {
			$spanpage = $spanspage->item($it_span);
			$spantitle = $spanpage->getAttribute('title');
			$vv=strpos($spantitle,"RAM Requirement");
			if($vv==true) {echo '<strong><font color="red">RAM: </font></strong>'.$spanpage->nodeValue.'<br>';break;}
			$it_span++;	
		}
	
		$it_span++;
		while ($it_span < $spanspage->length) {
			$spanpage = $spanspage->item($it_span);
			$spantitle = $spanpage->getAttribute('title');
			$vv=strpos($spantitle,"Direct X Requirement");
			if($vv==true) {echo '<strong><font color="red">DIRECT X:</font></strong> '.$spanpage->nodeValue.'<br>';break;}
			$it_span++;
		}
		$it_span++;
		while ($it_span < $spanspage->length) {
			$spanpage = $spanspage->item($it_span);
			$spantitle = $spanpage->getAttribute('title');
			$vv=strpos($spantitle,"Hard Disk Drive Space Requirement");
			if($vv==true) {echo '<strong><font color="red">HARD DISK SPACE:</font></strong> '.$spanpage->nodeValue.'<br>';break;}
			$it_span++;
		}
		while ($it_span < $spanspage->length) {
			$spanpage = $spanspage->item($it_span);
			$spantitle = $spanpage->getAttribute('title');
			$vv=strpos($spantitle,"Operating System Requirement");
			if($vv==true) {echo '<strong><font color="red">OS:</font> </strong>'.$spanpage->nodeValue.'<br>';break;}
			$it_span++;
		}
		$it_span++;
	}
	?>
</body>
</html>
