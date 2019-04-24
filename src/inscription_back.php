<?php
    // headers
    header("Content-Type: application/json; charset=UTF-8");

    // check HTTP method
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    if($method !== 'post') {
        http_response_code(405);
        echo json_encode(array('message' => 'This method is not allowed.'));
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);

    // Check si paramètres remplis
    if(!isset($data['pseudo']) || empty($data['pseudo'])){
        http_response_code(400);
        echo json_encode(array('message' => 'Missing pseudo.'));
        exit();
    }
    if(!isset($data['mdp']) || empty($data['mdp'])){
        http_response_code(400);
        echo json_encode(array('message' => 'Missing password.'));
        exit();
    }

    include_once "../data/MyPDO.projet-php-dictature.include.php";
        
    // Vérification du pseudo unique
    $prep = $db->prepare("SELECT * FROM `joueur` WHERE joueur.pseudo = :pseudo");
    $prep->bindValue(':pseudo', $data['pseudo']);
    if($prep->execute()) {
        while($res = $prep->fetch(PDO::FETCH_ASSOC)){
            http_response_code(400);
            echo json_encode(array('message' => 'Pseudo already existant.'));
            exit();
        }
    } else {
        die("Execute query error, because: ". print_r($db->errorInfo(),true) );
    }
        
    //on insere les données pseudo, mail et mdp dans la table Joueur
    $query = $db->prepare("INSERT INTO `joueur` (`pseudo`,`mail`,`mdp`) VALUES (:pseudo, :mail, :mdp)");
    $query->bindParam(':pseudo', $data['pseudo']);
    $query->bindParam(':mail', $data['mail']);
    $query->bindParam(':mdp', md5($data['mdp']));
    $query->execute();

    echo json_encode(array('message' => 'Done.'));
    exit();
?>