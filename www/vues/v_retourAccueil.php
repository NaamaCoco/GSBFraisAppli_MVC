<?php
/**
 * Vue Retour vers l'accueil apres validation de la fiche.
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Tsipora Schvarcz
 */
?>
<div class="alert alert-info-me" role="alert">
    <p>La fiche a bien été validée ! <a href="index.php">Cliquez ici</a>
        pour revenir à la page de connexion.</p>
</div>
<?php
header("Refresh: 2;URL=index.php");


