<div id="title">
    <?php echo  $member->name; ?> 
    <span><a class="" href="https://aikido-hdf.fr/edc/edc-members/edit/<?= $member->id; ?>"><i class="material-icons">edit</i></a>
    </span>
</div>

<p><small>Créé le : <?= $member->created ?></small></p>
<p><strong>Date de naissance</strong> : <?= h($member->dob) ?></p>
<p><strong>Email</strong> : <?= h($member->email) ?> <strong>Téléphone</strong> : <?= h($member->phone) ?></p>
<p><strong>Commentaires</strong> : <?= h($member->comments) ?></p>

<h4>Inscriptions</h4>
<table class="table table-hover" id="graytable"> 
    
    <tbody>
    <?php foreach ($member->edc_subscriptions as $s): ?>
        <tr>
            <td>
            <strong><?= $s->created->format('d-m-Y') ?></strong><br><small>Date d'inscription</small>
            </td>
            <td>
            <strong><?= $s->edc_club->name ?></strong><br><small>Club</small>
            </td>
            <td>
            <strong><?= $s->edc_grade->label ?></strong> <br><small>Grade</small>
            </td>
            <td>
            <strong><?= $s->teacherdegree ?></strong><br><small>Diplôme</small>
            </td>
            <td>
            <strong><?= $s->edc ?></strong><br><small>EdC</small>
            </td>
            <td>
            <strong><?= $s->edc_season->name ?></strong>
            </td>
            <td>
                <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-subscriptions/edit/<?= $s->id; ?>"><i class="material-icons">edit</i></a>
                  <?= $this->Form->postLink(
                'Supprimer',
                ['controller'=>'edc-subscriptions','action' => 'delete', $s->id],
                ['confirm' => 'Êtes-vous sûr de vouloir supprimer?', "class"=>"waves-effect waves-light btn red"])
            ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a class="btn-floating waves-effect waves-light" href="https://aikido-hdf.fr/edc/edc-subscriptions/renew/<?= $member->id; ?>"><i class="material-icons">add</i></a>
