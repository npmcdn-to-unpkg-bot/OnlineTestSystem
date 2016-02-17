/**
 * Created by janruls1 on 22-11-2015.
 */
var app = angular.module("OES",['ngRoute']).config(function($routeProvider, $locationProvider){
    $routeProvider
        .when('/', {
            templateUrl : 'home/angular',
            controller : 'OESController'
        })
        .when('/login', {
            templateUrl : 'login/angular',
            controller : 'loginController'
        })
        .otherwise({
            redirectTo: '/'
         });

    // use the HTML5 History API
    $locationProvider.html5Mode(true);
});
app.controller('loginController', function($scope, $http){
    $scope.dispatchMessage = function($type, $msg){
        $(".notice").html("<div class='alert alert-"+$type+"'>"+$msg+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>")
    }
    $scope.clearMessage = function(){
        $(".notice").html("");
    }
	$scope.validate = function($event){
        $event.preventDefault();
        if(isNaN(parseInt($scope.username))){
            $scope.dispatchMessage('danger', 'Username must contain numbers only');
            $scope.username = "";
            $("#username").focus();
            return false;
        }else if(parseInt($scope.username) < 1000000000 || parseInt($scope.username) > 9999999999) {
            $scope.dispatchMessage('danger', 'Username must be of 10 digit');
            $("#username").focus();
            return false;
        }else if($scope.password.length < 4){
            $scope.dispatchMessage('danger', 'Password must be of at least 4 chars');
            $("#password").focus();
        }else{
            $scope.clearMessage();
            $("#username,#password,.login-btn").prop('disabled', true);
            $scope.dispatchMessage('info','Validating data, Please wait ...')
            $http({
                method: 'POST',
                url: 'controllers/login.php',
                data: $.param({username: $scope.username, password: $scope.password}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function($data){
                $("#username,#password,.login-btn").prop('disabled', false);
                if($data.code == 200){
                    $scope.dispatchMessage($data.type, $data.message);
                    window.location.assign("dashboard");
                }else{
                    $scope.dispatchMessage($data.type, $data.message);
                }
                if($data.code == 501)
                    $("#username").val("").focus();
                if($data.code == 502)
                    $("#password").val("").focus();
                else if($data.code == 404){
                    $("#username").val("").focus();
                    $("#password").val("");
                }
            });
        }
        return false;
    }
}).controller('OESController', function($scope){
	
});
