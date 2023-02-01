<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout patient</title>
</head>
<body>
    <!-- ---- FORM---------- -->
    <h1>Creer un nouveau patient</h1>
    <form action="ajout-patient.php" method="get">
        <?php
        require_once('alias.php');

        foreach($alias as $key => $values){
            if($key !== 'dateHour'){
                echo"
                <p><label for='{$key}'>{$values[1]} </label><input type='{$values[0]}' name='{$key}'></p>
                ";
            }
        }
        echo"<p><input type='submit' value='OK'></p>";
        ?>
    </form>
    <!-- ----END FORM---------- -->


    <!-- Mise à jour de la BDD--------- -->


    <?php
    try
    {
        $db = new PDO('mysql:host=127.0.0.1;dbname=hospitalE2N;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
    if (isset ($_GET['lastname']) && isset ($_GET['firstname']) && isset ($_GET['birthdate']) && isset ($_GET['phone']) && isset ($_GET['mail'])){
        if ($_GET['lastname'] && $_GET['firstname'] && $_GET['birthdate'] && $_GET['phone'] && $_GET['mail']){

            // Ecriture de la requête
            $sqlQuery = 'INSERT INTO patients(lastname, firstname, birthdate, phone, mail) VALUES (:lastname, :firstname, :birthdate, :phone, :mail)';

            // Préparation
            $insertPatient = $db->prepare($sqlQuery);

            // Exécution 
            $insertPatient->execute([
                'lastname' => $_GET['lastname'],
                'firstname' => $_GET['firstname'],
                'birthdate' => $_GET['birthdate'],
                'phone' => $_GET['phone'],
                'mail' => $_GET['mail'],
            ]);
            echo "<p>Les modifications ont bien été prises en compte</p>"; 
        } else {
            echo "<h2>Il manque une ou plusieurs valeurs à renseigner dans le formulaire</h2>";
        }
    }
    ?>

    <br><hr><br>
    <button><a href="index.php">Retour à l'index</a></button>
    <br><br>
    <button><a href="liste-patients.php">Afficher la liste des patients</a></button>
</body>
</html>

