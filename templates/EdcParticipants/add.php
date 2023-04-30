<script>
    $(document).ready(function(){
        $('select').formSelect();
        $('.datepicker').datepicker();
        $( 'input.autocomplete' ).autocomplete({
            data: {  <?php 
                foreach ($members as $key) {  
                    echo'"'.$key .'" : null,';
                }
                ?>},
      onAutocomplete: function(txt) {
          sendItem(txt);
        },
    });
  });
  function sendItem(val) {
    console.log(val);
}
  
</script>

<div id="title" class="<?= $course->idseason; ?>" stageid="<?= $course->id; ?>" >Inscription stage <?= $course->edc_course_type->name; ?> à <?= $course->edc_course_place->name; ?> </div>

<div style="margin-bottom:10%">

<?php   
    echo $this->Form->create();
    echo '<div class="row">';
        echo '<div class="col s6">';
        echo' 
        <div class="input-field col s12">
                <input type="text" id="autocomplete-input" class="autocomplete"  >
          <label for="autocomplete-input">Rechercher un nom</label>
         
        </div>';
            //echo $this->Form->select('name',$members,['empty' => true,'id' => 'participant','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s6 hide-on-small-only">';
            
            echo $this->Html->link('Nouveau', ['controller'=>'edc-participants','action' => 'addnewfromcourse', $course->id],['class'=>"form-control btn btn-primary","style"=>"margin:0 20px"]);
        echo'</div>';
        echo '<div class="col s6 show-on-small-only hide-on-med-and-up">';
           
            echo '<a href="https://aikido-hdf.fr/edc/edc-participants/addfromcourse/'.$course->id.'" class="btn btn-primary"><i class="material-icons">person_add</i></a>';
          
        echo'</div>';
    echo'</div>';

    echo '<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('name',['label' => 'Nom','id' => 'name','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('email',['label' => 'Email','id' => 'email','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
           echo $this->Form->control('phone',['label' => 'Téléphone','id' => 'phone','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo '<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('dob',['label' => 'Date de naissance','id' => 'dob','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('gender',['label' => 'Genre','id' => 'gender','class'=>"form-control"]);
        echo'</div>';
        echo '<div class="col s4">';
            echo $this->Form->control('age',['label' => 'Age','id' => 'age','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';

    //si inscription à renouveler, afficher avertissement :
    echo '<div id="renew" class="row" style="display:none">
        <div class="card  red darken-4">
        <div class="card-content white-text">
        Stop ! Avant de continuer, indiquez le club, le grade et le diplôme de l\'année en cours.
        </div>
        </div>
        </div>';

    echo '<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('club',['options'=>$optionsClubs,'label' => 'Club','id' => 'club','class'=>"form-control browser-default",'clubid' => '0']);
        echo'</div>';
        echo '<div class="col s3">';
            echo $this->Form->control('grade',['options'=>$optionsGrades,'label' => 'Grade','id' => 'grade','class'=>"form-control browser-default",'gradeid' => '0']);
        echo'</div>';
        echo '<div class="col s3">';
            echo $this->Form->control('degree',['options'=>$optionsDegrees,'label' => 'Diplôme','id' => 'degree','class'=>"form-control browser-default"]);
        echo'</div>';
        echo '<div class="col s2">';
         echo $this->Form->control('edc',['options'=>['non'=>'non','oui'=>'oui'],'id' => 'edc', 'class'=>"form-control browser-default"]);
     echo'</div>';

      //si inscripton à renouveler, afficher bouton validation :
     echo'<div class="row" >';
        echo '<div class="col">';
            echo '<div id="buttonrenew" idmember="0" idsubscriptions="0" style="display:none; margin:20px 0px" class="form-control btn red darken-4">Renouveler</div>';
        echo'</div>';   
    echo'</div>';

    //si inscripton renouvelée alors afficher message d'info: :
    echo '<div id="validrenew" class="row" style="display:none">
    <div class="card  green">
    <div class="card-content white-text">
    Adhérent renouvelé, vous pouvez continuer l\'inscription au stage...
    </div>
    </div>
    </div>';

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
    echo'<div class="row">';
        echo '<div class="col">';
            echo '<div id="save" idmember="0" idsubscriptions="0" style="margin:20px 0px" class="form-control btn btn-primary">Sauvegarder</div>';
        echo'</div>';   
        echo '<div class="col">';
            echo $this->Html->link('Retour', ['controller'=>'edc-courses','action' => 'view',$course->id],['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);
        echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>
</div>

<script>

function sendItem(name) {
    var idseason = $("#title").attr('class');
    $.ajax({
            type: 'POST',
            headers : {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            url: 'https://aikido-hdf.fr/edc/edc-participants/result',
            data: {
                name: name,
                idseason: idseason,
            },
            dataType: 'json',
            success: function(response){
                console.log(response);
                var id = response['id'];
                $("#save").attr("idmember",id);
                $("#linkrenew").attr("href","/edc/edc-subscriptions/renew/"+id);
                $("#linkrenewmobile").attr("href","/edc/edc-subscriptions/renew/"+id);
                var name = response['name'];
                $("#name").val(name);
                var email = response['email'];
                $("#email").val(email);
                var phone = response['phone'];
                $("#phone").val(phone);
                var gender = response['gender'];
                $("#gender").val(gender);
                
                var dob = response['dob']; 
                $("#dob").val(dob);
                var dob = new Date($("#dob").val());   
                var today = new Date();
                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                $("#age").val(age);
                 
               //on vérifie si inscription sur année en cours ou pas et on affiche le card d'avertissement
                var array = response['edc_subscriptions'][0];
                if(typeof array === "undefined"){
                    $('#renew').show();
                    $('#buttonrenew').show();
                } 


                var idsubs = response['edc_subscriptions'][0]['id'];
                $("#save").attr("idsubscriptions",idsubs);

                var club = response['edc_subscriptions'][0]['edc_club']['name'];
                
                var clubid = response['edc_subscriptions'][0]['clubnumber'];
                $("#club").attr("clubid",clubid);
                $("#club").val(clubid).change();
                
                var degree = response['edc_subscriptions'][0]['teacherdegree'];
                $("#degree").val(degree).change();

                var grade = response['edc_subscriptions'][0]['edc_grade']['label'];
                var gradeid = response['edc_subscriptions'][0]['edc_grade']['id'];
                $("#grade").attr("gradeid",gradeid);
                $("#grade").val(gradeid);

                var edc = response['edc_subscriptions'][0]['edc'];
                $("#edc").val(edc).change();  
                
            },
            error: function(){
                alert("Echec de la récupération des informations. Rechargez la page. ");
            }
            
        });
    
};

$( "#payment" ).change(function(){
    if($('#payment').val() == 0){
        $('#foc').hide();
    }
    if($('#payment').val() > 0){
        $('#foc').show();
    }
});

$( "#save" ).click(function() {
    var name = $("#name").val();
    var idmember = $("#save").attr("idmember");
    var idsubs = $("#save").attr("idsubscriptions");
    var idcourse = $("#title").attr("stageid");
    var paid = $("#payment").val();
    var age = $("#age").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var samediam = $("#samediam").val();
    var samedipm = $("#samedipm").val();
    var dimancheam = $("#dimancheam").val();
    var edc = $("#edc").val();
    var rgpd = $("#rgpd").val();
    var comments = $("#comments").val();
    var clubid = $("#club").val();
    var gradeid = $("#grade").val();
    var degree = $("#degree").val();
    var idseason = $("#title").attr('class');

        $.ajax({
                type: 'POST',
                headers : {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },
                url: 'https://aikido-hdf.fr/edc/edc-participants/addknown',
                data: {
                    name: name,
                    phone: phone,
                    email: email,
                    idmember : idmember,
                    idsubs : idsubs,
                    idcourse : idcourse,
                    paid : paid,
                    age : age,
                    samediam : samediam,
                    samedipm : samedipm,
                    dimancheam : dimancheam,
                    edc : edc,
                    rgpd : rgpd,
                    comments : comments,
                    clubid : clubid,
                    gradeid : gradeid,
                    degree : degree,
                    idseason : idseason
                },
                dataType: 'text',
                success: function(response){
                    location.href = "https://aikido-hdf.fr/edc/edc-courses/view/"+idcourse;
                    
                    },

                error: function(){
                    alert("some problem in saving data");
                    }
        });
    }
);


$( "#buttonrenew" ).click(function() {
    var name = $("#name").val();
    var idmember = $("#save").attr("idmember");
    var idcourse = $("#title").attr("stageid");
    var paid = $("#payment").val();
    var age = $("#age").val();
    var edc = $("#edc").val();
    var rgpd = $("#rgpd").val();
    var comments = $("#comments").val();
    var clubid = $("#club").val();
    var gradeid = $("#grade").val();
    var degree = $("#degree").val();
    var idseason = $("#title").attr('class');

        $.ajax({
                type: 'POST',
                headers : {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },
                url: 'https://aikido-hdf.fr/edc/edc-participants/addrenew',
                data: {
                    name: name,
                    idmember : idmember,
                    idcourse : idcourse,
                    paid : paid,
                    age : age,
                    edc : edc,
                    rgpd : rgpd,
                    comments : comments,
                    clubid : clubid,
                    gradeid : gradeid,
                    degree : degree,
                    idseason : idseason
                },
                dataType: 'json',
                success: function(response){
                    console.log(response)
                    $('#renew').hide();
                    $('#buttonrenew').hide();
                    $('#validrenew').show();
                    
                   var idsubs = response['edc_subscriptions'][0]['id'];
                
                    $("#save").attr("idsubscriptions",idsubs);
                    },

                error: function(){
                    alert("some problem in saving data");
                    }
        });
    
    }
);
</script>

