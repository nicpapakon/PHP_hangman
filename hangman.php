<?php
    session_start();
    $letters = ["Α", "Β", "Γ", "Δ", "Ε", "Ζ", "Η", "Θ", "Ι", "Κ", "Λ", "Μ", "Ν", "Ξ", "Ο", "Π", "Ρ", "Σ", "Τ", "Υ", "Φ", "Χ", "Ψ", "Ω"];
    $words = ["ΖΩΓΡΑΦΙΑ", "ΤΟΜΕΑΣ", "ΑΘΑΝΑΤΟΣ", "ΦΡΕΝΑΡΩ", "ΗΠΑΤΤΙΤΙΔΑ", "ΦΟΡΕΜΑ", "ΜΕΡΑ", "ΑΛΗΘΙΝΟΣ", "ΣΤΟΡΓΙΚΟΣ", "ΛΕΙΡΙ", "ΑΔΥΝΑΤΙΖΩ", "ΜΠΑΡΑ", "ΠΛΗΜΜΥΡΙΖΩ", "ΞΥΡΑΦΙ", "ΑΣΦΑΛΙΖΩ", "ΔΙΑΦΗΜΙΖΩ", "ΠΡΟΑΓΩ", "ΜΕΣΑ", "ΔΙΑΦΗΜΙΣΗ", "ΜΟΛΥΝΣΗ", "ΜΥΛΩΝΑΣ", "ΠΑΡΟΥΣΙΑΖΩ", "ΦΟΥΡΝΟΣ", "ΕΛΕΓΧΩ"];
    if (!isset($_SESSION['newword'])) $_SESSION['newword'] = true;
    if (!isset($_SESSION['letters'])) $_SESSION['letters'] = [];
    if (isset($_GET['letter'])) {
        array_push($_SESSION['letters'], $_GET['letter']);
    } else {       
        $_GET['letter'] = '';
        $_SESSION['letters'] = [];
        $_SESSION['tries'] = 7;
        $_SESSION['newword'] = true;      
    }

    if ($_SESSION['newword']) {
        $randIndex = array_rand($words);
        $_SESSION['word'] = $words[$randIndex];
        $_SESSION['newword'] = false; 
    }    

    $wordsarray = preg_split('//u',$_SESSION['word'], 0, PREG_SPLIT_NO_EMPTY);     
    if (isset($_GET['letter']) && !in_array($_GET['letter'], $wordsarray)) {
        $_SESSION['tries']--;
    }     

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>
    <span class="word">
    <?php 
        $found = true;
        foreach ($wordsarray as $i) {
            if(in_array($i, $_SESSION['letters'])) echo $i;
            else {
                echo '_';
                $found = false;
            }    
        }
    ?>
    </span>
    </h1>
    <h1>

    <?php foreach($letters as $index => $letter): ?>
        <?php if($index % 6 == 0) echo '<br>' ?>
        <?php if (in_array($letter, $_SESSION['letters'])): ?>
            <button class="btn btm-info"><?= $letter ?></button>
        <?php else: ?>    
            <a href="<?= $_SERVER['PHP_SELF'] ?>?letter=<?= $letter ?>"><button class="btn btn-info"><?= $letter ?></button></a>
        <?php endif ?>
    <?php endforeach ?>
    </h1>

    <h2>
    <?php
        if ($found) {
            echo 'Κερδίσατε!!';
            $_SESSION['newword'] = true;
        }
        else {
            if ($_SESSION['tries'] <= 0){
                $_SESSION['tries'] = 7;
                $_SESSION['letters'] = [];
                echo 'Δυστυχώς χάσατε... Η λέξη είναι η: ' .$_SESSION['word'];
                $_SESSION['newword'] = true;
            } else {
                echo 'Έχετε ακόμα '. $_SESSION['tries'] . ' από 6 προσπάθειες';  
            }
        }
    ?>
    </h2>

    <a href="<?php echo $_SERVER['PHP_SELF'] ?>"><button class="btn btn-primary">Νέο Παιχνίδι!!</button></a>

</div>
</body>
</html>