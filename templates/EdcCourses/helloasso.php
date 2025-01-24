<div id="title" class="<?= $course->idseason; ?>" stageid="<?= $course->id; ?>" >pré-inscription stage  </div>

<?php /**connexion à l'API HelloAsso à partir des infos de la config https://aikido-hdf.fr/edc/config/helloassoconfig */
try {
    $pdo = new PDO("mysql:host=aikidoh489.mysql.db:3306;dbname=aikidoh489", "aikidoh489", "At69mAurzEaq");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => "Erreur de connexion : " . $e->getMessage()]);
    exit;
}

$query = "SELECT client, client_secret, association FROM edc_helloasso LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $client_id = $result['client'];
    $client_secret = $result['client_secret'];
    $association = $result['association'];
} else {
    echo "Aucun résultat trouvé.";
}

$token_url = 'https://api.helloasso.com/oauth2/token';

$data = [
    'grant_type' => 'client_credentials',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Erreur Curl : ' . curl_error($ch);
}
curl_close($ch);


$response_data = json_decode($response, true);

if (isset($response_data['access_token'])) {
    $access_token = $response_data['access_token'];
} else {
    echo "Access token not found in response.";
}


$event = $course->helloasso;

/*$url = 'https://api.helloasso.com/v5/organizations/'. $association .'/forms/Event/'. $event .'/items&tierTypes=Registration&withDetails=true&retrieveAll=true&itemStates=Processed';
$args = [
    'headers' => array(
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $access_token,
        'user-agent'=> ''
    ),
    'method' => 'GET',
    'blocking' => true
];*/

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.helloasso.com/v5/organizations/'. $association .'/forms/Event/'. $event .'/items?pageIndex=1&pageSize=20&withDetails=false',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'accept: application/json',
        'authorization: Bearer '. $access_token
    ],
]);

$responsecomplete = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Erreur Curl : ' . curl_error($curl);
} else {
    $response_data = json_decode($responsecomplete, true);
   
    /**on affiche les résultats dans un tableau*/
    echo ' <table class="table table-hover responsive-table">
    <thead class="table-light">
        <tr>
            <th>Order Id</th>
           
           <th>Nom Prénom</th>
           <th>Club</th>
           <th>Grade</th>
           <th>Paiement</th>
            <th></th>
        </tr>
    </thead>
    <tbody>';
    if (isset($response_data['data']) && is_array($response_data['data'])) {
       
        foreach ($response_data['data'] as $entry) {
            
            if (isset($entry['user']['lastName'])) {
                $orderId = $entry['order']['id'];
                $lastNames = $entry['user']['lastName'];
                $firstNames = $entry['user']['firstName'];

                $curlOrder = curl_init();

                curl_setopt_array($curlOrder, [
                    CURLOPT_URL => 'https://api.helloasso.com/v5/items/' .$orderId .'?withDetails=true' ,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        'accept: application/json',
                        'authorization: Bearer '. $access_token
                    ],
                ]);

                $responseOrder = curl_exec($curlOrder);
                $data = json_decode($responseOrder, true);
                $clubName = null;
                $grade = null;
                $degree = null;
                $dob = null;
                $email = null;
                $phone = null;
                $payment = null;
              
                if (isset($data['customFields']) && is_array($data['customFields'])) {
                    foreach ($data['customFields'] as $field) {
                        if (isset($field['name']) && $field['name'] === 'Club') {
                            $clubName = $field['answer'];                             
                        }
                        if (isset($field['name']) && $field['name'] === 'Grade') {
                            $grade = $field['answer'];
                        }
                        if (isset($field['name']) && $field['name'] === 'Date de naissance') {
                            $dob = $field['answer'];
                        }
                        if (isset($field['name']) && $field['name'] === 'Email') {
                            $email = $field['answer'];
                        }
                        if (isset($field['name']) && $field['name'] === 'Téléphone') {
                            $phone = $field['answer'];
                        }
                        if (isset($field['name']) && $field['name'] === 'Diplôme d\'enseignant') {
                            $degree = $field['answer'];
                            break; // Arrêter la boucle une fois que le club est trouvé
                        }
                    }
                }
                if (isset($entry['amount'])) {
                    $payment = $entry['amount'];
                }
                
                echo " <tr>
                 <td>" . $orderId . "</td>
                 
            <td>" . $lastNames . " " . $firstNames . "</td>
            <td>" . $clubName . "</td>
            <td>" . $grade . "</td>    
            <td>" . $payment . "</td>
            <td><button class='search-btn' data-lastname='".$lastNames."' data-payment='".$payment."' data-clubname='".$clubName."' data-grade='".$grade."' data-dob='".$dob."' data-email='".$email."' data-degree='".$degree."' data-phone='".$phone."'>Valider</button></td></tr>";
            }
        }
    }
   
    echo '</tbody>
</table>';

}

curl_close($curl);
curl_close($curlOrder);
?>

<script>
    $(document).ready(function() {
    // Attacher un event listener à chaque bouton de recherche
        $('.search-btn').on('click', function() {
            var lastname = $(this).data('lastname');
            var clubname = $(this).data('clubname');
            var grade = $(this).data('grade');
            var dob = $(this).data('dob');
            var phone = $(this).data('phone');
            var email = $(this).data('email');
            var payment = $(this).data('payment');
            var degree = $(this).data('degree');
            fetchID(lastname,clubname,grade,dob,phone,email,payment,degree); // Appel de la fonction fetchID avec le nom de famille
        });
    });

    function fetchID(lastname,clubname,grade,dob,phone,email,payment,degree) {
        var idseason = $("#title").attr('class');
        var idcourse = $("#title").attr("stageid");
        $.ajax({
            type: 'POST',
            headers : {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            url: 'https://aikido-hdf.fr/edc/edc-participants/result',
            data: {
                name : lastname,
                idseason: idseason,
            },
            dataType: 'json',
            success: function(response){
                if(response != null){
                    /**l'adhérent est connu dans la base, on affiche ses données dans un formulaire pour l'inscrire au stage */
                    var id = response['id'];
                    location.href = "https://aikido-hdf.fr/edc/edc-participants/addhelloasso?id1="+idcourse+"&id2="+id+"&name="+lastname+"&club="+clubname+"&grade="+grade+"&dob="+dob+"&phone="+phone+"&email="+email+"&degree="+degree+"&payment="+payment;

                }else{
                      /**l'adhérent n'est pas connu dans la base, on affiche ses données dans un formulaire pour l'inscrire dans la base puis au stage */
                    location.href = "https://aikido-hdf.fr/edc/edc-participants/addnewhelloasso?id1="+idcourse+"&name="+lastname+"&club="+clubname+"&grade="+grade+"&dob="+dob+"&phone="+phone+"&email="+email+"&degree="+degree+"&payment="+payment;
                }
            },
            error: function(){
                alert("Echec de la récupération des informations. Rechargez la page. ");
            }
            
        });
    
};

</script>
