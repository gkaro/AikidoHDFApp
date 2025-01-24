<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ruda:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/edc/css/materialize.css">
    <link rel="stylesheet" href="/edc/css/custom.css"/>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    
    <script src="/edc/js/materialize.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
    <?= $this->Html->meta("csrfToken", $this->request->getAttribute("csrfToken"));?>

    <script src="/edc/js/offline.js"></script>

    <!--PWA Manifest et Service Worker-->
    <link rel="manifest" href="/edc/manifest.json">
    <script>
        navigator.serviceWorker.register("https://aikido-hdf.fr/pwabuilder-sw.js").catch(console.error);
    </script>
</head>
<body>
<script>
   $(document).ready(function () {
        $('.dropdown-trigger').dropdown({
            constrainWidth:false,
        }); 
        $('.sidenav').sidenav();
  });
</script>

<!--Menu Principal -->
    <ul id="dropdownmembers" class="dropdown-content">
        <li><a href="<?= $this->Url->build('/edc-members/index') ?>">Liste complète</a></li>
        <li><a href="<?= $this->Url->build('/edc-members/edc') ?>">EdC</a></li>
    </ul>

    <ul id="dropdownstats" class="dropdown-content">
        <li><a href="<?= $this->Url->build('/stats/index') ?>">Stats Globales EdC</a></li>
        <li><a href="<?= $this->Url->build('/stats/type') ?>">Stats par type de Stages</a></li>
        <li><a href="<?= $this->Url->build('/stats/teacher') ?>">Stats par Intervenant</a></li>
        <li><a href="<?= $this->Url->build('/stats/place') ?>">Stats par lieu de stage</a></li>
        <?php foreach ($seasons as $s): ?>
        <li> <?= $this->Html->link("Stages ".$s->name, ['controller'=>'stats','action' => 'seasoncourses',$s->id],['class'=>'dropdown-item']) ?></li>
        <?php endforeach; ?>
    </ul>

    <ul id="dropdownconfig" class="dropdown-content">
        <li><a href="<?= $this->Url->build('/config/types') ?>">Types de stage</a></li>
        <li><a href="<?= $this->Url->build('/config/places') ?>">Lieux de stage</a></li>
        <li><a href="<?= $this->Url->build('/config/teachers') ?>">Intervenants</a></li>
        <li><a href="<?= $this->Url->build('/config/clubs') ?>">Listes des clubs</a></li>
        <li><a href="<?= $this->Url->build('/config/helloassoconfig') ?>">Hello Asso</a></li>
    </ul>

   
    <nav>
        <div class="nav-wrapper">
            <a href="<?= $this->Url->build('/') ?>" class="brand-logo left">Stages Ligue HDF</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="<?= $this->Url->build('/edc-courses/index') ?>">Stages</a></li>
                <li><a href="#!" class="dropdown-trigger" data-target="dropdownmembers">Participants<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="<?= $this->Url->build('/edc-seasons/index') ?>">Saisons sportives</a></li>
                <li><a href="#!" class="dropdown-trigger" data-target="dropdownstats">Stats<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="#!" class="dropdown-trigger" data-target="dropdownconfig">Configuration<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="<?= $this->Url->build('/edc-members/offline') ?>">Hors Connexion</a></li>
            </ul>
        </div>
    </nav>

<!--Menu Principal version mobile -->
    <ul id="dropdown4" class="dropdown-content">
        <li><a href="<?= $this->Url->build('/stats/index') ?>">Stats EdC</a></li>
        <li><a href="<?= $this->Url->build('/stats/type') ?>">Stats type de Stages</a></li>
        <li><a href="<?= $this->Url->build('/stats/teacher') ?>">Stats Intervenant</a></li>
        <li><a href="<?= $this->Url->build('/stats/place') ?>">Stats Lieux</a></li>
        <?php foreach ($seasons as $s): ?>
        <li> <?= $this->Html->link("Stages ".$s->name, ['controller'=>'stats','action' => 'seasoncourses',$s->id],['class'=>'dropdown-item']) ?></li>
        <?php endforeach; ?>
    </ul>
    <ul class="sidenav" id="mobile-demo">
        <li><a href="<?= $this->Url->build('/edc-courses/index') ?>">Stages</a></li>
        <li><a href="<?= $this->Url->build('/edc-members/index') ?>">EdC</a></li>
        <li><a href="<?= $this->Url->build('/edc-seasons/index') ?>">Saisons sportives</a></li>
        <li><a href="#!" class="dropdown-trigger" data-target="dropdown4">Stats<i class="material-icons right">arrow_drop_down</i></a></li>
        <li><a href="<?= $this->Url->build('/edc-members/offline') ?>">Hors Connexion</a></li>
    </ul>


    
     
    <main class="main">
        <div class="container px-5 mt-5 edc">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer style="min-height:20px;">
    
    <img src="https://media.tenor.com/pN36RDwHQSoAAAAj/tuesday-hamster.gif" alt="mini-gif-image-animee-0016" />
    
  
    
    </footer>
</body>
</html>