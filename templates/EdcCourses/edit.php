<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<h3>Modifier le stage : <?= $course->edc_course_type->name; ?></h3>
<?php
    echo $this->Form->create($course);
    echo '<div class="row">';
        echo '<div class="col s4">';
        echo $this->Form->control('idseason', ['options' => $seasons,'label'=>'Saison', 'class'=>"form-control"]);
        echo'</div>';
        echo ' <div class="col s4">';
        echo $this->Form->control('idtype',['options' => $types,'label' => 'Type de stage', 'class'=>"form-control"]);
        echo'</div>';
        echo ' <div class="col s4">';
        echo $this->Form->control('date',['class'=>"form-control"]);
        echo'</div>';
    echo'</div>';


    echo '<div class="row">';
        echo ' <div class="col s4">';
        echo $this->Form->control('idplace',['options' => $places,'label' => 'Type de stage', 'class'=>"form-control"]);
        echo'</div>';
        echo ' <div class="col s4">';
        echo $this->Form->control('edc_course_teachers._ids',['type' => 'select','multiple' => true,'options' => $teachers,'label' => 'Intervenants', 'class'=>"form-control"]);
     echo'</div>';
        echo ' <div class="col s4">';
        echo $this->Form->control('price',['label' => 'Tarif', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo '<div class="row">';
        echo ' <div class="col s4">';
        echo $this->Form->button(__('Sauvegarder'),['class'=>'form-control btn btn-primary']);
        echo'</div>';
        echo ' <div class="col s4">';
        echo $this->Html->link("Annuler", ['action' => 'view',$course->id],['class'=>'form-control btn btn-primary my-5',"style"=>"margin:20px 0"]);
        echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>
