<div id="title">Liste des adhérents</div> 

<a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-subscriptions/add"><i class="material-icons left">account_circle</i>Ajouter une inscription</a>
<input type="text" name="searchmember" placeholder="recherche pratiquant" id="searchmember" class="form-control" style="display: inline;width:40%;margin-left: 5%;"> 
<button type="submit" id="searchMemberButton" style="padding: 9px 15px;">OK</button>
<table class="table highlight responsive-table"> 
    <thead class="table-light">
    <tr>
        <th>Nom</th>
        <th>Club</th>
        <th>Saisons</th>
        <th></th>
    </tr>
    </thead>
    <tbody id="listmembers">
    <?php foreach ($members as $m): ?>
    <tr>
        <td>
            <?= $this->Html->link($m->edc_member->name, ['action' => 'view', $m->edc_member->id],['class'=>"link-secondary"]) ?>
        </td>
        <td id="listmembersclub">
            <?php foreach($m->edc_member->edc_subscriptions as $e){
            echo $e->edc_club->name. '<br />';
            }?>
        </td>
        <td id="listmembersseason">
            <?php foreach($m->edc_member->edc_subscriptions as $e){
            echo $e->edc_season->name;
            if($e->edc == 'oui'){echo ' <small>EdC</small>';}
            echo '<br />';
            }?>
        </td>
        <td>
            
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table> 

<script>

$('#searchMemberButton').click(function(){
	var name = $('#searchmember').val();
	$.ajax({
		type: 'POST',
        headers : {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
		url: 'https://aikido-hdf.fr/edc/edc-members/result',
		data: {
			name: name,
		},
		dataType: 'text',
		success: function(response){
            console.log(response);
            var name = response['name'];
            $('#listmembers').html(response);
			},
		error: function(){
			alert("pas trouvé");
			}
	});
});
</script>