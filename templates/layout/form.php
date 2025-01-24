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
   
    <?php echo $this->Html->meta("csrfToken", $this->request->getAttribute("csrfToken"));?>

     
</head>
<body>

    <main class="main">
        <div class="container px-5 mt-5 edc">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer style="min-height:100px;">
    
    
    </footer>
</body>
</html>

