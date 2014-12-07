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
    feedbackApp.controller('nouveauController', function($scope,$http) {
        $scope.title="Nouvel évènement";
        $scope.getListe=function(){$http.get("test.php/questRep").success(function(data){
                $scope.items=data;  
            })
            .error(function() {
                alert('erreur');
            })
        };
        $scope.getListe();
            $scope.videMessage=function(){
            $scope.resultMessage = "";
            $scope.result='';
       
       };
	});

   feedbackApp.controller('gestionController', function($scope) {
        $scope.title="Gestion évènement";
	});
   feedbackApp.controller('parametresController', function($scope) {
        $scope.title="Paramètres";
	});

   feedbackApp.controller('questionsController', function($scope, $http) {
       //on affiche à quelle question on en est (évite les violations d'intégrité bdd)
        $scope.maxQuestion=parseInt(1);
        $scope.getMaxQuestion=function(){$http.get("test.php/maxQuest").success(function(data){
                    if (parseInt(data)>=0)
                        $scope.maxQuestion=parseInt(data)+parseInt(1);  
                    else
                        $scope.maxQuestion=parseInt(1);                   
                })
                .error(function() {
                        alert('erreur');
                })
                                        };
       $scope.getMaxQuestion();

                
       

    //On met les questions sur la base de données
        $scope.valideQuestion=function(){
                $http.post("test.php/addQuest", {enonce:$scope.questionInput, id:$scope.maxQuestion}).success(function(){
                    $scope.resultMessage = "La question a été ajoutée !";
                    $scope.result='alert alert-success';
                    $scope.getListe();
                })
                .error(function() {
                    $scope.resultMessage = "Erreur lors de l'ajout de la question";
                    $scope.result='alert alert-danger';
                })
       
                $scope.questionInput='';
                $scope.getMaxQuestion(); //Met à jour le nombre de question
                $scope.getListe();

    
       };
       
         //permet d'activer les tooltip bootstrap
         $('[data-toggle="tooltip"]').tooltip();
	});

   feedbackApp.controller('reponsesController', function($scope, $http) {
       $scope.listRep=[{reponse:''}];
        $scope.listLettre=[{lettre:'A'},{lettre:'B'},{lettre:'C'},{lettre:'D'},{lettre:'E'},{lettre:'F'}];

        $scope.nbRepInput = parseInt(1);
        $scope.nbRep = parseInt(1);

        $scope.set = function() {
            if($scope.nbRep >= $scope.nbRepInput){
                $scope.listRep.push({reponse:''});
            }
            else{
                $scope.listRep.splice($scope.nbRepInput-1,1);
            }
             $scope.nbRepInput = $scope.nbRep;
        };
       
       $scope.valideReponse=function(){
          /*  console.log($scope.nbRepInput);
            console.log($scope.numQuestionInput);
            console.log($scope.listRep[0].reponse);
            console.log($scope.listRep[1].reponse);*/
  
           
                for(var i=0; i<$scope.nbRepInput;i++){
                if($scope.listRep[i].reponse!=''){
                $http.post("test.php/addRep", {description:$scope.listRep[i].reponse, numQuest:$scope.numQuestionInput, numRep:$scope.listLettre[i].lettre}).success(function(data){
                  $scope.resultMessage = "La réponse a été ajoutée !";
                    $scope.result='alert alert-success';
                    console.log(data);
  

                })
                .error(function() {
                    $scope.resultMessage = "Erreur lors de l'ajout de la réponse";
                    $scope.result='alert alert-danger';
                })
            }
            $scope.listRep[i].reponse="";
                
       }
            $scope.numQuestionInput="";

       };

	});






