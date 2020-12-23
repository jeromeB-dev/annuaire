<?
// page user
require_once 'inc/db-connect.inc.php';

// [TODO] : faire un filter sur get id + if sur le id
$query = $db->prepare("SELECT * FROM users WHERE id = :id;");
$query->execute(array(
    ':id' => $_GET['id'],
));
$user = $query->fetch(PDO::FETCH_ASSOC);

require_once 'inc/header.inc.php'; // MEMO : keep header in last position here for dynamic title
?>

<body>
    <div class="container">
        <h1 class="text-center">Profil</h1>
        <?require_once 'inc/nav.inc.php';?>
        <div class="container">
            <div class="container-fluid border">
                <div class="row">
                    <div class="col-5">
                        <!-- <img src="<?=strstr($user['photo'], '?', true)?>" class="card-img-top" alt="photo"> -->
                        <img src="<?=$user['photo']?>" class="card-img-top" alt="photo">
                        <div class="text-center">
                            <p><i><?=$user['slogan']?></i></p>
                        </div>
                    </div>
                    <div class="col-7">
                        <h2 class="<?=strtolower($user['gender'])?>">
                            <?="{$user['first_name']} {$user['last_name']}"?>
                        </h2>
                        <hr>
                        <p>E-mail : <?=$user['email']?></p>
                        <hr>
                        <p>Téléphone : <?=$user['phone']?></p>
                    </div>
                </div>
                <div class="text-center d-flex justify-content-between">
                    <a href="user.php?id=<?=($user['id'] - 1 == 0) ? $count_all : $user['id'] - 1?>"
                        class="col-1 btn btn-light" title="Profil précédent">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a class="col-4 btn btn-success" href="index.php" title="Retourner à la page d'accueil">
                        Retourner à la page d'accueil</a>
                    <a href="user.php?id=<?=($user['id'] + 1 > $count_all) ? 1 : $user['id'] + 1?>"
                        class="col-1 btn btn-light" title="Profil suivant">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                <br>
            </div>
            <br>
        </div>
    </div>
</body>

</html>