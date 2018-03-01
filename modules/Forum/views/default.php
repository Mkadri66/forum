
<div class="row connect">
   
    <h2 class="col-lg-4 offset-lg-4 text-center "> Connexion au forum </h2>
    <br> <br> <br> 
    <form class="col-lg-4 offset-lg-4 " action="" method="POST">

        <label for="mail"> Mail</label>
        <br>
        <input type="mail" name="mail" class="form-control input-md"  placeholder="Votre mail">
        <br> <br>
    


        <label for="prenom"> Prénom</label> <br>
        <input type="text" name="prenom" class="form-control input-md"  placeholder="Votre prénom">

        <br> <br>

        <input type="submit" class="btn btn-primary" value="Valider">

    </form>

</div>

<?php echo $message;?>


<div class='row'>

     <a href="<?php echo  DOMAIN .'forum/createuser/ '; ?>" class="col-lg-4 offset-lg-4  text-center" title="Creer un compte"> Creer un compte </a>
</div>


<br> <br>
