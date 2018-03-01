
<?php 
// verifier page max

$pageSuivante = $maPageActuelle + 1;

$pagePrecedente = $maPageActuelle - 1;

?>

<h2 class="text-center"> Conversation n° <?php echo $id ?></h2>

<br>
<div class="row">
    <div class="col-lg-6">

        <form action="" method="POST">
            <label for="message"> Ajoutez un message à la conversation </label> <br>
            <textarea name="message" id="" cols="40" rows="5"> </textarea> 
            <br> <br>
            <input type="submit" class="btn btn-primary" value="Valider">

        </form>
    </div>
</div>
<br> <br> <br>
<div class="row">
    <div class="col-lg-6">
        <form action="" method="POST">
            <label for="tri"> Trier par : </label>
            <select name="tri" id="">
                <option value="id"> id</option>
                <option value="date"> date</option>
                <option value="auteur"> auteur</option>           
            </select>
            <input type="submit" class="btn btn-primary" value="Valider">
        </form>
    </div>


</div>


<table  class="table-striped table-bordered" cellpadding="10px" border="1px" style="border-collapse: collapse; text-align: center;">
    <thead>
        <th> Id </th>
        <th> Date</th>
        <th> Heure du message</th>
        <th> Nom prenom </th>
        <th> Contenu </th>     
    </thead>
    
    <?php echo $messages;?>
</table>

    <?php 

    if(  $maPageActuelle  > 1 ) { ?>
         <a href="<?php echo DOMAIN .'forum/conversation/'. $id . '/'. $pagePrecedente . '?tri=' . $tri  ;?> "  title="Précédent"> Page précédente </a>

    <?php } ?> 
   

    <a href="<?php echo DOMAIN .'forum/conversation/'. $id . '/'. $pageSuivante . '?tri=' . $tri ; ?>" title="Suivant"> Page suivante </a>
 