<script>

    const DBOpenRequest = window.indexedDB.open("edc-members");
    DBOpenRequest.onsuccess = (event) => {
        db = DBOpenRequest.result;
        const transaction = db.transaction("members", "readwrite");
        var objectStore = transaction.objectStore("members");
        const objectStoreRequest = objectStore.getAll();
        objectStoreRequest.onsuccess = (event) => {
            const members = objectStoreRequest.result;
        }
        const cursorRequest = objectStore.openCursor();
        cursorRequest.onsuccess = e => {
            const cursor = e.target.result;
            let i = 0;
            if (cursor) {
                if (cursor.value.synced == "N" | cursor.value.synced == null) {
                    const id = cursor.value.id;
                    const name = cursor.value.name;
                    const phone = cursor.value.phone;
                    const email = cursor.value.email;
                    const dob = cursor.value.dob;
                    const gender = cursor.value.gender;
                    const member = document.getElementById("ismember");
                    member.innerHTML += '<tr id="detailmember" data-member=""><td class="idmember">'+id+'</td><td class="name">'+name+'</td><td class="phone">'+phone+'</td><td class="email">'+email+'</td><td class="dob">'+dob+'</td><td class="gender">'+gender+'</td></tr>';
                }
                cursor.continue();
            }
        };
    }
    
    const DBOpenRequestSubs = window.indexedDB.open("edc-subscriptions");
    DBOpenRequestSubs.onsuccess = (event) => {
        dbSubs = DBOpenRequestSubs.result;
        const transaction = dbSubs.transaction("subscriptions", "readwrite");
        var objectStore = transaction.objectStore("subscriptions");
        const objectStoreRequest = objectStore.getAll();
        objectStoreRequest.onsuccess = (event) => {
            const subscriptions = objectStoreRequest.result;
        }
        const cursorRequest = objectStore.openCursor();
        cursorRequest.onsuccess = e => {
            const cursor = e.target.result;
                
            if (cursor) {
                if (cursor.value.synced == "N" | cursor.value.synced == null) {
                    const id = cursor.value.id;
                    const idmember = cursor.value.idmember;
                    const clubnumber = cursor.value.clubnumber;
                    const actualgrade = cursor.value.actualgrade;
                    const teacherdegree = cursor.value.teacherdegree;
                    const idseason = cursor.value.idseason;
                    const age = cursor.value.age;
                    const edc = cursor.value.edc;
                    const subs = document.getElementById("subs");
                    subs.innerHTML += '<tr id="detailsubs"><td class="id">'+id+'</td><td class="idsubmember">'+idmember+'</td><td class="clubnumber">'+clubnumber+'</td><td class="actualgrade">'+actualgrade+'</td><td class="teacherdegree">'+teacherdegree+'</td><td class="idseason">'+idseason+'</td><td class="age">'+age+'</td><td class="edc">'+edc+'</td></tr>';
                }
                cursor.continue();
            }
        };
    }
    const DBOpenRequestParts = window.indexedDB.open("edc-participants");
    DBOpenRequestParts.onsuccess = (event) => {
        dbParts = DBOpenRequestParts.result;
        const transaction = dbParts.transaction("participants", "readwrite");
        var objectStore = transaction.objectStore("participants");
        const objectStoreRequest = objectStore.getAll();
        objectStoreRequest.onsuccess = (event) => {
            const participants = objectStoreRequest.result;
        }
        const cursorRequest = objectStore.openCursor();
        cursorRequest.onsuccess = e => {
            const cursor = e.target.result;
                
            if (cursor) {
                if (cursor.value.synced == "N" | cursor.value.synced == null) {
                    const id = cursor.value.id;
                    const idcourse = cursor.value.id_course;
                    const idsub = cursor.value.id_subscriptions;
                    const km = cursor.value.km;
                    const payment = cursor.value.payment;
                    const satam = cursor.value.satam;
                    const satpm = cursor.value.satpm;
                    const sunam = cursor.value.sunam;
                    const age = cursor.value.age;
                    const edc = cursor.value.edc;
                    const parts = document.getElementById("parts");
                    parts.innerHTML += '<tr id="detailparts"><td class="id">'+id+'</td><td class="idcourse">'+idcourse+'</td><td class="idsub">'+idsub+'</td><td class="satam">'+satam+'</td><td class="satpm">'+satpm+'</td><td class="sunam">'+sunam+'</td><td class="km">'+km+'</td><td class="age">'+age+'</td><td class="edc">'+edc+'</td><td class="payment">'+payment+'</td></tr>';
                }
                cursor.continue();
            }
        };
    }

   
