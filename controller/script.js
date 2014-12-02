/************** ANGULAR JS ***********************/
var feedbackApp = angular.module('feedbackApp', ['ngRoute','ngAnimate', 'ngTouch', 'ngSanitize'])
	// create the module and name it scotchApp


	// configure our routes
	feedbackApp.config(function($routeProvider) {
		$routeProvider

			// route for the home page
			.when('/', {
				templateUrl : 'view/nouveau.html',
                controller  : 'nouveauController'
			})

			// route for the contact page
			.when('/gestion', {
				templateUrl : 'view/gestion.html',
                controller  : 'gestionController'			
			})
            .when('/parametres', {
				templateUrl : 'view/parametres.html',
                controller  : 'parametresController'
			
			})
	});

	feedbackApp.controller('navController', function($scope, $location) {
         $scope.isActive = function (viewLocation) { 
            return viewLocation === $location.path();
        };
	});


    feedbackApp.controller('nouveauController', function($scope) {
        $scope.title="Nouvel évènement";
	});
   feedbackApp.controller('gestionController', function($scope) {
        $scope.title="Gestion évènement";
	});
   feedbackApp.controller('parametresController', function($scope) {
        $scope.title="Paramètres";
	});


   feedbackApp.controller('questionsController', function($scope,$sce) {
    $scope.formulaire=$sce.trustAsHtml('<label for="question">Question 1: </label><input type="text" name="question" value="" class="form-control" />');
       $scope.ajoutForm=function(i){
           
                $scope.formulaire=$sce.trustAsHtml('<label for="question">Question '+i+': </label><input type="text" name="question" value="" class="form-control" />');
    
       };
        $scope.valideQuestion=function(){
           
                $scope.formulaire='';
    
       };
       
         $('[data-toggle="tooltip"]').tooltip();
	});

