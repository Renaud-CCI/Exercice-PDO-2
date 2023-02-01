<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des patients</title>
</head>
<body>
    <h2>Liste des patients de l'hopital</h2>
    <?php

        //---Ouverture BDD--------
        try
        {
            $db = new PDO('mysql:host=127.0.0.1;dbname=hospitalE2N;charset=utf8', 'root', '');
        }
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage());
        }


        $request = $db->query('SELECT * FROM patients ORDER BY lastname');

        $patients = $request->fetchAll();
        //Fin ouverture bdd

        
        foreach($patients as $patient){
            echo "<form action='profil-patient.php' method='post'>";
            echo "
            <input type='hidden' name = 'id' value = '$patient[id]'>
            <button type='submit'>" . $patient['lastname'] . " ". $patient['firstname'] . "</button><br><br>
            ";        
            echo "</form>";
        }

    ?>
    
    <br><hr><br>
    <button><a href="ajout-patient.php">Ajouter un patient</a></button>
    <br><br>
    <button><a href="index.php">Retour à l'index</a></button>

    <form action="profil-patient.php" method="post">
        
    </form>
</body>
</html>