</script>

<table class="tablesync">
    <thead>
    <tr> 
        <th>id</th>
        <th>nom</th>
        <th>téléphone</th>
        <th>email</th>
        <th>date de naissance</th>
        <th>genre</th>
    </tr>
    </thead>
    <tbody id="ismember">
        
    </tbody>
</table>
<div id="syncmember" style="margin:20px 0px" class="form-control btn btn-primary">Valider</div>
<table class="tablesync" style="margin-top:5%">
    <thead>
    <tr>
        <th>id inscriptions</th>
        <th>id pratiquant</th>
        <th>club</th>
        <th>grade</th>
        <th>diplôme</th>
        <th>saison</th>
        <th>age</th>
        <th>edc</th>
    </tr>
    </thead>
    <tbody id="subs">
        
    </tbody>
</table>
<div id="syncsubs" style="margin:20px 0px" class="form-control btn btn-primary">Valider</div>
<table class="tablesync" style="margin-top:5%">
    <thead>
    <tr>
        <th>id</th>
        <th>stage</th>
        <th>id inscriptions</th>
        <th>samedi matin</th>
        <th>samedi après-midi</th>
        <th>dimanche matin</th>
        <th>km</th>
        <th>age</th>
        <th>edc</th>
        <th>paiement</th>
    </tr>
    </thead>
    <tbody id="parts">
        
    </tbody>
