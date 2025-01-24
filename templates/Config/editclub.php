<?php   
    echo $this->Form->create($club);
   
    echo '<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('name',['label' => 'Nom du club','class'=>"form-control"]);
            echo $this->Form->control('city',['label' => 'Ville','class'=>"form-control"]);
            $options = ['Nord-Pas-De-Calais' => 'Nord-Pas-De-Calais', 'Picardie' => 'Picardie','Hors Ligue'=>'Hors Ligue'];
            
            echo $this->Form->control('CID',['label' => 'CID','class'=>"form-control"]);
            echo $this->Form->control('map',['label' => 'Coordonnées GPS','class'=>"form-control"]);
            echo $this->Form->control('complete_name',['label' => 'Nom complet','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
   
    
    echo '<div class="row">';
    echo '<div class="col">';
    echo $this->Form->button(__('Sauvegarder'),['class'=>'form-control btn btn-primary']);
    echo'</div>';
    echo '<div class="col">';
    echo $this->Html->link('Annuler', ['controller'=>'config','action' => 'clubs'],['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);
    echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>
</div>
