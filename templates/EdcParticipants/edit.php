<script>
    $(document).ready(function(){
        $('select').formSelect();
        $('.datepicker').datepicker();
  });
</script>

<h4 id="course" destination="<?= $participant->edc_course->place;?>" participant="<?= $participant->id;?>">Modifier l'inscription de <?= $participant->edc_subscription->edc_member->name;?> au stage <?= $participant->edc_course->name;?></h4>

<div style="margin-bottom:10%">

<?php   
    echo $this->Form->create($participant);
    echo '<div class="row">';
       
    echo'</div>';
   
    echo '<div class="row">';
        echo '<div class="col s4">';
        echo $this->Form->control('edc_subscription.clubnumber',['options'=>$optionsClubs,'label' => 'Club','id' => 'club','class'=>"form-control",'place'=>$participant->edc_subscription->edc_club->city]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('edc_subscription.actualgrade',['options'=>$optionsGrades,'label' => 'Grade','id' => 'grade','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('edc_subscription.teacherdegree',['options'=>$optionsDegrees,'label' => 'Diplôme','id' => 'degree','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo'<div class="row">';
        echo '<div class="col s4">';
        echo $this->Form->control('satam',['options'=>['0'=>'non','1'=>'oui'],'label' => 'Samedi Matin', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('satpm',['options'=>['0'=>'non','1'=>'oui'],'label' => 'Samedi Après-Midi', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->control('sunam',['options'=>['0'=>'non','1'=>'oui'],'label' => 'Dimanche Matin', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo'<div class="row">';
        echo '<div class="col s4">';
        echo $this->Form->label('rgpd','RGPD');
        echo $this->Form->text('rgpd',['id' => 'rgpd', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
        echo $this->Form->label('payment','Paiement');
        echo $this->Form->text('payment',['id' => 'payment', 'class'=>"form-control"]);
        echo'</div>'; 
        echo '<div class="col s4">';
        echo $this->Form->label('edc','Ecole des Cadres');
        echo $this->Form->text('edc',['id' => 'edc', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';  
    echo'<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->label('km','Km parcourus');
            echo $this->Form->text('km',['id' => 'km', 'class'=>"form-control"]);
            echo '<a class="waves-effect waves-light" id="recalc_km"><i class="tiny material-icons">replay</i></a>';
        echo'</div>'; 
        echo '<div class="col s4">';
            echo $this->Form->label('age','Age');
            echo $this->Form->text('age',['id' => 'age', 'class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s42">';
            echo $this->Form->label('comments','Commentaires');
            echo $this->Form->text('comments',['id' => 'comments', 'class'=>"form-control"]);
        echo'</div>';   
        
    echo'</div>';
    echo'<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->button(__('Sauvegarder'),['class'=>'form-control btn btn-primary']);
        echo'</div>';   
        echo '<div class="col s4">';
            echo $this->Html->link('Retour', ['controller'=>'edc-courses','action' => 'view',$participant->id_course],['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);
        echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>
</div>


<script>
    $( "#recalc_km" ).click(function() {
        var id= document.getElementById('course').getAttribute('participant');
        var origin = document.getElementById('club').getAttribute('place');
        console.log(origin);
        var destination = document.getElementById('course').getAttribute('destination');
        console.log(destination);
        var key = "AIzaSyAxoP4zo_UbIDv1A5R8caiRziCDAXJy5jE";
        var url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins="+encodeURI(origin)+"&destinations=" + encodeURI( destination) +"&key=" +key;
        console.log(url);
        //$.getJSON(url, function(data){console.log(data);}
        $.ajax({
                    type: 'POST',
                    headers : {
                            'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                        },
                    url: "https://aikido-hdf.fr/edc/edc-participants/recalckm/"+id,
                    data:{
                        id : id,
                        origin : origin,
                        destination : destination,
                        key : key,
                        url : url,
                    },
                    dataType: 'text',
                    async:false, 
                    success: function(response){
                        location.reload(true); 
                    },

                    error: function(){
                        alert("erreur" );
                    }
            });
        });
       
        //var destination = ""
        //var key = "AIzaSyAxoP4zo_UbIDv1A5R8caiRziCDAXJy5jE"
        //var url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode(origin)."&destinations=" . urlencode( destination) . "&key=" . $key
       //var jsonfile = file_get_contents($url)
        //var jsondata = json_decode($jsonfile)
        //var km = round($jsondata->rows[0]->elements[0]->distance->value/1000)
</script>
