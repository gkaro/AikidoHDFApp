<div id="title">Types de stages</div>

<span >
    <a style="margin:2% 0" class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/config/addtype"><i class="material-icons left">add</i>Ajouter un type de stage</a>
</span>

<table class="table highlight responsive-table" id="graytable">
    
    <tbody>
    <?php foreach ($types as $t): ?>
    <tr>
        
        <td>
            <?= $t->name ?>
        </td>
        
        <td>
            <?= $this->Html->link("Modifier", ['action' => 'edittype', $t->id],['class'=>'btn btn-primary']) ?>
        </td>
        <td>
            <?= $this->Form->postLink(
                'Supprimer',
                ['action' => 'deletetype', $t->id],
                ['confirm' => 'Êtes-vous sûr de vouloir supprimer?', "class"=>"waves-effect waves-light btn red"])
            ?>
        </td>
       
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>