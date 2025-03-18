<?php
/**
 * Gestion de la connexion
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
if (!$action) { //uc diriger vers le controlleur action ou on va ds le controlleur
    $action = 'demandeconnexion';
}
switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_SPECIAL_CHARS);
    $visiteur = $pdo->getInfosVisiteur($login, $mdp); //la variable visiteur va recevoir les infos= resultat de cette fonctio fonction de la classe pdo gsb il faut mettre a chaque fois ce pdo pr connecter l objet a sa fonction
    $comptable = $pdo->getInfosComptable($login, $mdp); //la variable visiteur va recevoir les infos= resultat de cette fonctio fonction de la classe pdo gsb il faut mettre a chaque fois ce pdo pr connecter l objet a sa fonction
    var_dump($comptable, $visiteur);
    if (!is_array($visiteur)&&!is_array($comptable)) {
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    } elseif (is_array($visiteur)) {
        $id = $visiteur['id'];
        $nom = $visiteur['nom'];
        $prenom = $visiteur['prenom'];
       connecterVisiteur($id, $nom, $prenom);
        header('Location: index.php');
    } else {
        $id = $comptable['id'];
        $nom = $comptable['nom'];
        $prenom = $comptable['prenom'];
        connecterComptable($id, $nom, $prenom);
        header('Location: index.php');        
    }
    break;
default:
    include 'vues/v_connexion.php';
    break;
}
