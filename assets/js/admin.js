/**
 * Created by janruls1 on 22-11-2015.
 */
var app = angular.module("admin-OES",['ngRoute', 'ng-fx', 'ngAnimate', 'toastr']).config(function($routeProvider, $locationProvider){
    $routeProvider
        .when('/dashboard', {
            templateUrl : 'admin-home/angular',
            controller : 'AdminOESController'
        })
        .when('/manage-students', {
            templateUrl : 'manage-students/angular',
            controller : 'studentController'
        })
        .when('/manage-exams', {
            templateUrl : 'manage-exams/angular',
            controller : 'manageExamsController'
        })
        .when('/manage-courses', {
            templateUrl : 'manage-courses/angular',
            controller : 'manageCourseController'
        })
        .when('/manage-question', {
            templateUrl : 'manage-question/angular',
            controller : 'manageQuestionController'
        })
        .when('/add-question/:id', {
            templateUrl : function ($routeParams) {
                return 'add-question/angular/' + $routeParams.id ;
            },
            controller : 'manageAddQuestionController'
        })
        .otherwise({
            redirectTo: '/'
        });

    // use the HTML5 History API
    $locationProvider.html5Mode(true);
});
app.config(function(toastrConfig) {
	  angular.extend(toastrConfig, {
	    autoDismiss: false,
	    containerId: 'toast-container',
	    maxOpened: 0,    
	    newestOnTop: true,
	    positionClass: 'toast-bottom-right',
	    preventDuplicates: false,
	    preventOpenDuplicates: false,
	    target: 'body',
	    allowHtml: true,
	    closeButton: true,
	    closeHtml: '<button>&times;</button>',
	    extendedTimeOut: 7000,
	  });
});
app.run(function($rootScope, $templateCache) {
    $rootScope.$on('$routeChangeStart', function(event, next, current) {
        if (typeof(current) !== 'undefined'){
            $templateCache.remove(current.templateUrl);
        }
    });
});
app.directive('ngElementReady', [function() {
    return {
        priority: -1000, // a low number so this directive loads after all other directives have loaded. 
        restrict: "A", // attribute only
        link: function($scope, $element, $attributes) {
            console.log(" -- Element ready!");
            $scope.$eval($attributes.ngElementReady);
        }
    };
}]);
app.controller('AdminOESController', function($scope){
    addActive("dashboard");
}).controller('studentController', function($scope, $http){
    addActive("manage-students");
    $scope.students = {};
    $scope.students = JSON.parse($(".data").html());
    $scope.selectAll = function () {
        $("#students").find("[type='checkbox']").each(function(){
            $(this).prop("checked",$scope.selAll);
        })
    }
})
.controller('manageAddQuestionController', function($scope, $http, toastr, $routeParams){
    addActive("manage-question");
    //$scope.qs = JSON.parse($(".q-data").html());
    var qbid = $routeParams.id;
    $scope.qbs = JSON.parse($(".q-"+qbid+"-data").html());
    $scope.type = "mcq";
    $scope.defaultOptions = [{isAns:false, option:''},
                             {isAns:false, option:''},
                             {isAns:true, option:''},
                             {isAns:false, option:''}]
    $scope.options = $scope.defaultOptions;
    $scope.addOption = function(){
    	$scope.options.push({
    		isAns:false, option:''
    	});
    }
    $scope.removeOption = function($index){
    	var i = 0;
    	var optionClone = $scope.options;
    	$scope.options = [];
    	angular.forEach(optionClone,function(value){
    		if(i++!=$index)
    			$scope.options.push(value);
    	});
    }
})
.controller('manageQuestionController', function($scope, $http, toastr){
    addActive("manage-question");
    $scope.qbs = JSON.parse($(".qb-data").html());
    $scope.createTable = function(){
		$("#qb_table").bdt();
		console.log("table created");
	};
	$scope.add = function($event){
    	$event.preventDefault();
    	$(".btn, .form-control").prop("disabled",true);
    	$(".submit-btn").text("Creating...");
    	toastr.info("Creating Question bank. Please Wait ...");
    	$http({
            method: 'POST',
            url: 'controllers/question_bank.php',
            data: $.param(
            		{action: 'create',
            			name: $scope.name,
            			course: $scope.course
            		}
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function($data){
        	$(".submit-btn").text("Create");
            if($data.code == 200){
                $http({
                	method: 'post',
                	url: 'controllers/question_bank.php',
                	data: $.param({
                		action: 'getListAdmin',
                	}),
                	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function($data){
                	$(".qb-data").html($data);
                	$scope.qbs = $data;
                	$(".form-control").val("");
                    toastr.success("Question Bank Created Successfully");
                    $scope.create = false;
                });
            }else{
            	toastr.error("Something gone wrong. Please try again");
            }
            $(".btn, .form-control").prop("disabled",false);
        });
    }
    $scope.delete = function(obj, $id){
    	var con = confirm("Do you really want to delete this question bank ? This will delete all questions and exams associated with it!!!");
    	if(con){
        	if(obj.target.nodeName == 'A')
        		var elem = $(obj.target).parent().parent();
        	else
        		var elem = $(obj.target).parent().parent().parent();
        	elem.addClass("danger").find(".btn").addClass("disabled", true);
    		toastr.info("Deleting course. Please Wait ...");
    		$http({
            	method: 'post',
            	url: 'controllers/question_bank.php',
            	data: $.param({
            		action: 'delete',
            		id: $id,
            	}),
            	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function($data){
            	if($data.code == 200){
            		$http({
	                	method: 'post',
	                	url: 'controllers/question_bank.php',
	                	data: $.param({
	                		action: 'getListAdmin',
	                	}),
	                	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	                }).success(function($data){
	                	$(".qb-data").html($data);
	                	$scope.qbs = $data;
	                	toastr.success("Course deleted successfully");
	                });
            	}else{
            		toastr.error($data.message);
            	}
            });
    	}
    }
	
})
.controller('manageCourseController', function($scope, $http, toastr){
    addActive("manage-courses");
    $scope.courses = JSON.parse($(".course-data").html());
	$scope.createTable = function(){
		$("#course_table").bdt();
		console.log("table created");
	};
    $scope.add = function($event){
    	$event.preventDefault();
    	$(".btn, .form-control").prop("disabled",true);
    	$(".submit-btn").text("Creating...");
    	toastr.info("Creating Course. Please Wait ...");
    	$http({
            method: 'POST',
            url: 'controllers/courses.php',
            data: $.param(
            		{action: 'create',
            			name: $scope.name,
            		}
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function($data){
        	$(".submit-btn").text("Create");
            if($data.code == 200){
                $http({
                	method: 'post',
                	url: 'controllers/courses.php',
                	data: $.param({
                		action: 'getListAdmin',
                	}),
                	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function($data){
                	$(".course-data").html($data);
                	$scope.courses = $data;
                	$(".form-control").val("");
                    toastr.success("Course Created Successfully");
                    $scope.create = false;
                });
            }else{
            	toastr.error("Something gone wrong. Please try again");
            }
            $(".btn, .form-control").prop("disabled",false);
        });
    }
    $scope.delete = function(obj, $id){
    	var con = confirm("Do you really want to delete this course ? This will delete all question banks and exams associated with it!!!");
    	if(con){
        	if(obj.target.nodeName == 'A')
        		var elem = $(obj.target).parent().parent();
        	else
        		var elem = $(obj.target).parent().parent().parent();
        	elem.addClass("danger").find(".btn").addClass("disabled", true);
    		toastr.info("Deleting course. Please Wait ...");
    		$http({
            	method: 'post',
            	url: 'controllers/courses.php',
            	data: $.param({
            		action: 'delete',
            		id: $id,
            	}),
            	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function($data){
            	if($data.code == 200){
            		$http({
	                	method: 'post',
	                	url: 'controllers/courses.php',
	                	data: $.param({
	                		action: 'getListAdmin',
	                	}),
	                	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	                }).success(function($data){
	                	$(".course-data").html($data);
	                	$scope.courses = $data;
	                	toastr.success("Course deleted successfully");
	                });
            	}else{
            		toastr.error($data.message);
            	}
            });
    	}
    }
})


.controller('manageExamsController', function($scope, $http, toastr, $templateCache){
    addActive("manage-exams");
    $scope.exams = JSON.parse($(".exam-data").html());
	$scope.createTable = function(){
		$("#exam_table").bdt();
		console.log("table created");
	};
    $scope.createExam = function($event){
    	$event.preventDefault();
    	$(".btn, .form-control").prop("disabled",true);
    	$(".submit-btn").text("Creating...");
    	toastr.info("Creating Exam. Please Wait ...");
    	$http({
            method: 'POST',
            url: 'controllers/exam.php',
            data: $.param(
            		{action: 'create',
            			exam_name: $scope.exam_name, 
            			start_time: $scope.start_time,
            			end_time: $scope.end_time,
            			exam_duration: $scope.exam_duration,
            			exam_student_group: $scope.exam_student_group,
            			show_result: $scope.show_result,
            			exam_about: $scope.exam_about,
            			exam_type: $scope.exam_type,
            		}
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function($data){
        	$(".submit-btn").text("Create");
            if($data.code == 200){
                $http({
                	method: 'post',
                	url: 'controllers/exam.php',
                	data: $.param({
                		action: 'getExamsListAdmin',
                	}),
                	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function($data){
                	$(".exam-data").html($data);
                	$scope.exams = $data;
                	$(".form-control").val("");
                    toastr.success("Exam Created Successfully");
                    $scope.create = false;
                });
            }else{
            	toastr.error("Something gone wrong. Please try again");
            }
            $(".btn, .form-control").prop("disabled",false);
        });
    }
    $scope.deleteExam = function(obj, $id){
    	var con = confirm("Do you really want to delete this exam ?");
    	if(con){
        	if(obj.target.nodeName == 'A')
        		var elem = $(obj.target).parent().parent();
        	else
        		var elem = $(obj.target).parent().parent().parent();
        	elem.addClass("danger").find(".btn").addClass("disabled", true);
    		toastr.info("Deleting Exam. Please Wait ...");
    		$http({
            	method: 'post',
            	url: 'controllers/exam.php',
            	data: $.param({
            		action: 'delete',
            		id: $id,
            	}),
            	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function($data){
            	if($data.code == 200){
            		$http({
	                	method: 'post',
	                	url: 'controllers/exam.php',
	                	data: $.param({
	                		action: 'getExamsListAdmin',
	                	}),
	                	headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	                }).success(function($data){
	                	$(".exam-data").html($data);
	                	$scope.exams = $data;
	                	toastr.success("Exam deleted successfully");
	                });
            	}else{
            		toastr.error($data.message);
            	}
            });
    	}
    }
});


function addActive(link){
    $("ul.navbar-nav").find(".active").removeClass("active");
    $("ul.navbar-nav").find("a[href='"+link+"']").parent().addClass("active");
    if($("ul.navbar-nav").find(".active").parent().parent().get(0).tagName == "LI")
        $("ul.navbar-nav").find(".active").parent().parent().addClass("active");
}