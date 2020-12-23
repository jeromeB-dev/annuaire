<?
// page user
require_once 'inc/db-connect.inc.php';
require_once 'inc/header.inc.php';

$new_user = [
    'firstName' => filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING),
    'lastName' => filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING),
    'inputEmail' => filter_input(INPUT_POST, 'inputEmail', FILTER_VALIDATE_EMAIL),
    'inputGender' => filter_input(INPUT_POST, 'inputGender', FILTER_SANITIZE_STRING),
    'inputPhoto' => filter_input(INPUT_POST, 'inputPhoto', FILTER_VALIDATE_URL),
    'inputPhone' => filter_input(INPUT_POST, 'inputPhone', FILTER_SANITIZE_NUMBER_INT),
    'inputSlogan' => filter_input(INPUT_POST, 'inputSlogan', FILTER_SANITIZE_STRING),
];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // if POST method do next
    if (in_array(false, $new_user)) { // if error in array display them
        echo "Au moins une erreur trouvée dans le formulaire : <br>";
        foreach ($new_user as $key => $value) {
            $test = ($value == false) ? "Ce champs n'est pas bon" : "OK";
            echo "[$key] = '$value' : $test<br>";
        }
    } else { // else no error then add values in DB

        $query = $db->prepare("INSERT INTO users (first_name, last_name, email, gender, photo, phone, slogan) VALUES (:first_name, :last_name, :email, :gender, :photo, :phone, :slogan)");
        $query->execute(array(
            ':first_name' => $new_user['firstName'],
            ':last_name' => $new_user['lastName'],
            ':email' => $new_user['inputEmail'],
            ':gender' => $new_user['inputGender'],
            ':photo' => $new_user['inputPhoto'],
            ':phone' => $new_user['inputPhone'],
            ':slogan' => $new_user['inputSlogan'],
        ));
        $result = $db->lastInsertId();
        foreach ($new_user as $key => $value) { // clear all input after DB insert
            $new_user[$key] = '';
        }
        $success = "L'utilisateur a été rajouté : <a href='user.php?id=$result' title='Voir le nouvel utilisateur' target='_blank'>Voir " . $new_user['firstName'] . "</a>";
    }
} elseif (count($_GET) > 0) { // if GET sent to page error and exit
    echo "<div class='container'><h2>Une erreur s'est produite lors de l'envoi du formulaire</h2>";
    echo "<p>Le(s) paramètre(s) suivant ne peu(ven)t pas être pris en compte : </p>";
    exit("<p><pre>" . print_r($_GET) . "</pre></p></div>");
}
?>

<body>
    <div class="container">
        <h1 class="text-center">Ajouter un utilisateur</h1>
        <?require_once 'inc/nav.inc.php';?>
        <div class="container">
            <div class="container-fluid">
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstName">Prénom</label>
                            <input id="firstName" type="text" class="form-control" name="firstName" placeholder="Prénom"
                                required value="<?=$new_user['firstName']?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Nom</label>
                            <input id="lastName" type="text" class="form-control" name="lastName" placeholder="Nom"
                                required value="<?=$new_user['lastName']?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail">Email</label>
                            <input id="inputEmail" type="email" class="form-control" name="inputEmail"
                                placeholder="Email" required value="<?=$new_user['inputEmail']?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputGender">Genre</label>
                            <select id="inputGender" name="inputGender" class="form-control">
                                <option disabled>Choisissez votre Genre</option>
                                <option value="male" selected>Homme</option>
                                <option value="female">Femme</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="inputPhoto">Photo (lien)</label>
                            <input id="inputPhoto" type="url" class="form-control" name="inputPhoto"
                                placeholder="Collez l'URL (lien) vers votre photo"
                                title="Exemple : http://www.monsite.fr/ma-photo.jpg" required
                                value="<?=$new_user['inputPhoto']?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputPhone">Téléphone</label>
                            <input id="inputPhone" type="tel" class="form-control" name="inputPhone"
                                placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                title="Format : 123-123-1234" required value="<?=$new_user['inputPhone']?>">
                        </div>
                        <div class="form-group col-md-10">
                            <label for="inputSlogan">Slogan</label>
                            <input id="inputSlogan" type="text" class="form-control" name="inputSlogan"
                                placeholder="Saisissez votre slogan" required value="<?=$new_user['inputSlogan']?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Créer</button>
                    <a class="btn btn-outline-warning" href="index.php" title="Retrourner à l'accueil">
                        Retrourner à l'accueil
                    </a>
                    <div class="container-fluid text-center">
                        <span class="text-success font-italic"><?=$success?></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>