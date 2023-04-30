<div id="title">Ouvrir une nouvelle saison sportive</div>
<?php
    echo $this->Form->create($season);
    echo '<div class="row gx-5">';
        echo '<div class="col">';
        echo $this->Form->control('name',['label' => 'Nouvelle Période', 'class'=>"form-control"]);
        echo'</div>';
    echo'</div>';
    echo $this->Form->button(__('Sauvegarder'), ['class'=>'btn btn-primary']);
    echo $this->Form->end();
?>