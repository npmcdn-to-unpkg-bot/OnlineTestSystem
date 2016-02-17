<!DOCTYPE html>
<html ng-app="OES" lang="en">
	<head>
		<meta charset="UTF-8">
    	<base href="http://localhost/A0WebRoot/OnlineTestSystem/">
    	<script src="<?=assets?>pace/pace.min.js"></script>
    	<link href="<?=assets?>pace/pace.css" rel="stylesheet" />
		<title>PSITCoe CS/IT Exam System</title>
		<link href="<?=assets?>bootstrap/bootstrap.min.css" rel="stylesheet" />
		<link href="<?=assets?>font-awesome/font-awesome.min.css" rel="stylesheet" />
		<link href="<?=assets?>css/app.css" rel="stylesheet" />
		<style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>
	</head>
	<body ng-cloak ng-controller="OESController">
		<div ng-view></div>
		<script src="<?=assets?>jquery/jquery-2.1.4.min.js"></script>
		<script src="<?=assets?>angular/angular.min.js"></script>
		<script src="<?=assets?>angular/angular-route.min.js"></script>
		<script src="<?=assets?>bootstrap/bootstrap.min.js"></script>
		<script src="<?=assets?>js/app.js"></script>
	</body>
</html>