<?
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    http_response_code(403);
    die('Direct access not allowed');
    exit();
};

define('PROJECT_NAME', 'annuaire');
include_once '../../env/' . PROJECT_NAME . '/env.php';
$host_name = DB_HOST;
$database = DB_NAME;
$user_name = DB_LOGIN;
$password = DB_PASS;

try {
    $db = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
} catch (PDOException $e) {
    echo "Erreur!: " . $e->getMessage() . "<br/>";
    die();
}

