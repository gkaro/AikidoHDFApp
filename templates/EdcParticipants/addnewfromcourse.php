<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<div id="title" destination="<?= $course->edc_course_place->name; ?>">Ajouter un nouveau pratiquant</div>
<?php
    echo $this->Form->create($participant);
    echo '<div class="row">';
        echo ' <div class="col s4">';
            echo $this->Form->control('idseason', ['options' => $seasons,'label'=>'Saison', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row">';
        echo '<div class="col s3">';
            echo $this->Form->control('edc_subscription.edc_member.name',['label' => 'Nom', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s3">';
            echo $this->Form->control('edc_subscription.edc_member.dob',['label' => 'Date de naissance', 'class'=>"form-control datepicker"]);
        echo'</div>';
        echo '<div class="col s3">';
            echo $this->Form->control('edc_subscription.age',['class'=>"form-control age"]);
        echo'</div>';
        echo '<div class="col s3">';
            $optionsGender = ['H'=>'H','F'=>'F','Autre'=>'Autre'];
            echo $this->Form->control('edc_subscription.edc_member.gender',['options' => $optionsGender,'label' => 'Genre', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row">';
        echo '<div class="col s6">';
            echo $this->Form->control('edc_subscription.edc_member.email',['class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
            echo $this->Form->control('edc_subscription.edc_member.phone',['label' => 'Téléphone', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('edc_subscription.clubnumber',['options' => $optionsClubs,'empty' => true,'label' => 'Nom du club', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('edc_subscription.actualgrade',['options' => $optionsGrades,'label' => 'Grade actuel', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('edc_subscription.teacherdegree',['options' => $optionsDegrees,'label' => 'Avez-vous un diplôme d\'enseignant ?', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row">';
        echo '<div class="col s4">'; 
        $optionsedc = ['oui' => 'oui', 'non' => 'non'];
            echo $this->Form->control('edc_subscription.edc',  ['options' => $optionsedc,'val'=>'non','id'=>'edc','label' => 'Ecole des Cadres', 'class'=>"form-control"]);
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
                echo $this->Form->control('edc_subscription.type', ['options' => $optionstype,'label' => 'Type','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6">';
                echo $this->Form->control('edc_subscription.paid', ['label' => 'Payé','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    echo '<div class="row edcform" style="display:none;">';
        echo '<div class="col s4">';
            echo $this->Form->control('edc_subscription.gradeprepared',['label' => 'Préparez-vous un grade cette année ?', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('edc_subscription.degreeprepared',['label' => 'Préparez-vous un diplôme d\'enseignant ?', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('edc_subscription.roleclub',['label' => 'Avez-vous des responsabilités au sein du club ?', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    
    echo'<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('satam',['options'=>['non','oui'],'label' => 'Samedi Matin', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('satpm',['options'=>['non','oui'],'label' => 'Samedi Après-Midi', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('sunam',['options'=>['non','oui'],'label' => 'Dimanche Matin', 'class'=>"form-control"]);
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
        echo '<div class="col s3">';
           
            echo $this->Form->control('km',['class'=>'form-control ']);
        echo'</div>';   
        echo '<div class="col s3">';
           
            echo $this->Form->control('age',['data-type' => 'hidden']);
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
$( "#edc-subscription-edc-member-dob" ).focusout(function(){
    var dob = $('#edc-subscription-edc-member-dob').val();
    dob = new Date(dob);
    var today = new Date();
    var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    $('#edc-subscription-age ').val(age);
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

$( "#edc-subscription-clubnumber" ).change(function(){
    console.log($("#edc-subscription-clubnumber").val())
    var clubnumber = $("#edc-subscription-clubnumber").val()
    var destination = document.getElementById('title').getAttribute('destination');
    console.log(destination);
       
          $.ajax({
                    type: 'POST',
                    headers : {
                            'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                        },
                    url: "https://aikido-hdf.fr/edc/edc-participants/calckm/",
                    data:{
                        clubnumber : clubnumber,
                        destination : destination,
                    },
                    dataType: 'json',
                    async:false, 
                    success: function(response){
                        $("#km").val(response)
                    },

                    error: function(){
                        alert("erreur" );
                    }
            });
        });


    /*    $jsonfile = file_get_contents($url);
        $jsondata = json_decode($jsonfile);
        $km = round($jsondata->rows[0]->elements[0]->distance->value/1000);*/

</script>