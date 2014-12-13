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
        $scope.getListeQuestions=function(){$http.get("test.php/listeQuest").success(function(data){
                $scope.listeQuestions=data;  
            })
            .error(function() {
                console.log('erreur');
            })
        };
        $scope.getListeReponses=function(){$http.get("test.php/listeRep").success(function(data){
                $scope.listeReponses=data;  
            })
            .error(function() {
                console.log('erreur');
            })
        };
        $scope.getListeReponses();
        $scope.getListeQuestions();

	});

   feedbackApp.controller('gestionController', function($scope) {
        $scope.title="Gestion évènement";
	});
   feedbackApp.controller('parametresController', function($scope) {
        $scope.title="Paramètres";
	});



 feedbackApp.controller('qcmController', function($scope, $http) {
        $scope.listRep=[{reponse:'',points:0},{reponse:'',points:0}];
        $scope.listLettre=[{lettre:'A'},{lettre:'B'},{lettre:'C'},{lettre:'D'},{lettre:'E'},{lettre:'F'}];
        $scope.nbRepInput = parseInt(2);
        $scope.nbRep = parseInt(2);
     
  //on affiche à quelle question on en est (évite les violations d'intégrité bdd)
        $scope.maxQuestion=parseInt(1);
        $scope.getMaxQuestion=function(){$http.get("test.php/maxQuest")
            .success(function(data){
                if (parseInt(data)>=0){
                    $scope.maxQuestion=parseInt(data)+parseInt(1); 
                }
                else{
                    $scope.maxQuestion=parseInt(1);   
                }
            })
            .error(function() {
                console.log('erreur');
            })
        };
     
        $scope.getMaxQuestion();
        $scope.videMessage=function(){
            $scope.resultMessage = "";
            $scope.result='';
       
        };         
     
     //On met les questions sur la base de données
        $scope.valideQcm=function(){
               if($scope.questionInput!=''){
                $http.post("test.php/addQuest", {enonce:$scope.questionInput, id:$scope.maxQuestion})
                    .success(function(){
                        for(var i=0; i<$scope.nbRepInput;i++){
                            if($scope.listRep[i].reponse!=''){
                                $http.post("test.php/addRep", {description:$scope.listRep[i].reponse, numQuest:$scope.maxQuestion, numRep:$scope.listLettre[i].lettre, points:parseInt($scope.listRep[i].points)})
                                    .success(function(data){
  
                                    })
                                    .error(function() {
                                        console.log("Erreur lors de l'ajout de la réponse");
                                    })
                            }
                          $scope.listRep[i].reponse="";
                          $scope.listRep[i].points= "0";
                          $scope.getListeReponses();
                
                        }
                        $scope.perso=false;
                        $scope.resultMessage = "Les questions et les réponses ont été ajoutées !";
                        $scope.result='alert alert-success';
                        $scope.getMaxQuestion(); //Met à jour le nombre de question
                        $scope.getListeQuestions();
                        $scope.numQuestionInput="";
                        $scope.questionInput='';
                    })
                    .error(function() {
                        $scope.resultMessage = "Erreur lors de l'ajout des questions/réponses";
                        $scope.result='alert alert-danger';
                    })
                    $scope.getListeReponses();
            }

        };    
        $scope.set = function() {

            if($scope.nbRep>=2){
                if($scope.nbRep > $scope.nbRepInput){
                    $scope.listRep.push({reponse:'',points:0});
                }
                else if($scope.nbRep < $scope.nbRepInput){
                    $scope.listRep.splice($scope.nbRepInput-1,1);
                }
                $scope.nbRepInput = $scope.nbRep;
            }
            else{
                $scope.nbRep=parseInt(2);
            }
        };  
          //permet d'activer les tooltip bootstrap
         $('[data-toggle="tooltip"]').tooltip();
 
 });







