<?php
    require "PDO.php";

    $data = array(
        ':email' => $_POST['email'],
        ':motDePasse' => $_POST['motDePasse']
    );

    $query = "
    SELECT COUNT(*) as nbUsers, id, nom, prenom, id_role
    FROM utilisateur
    WHERE email = :email
    AND motDePasse = :motDePasse
    ";
    $statement = $connect->prepare($query);
    $result = $statement->execute($data);
    $array = $statement->fetch();

    if ($result && $array['nbUsers'] == 1) {
        $user = array(
            "successful" => true,
            "id" => $array['id'],
            "nom" => $array['nom'],
            "prenom" => $array['prenom'],
            "role" => $array['id_role']
        );
    } else {
        $user = array(
            "successful" => false
        );
    };
    echo json_encode($user);
?>