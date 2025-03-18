<?php

/**
 * Valider frais
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
switch ($action) {
    case 'listeVisiteur':
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesCles = array_keys($lesVisiteurs);
        $visiteurASelectionner = $lesCles[0];
        $moisAffiches = getLesMois();
        $lesCles21 = array_keys($moisAffiches);
        $moisASelectionner = $lesCles21[0];
        include 'vues/v_listeVisiteur.php';
        break;

    case 'afficheFrais':

        $idVisiteur = filter_input(INPUT_POST, 'visiteur', FILTER_SANITIZE_SPECIAL_CHARS);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
        $visiteurASelectionner = $idVisiteur;
        $moisASelectionner = $mois;
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $moisAffiches = getLesMois();
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        if (empty($lesFraisForfait) && empty($lesFraisHorsForfait)) {
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            include 'vues/v_listeVisiteur.php';
        } else {

            include 'vues/v_validerFiches.php';
        }


        break;
    case "corriger":
        $nouveauFrais = filter_input(INPUT_POST, 'nouveauFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $idVisiteur = filter_input(INPUT_POST, 'visiteur', FILTER_SANITIZE_SPECIAL_CHARS);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
        $visiteurASelectionner = $idVisiteur;
        $moisASelectionner = $mois;
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $moisAffiches = getLesMois();
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        $pdo->majFraisForfait($idVisiteur, $mois, $nouveauFrais);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        break;
    case "corrigerFrais":
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_SPECIAL_CHARS);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        $idVisiteur = filter_input(INPUT_POST, 'visiteur', FILTER_SANITIZE_SPECIAL_CHARS);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($_POST['corriger'])) {
            var_dump($montant, $libelle, $date, $idVisiteur, $mois);
            $visiteurASelectionner = $idVisiteur;
            $moisASelectionner = $mois;
            $lesVisiteurs = $pdo->getLesVisiteurs();
            $moisAffiches = getLesMois();
            $pdo->majFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois); //creer cette fonction avec la fonction majfraisforfait et creenouveaufraisforfait de pdoclass
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        } elseif (isset($_POST['reporter'])) {
            $visiteurASelectionner = $idVisiteur;
            $moisASelectionner = $mois;
            $lesVisiteurs = $pdo->getLesVisiteurs();
            $moisAffiches = getLesMois();
            $libelle = "refuser " . $libelle;
            $pdo->majFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
            $mois = $mois+1;
            if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
        $pdo->creeNouvellesLignesFrais($idVisiteur, $mois, $libelle, $date, $montant);
    }
            $pdo->creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant);
        } elseif (isset($_POST['supprimer'])) {
                $pdo->supprimerFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant); 
        }

        include 'vues/v_validerFiches.php';

        break;
}

//  controleur if(isset($_POST['Corriger])){
//on recupere les donnees on met a jour avec refuser devant libelle et on cree ce frais pour le mois suivant et on reaffiche la vue en appelant les fonction