
<?php 

session_start();

?>
<!DOCTYPE html>
<html>
 <head>
 <title> pendu </title>
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&display=swap" rel="stylesheet"> 
 <meta name="viewport" content="width=device-width, initial-scale=0.5">
 </head>
 <link rel="stylesheet" type="text/css" href="class.css">
 <body onload="document.getElementById('letter').focus()"> 
    <main>
<?php 

if(isset($_SESSION['erreur'])){
   
} else {
    $_SESSION['erreur']=0;
}

$str = file_get_contents('mots.txt');
$result = explode(' ',$str); 
$result = $result[array_rand($result)];
$_SESSION["words"]=$result;

if(!isset($_SESSION["display"])){
    $_SESSION["Cword"] = str_split($_SESSION["words"]);
    foreach($_SESSION["Cword"] as $word){
        $_SESSION["display"][]="";
    }
}

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

$i = 0;

if(isset($_POST["letter"])){
    $letters=$_POST["letter"];
    $letters=htmlspecialchars(cleanString($letters)); 
    $OK = false;
    foreach($_SESSION["Cword"] as $wletter){
        if(strtoupper($letters) == $wletter){
            $_SESSION["display"][$i] = $wletter;
            $OK = true;
        }
        $i++;
    }
    if($OK==false){
        $_SESSION["erreur"]++;
    }
}


if($_SESSION['erreur']==6){
    $_SESSION["display"]=$_SESSION["Cword"];
}


if(isset($_POST["newgame"])||$_SESSION["erreur"] >6){
    session_destroy();
    header('Location: index.php');
}

?>
<div class="TTC">  
    <div class='newgame'> 
        <form method ="post" action="">   
                <input type="submit" value="ADMIN" name="admin" class="memory"> </input> 
        </form> 
    </div>
</div>
<div class="game">

<?php 

if(isset($_POST['admin'])){
    echo  '<div class="divvic"><form action="" method="post">
            <input type="text" name="login" placeholder="login" required><br><br>
            <input type="password" name="password" placeholder="password" required><br><br>
            <input type="submit" name="enter" value="enter">
        </form></div>';
}
if( (isset($_POST['login']) and !empty($_POST['login'])) and 
    (isset($_POST['password']) and !empty($_POST['password'])) ){ 
    $login=htmlspecialchars($_POST['login']);
    $password=htmlspecialchars($_POST['password']);
    if($login === 'admin' and $password === 'admin'){
        echo '<a href="admin.php"><h1> gerer les mots</h1></a>';
    } else {
        echo '<span>erreur login</span>';
    }
}


if($_SESSION['erreur']==6){
    echo  '<div class="divvic"><h1>PERDU!!!</h1><br>';
   
}


$k=0;
$cword= (sizeof($_SESSION['Cword'])) -1 ;
for($n = 0; $n<=$cword;$n++){
    if($_SESSION['display'][$n] == $_SESSION['Cword'][$n]){
        $k++;
    }
}


if($k == ($cword + 1) and $_SESSION["erreur"]<6){
    echo '<div class="divvic"><h1>VICTOIRE!!!</h1>';
    echo"<img src='hangman/hangman8.gif'>";
    echo '<form method ="post" action="">
          <input type="submit" value="nouvelle partie" name="newgame" class="memory"> </input>
        </form></div> ';
    echo '<style> #letter{ pointer-events:none; }</style> ';

}

if(isset($_POST['letter'])){
    $_SESSION['options'][]= $_POST['letter'];
    echo '<h2> Déjà essayé </h2>';
    echo '<h3>';
    foreach($_SESSION['options']as $k => $v){
    echo strtoupper($v).' ';
    }
    echo '</h3>';
}

?>
<div class ="container">
    <div class ="socle">
   
        <?php 
        if($_SESSION['erreur']==0){
            echo"<img src='hangman/hangman0.gif'>";}

        if($_SESSION['erreur']==1){
            echo "<img src='hangman/hangman1.gif'>";}
            ?>
        <div class="tronc"> 
            <div class="one">
            <?php 
        if($_SESSION['erreur']==2 ){
            echo "<img src='hangman/hangman2.gif'>";}
            ?>            </div> 
            <div class="two">
            <?php 
        if($_SESSION['erreur']==3){
            echo "<img src='hangman/hangman3.gif'>";}
            ?>            </div> 
            <div class="three">
            <?php 
        if($_SESSION['erreur']==4){
            echo "<img src='hangman/hangman4.gif'>";}
            ?>            </div> 
        </div>
        <div class="legs">         
        <?php 
        if($_SESSION['erreur']==5){
            echo "<img src='hangman/hangman5.gif'>";}
        if($_SESSION['erreur']==6){
            echo "<img src='hangman/hangman7.gif'>";}
            ?>        
        </div>
    </div>
</div>
<div class='newgame'>
<?php 

if($_SESSION['erreur'] < 6){
   
    echo  '<form method ="post"><input type="text" name="letter" id="letter" maxlength="1" >  </input> </form>';
}


?>
</div>
<?php

echo "<div class='text'> ";



for($n = 0; $n<=isset($_SESSION["Cword"][$n]);$n++){
$_SESSION["display"][]="";
$val = $_SESSION["display"][$n];
    if($_SESSION["display"][$n] == $val){
        echo '<div class="divletter">'.$_SESSION["display"][$n].'</div>';
    } else {
        echo '<div class="divletter"></div>';
    }
}

echo "</div>"; 

?>

</div>

<div class="memory">  <div class='newgame'> 
     <form method ="post" action="">   
        <input type='submit' value='nouvelle partie' name='newgame'> </input> 
    </form>   

</div> 
</div>
</main>
<footer>

</footer>
</body>
</html>
