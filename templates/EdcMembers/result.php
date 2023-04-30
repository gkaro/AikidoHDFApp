<?php foreach ($result as $m): ?>
    <tr>
        <td>
            <?= $this->Html->link($m->name, ['action' => 'view', $m->id],['class'=>"link-secondary"]) ?>
        </td>
        <td id="listmembersclub">
            <?php foreach($m->edc_subscriptions as $e){
            echo $e->edc_club->name. '<br />';
            }?>
        </td>
        <td id="listmembersseason">
            <?php foreach($m->edc_subscriptions as $e){
            echo $e->edc_season->name. '<br />';
            }?>
        </td>
        <td>
            
        </td>
    </tr>
    <?php endforeach; ?>