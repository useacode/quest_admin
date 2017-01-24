<!DOCTYPE html>
<html lang="en" ng-app="Admin">
<head>
    <meta charset="UTF-8">
    <title>Квест</title>
    <base href="/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
</head>
<body>
    <div class="header">
       <div class="">
           <div class="clearfix">
                <div class="col-xs-11">
                    <nav class="top-menu navbar">
                       <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target='.navbar-collapse'>
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="collapse">
                            <ul class="nav navbar-nav">
                                <li class="nav-item"><a href="new/"><nob>Новые заказы</nob></a></li>
                                <li class="nav-item"><a href="table/">График</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
           </div>
        </div>                
    </div>     
    <div ng-view>
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-route.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>