<script>
$(document).ready(function(){
    $('.collapsible').collapsible();
});
</script>

<h4 id="title" season=<?= '"'.$season->id.'"';?>>Participations aux stages saison <?= $season->name ?></h4>

<input type="text" name="searchmember" placeholder="recherche pratiquant" id="searchmember" class="form-control" style="display: inline;width:40%;margin-left: 5%;"> 
<button type="submit" id="searchMemberButton" style="padding: 9px 15px;">OK</button>

<div id="listmembers" class="row" style="margin-top:5%" id="stats">
    
    <div class="col s12">
        <ul class="collapsible">
            <?php foreach ($subs as $s): ?>

            <li>
                <div class="collapsible-header">
                    <div class="container" style="width:100%"> 
                        <div class="row"> 
                            <div class="col s3">
                                <strong><?= $s->edc_member->name ?></strong> 
                                <a class="waves-effect waves-light" href="https://aikido-hdf.fr/edc/edc-members/edit/<?= $s->edc_member->id; ?>"><i class="material-icons tiny">edit</i></a>
                                <br>
                                <small><?= $s->edc_club->name ?></small>
                            </div>
                        
                            <div class="col s2">
                                <?= $s->edc_grade->label ?>
                            </div>
                            <div class="col s1">
                                <?= $s->teacherdegree ?>
                            </div>
                            <div class="col s1">
                                <?= $s->edc ?>
                            </div>
                            <div class="col s2">
                                <?php if ($s->nbcourses == null){
                                    echo "pas de stages";
                                }
                                elseif ($s->nbcourses == '1'){
                                    echo $s->nbcourses." stage";
                                }
                                elseif ($s->nbcourses > '1')
                                    echo $s->nbcourses." stages" ;?>
                            </div>
                            <div class="col s3">
                                <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-subscriptions/edit/<?= $s->id; ?>"><i class="material-icons">edit</i></a>
                                <?= $this->Form->postLink(
                                    'Supprimer',
                                    ['controller'=>'edc-subscriptions','action' => 'delete', $s->id],
                                    ['confirm' => 'Êtes-vous sûr de vouloir supprimer?', "class"=>"waves-effect waves-light btn red"])
                                ?>          
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapsible-body">
                    <?php foreach ($parts as $p): ?>
                
                    <?php if ($p->id_subscriptions == $s->id) {
                        echo $p->edc_course->edc_course_type->name." le ".$p->edc_course->date->format('d-m-Y')." à ".$p->edc_course->edc_course_place->name."</br>";
                    }?>
                
                    <?php endforeach; ?>
                </div>
            </li>
    
            <?php endforeach; ?>  
        </ul>
    </div>
</div>
<script>

$('#searchMemberButton').click(function(){
	var name = $('#searchmember').val();
    var idseason = $('#title').attr("season");
	$.ajax({
		type: 'POST',
        headers : {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
		url: 'https://aikido-hdf.fr/edc/edc-seasons/result',
		data: {
			name: name,
            idseason: idseason,
		},
		dataType: 'text',
		success: function(response){
           
            $('#listmembers').html(response);
			},
		error: function(){
			alert("pas trouvé");
			}
	});
});
</script>