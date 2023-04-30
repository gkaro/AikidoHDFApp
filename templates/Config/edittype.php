<?php   
    echo $this->Form->create($type);
   
    echo '<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('name',['label' => 'Type de stage','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
   
    
    echo '<div class="row">';
    echo '<div class="col">';
    echo $this->Form->button(__('Sauvegarder'),['class'=>'form-control btn btn-primary']);
    echo'</div>';
    echo '<div class="col">';
    echo $this->Html->link('Annuler', ['controller'=>'config','action' => 'types'],['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);
    echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>
</div>
