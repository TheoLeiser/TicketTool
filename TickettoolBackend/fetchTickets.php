<?php
    require "PDO.php";


    if (ISSET($_POST['idUtilisateur'])) {
        $id_Utilisateur = $_POST['idUtilisateur'];
    }
    $action = $_POST['action'];
    $querySelectInfosTicket = "
        SELECT ticket.id AS id, titre, contenu, etat.libelle AS etat, severite.libelle AS severite
        FROM ticket
        INNER JOIN etat ON etat.id = ticket.id_etat
        INNER JOIN severite ON severite.id = ticket.id_severite
        INNER JOIN faire ON faire.id_ticket = ticket.id
        WHERE id_etat != 0
        ";

    if ($action == "my") {
        $query = $querySelectInfosTicket."
        AND faire.id_action = 1
        AND faire.id_Utilisateur = ".$id_Utilisateur."
        ";
    }
    if ($action == "assigned") {
        $query = $querySelectInfosTicket."
        AND id_etat != 3
        AND faire.id_action = 2
        AND faire.id_Utilisateur = ".$id_Utilisateur."
        ";
    }
    if ($action == "waiting") {
        $query = $querySelectInfosTicket."
        AND id_etat = 1
        AND faire.id_Utilisateur != ".$id_Utilisateur."
        ";
    }
    if ($action == "all") {
        $query = "
        SELECT ticket.id AS id, titre, contenu, etat.libelle AS etat, severite.libelle AS severite
        FROM ticket
        INNER JOIN etat ON etat.id = ticket.id_etat
        INNER JOIN severite ON severite.id = ticket.id_severite
        WHERE id_etat != 0
        ";
    }

    $statement = $connect->prepare($query);
    $statement->execute();
    $array = $statement->fetchAll();

    echo json_encode($array);
?>