<?
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    http_response_code(403);
    die('Direct access not allowed');
    exit();
};

// page nav
require_once 'inc/db-connect.inc.php';
$query = $db->prepare("SELECT * FROM users;");
$query->execute();
$count_all = $query->rowCount();

$gender_male = $db->prepare("SELECT * FROM users WHERE gender LIKE 'male';");
$gender_male->execute();
$count_male = $gender_male->rowCount();

$gender_female = $db->prepare("SELECT * FROM users WHERE gender LIKE 'female';");
$gender_female->execute();
$count_female = $gender_female->rowCount();
// [TODO] boucle Walid pour les boutons gender : SELECT gender, COUNT(gender) AS 'nbr' FROM users GROUP BY gender

?>
<div class="container text-center">
    <a class="btn btn-info" href="../" title="Retour site précédent">
        Retour site précédent
    </a>
    <a class="btn btn-info" href="index.php" title="Tous">
        Tous (<?=$count_all?>)
    </a>
    <a class="btn btn-info" href="index.php?gender=male" title="Hommes">
        Hommes (<?=$count_male?>)
    </a>
    <a class="btn btn-info" href="index.php?gender=female" title="Femmes">
        Femmes (<?=$count_female?>)
    </a>
    <a class="btn btn-info" href="add-user.php" title="Ajouter un utilisateur">
        Ajouter un utilisateur
    </a>
    <hr>
</div>