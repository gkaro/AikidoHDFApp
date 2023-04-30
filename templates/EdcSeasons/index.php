<div id="title">Saisons sportives</div>
<?= $this->Html->link("ajouter", ['action' => 'add'],['class'=>'btn btn-primary','style'=>'margin:2% 0']) ?>
<table class="table table-hover" id="graytable">
   
    <tbody>
        <?php foreach ($seasons as $season): ?>
        <tr>
            <td>
                Saison <?= $season->name ?>
            </td>
            <td>
                
            </td>
            <td>
                <?= $this->Html->link("Participations aux stages", ['action' => 'view', $season->id],['class'=>'btn btn-primary']) ?>
            
                <?= $this->Html->link("XLS", ['action' => 'exportsubscriptions', $season->id],['class'=>'btn btn-primary']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
