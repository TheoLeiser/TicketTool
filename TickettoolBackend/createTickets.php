<?php
    require "PDO.php";


    if ($_POST['severite'] == "FATAL") {
        $id_severite = 1;
    } else if ($_POST['severite'] == "ERROR") {
        $id_severite = 2;
    } else {
        $id_severite = 3;
    }
    $data = array(
        ':idUtilisateur' => $_POST['idUtilisateur'],
        ':titre' => $_POST['titre'],
        ':contenu' => $_POST['contenu'],
        ':id_severite' => $id_severite
    );
    
    $query = "
    INSERT INTO ticket
    (titre, contenu, id_etat, id_severite)
    VALUES (:titre, :contenu, 1, :id_severite);
    INSERT INTO faire
    (id_Utilisateur, id_action, id_ticket, date)
    VALUES (:idUtilisateur, 1, (SELECT MAX(id) FROM ticket), NOW())
    ";

    $statement = $connect->prepare($query);
    $result = $statement->execute($data);
?>