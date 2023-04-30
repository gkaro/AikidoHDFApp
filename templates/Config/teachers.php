<div id="title">Intervenants</div>

<span >
    <a style="margin:2% 0" class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/config/addteacher"><i class="material-icons left">add</i>Ajouter un intervenant</a>
</span>

<table class="table highlight responsive-table" id="graytable">
    
    <tbody>
    <?php foreach ($teachers as $t): ?>
    <tr>
        
        <td>
            <?= $t->name ?>
        </td>
        
        <td>
            <?= $this->Html->link("Modifier", ['action' => 'editteacher', $t->id],['class'=>'btn btn-primary']) ?>
        </td>
        <td>
        <?= $this->Form->postLink(
                'Supprimer',
                ['action' => 'deleteteacher', $t->id],
                ['confirm' => 'Êtes-vous sûr de vouloir supprimer?', "class"=>"waves-effect waves-light btn red"])
            ?>
        </td>
       
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>