/************** ANGULAR JS ***********************/

//on déclare l'application et les services qu'on av utiliser
var feedbackApp = angular.module('feedbackApp', ['ngRoute','ngAnimate', 'ngTouch', 'ngSanitize']); 


	//On créer les directions du menu (route) 
	feedbackApp.config(function($routeProvider) {
		$routeProvider

			.when('/', {
				templateUrl : 'view/nouveau.html',
                controller  : 'nouveauController'
			})

			.when('/gestion', {
				templateUrl : 'view/gestion.html',
                controller  : 'gestionController'			
			})
            .when('/parametres', {
				templateUrl : 'view/parametres.html',
                controller  : 'parametresController'
			
			})
	});



    //permet de spécifier le menu actif (la page sur laquelle on est)
	feedbackApp.controller('navController', function($scope, $location) {
         $scope.isActive = function (viewLocation) { 
            return viewLocation === $location.path();
        };
	});