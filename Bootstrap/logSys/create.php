<?php
if (isset($_POST['create'])) {
    try {
    $bdd = new PDO('mysql:host=localhost;dbname=id11453176_fisheyes;charset=utf8', 'id11453176_daniel43886', 'c=5CPBky');
} 
    catch (Exception $e) {
    die('Erreur : ' .$e->getMessage());
} 
    $user = $_POST['user'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $req = $bdd->prepare('SELECT COUNT(*) FROM users WHERE email = :email OR username = :username');
    $req->execute(array(
        'email' => $email,
        'username' => $user
    ));
    $donnee = $req->fetch();
    if ($donnee[0] != 0) {
        $req->closeCursor(); 
        header('location: ../index.php?userexistalready');
        exit();
    } else {
        $req = $bdd->prepare('INSERT INTO users(username, email, password) VALUES(:username, :email, :password)');
        $req->execute(array(
            'username' => $user,
            'email' => $email,
            'password' => $password
        ));
        $req->closeCursor(); 
        header('location: ../index.php?createsuccess');
    }
} else {
    header('location: ../index.php');
}