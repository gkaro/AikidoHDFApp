<div id="title">Liste des clubs</div>

<span >
    <a style="margin:2% 0" class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/config/addclub"><i class="material-icons left">add</i>Ajouter un club</a>
</span>

<table class="table highlight responsive-table" id="graytable">
    
    <tbody>
    <?php foreach ($clubs as $c): ?>
    <tr>
        
        <td>
            <?= $c->name ?>
        </td>
        <td>
            <?= $c->city ?>
        </td>
        <td>
            <?= $c->CID ?>
        </td>
        <td>
            <?= $c->map ?>
        </td>
        <td>
            <?= $c->complete_name ?>
        </td>
        <td>
            <?= $this->Html->link("Modifier", ['action' => 'editclub', $c->id],['class'=>'btn btn-primary']) ?>
        </td>
        <td>
            <?= $this->Form->postLink(
                'Supprimer',
                ['action' => 'deleteclub', $c->id],
                ['confirm' => 'Êtes-vous sûr de vouloir supprimer?', "class"=>"waves-effect waves-light btn red"])
            ?>
        </td>
       
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>