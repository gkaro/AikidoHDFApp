<div id="title">Modifier l'inscription pour <?= $sub->edc_member->name; ?></div>
<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<?php
   echo $this->Form->create($sub);
    echo '<div class="row">';
        echo '<div class="col s6">';
        echo $this->Form->control('idseason', ['options' => $seasons,'label'=>'Saison', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
        $options = [
            '0' => '',
            '1' => 'nouvelle inscription',
            '2' => 'renouvellement'  ,
            '3' => 'renouvellement après interruption' 

        ];
        echo $this->Form->control('type',['options' => $options,'class'=>"form-control"]);
        echo $this->Form->hidden('idmember',['value' => $sub->edc_member->id]);
        echo'</div>';
    echo'</div>';
    echo '<div class="row">';

        echo '<div class="col s4">';
        echo $this->Form->control('clubnumber',['options' => $optionsClubs,'label' => 'Nom du club', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('actualgrade',['options' => $optionsGrades,'label' => 'Grade actuel', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('teacherdegree',['options' => $optionsDegrees,'label' => 'Avez-vous un diplôme d\'enseignant ?', 'class'=>"form-control"]);
        echo'</div>';

    echo'</div>';
    echo '<div class="row">';
      
        echo '<div class="col s4">';
        echo $this->Form->control('gradeprepared',['label' => 'Préparez-vous un grade cette année ?', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('degreeprepared',['label' => 'Préparez-vous un diplôme d\'enseignant ?', 'class'=>"form-control"]);
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

