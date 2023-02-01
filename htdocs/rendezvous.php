<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche rendez-vous</title>
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

if (isset ($_POST['modify']) && isset ($_POST['idPatients']) && isset ($_POST['dateHour'])){
    if ($_POST['idPatients'] && $_POST['dateHour']){
        // Ecriture de la requête
        $sqlQuery = "UPDATE appointments 
            INNER JOIN patients ON appointments.idPatients = patients.id
            SET idPatients=:idPatients, dateHour=:dateHour
            WHERE appointments.id = {$_POST['id']}";

        // Préparation
        $updateRDV = $db->prepare($sqlQuery);

        // Exécution 
        $updateRDV->execute([
            'idPatients' => $_POST['idPatients'],
            'dateHour' => $_POST['dateHour'],
        ]); 
        echo "<p>Les modifications ont bien été prises en compte</p>";
    }
};

//--------FIN Modification----------

//-----SI suppression patient----

if (isset ($_POST['delete'])){
        // Ecriture de la requête
        $sqlQuery = "DELETE FROM appointments WHERE appointments.id=:id";

        // Préparation
        $deletePatient = $db->prepare($sqlQuery);

        // Exécution 
        $deletePatient->execute([
            'id' => $_POST['id'],
        ]); 
        echo "<p>Suppression achevée avec succès</p>";
        $_POST['id']=null;
};

//----------FIN Suppression patient--------



//Création/Affichage profil patient----------------

// var_dump($_POST);

if (isset($_POST['id']) && $_POST['id']){
    $request = $db->query("SELECT appointments.id, appointments.dateHour, appointments.idPatients, CONCAT(patients.lastname, ' ', patients.firstname) AS groupedName 
    FROM appointments 
    RIGHT JOIN patients ON appointments.idPatients = patients.id");

    $appointments = $request->fetchAll(PDO::FETCH_ASSOC);


    echo "<h1>Fiche rendez-vous n°{$_POST['id']}</h1>

        <br>
    <form action='rendezvous.php' method='post'>
        <input type='hidden' name='id' value='{$_POST['id']}'>

        <label for='idPatients'>Patient :</label>
        <select name='idPatients'>
        ";

        
        // foreach ($appointments as $appointment){

        //         if ($appointment['id'] == $_POST['id']){
        //             echo "<option value='{$appointment['idPatients']}' autofocus='autofocus'>{$appointment['groupedName']}</option>";
        //         } else {
        //             echo "<option value='{$appointment['idPatients']}'>{$appointment['groupedName']}</option>";
        //         }
        //     };
        foreach ($appointments as $appointment){

                if ($appointment['id'] == $_POST['id']){
                    echo "<option value='{$appointment['idPatients']}' autofocus='autofocus'>{$appointment['groupedName']}</option>";
                }
            };
        echo"</select>";

        foreach($appointments as $appointment){
            foreach ($appointment as $key => $info){
                if ($appointment['id'] == $_POST['id'] && $key == 'dateHour'){
                    require_once('alias.php');
                    echo"
                    <p><label for='{$key}'>{$alias[$key][1]} </label><input type='{$alias[$key][0]}' name='{$key}' value='{$info}'></p>
                    ";
                }
            }
        };
        ?>
        <?php

        echo"
        <br>
        <button type='submit' name='modify'>Sauvegarder les modifications</button>

        <button type='submit' name='delete'>Supprimer le rendez-vous</button>
    </form>
        ";
};
echo"<br>";
// var_dump($_POST);

//----FIN Création/Affichage profil patient----------------
// var_dump($_POST);






?>

    <br><hr><br>
    <button><a href="liste-rendezvous.php">Retour Liste des rendez-vous</a></button>
    <br><br>
    <button><a href="index.php">Retour à l'index</a></button>

</body>
</html>