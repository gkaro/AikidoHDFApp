<div id="title">Renouveler l'inscription pour <?= $member->name; ?></div>

<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>
<?php
    echo $this->Form->create($newsub);
    echo '<div class="row">';
        echo '<div class="col s6">';
            echo $this->Form->control('idseason', ['options' => $seasons,'label'=>'Saison', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s2">';
            echo $this->Form->hidden('idmember',['value'=>$member->id]);
        echo'</div>';
        echo '<div class="col s2">';
            echo $this->Form->control('age',['class'=>"form-control age"]);
        echo'</div>';
        echo '<div class="col s2" id="dob" data="'. $member->dob->format('m-d-Y') .'">';
       
        echo'</div>';
    echo'</div>';
    echo '<div class="row">';
        echo '<div class="col s6">';
            echo $this->Form->control('clubnumber',['options'=>$optionsClubs,'val'=>$member->edc_subscriptions[0]->clubnumber,'label' => 'Nom du club','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
            echo $this->Form->control('roleclub',['label' => 'Avez-vous des responsabilités au sein du club ?', 'class'=>"form-control"]);
        echo'</div>';
    echo '</div>';
    echo '<div class="row">';
        echo '<div class="col s6">';
            echo $this->Form->control('actualgrade',['options' => $optionsGrades,'val'=>$member->edc_subscriptions[0]->edc_grade->id,'label' => 'Grade actuel', 'class'=>"form-control"]);
        echo '</div>';
        echo '<div class="col s6">';
            echo $this->Form->control('teacherdegree',['options' => $optionsDegrees,'val'=>$member->edc_subscriptions[0]->teacherdegree,'label' => 'Avez-vous un diplôme d\'enseignant ?', 'class'=>"form-control"]);
        echo '</div>';
        
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col s6">';
    echo $this->Form->control('gradeprepared',['label' => 'Préparez-vous un grade cette année ?', 'class'=>"form-control"]);
echo '</div>';
        echo '<div class="col s6">';
            echo $this->Form->control('degreeprepared',['label' => 'Préparez-vous un diplôme d\'enseignant ?', 'class'=>"form-control"]);
        echo '</div>';
    echo '</div>';

    echo '<div class="row">';
        echo '<div class="col s4">'; 
        $optionsedc = ['oui' => 'oui', 'non' => 'non'];
            echo $this->Form->control('edc', ['options' => $optionsedc,'val'=>'non','label' => 'Ecole des Cadres', 'class'=>"form-control"]);
        echo '</div>';
    echo '</div>'; 
    echo '<div class="row edcform" style="display:none;">';
        echo '<div class="col s6">';
        $options = [
            '0' => '',
            '1' => 'nouvelle inscription',
            '2' => 'renouvellement'  ,
            '3' => 'renouvellement après interruption' 
        ];
            echo $this->Form->control('type',['options' => $options,'class'=>"form-control",'empty' => true,'default'=>'2']);
        echo'</div>';
        echo '<div class="col s6">';
            echo $this->Form->control('paid', ['label' => 'Paiement', 'class'=>"form-control"]);
        echo '</div>';
    echo '</div>';  

    echo '<div class="row">';
        echo '<div class="col s12">';
            echo $this->Form->control('comments', ['rows' => '3','label' => 'Commentaires', 'class'=>"materialize-textarea"]);
        echo '</div>';
    echo '</div>';
    echo '<div class="row">';
        echo '<div class="col">';
            echo $this->Form->button(__('Sauvegarder'),['class'=>'form-control btn btn-primary']);
        echo '</div>';
        echo '<div class="col">';
            echo $this->Html->link('Annuler', $this->request->referer(),['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);
        echo '</div>';
    echo '</div>';
    echo $this->Form->end();
?>

<!--calcul de l'âge-->
<script>

$(function() {
    var dob = $('#dob').attr('data');
    dob = new Date(dob);
    console.log(dob);
    var today = new Date();
    var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    $('#age ').val(age);
  });

  $( "#edc" ).change(function(){
    if($('#edc').val() == "non"){
        $('#paid').parent().hide();
        $('.edcform').hide();
    }
    if($('#edc').val() == "oui"){
        $('#paid').parent().show();
        $('.edcform').show();
    }
});
</script>