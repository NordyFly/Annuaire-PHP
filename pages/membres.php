
<?php
error_reporting(E_ALL);
ini_set('display_errors', true);


const USERS_CSV_PATH = "./src/datas/users.csv";

function read_users() {
    $users = [];
    if (file_exists(USERS_CSV_PATH)) {
        $file_pointer = fopen(USERS_CSV_PATH, "r");
        while (($data = fgetcsv($file_pointer, null, ",")) !== false) {
            $data = array_map('trim', $data);
            $users[] = $data;
        }
        fclose($file_pointer);
    }
    return $users;
}

function compare_by_firstname($a, $b) {
    return strnatcasecmp($a[0], $b[0]);
}

function compare_by_lastname($a, $b) {
    return strnatcasecmp($a[1], $b[1]);
}

function compare_by_email($a, $b) {
    return strnatcasecmp($a[2], $b[2]);
}

$users = read_users();
usort($users, 'compare_by_lastname'); // Initial sorting

$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $authenticated = false;
    foreach ($users as $user) {
        if ($user[2] === $login && $user[3] === $password) {
            $_SESSION['authenticated'] = true;
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        // Mettre à jour la variable $authenticated ici
        $authenticated = true;

        header('Location: membres.php');
        exit;
        
    } else {
        echo "<p class='error-message'>Identifiants incorrects. Veuillez réessayer.</p>";
    }
}

if (!$authenticated) {
    echo "<h1>Les membres de l'équipe</h1>";
    echo "<table class='table' id='userTable'>";
    echo "<tr><th><a href='javascript:void(0)' onclick='sortTable(0)'>Prénom</a></th><th><a href='javascript:void(0)' onclick='sortTable(1)'>Nom</a></th><th><a href='javascript:void(0)' onclick='sortTable(2)'>Email</a></th></tr>";

    foreach ($users as $user) {
        echo "<tr><td>{$user[0]}</td><td>{$user[1]}</td><td>{$user[2]}</td></tr>";
    }

    echo "</table>";

    echo "<script>";
    echo "function sortTable(columnIndex) {";
    echo "let table, rows, switching, i, x, y, shouldSwitch;";
    echo "table = document.getElementById('userTable');";
    echo "switching = true;";
    echo "while (switching) {";
    echo "switching = false;";
    echo "rows = table.rows;";
    echo "for (i = 1; i < (rows.length - 1); i++) {";
    echo "shouldSwitch = false;";
    echo "x = rows[i].getElementsByTagName('TD')[columnIndex];";
    echo "y = rows[i + 1].getElementsByTagName('TD')[columnIndex];";
    echo "if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {";
    echo "shouldSwitch = true;";
    echo "break;";
    echo "}";
    echo "}";
    echo "if (shouldSwitch) {";
    echo "rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);";
    echo "switching = true;";
    echo "}";
    echo "}";
    echo "}";
    echo "</script>";
}


if ($authenticated) {
    echo "<h1>Les membres de l'équipe</h1>";
    echo "<table class='table' id='userTable'>";
    echo "<tr><th><a href='javascript:void(0)' onclick='sortTable(0)'>Prénom</a></th><th><a href='javascript:void(0)' onclick='sortTable(1)'>Nom</a></th><th><a href='javascript:void(0)' onclick='sortTable(2)'>Email</a></th></tr>";

    foreach ($users as $user) {
        echo "<tr><td>{$user[0]}</td><td>{$user[1]}</td><td>{$user[2]}</td><td class='text-right'><button class='btn btn-primary'>Mode Admin</button></td></tr>";

    }

    echo "</table>";

    echo "<script>";
    echo "function sortTable(columnIndex) {";
    echo "let table, rows, switching, i, x, y, shouldSwitch;";
    echo "table = document.getElementById('userTable');";
    echo "switching = true;";
    echo "while (switching) {";
    echo "switching = false;";
    echo "rows = table.rows;";
    echo "for (i = 1; i < (rows.length - 1); i++) {";
    echo "shouldSwitch = false;";
    echo "x = rows[i].getElementsByTagName('TD')[columnIndex];";
    echo "y = rows[i + 1].getElementsByTagName('TD')[columnIndex];";
    echo "if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {";
    echo "shouldSwitch = true;";
    echo "break;";
    echo "}";
    echo "}";
    echo "if (shouldSwitch) {";
    echo "rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);";
    echo "switching = true;";
    echo "}";
    echo "}";
    echo "}";
    echo "</script>";
}
?>
