 

<?php
/**
 * Vue suivi du paiement des fiches 
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Missika TM
 */
 
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$mois = getMois(date('d/m/Y'));
if (!$uc) {
    $uc = 'suiviPaiement';
}
switch ($action) {
    case 'choixFiche':
        $lesVisiteurs=$pdo->getLesVisiteursDontFicheVA();
        $lesCles1=array_keys($lesVisiteurs);
        $visiteurASelectionner=$lesCles1[0];
        $lesMois = $pdo->getLesMoisDontFicheVA();
        $lesCles2=array_keys($lesMois);
        $moisASelectionner=$lesCles2[0];
       // $fichesVA = $pdo->fichesVA();
        include 'vues/v_choix_fiches.php';
        break;
    case 'afficheFrais':
       $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_SPECIAL_CHARS);
       $lesVisiteurs=$pdo->getLesVisiteursDontFicheVA();
       $visiteurASelectionner=$idVisiteur;  
       $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);//on recupere ce qui a ete selectionné ds la liste deroulante de nummois(qui se trouve dans v_listemois).
       $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
       $moisASelectionner = $leMois;
       $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
       $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
       $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
       //$num = $pdo->récupererNum();
       $numAnnee = substr($leMois, 0, 4);
       $numMois = substr($leMois, 4, 2);
       $libEtat = $lesInfosFicheFrais['libEtat'];
       $montantValide = $lesInfosFicheFrais['montantValide'];
       $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
       $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
       if(!is_array($lesInfosFicheFrais)){
            //ajouterErreur('Pas de fiche de frais validée pour ce visiteur ce mois');
            //include 'vues/v_erreurs.php';
            include 'vues/v_choix_fiches.php';
        }
        else{
            include 'vues/v_etatFrais.php';
            include 'vues/v_mise_en_paiement.php';
        }
        break;
    case 'paiement':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_SPECIAL_CHARS);
        $lesVisiteurs=$pdo->getLesVisiteurs();
        $visiteurASelectionner=$idVisiteur;  
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);//on recupere ce qui a ete selectionné ds la liste deroulante de nummois(qui se trouve dans v_listemois).
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        $moisASelectionner = $leMois;
        $etat='RB';
        $pdo->majEtatFicheFrais($idVisiteur, $leMois, $etat);
        echo "La fiche a bien été remboursée.";
        break;
}


