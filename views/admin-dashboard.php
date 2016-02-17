<!DOCTYPE html>
<html ng-app="admin-OES" lang="en">
<head>
    <meta charset="UTF-8">
    <base href="http://localhost/A0WebRoot/OnlineTestSystem/">
    <script src="<?=assets?>pace/pace.min.js"></script>
    <link href="<?=assets?>pace/pace.css" rel="stylesheet" />
    <title>Admin Dashboard - PSITCoe CS/IT Exam System</title>
    <link href="<?=assets?>bootstrap/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=assets?>font-awesome/font-awesome.min.css" rel="stylesheet" />
    <link href="<?=assets?>jquery/jquery.bdt.min.css" rel="stylesheet" />
    <link href="<?=assets?>css/admin.css" rel="stylesheet" />
    <link href="<?=assets?>angular-toastr/dist/angular-toastr.min.css" rel="stylesheet" />
    <link href="<?=assets?>datetimepicker-master/jquery.datetimepicker.css" rel="stylesheet" />
    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>
</head>
<body ng-cloak ng-controller="AdminOESController">
<nav class="navbar navbar-inverse">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><!--PSITCoe OES--> Major Project</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="dashboard">Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="manage-exams">Manage Exams</a></li>
                        <li><a href="manage-courses">Manage Courses</a></li>
                        <li><a href="manage-question">Manage Question Banks</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="manage-students">Manage Students</a></li>
                    </ul>
                </li>
                <li><a href="#">Exam Results</a></li>
                <li><a href="#">Live Exam Feed</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#">Sign out</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

</div>
<div ng-view></div>
<script src="<?=assets?>jquery/jquery-2.1.4.min.js"></script>
<script src="<?=assets?>angular/angular.min.js"></script>
<script src="<?=assets?>angular/angular-route.min.js"></script>
<script src="<?=assets?>ng-fx/dist/ng-fx.js"></script>
<script src="<?=assets?>angular/angular-animate.min.js"></script>
<script src="<?=assets?>angular-toastr/dist/angular-toastr.tpls.js"></script>
<script src="<?=assets?>bootstrap/bootstrap.min.js"></script>
<script src="<?=assets?>jquery/jquery.bdt.min.js"></script>
<script src="<?=assets?>jquery/vendor/jquery.sortelements.js"></script>
<script src="<?=assets?>bootstrap/bootstrap-hover-dropdown.min.js"></script>
<script src="<?=assets?>datetimepicker-master/build/jquery.datetimepicker.full.js"></script>
<script src="<?=assets?>js/admin.js"></script>
</body>
</html>