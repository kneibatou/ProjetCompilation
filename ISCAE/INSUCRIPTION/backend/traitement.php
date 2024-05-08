<?php
$errors = array();


//connection databases (med salem)

// Paramètres de connexion à la base de données
// Paramètres de connexion à la base de données
$host = 'localhost'; // ou l'adresse IP du serveur MySQL
$dbname = 'iscaedb';
$password = 'votre_mot_de_passe_mysql'; // Votre mot de passe MySQL

try {
    // Créer une connexion à la base de données
    $bdd = new PDO("mysql:host=$host;dbname=$dbname", 'root', $password);
    // Définir le mode d'erreur de PDO à exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données.";
} catch(PDOException $e) {
    // En cas d'erreur, afficher l'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

if (isset($_POST['submit'])) {
    //validation si le NNI est unique dans le base de donnees (knybe)
    // Récupère le NNI soumis par le formulaire
    $NNI = $_POST['NNI'];

    // Prépare la requête SQL
    $query = $bdd->prepare("SELECT COUNT(*) AS count FROM table WHERE NNI = :NNI");

    // Lie le paramètre NNI à la valeur soumise
    $query->bindParam(':NNI', $NNI);

    // Exécute la requête
    $query->execute();

    // Récupère le résultat
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Vérifie si le NNI est unique
    if ($result['count'] > 0) {
        // Le NNI existe déjà dans la base de données
        echo "Le NNI est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Le NNI est unique, vous pouvez procéder à l'ajout dans la base de données
        // Exemple : $bdd->query("INSERT INTO table (nni) VALUES ('$nni')");
        echo "Le NNI est unique. Enregistrement autorisé.";
    }



    // Validation de la date  (selwe)
    

    // Si des erreurs sont détectées (khadije)
    if (!empty($errors)) {
        $errorString = implode("&", array_map("urlencode", $errors));
        header("Location: formul.php?errors=$errorString");
        exit();
    }
}

// stocker sur  databases (med salem)


header("Location: reussie.html");
exit();

?>
