<?
// page index
require_once 'inc/header.inc.php';
require_once 'inc/db-connect.inc.php';

// var def
$genders = array("male", "female");
$gender = $_GET['gender'] ?? '';

if (in_array($gender, $genders)) { // if gender from GET match with array do this
    $query = $db->prepare("SELECT * FROM users WHERE gender = :gender;");
    $query->execute(array(
        ':gender' => $gender,
    ));
} elseif ($gender !== '') { // else do this if gender don't match
    $query = $db->prepare("SELECT * FROM users WHERE gender LIKE :gender;");
    $query->execute(array(
        ':gender' => "%$gender%",
    ));
    // [TODO] : ajouter un message modal d'erreur ?
} else { // finaly do this
    $query = $db->prepare("SELECT * FROM users;");
    $query->execute();
}

$users = $query->fetchAll(PDO::FETCH_ASSOC); // fetch query result from DB in $users
?>

<body>
    <div>
        <div class="sticky-top bg-white">
            <h1 class="text-center">Liste des utilisateurs présents dans la base de données</h1>
            <?require_once 'inc/nav.inc.php';?>
        </div>
        <div class="container">
            <div class="row d-flex">
                <?foreach ($users as $user) {?>
                <div class="card col-sm-3 my-2 mx-0">
                    <a href="user.php?id=<?=$user['id']?>" title="<?="{$user['first_name']} {$user['last_name']}"?>">
                        <!-- <img src="<?=strstr($user['photo'], '?', true)?>" class="card-img-top" alt="photo"> -->
                        <img src="<?=$user['photo']?>" class="card-img-top" alt="photo">
                    </a>
                    <?// $formated_pic = strstr($user['photo'], '?', true);
                // echo $formated_pic;?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title <?=strtolower($user['gender'])?>">
                            <?="{$user['first_name']} {$user['last_name']}"?>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?=$user['slogan']?></h6>
                        <hr class="border-top mx-0">
                        <p class="card-text">E-mail : </p>
                        <p class="card-text"><?=$user['email']?></p>
                        <hr class="border-top mx-0">
                        <p class="card-text">Téléphone : </p>
                        <p class="card-text"><?=$user['phone']?></p>
                        <div class="text-center mt-auto">
                            <a class="btn btn-info" href="user.php?id=<?=$user['id']?>"
                                title="<?="{$user['first_name']} {$user['last_name']}"?>">
                                Voir la fiche
                            </a>
                        </div>
                    </div>
                </div>
                <?}?>
            </div>
        </div>
        <div>
            <a id="back-to-top" href="#" title="Revenir en haut" class="btn btn-light btn-lg back-to-top" role="button">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>

</body>

</html>