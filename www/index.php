<?php
/**
 * Index du projet GSB
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

require_once 'includes/fct.inc.php'; //appel obligatoire en restant sur la page
require_once 'includes/class.pdogsb.inc.php';
session_start(); //pour faire passer une variable d un controler a l autre, on utilise une superglobale comme get et post (destroy session pr detruire place
$pdo = PdoGsb::getPdoGsb();//on affecte a la variable pdo la fonction de la classe pdoGsb Un objet a tjrs une classe
$estConnecte = visiteurConnecte()|| comptableConnecte();
$visiteurConnecte = visiteurConnecte(); //on affecte le resultat de la fonction estConnecte a la variable est connecte
$comptableConnecte = comptableConnecte(); //on affecte le resultat de la fonction estConnecte a la variable est connecte
require 'vues/v_entete.php';
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_SPECIAL_CHARS);  //uc ou action-get les autres post
if (empty($uc) && !$estConnecte) { //il faut que y ait les 2 estconnecte = booleen 
    $uc = 'connexion';
} elseif (empty($uc)) { //uc est vide, pas initialisé
    $uc = 'accueil';//on affecte a la variable pdo la fonction de la classe pdoGsb Un objet a tjrs une classe

}
switch ($uc) { //if= tester plusieurs variables differentes / switch= tester la meme variable
case 'connexion':
    include 'controleurs/c_connexion.php';
    break; //obligé
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais': //remplir frais
    include 'controleurs/c_gererFrais.php';
    break;
case 'etatFrais': //verifier letat
    include 'controleurs/c_etatFrais.php';
    break;
case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
case 'suivrePaiement':
    include 'controleurs/c_suivrePaiement.php';
    break;
case 'validerFrais':
    include 'controleurs/c_validerFrais.php';
    break;
}
require 'vues/v_pied.php'; //faire appel sans rediriger
