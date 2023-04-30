<div id="title">Modifier <?= $member->name; ?></div>
<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<?php
   echo $this->Form->create($member);
    echo '<div class="row">';

        echo '<div class="col s4">';
        echo $this->Form->control('name',['label' => 'Nom et prénom', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('dob',['label' => 'Date de naissance', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('gender',['options'=>['H'=>'H','F'=>'F','Autre'=>'Autre'],'label' => 'Sexe (H, F ou Autre', 'class'=>"form-control"]);
        echo'</div>';

    echo'</div>';
    echo '<div class="row">';
        echo '<div class="col s4">';
        echo $this->Form->control('street',['label' => 'N° de rue et rue', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('zip',['label' => 'Code postal', 'class'=>"form-control"]);
        echo'</div>';   
        echo '<div class="col s4">';
        echo $this->Form->control('city',['label' => 'Ville', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo '<div class="row">';
        echo '<div class="col s6">';
        echo $this->Form->control('email',['label' => 'Email', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
        echo $this->Form->control('phone',['label' => 'Téléphone', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo '<div class="row">';
        echo '<div class="col s6">';
        echo $this->Form->control('comments',['label' => 'Commentaires', 'class'=>"form-control"]);
        echo'</div>';  

    echo'</div>';
    echo '<div class="row">';

        echo '<div class="col">';

        echo $this->Form->button(__('Sauvegarder'),['class'=>"form-control btn btn-primary"]);

        echo'</div>';

        echo '<div class="col">';
       $referer = $this->request->referer();
       echo '<a href="/edc/' . $referer . '" class="form-control btn btn-primary" style="margin:20px 0">Annuler</a>'; 

        echo'</div>';

    echo'</div>';
    echo $this->Form->end();
?>

