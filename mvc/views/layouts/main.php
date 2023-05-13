<!DOCTYPE html>
<html>
<head>
    <title>Proyecto MVC</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= \DaVinci\Core\App::getUrlPath();?>css/bootstrap.css">
    <link rel="stylesheet" href="<?= \DaVinci\Core\App::getUrlPath();?>css/estilos.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Da Vinci</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= \DaVinci\Core\App::getUrlPath() . '';?>">Home</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container main-content">
        @{{content}}
    </div>

    <div class="footer">
        Copyright &copy; Da Vinci 2018
    </div>
    <script src="<?= \DaVinci\Core\App::getUrlPath();?>js/jquery-3.2.1.js"></script>
    <script src="<?= \DaVinci\Core\App::getUrlPath();?>js/bootstrap.js"></script>
</body>
</html>


