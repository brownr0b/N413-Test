<html>
    <head>
        <link href="<?= config_item('base_uri') ?>assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= config_item('base_uri') ?>assets/icons/css/icons-fonts.css" rel="stylesheet"/>
        <link href="<?= config_item('base_uri') ?>assets/css/normalize.css" rel="stylesheet"/>
        <script src="<?= config_item('base_uri') ?>assets/js/jquery.min.js"></script>
        <script src="<?= config_item('base_uri') ?>assets/bs/js/bootstrap.min.js"></script>
    </head>
    <body style="padding-top: 60px;">
        <!-- BEGIN Bootstrap Navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header"><!-- Mobile menu code -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">N413 Contact</a>
                </div> <!-- /.navbar-header -->
                <div id="navbar" class="collapse navbar-collapse">  <!-- Full-width menu code -->
                    <ul class="nav navbar-nav">
                        <li><a href="https://in-info-web4.informatics.iupui.edu/~brownrob/N413/CodeIgniter-3.1.7/index.php/simpleview/">View One</a></li>
                        <li class="active"><a href="https://in-info-web4.informatics.iupui.edu/~brownrob/N413/CodeIgniter-3.1.7/index.php/simpleview/bs">View Two</a></li>
                    </ul>
                </div><!--/.collapse navbar-collapse -->
            </div><!--/.container -->
        </nav>
        <!-- END Bootstrap Navbar -->
        <div style="margin-left: 20px;">
            <h1>Users</h1>
            <?php
            foreach($records as $record){
                echo'<p>'.$record["name"].'</p>';
            }
            ?>
        </div>
    </body>
</html>