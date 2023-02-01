<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous</title>
</head>
<body>
    <h1>Ajouter un rendez-vous</h1>

    <?php
    //Ouverture bdd
    // var_dump($_POST);
    try
    {
        $db = new PDO('mysql:host=127.0.0.1;dbname=hospitalE2N;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
    //Fin ouverture bdd

    //Requete recherche patients
    $request = $db->query('SELECT id, lastname, firstname FROM patients ORDER BY lastname');

    $patients = $request->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($patients);
    echo"<br><br>";

    ?>

    <form action='ajout-rendezvous.php' method='post'>
        
        <label for='name-select'>Choisissez un patient :</label>
        <select name='idPatients'>
        <?php
        foreach ($patients as $patient){
            echo "<option value='{$patient['id']}'>{$patient['lastname']} {$patient['firstname']}</option>";
        }
        ?>
        </select>
        

        <?php
        require_once('alias.php');      

        echo"
        <p><label for='dateHour'>{$alias['dateHour'][1]} </label><input type='{$alias['dateHour'][0]}' name='dateHour'></p>

        <p><input type='submit' value='OK'></p>
        </form>
        "
        ?>

    <!-- ----END FORM---------- -->


    <!-- Mise à jour de la BDD--------- -->


    <?php
    // var_dump($_POST);

    try
    {
        $db = new PDO('mysql:host=127.0.0.1;dbname=hospitalE2N;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }

    if (isset ($_POST['idPatients']) && isset ($_POST['dateHour'])){
        if ($_POST['idPatients'] && $_POST['dateHour']){

            // Ecriture de la requête
            $sqlQuery = 'INSERT INTO appointments (idPatients, dateHour) VALUES (:idPatients, :dateHour)';

            // Préparation
            $insertPatient = $db->prepare($sqlQuery);

            // Exécution 
            $insertPatient->execute([
                'idPatients' => $_POST['idPatients'],
                'dateHour' => $_POST['dateHour'],
            ]); 
        } else {
            echo "<h2>Il manque une ou plusieurs valeurs à renseigner dans le formulaire</h2>";
        }
    }
    ?>

    <br><hr><br>
    <button><a href="index.php">Retour à l'index</a></button>
</body>
</html>