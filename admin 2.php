<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="class.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&display=swap" rel="stylesheet"> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ADMIN</title>
</head>

<body>
	<header>
			<a display= 'center' href="index.php">play</a>
	</header>
<main>
	<div id="mainwrapper">
<?php 
$testarr = explode(' ',file_get_contents('mots.txt')); 
echo '<table>';
foreach ($testarr as $k => $words) {
	echo '<tr><td>'.$words.'<br/></td>';
    echo '<td><form method ="post" action="">   
            <input type="submit" value="supprimer" name="'.$words.'" /> 
        </form></div></td></tr>';
    if( $k == 0){
    	$first= $words;
    } else {
    	if(isset($_POST[$words])){
			 $deleted = implode(' ',array_diff($testarr,array($words)));
			 file_put_contents('mots.txt', $deleted);
			 header('Location:admin.php');
		}
    }
}

echo '</table>';


function cleanString($text) {
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   ' ', 
        '/[’‘‹›‚]/u'    =>   ' ',
        '/[“”«»„]/u'    =>   ' ', 
        '/ /'           =>   ' ', 
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}


?>
		<span>
			&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; 
		</span>
		<div id="addiv">
			<span> enter new word : </span>
		    <form method ="post">
		        <input type="text" name="letter" pattern="[A-Za-z]*" /> 
		    </form>  
		</div>
	</div> 
	<div id="subwrapper">
<?php 

if(isset($_POST['letter']) and !empty($_POST['letter'])){
	if(!strpos($_POST['letter'], ' ')){
		if(ctype_alpha($_POST['letter'])){  
			$text= implode(' ',$testarr);
			$addword=strtoupper(htmlspecialchars(cleanString($_POST['letter']))); 
				
			if( !strpos(file_get_contents('mots.txt'), (' '.$addword)) and 
				!strpos(file_get_contents('mots.txt'), ($addword.' ')) and
				$first !== $addword ){
				
				$text .= ' '.$addword;
				file_put_contents('mots.txt', $text);
				header('Location:admin.php');
			} else {
				echo '<span>mot invalide</span>';
			}
		} else {
			echo '<span>error</span>';
		}
	} else {
		echo '<span>error</span>';
	}
}

?>	
	<div>
</main>
	<footer>
	</footer>
</body>
</html>