<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des rendez-vous</title>
</head>
<body>
    <h2>Liste des rendez-vous de l'hopital</h2>
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

        // 
        $request = $db->query(
            'SELECT appointments.id, DATE_FORMAT(dateHour,"%d/%m/%Y %Hh%i") AS niceDate, patients.lastname, patients.firstname
            FROM appointments 
            INNER JOIN patients ON appointments.idPatients = patients.id
            ORDER BY dateHour');
        $appointments = $request->fetchAll();
        //Fin ouverture bdd

        //-----Affichage RDV-----
        
        foreach($appointments as $appointment){
            echo "<form action='rendezvous.php' method='post'>";
            echo "
            <input type='hidden' name = 'id' value = '{$appointment['id']}'>
            <button type='submit'>
                <p>{$appointment['lastname']} {$appointment['firstname']}</p>
                <p>{$appointment['niceDate']}</p>
            </button><br><br>
            ";        
            echo "</form>";
        }

        //--------FIN Affichage RDV-----

    ?>
    
    <br><hr><br>
    <button><a href="ajout-rendezvous.php">Ajouter un rendez-vous</a></button>
    <br><br>
    <button><a href="index.php">Retour à l'index</a></button>

    <form action="profil-patient.php" method="post">
        
    </form>
</body>
</html>