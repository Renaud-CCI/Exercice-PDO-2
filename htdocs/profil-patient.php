<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil des patients</title>
</head>
<body>
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

        //-----------SI Modification BDD-----------

    if (isset ($_POST['modify']) &&isset ($_POST['lastname']) && isset ($_POST['firstname']) && isset ($_POST['birthdate']) && isset ($_POST['phone']) && isset ($_POST['mail'])){
        if ($_POST['lastname'] && $_POST['firstname'] && $_POST['birthdate'] && $_POST['phone'] && $_POST['mail']){
            // Ecriture de la requête
            $sqlQuery = "UPDATE patients SET lastname=:lastname, firstname=:firstname, birthdate=:birthdate, phone=:phone, mail=:mail WHERE id = {$_POST['id']}";

            // Préparation
            $updatePatient = $db->prepare($sqlQuery);

            // Exécution 
            $updatePatient->execute([
                'lastname' => $_POST['lastname'],
                'firstname' => $_POST['firstname'],
                'birthdate' => $_POST['birthdate'],
                'phone' => $_POST['phone'],
                'mail' => $_POST['mail'],
            ]); 
            echo "<p>Les modifications ont bien été prises en compte</p>";
        }
    };
    //--------FIN Modification----------

    //-----SI suppression patient----

    if (isset ($_POST['delete'])){
            // Ecriture de la requête
            $sqlQuery = "DELETE FROM patients WHERE id=:id";

            // Préparation
            $deletePatient = $db->prepare($sqlQuery);

            // Exécution 
            $deletePatient->execute([
                'id' => $_POST['id'],
            ]); 
            echo "<p>Suppression achevée avec succès</p>";
    };

    //----------FIN Suppression patient--------



    //Création/Affichage profil patient----------------
    if (isset($_POST['id'])){
        $request = $db->query("SELECT * FROM patients WHERE id = {$_POST['id']}");

        $patients = $request->fetchAll(PDO::FETCH_ASSOC);

        require_once('alias.php');
        echo "
        <h1>Fiche patient n°{$_POST['id']}</h1>
        <br>
        <form action='profil-patient.php' method='post'>
            <input type='hidden' name='id' value='{$_POST['id']}'>
            ";

            foreach($patients as $patient){
                foreach  ($patient as $key => $info){
                    if ($key !== 'id'){
                        echo"
                        <p><label for='{$key}'>{$alias[$key][1]} </label><input type='{$alias[$key][0]}' name='{$key}' value='{$info}'></p>
                        ";
                        }
                }   
            };

            echo"
            <br>
            <button type='submit' name='modify'>Sauvegarder les modifications</button>

            <button type='submit' name='delete'>Supprimer le patient</button>
        </form>
        ";
    };
    echo"<br>";

    //----FIN Création/Affichage profil patient----------------
    // var_dump($_POST);






    ?>

    <br><hr><br>
    <button><a href="liste-patients.php">Retour Liste des patients</a></button>
    <br><br>
    <button><a href="index.php">Retour à l'index</a></button>

</body>
</html>