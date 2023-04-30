<div id="title">Lieux de stages</div>

<span >
    <a style="margin:2% 0" class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/config/addplace"><i class="material-icons left">add</i>Ajouter un lieu de stage</a>
</span>

<table class="table highlight responsive-table" id="graytable">
    
    <tbody>
    <?php foreach ($places as $p): ?>
    <tr>
        
        <td>
            <?= $p->name ?>
        </td>
        
        <td>
            <?= $this->Html->link("Modifier", ['action' => 'editplace', $p->id],['class'=>'btn btn-primary']) ?>
        </td>
        <td>
        <?= $this->Form->postLink(
                'Supprimer',
                ['action' => 'deleteplace', $p->id],
                ['confirm' => 'Êtes-vous sûr de vouloir supprimer?', "class"=>"waves-effect waves-light btn red"])
            ?>
        </td>
       
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>