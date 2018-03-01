
<a href="<?php echo  DOMAIN .'forum/addconversation/ '; ?>" title="Ajouter une conversation"> Ajouter une conversation </a>
<h2> Listes des conversations </h2>

<div>
    <table class="table-bordered col-lg-12 text-center" cellpadding="20px" style="border-collapse: collapse">
    <thead>
        <th> ID</th>
        <th> Date </th>
        <th> Heure</th>
        <th> Messages</th>
        <th> Conversation </th>
    </thead>

    
    <?php echo $conversations;?>

</table>



</div>



