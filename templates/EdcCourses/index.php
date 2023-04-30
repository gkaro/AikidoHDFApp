<div id="title">Stages</div>
<div class="hide-on-small-only">
    <span >
    <a style="margin:2% 0" class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-courses/add"><i class="material-icons left">add</i>Ajouter un stage</a>
    </span>
    <span style="margin-left:5%">

    <a style="margin:2% 0" class="waves-effect waves-light btn sync" href="https://aikido-hdf.fr/edc/edc-courses/sync"><i class="material-icons left">sync</i>Synchro</a>
    </span>
</div>
<div class="show-on-small-only hide-on-med-and-up">
    <span >
    <a style="margin:2% 0" class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-courses/add"><i class="material-icons">add</i></a>
    </span>
    <span style="margin-left:5%">

    <a style="margin:2% 0" class="waves-effect waves-light btn sync" href="https://aikido-hdf.fr/edc/edc-courses/sync"><i class="material-icons">sync</i></a>
    </span>
</div>
<table class="table highlight responsive-table" id="graytable">
    
    <tbody>
    <?php foreach ($courses as $c): ?>
      
    <tr> 
        <td>
            <?= $c->date->format('d-M-Y') ?>
        </td>
        <td>
            <?= $c->edc_course_place->name; ?>
        </td>
        <td>
            <?php $name = $c->edc_course_type->name; ?>
        <?= $this->Html->link("$name", ['action' => 'view', $c->id],['class'=>"link-secondary"]) ?>
        </td>
        <td>
            <?php foreach ($c->edc_course_teachers as $t): ?>
            <?= $t->name; ?> |
            <?php endforeach; ?>
        </td>
        <td>
            <?= $this->Html->link("Participants", ['action' => 'listparticipants', $c->id],['class'=>'btn btn-primary']) ?>
        </td>
        <td>
            <?= $this->Html->link("XLS", ['action' => 'exportparticipants', $c->id],['class'=>'btn btn-primary']) ?>
        </td>
        <td>
            <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-courses/stats/<?= $c->id; ?>"><i class="material-icons">insert_chart</i></a>
        </td>
       
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
