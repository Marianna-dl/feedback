/************** ANGULAR JS ***********************/

//on déclare l'application et les services qu'on av utiliser
var feedbackApp = angular.module('feedbackApp', ['ngRoute','ngAnimate', 'ngTouch', 'ngSanitize']) 


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

    //Création des controleurs et affichage du titre des pages
    feedbackApp.controller('nouveauController', function($scope) {
        $scope.title="Nouvel évènement";
	});
   feedbackApp.controller('gestionController', function($scope) {
        $scope.title="Gestion évènement";
	});
   feedbackApp.controller('parametresController', function($scope) {
        $scope.title="Paramètres";
	});

   feedbackApp.controller('questionsController', function($scope, $http) {
       //on affiche à quelle question on en est (évite les violations d'intégrité bdd
        $scope.maxQuestion=1;
        $scope.getMaxQuestion=function(){$http.get("test.php/maxQuest").success(function(data){
                    $scope.maxQuestion=data;   
                })
                .error(function() {
                        alert('erreur');
                })
                                        };
       $scope.getMaxQuestion();
                
       
       $scope.videMessage=function(){
            $scope.resultMessage = "";
            $scope.result='';
       
       };
    //On met les questions sur la base de données
        $scope.valideQuestion=function(){
                $http.post("test.php/addQuest", {enonce:$scope.questionInput, id:$scope.maxQuestion}).success(function(){
                    $scope.resultMessage = "La question a été ajoutée !";
                    $scope.result='alert alert-success';
                })
                .error(function() {
                    $scope.resultMessage = "Erreur lors de l'ajout de la question";
                    $scope.result='alert alert-danger';
                })
       
                $scope.questionInput='';
                $scope.getMaxQuestion(); //Met à jour le nombre de question
    
       };
       
         //permet d'activer les tooltip bootstrap
         $('[data-toggle="tooltip"]').tooltip();
	});
