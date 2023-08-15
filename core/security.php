<?php

/**
 * Traitement du formulaire de connexion
 *
 * @return void
 */
function connect()
{
    //soit l'uti
    if (isset($_POST['connexion']) && $_POST['connexion'] === 'connect') {
        session_destroy();
        if (isset($_POST['user']) && isset($_POST['password'])) {
            if (search_user($_POST['user'], $_POST['password']) === true) {
                session_start();
                $_SESSION['user'] = true;
                header('location: http://localhost:4000/index.php?page=accueil');
            }
        }
    } elseif (isset($_SESSION['user']) && $_SESSION['user'] === true) {
        header('location: http://localhost:4000/index.php?page=accueil');
    } else {
        session_destroy();
    }
}

/**
 * Vérifie que l'utilisateur est connecté
 *
 * @return boolean
 */
function is_connected()
{
    session_start();
    if (isset($_SESSION['user']) && $_SESSION['user'] === true) {
        return true;
    }
    session_destroy();
    return false;
}

/**
 * Déconnecte l'utilisateur
 *
 * @return void
 */
function disconnect()
{
    if (isset($_SESSION['user'])) {
        session_destroy();
    }
}

/**
 * Lit le fichier des utilisateurs
 *
 * @return mixed
 */
function read_users()
{
    if ($fp = fopen(dirname(__FILE__) . '/../src/datas/users.csv', 'r')) {
        while ($user = fgetcsv($fp, null, ';')) {
            $return[$user[0]] = $user[1];
        }
        fclose($fp);
        return $return;
    } else {
        echo 'Erreur pendant l\'ouverture du fichier<br>';
    }
}

/**
 * Cherche un utilisateur dans le fichier users.csv avec nom d'utilisateur et mdp
 *
 * @param string $name le nom d'utilisateur
 * @param string $pwd le mot de passe de l'utilisateur
 * @return void
 */
function search_user($name, $pwd)
{
    $users = read_users();
    if (is_array($users) && array_key_exists($name, $users) &&  password_verify($pwd, $users[$name])) {
        return true;
    }
    return false;
}

/**
 * Traitement du formulaire de création d'un utilisateur
 *
 * @return void
 */
function createUser()
{
    $errors = [];
    if (isset($_POST['submit']) && $_POST['submit'] === "createUser") {
        if (isset($_POST['user']) && $_POST['user'] !== '') {
            if (isset($_POST['password']) && $_POST['password'] !== '') {
                if (isset($_POST['confirmPassword']) && $_POST['password'] === $_POST['confirmPassword']) {
                    $user = search_user_by_name($_POST['user']);
                    if ($user === true) {
                        $errors[] = "Le nom d'utilisateur est déjà utilisé";
                    } else {
                        if (save_user($_POST['user'], $_POST['password'])) {
                            echo "L'utilisateur est bien enregistré!";
                        } else {
                            $errors[] = "Un problème est survenu lors de l'enregistrement de l'utilisateur.<br>";
                        }
                    }
                } else {
                    $errors[] = "Les mots de passe doivent correspondre<br>";
                }
            } else {
                $errors[] = "Le mot de passe est obligatoire<br>";
            }
        } else {
            $errors[] = "Le champ utilisateur est obligatoire";
        }
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error;
        }
    }
}

/**
 * Recherche un utilisateur en fonction de son nom
 *
 * @param string $name le nom à rechercher
 * @return boolean
 */
function search_user_by_name($name)
{
    $users = read_users();
    if (array_key_exists($name, $users)) {
        return true;
    }
    return false;
}

/**
 * Sauvegarde un utilisateur
 *
 * @param string $name le nom d'utilisateur
 * @param string $pwd le mot de passe
 * @return boolean true si enregistrement ok, false sinon
 */
function save_user($name, $pwd)
{
    if ($fp = fopen(dirname(__FILE__) . '/../datas/users.csv', 'a')) {
        if (fputcsv($fp, [$name, password_hash($pwd, PASSWORD_DEFAULT)], ';')) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}