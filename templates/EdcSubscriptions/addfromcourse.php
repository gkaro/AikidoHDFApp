<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<h3>Ajouter une inscription</h3>
<?php
    echo $this->Form->create($sub);
    echo '<div class="row">';
        echo ' <div class="col s4">';
            echo $this->Form->control('idseason', ['options' => $seasons,'label'=>'Saison', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
            echo $this->Form->hidden('type',['value' => 1, 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row">';
        echo '<div class="col s3">';
            echo $this->Form->control('edc_member.name',['label' => 'Nom', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s3">';
            echo $this->Form->control('edc_member.dob',['label' => 'Date de naissance', 'class'=>"form-control datepicker"]);
        echo'</div>';
        echo '<div class="col s3">';
            echo $this->Form->control('age',['class'=>"form-control age"]);
        echo'</div>';
        echo '<div class="col s3">';
            $optionsGender = ['H'=>'H','F'=>'F','Autre'=>'Autre'];
            echo $this->Form->control('edc_member.gender',['options' => $optionsGender,'label' => 'Genre', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row">';
        echo '<div class="col s6">';
            echo $this->Form->control('edc_member.email',['class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
            echo $this->Form->control('edc_member.phone',['label' => 'Téléphone', 'class'=>"form-control"]);
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
        $optionsedc = ['oui' => 'oui', 'non' => 'non'];
            echo $this->Form->control('edc',  ['options' => $optionsedc,'val'=>'non','label' => 'Ecole des Cadres', 'class'=>"form-control"]);
        echo '</div>';
        
    echo'</div>';
    echo '<div class="row edcform" style="display:none;">';
        echo '<div class="col s6">';
        $optionstype = [
            '0' => '',
            '1' => 'nouvelle inscription',
            '2' => 'renouvellement'  ,
            '3' => 'renouvellement après interruption' 
        ];
                echo $this->Form->control('type', ['options' => $optionstype,'label' => 'Type','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
                echo $this->Form->control('paid', ['label' => 'Payé','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row edcform" style="display:none;">';
        echo '<div class="col s4">';
            echo $this->Form->control('gradeprepared',['label' => 'Préparez-vous un grade cette année ?', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('degreeprepared',['label' => 'Préparez-vous un diplôme d\'enseignant ?', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('roleclub',['label' => 'Avez-vous des responsabilités au sein du club ?', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    
    echo'<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('samediam',['options'=>['non','oui'],'label' => 'Samedi Matin', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('samedipm',['options'=>['non','oui'],'label' => 'Samedi Après-Midi', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('dimancheam',['options'=>['non','oui'],'label' => 'Dimanche Matin', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo'<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('rgpd',['options'=>['oui','non'],'id' => 'rgpd', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->label('payment','Paiement');
            echo $this->Form->text('payment',['id' => 'payment', 'class'=>"form-control"]);
        echo'</div>'; 
        echo '<div class="col s4">';
         echo $this->Form->control('freeofcharge',['options'=>['edc'=>'école des cadres','codir'=>'Comité Directeur','autre'=>'Autre'],'empty' => true,'label' => 'Motif de gratuité','id' => 'foc', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';  
    echo'<div class="row">';
        echo '<div class="col s12">';
            echo $this->Form->label('comments','Commentaires');
            echo $this->Form->text('comments',['id' => 'comments', 'class'=>"form-control"]);
        echo'</div>';   
        
    echo'</div>';
    
    echo '<div class="row gx-5">';
        echo '<div class="col s6">';
            echo $this->Form->control('comments', ['label' => 'Commentaires', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row gx-5">';
        echo '<div class="col">';
            echo $this->Form->button(__('Sauvegarder'), ['class'=>'form-control btn btn-primary']);
        echo'</div>';
        echo '<div class="col">';
        $referer = $this->request->referer();
            echo $this->Html->link('Annuler',  $referer,['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);
        echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>



<!--calcul de l'âge-->
<script>
$( "#edc-member-dob" ).focusout(function(){
    var dob = $('#edc-member-dob').val();
    dob = new Date(dob);
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