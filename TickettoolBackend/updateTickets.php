<?php
    require "PDO.php";


    $action = $_POST['action'];
    $id_ticket = $_POST['idTicket'];
    $id_utilisateur = $_POST['idUtilisateur'];
    if ($action == "assign") {
        $new_idEtat = 2;
        $new_idAction = 2;
    }
    if ($action == "solve") {
        $new_idEtat = 3;
        $new_idAction = 3;
    }
    if ($action == "delete") {
        $new_idEtat = 0;
        $new_idAction = 4;
    }

    updateTicket($new_idEtat, $id_ticket, $id_utilisateur, $new_idAction, $connect);

    function updateTicket($f_idEtat, $f_idTicket, $f_idUtilisateur, $f_idAction, $f_connect) {
        $query = "
        UPDATE ticket 
        SET id_etat = ".$f_idEtat."
        WHERE id = ".$f_idTicket.";
        INSERT INTO faire
        (id_Utilisateur, id_action, id_ticket)
        VALUES (".$f_idUtilisateur.", ".$f_idAction.", ".$f_idTicket.")
        ";
        $statement = $f_connect->prepare($query);
        $result = $statement->execute();
    }
?>