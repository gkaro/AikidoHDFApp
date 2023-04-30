<script>
    $(document).ready(function(){
    $('select').formSelect();
  });
</script>

<div id="title">Ajouter un stage</div>
<?php
    echo $this->Form->create($course);
    echo '<div class="row gx-5">';
    echo '<div class="col s4">';
    echo $this->Form->control('idseason', ['options' => $seasonslist,'label'=>'Saison', 'class'=>"form-control"]);
    echo'</div>';
    echo ' <div class="col s4">';
    echo $this->Form->control('idtype',['options' => $types,'label' => 'Type de stage', 'class'=>"form-control"]);
    echo'</div>';
    echo ' <div class="col s4">';
    echo $this->Form->control('date',['class'=>"form-control"]);
    echo'</div>';
    echo'</div>';


    echo '<div class="row gx-5">';
    echo '<div class="col s4">';
    echo $this->Form->control('idplace',['options' => $places,'label' => 'Lieu du stage', 'class'=>"form-control"]);
    echo'</div>';
    echo '<div class="col s4">';
    echo $this->Form->control('edc_course_teachers._ids',['type' => 'select','multiple' => true,'options' => $teachers,'label' => 'Intervenants', 'class'=>"form-control"]);
    echo'</div>';
    echo '<div class="col s4">';
    echo $this->Form->control('price',['label' => 'Tarif', 'class'=>"form-control"]);
    echo'</div>';
    echo'</div>';

    echo '<div class="row gx-5">';
    echo '<div class="col s4">';
    echo $this->Form->control('fullname',['label' => 'Nom complet', 'class'=>"form-control"]);
    echo'</div>';
    echo'</div>';

    echo '<div class="row gx-5">';
    echo '<div class="col">';
    echo $this->Form->button(__('Sauvegarder'),['class'=>'form-control btn btn-primary']);
    echo'</div>';
    echo '<div class="col">';
    echo $this->Html->link('Annuler', ['controller'=>'edc-courses','action' => 'index'],['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);
    echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>

<script>
$( "#idplace" ).change(function(){
  var type = $("#idtype option:selected" ).text();
  var date = $("#date").val();
  var place = $("#idplace option:selected").text();
  var completename = type + "-" + date + "-" + place
   $('#fullname').val(completename) 
   
});
</script>
