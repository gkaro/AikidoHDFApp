<?php   
    echo $this->Form->create($config);
   
    echo '<div class="row">';
        echo '<div class="col s4">';
            echo $this->Form->control('client',['label' => 'Client ID','class'=>"form-control"]);
            echo $this->Form->control('client_secret',['label' => 'Client Secret','class'=>"form-control"]);
            echo $this->Form->control('association',['label' => 'Association','class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
   
    
    echo '<div class="row">';
        echo '<div class="col">';
        echo $this->Form->button(__('Sauvegarder'),['class'=>'form-control btn btn-primary']);
        echo'</div>';
    echo'</div>';
    echo $this->Form->end();
?>
</div>