</table>
<div id="syncparts" style="margin:20px 0px" class="form-control btn btn-primary">Valider</div>
<script>
    /*valider synchronisation Membres*/
    $("#syncmember" ).click(function() {
            for (let i = 1; i <= $('#ismember tr').length; i++) {
                document.getElementById('detailmember').setAttribute('data-member', i);
                console.log($('#ismember tr').length);
                console.log(i);
                //makeRequest(i);
        }
    });
    /*fonction qui récupère les données du tableau et les envois en bdd*/
        function makeRequest(i){
            console.log('toto 2');
                //var row = document.querySelectorAll('[data-member="'+i+ '"]');
               
                let content = document.getElementById(i);
                let id = document.getElementById(i).getElementsByClassName('idmember')[0].innerHTML;
                let name = document.getElementById(i).getElementsByClassName('name')[0].innerHTML;
                let phone = document.getElementById(i).getElementsByClassName('phone')[0].innerHTML;
                let email = document.getElementById(i).getElementsByClassName('email')[0].innerHTML;
                let dob = document.getElementById(i).getElementsByClassName('dob')[0].innerHTML;
                let gender = document.getElementById(i).getElementsByClassName('gender')[0].innerHTML;
               /* $.ajax({
                    type: 'POST',
                    headers : {
                            'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                        },
                    url: "https://aikido-hdf.fr/edc/edc-members/syncmember/"+i,
                    data:{
                        id : id,
                        name : name,
                        phone : phone,
                        email : email,
                        dob : dob,
                        gender : gender
                    },
                    dataType: 'text',
                    async:false, 
                    success: function(response){
                        alert("synchro ok pour " + id);
                    },

                    error: function(){
                        alert("erreur sur synchro " + id);
                    }
                });*/

        };

         /*valider synchronisation Subscriptions*/
         $( "#syncsubs" ).click(function() {
            for (let i = 1; i <= $('#subs tr').length; i++) {
                document.getElementById('detailsubs').setAttribute('id', i);
                syncSubs(i);
            }
        });
        /*fonction qui récupère les données du tableau et les envois en bdd*/
        function syncSubs(i){
                var row = document.getElementById(i);
                let content = document.getElementById(i);
                let id = document.getElementById(i).getElementsByClassName('id')[0].innerHTML;
                let idmember = document.getElementById(i).getElementsByClassName('idsubmember')[0].innerHTML;
                let clubnumber = document.getElementById(i).getElementsByClassName('clubnumber')[0].innerHTML;
                let actualgrade = document.getElementById(i).getElementsByClassName('actualgrade')[0].innerHTML;
                let teacherdegree = document.getElementById(i).getElementsByClassName('teacherdegree')[0].innerHTML;
                let idseason = document.getElementById(i).getElementsByClassName('idseason')[0].innerHTML;
                let age = document.getElementById(i).getElementsByClassName('age')[0].innerHTML;
                let edc = document.getElementById(i).getElementsByClassName('edc')[0].innerHTML;
                $.ajax({
                    type: 'POST',
                    headers : {
                            'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                        },
                    url: "https://aikido-hdf.fr/edc/edc-subscriptions/syncsub/"+i,
                    data:{
                        id : id,
                        idmember : idmember,
                        clubnumber : clubnumber,
                        actualgrade : actualgrade,
                        teacherdegree : teacherdegree,
                        idseason : idseason,
                        age : age,
                        edc : edc
                    },
                    dataType: 'text',
                    async:false, 
                    success: function(response){
                        alert("synchro ok pour " + id);
                        location.reload(true); 
                    },

                    error: function(){
                        alert("erreur sur synchro " + id);
                    }
            });

           
        };
       /*valider synchronisation participants*/
       $( "#syncparts" ).click(function() {
            for (let i = 1; i <= $('#parts tr').length; i++) {
                document.getElementById('detailparts').setAttribute('id', i);
                syncparts(i);
            }
        });
        /*fonction qui récupère les données du tableau et les envois en bdd*/
        function syncparts(i){
                var row = document.getElementById(i);
                let content = document.getElementById(i);
                let id = document.getElementById(i).getElementsByClassName('id')[0].innerHTML;
                let idcourse = document.getElementById(i).getElementsByClassName('idcourse')[0].innerHTML;
                let idsub = document.getElementById(i).getElementsByClassName('idsub')[0].innerHTML;
                let km = document.getElementById(i).getElementsByClassName('km')[0].innerHTML;
                let payment = document.getElementById(i).getElementsByClassName('payment')[0].innerHTML;
                let satam = document.getElementById(i).getElementsByClassName('satam')[0].innerHTML;
                let satpm = document.getElementById(i).getElementsByClassName('satpm')[0].innerHTML;
                let sunam = document.getElementById(i).getElementsByClassName('sunam')[0].innerHTML;
                let age = document.getElementById(i).getElementsByClassName('age')[0].innerHTML;
                let edc = document.getElementById(i).getElementsByClassName('edc')[0].innerHTML;
                $.ajax({
                    type: 'POST',
                    headers : {
                            'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                        },
                    url: "https://aikido-hdf.fr/edc/edc-participants/syncpart/"+i,
                    data:{
                        id : id,
                        idcourse : idcourse,
                        idsub : idsub,
                        km : km,
                        payment : payment,
                        satam : satam,
                        satpm : satpm,
                        sunam : sunam,
                        age : age,
                        edc : edc
                    },
                    dataType: 'text',
                    async:false, 
                    success: function(response){
                        alert("synchro ok pour " + id);
                    },

                    error: function(){
                        alert("erreur sur synchro " + id);
                    }
            });

           
        };
</script>