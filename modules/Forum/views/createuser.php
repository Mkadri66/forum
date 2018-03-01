<div class="col-lg-4 offset-lg-4">

    <h2> Creer un compte </h2>

    <form class=""action=""method="POST">
        <label for="login"> Mail </label> <br>
        <input type="text" name="mail"   class="form-control input-md" placeholder="Votre mail">
        <br> <br>
        <label for="prenom"> Prénom </label>  <br>
        <input type="text" name="prenom" class="form-control input-md" placeholder="Votre prénom">
        <br> <br>
        <label for="nom"> Nom </label>  <br>
        <input type="text" name="nom" class="form-control input-md" placeholder="Votre nom">
        <br> <br>
        <label for="date_naissance"> Date de naissance </label>  <br>
        <input type="date" name="date_naissance" class="form-control input-md" placeholder="Date de naissance">
        <br> <br>

        <input type="submit" class="btn btn-primary" value="Valider">

    </form> 

<?php echo $message; ?>

</div>


