
<?php $referer = $this->request->referer(); ?>
<h3 class="mb-5">Liste des participants <?= $course->name; ?></h3> <span><?= $this->Html->link("Retour", $referer,['class'=>'btn btn-secondary']) ?></span>
<table class="table  highlight responsive-table">
    <thead class="table-light ">
        <tr>
            <th>Nom</th>
            <th>Club</th>
            <th style="text-align:center;">Grade</th>
            <th style="text-align:center;">Diplôme</th>
            <th style="text-align:center;">Paiement</th>
            <th style="text-align:center;">Km</th>
            <th style="text-align:center;">Edc</th>
            <th style="text-align:center;">Samedi Matin</th>
            <th style="text-align:center;">Samedi Après-midi</th>
            <th style="text-align:center;">Dimanche</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($participants as $c): ?>
        <tr>
            <td>
                <?= $c->edc_subscription ->edc_member->name; ?>
            </td>
            <td>
                <?= $c->edc_subscription->edc_club->name; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->edc_subscription->edc_grade->label; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->edc_subscription ->teacherdegree; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->payment; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->km; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->edc; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->satam; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->satpm; ?>
            </td>
            <td style="text-align:center;">
                <?= $c->sunam; ?>
            </td>
            <td>
                <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-participants/edit/<?= $c->id; ?>"><i class="material-icons">edit</i></a>
            </td>
            <td>
            <a class="waves-effect waves-light btn red" href="https://aikido-hdf.fr/edc/edc-participants/delete/<?= $c->id; ?>" data-confirm-message="êtes-vous sûr de vouloir supprimer?" onclick="if (confirm(this.dataset.confirmMessage)) { return true; } return false;"><i class="material-icons">delete</i></a>
            </td>
           
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>