<?php
/**
 * Vue Liste des frais au forfait
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
?>

<form action="index.php?uc=validerFrais&action=corriger" 
      method="post" role="form"><div class="row">
        <div class="col-md-4">
            <h3>Choisir le visiteur : </h3>
        </div>
        <div class="col-md-4">

            <div class="form-group">
                <label for="lstMois" accesskey="n">Visiteur : </label>
                <select id="lstMois" name="visiteur" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($id == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?> 
                </select>
            </div>

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($moisAffiches as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>

        </div>
    </div>   


    <div class="row">    
        <h2>Valider la fiche de frais
        </h2>
        <h3>Eléments forfaitisés</h3>
        <div class="col-md-4">
                <fieldset>       
                    <?php
                    foreach ($lesFraisForfait as $unFrais) {
                        $idFrais = $unFrais['idfrais'];
                        $libelle = htmlspecialchars($unFrais['libelle']);
                        $quantite = $unFrais['quantite'];
                        ?>
                        <div class="form- group">
                            <label for="idFrais"><?php echo $libelle ?></label>
                            <input type="text" id="idFrais" 
                                   name="nouveauFrais[<?php echo $idFrais ?>]"
                                   size="10" maxlength="5" 
                                   value="<?php echo $quantite ?>" 
                                   class="form-control">
                        </div>
                        <?php
                    }
                    ?>
                    <button class="btn btn-success" type="submit" a href="">Corriger</button>
                    <button class="btn btn-danger" type="reset">Réinitialiser</button>
                </fieldset>
           
        </div>
    </div>
</form>

<form action="index.php?uc=validerFrais&action=corrigerFrais" 
      method="post" role="form"><hr>
    <input type="hidden" value="<?php echo $visiteurASelectionner ?>" name="visiteur">
    <input type="hidden" value="<?php echo $moisASelectionner ?>" name="lstMois">
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
                <?php
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                    $date = $unFraisHorsForfait['date'];
                    $montant = $unFraisHorsForfait['montant'];
                    $id = $unFraisHorsForfait['id'];
                    ?>           
                    <tr>
                        <td><input type="text" value="<?php echo $date ?>" name="date"></td>
                        <td><input type="text" value="<?php echo $libelle ?>" name="libelle"></td>
                        <td><input type="text" value="<?php echo $montant ?>" name="montant"></td>
                        <td> <input id="corriger" name="corriger" type="submit" value="Corriger"  class="btn btn-success">
                        <td> <input id="reporter" name="reporter" type="submit" value="Reporter"  class="btn btn-success">
                        <td> <input id="supprimer" name="supprimer" type="submit" value="Supprimer"  class="btn btn-success">

                </tr>
            <?php } ?>
            </tbody>  
        </table>
    </div>
</div>

</form>
<div class="row">

    <div class="form-group">
        <label for="nombreJustificatifs">Nombre de justificatifs: </label>
        <input type="text" id="nombreJustificatifs" name="nombreJustificatifs" 
               class="form-control" >
    </div>


</div>

<div>
    <button class="btn btn-success" type="submit">Ajouter</button>
    <button class="btn btn-danger" type="reset">Effacer</button>
</form>
</div>
