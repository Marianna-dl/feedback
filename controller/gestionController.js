'use strict';    

angular.module('feedbackApp').controller('gestionController', function($scope, $http, $interval, $window) {
        $scope.title="Gestion évènement";  

            //On initialise la question courante à 1 avant le début de l'évènement
            $http.get("controller/classController.php/initCurrentQuestion").success(function(){

            })
            .error(function(){
                console.log(data);
            })  
            
        // Récupère le nombre de max de question, on ne pourra pas afficher de question au-delà de ce nombre    
        $http.get("controller/classController.php/maxQuest").success(function(data){
            $scope.nbQuestion=data;
            console.log(data);
            })
            .error(function(){
                console.log(data);
            })
            //On récupère les réponses des users déjà présents en bdd -> juste pour l'exemple du projet
            $http.get("controller/classController.php/getMessages").success(function(data){
            $scope.listeReponseParticipants=data;
            })
            .error(function(){
                console.log(data);
            })  
        
        //Après l'initialisation, on récupère la question courante
        $scope.getQuestionCourante=function(){
            $http.get("controller/classController.php/getCurrentQuestion").success(function(data){
            $scope.questionCourante=data;
            })
            .error(function(){
                console.log(data);
            }) 
        }
        $scope.getQuestionCourante();
    
    // On vérifie si l'évenement est déjà lancé pour activer/desactiver les boutons "lancer"/"stopper" si nécessaire
        $http.get("controller/classController.php/etatEvent").success(function(data){
         $scope.stop=angular.fromJson(data);
        $scope.start=!angular.fromJson(data);
        $scope.robotDB=angular.fromJson(data);
    })
    .error(function() {
        console.log('erreur lors de la vérification de l\'état de l\'évènement');
    })  
        
    if ($scope.robotDB==false){
        $scope.resultMessage = "Simulation activée";
        $scope.result='alert alert-success';         
    }
    else{
        $scope.resultMessage = "Simulation désactivée";
        $scope.result='alert alert-danger';    
    }      
        
    //Réinitialise le timer
    if(angular.isDefined( $scope.timer) && angular.isDefined( $scope.timerRobot)){
        $interval.cancel( $scope.timer);  
        $scope.timer=undefined;     
            $interval.cancel( $scope.timerRobot);  
        $scope.timerRobot=undefined;       
    }

    //On verifie les changement sur le bouton "lancer" ($scope.start)
    $scope.$watch('start', function() {
        if ($scope.start==false){//Si start est a false, l'évenement est lancé mais le bouton se grise
            //On récupère alors toutes les deux secondes les messages entrant dans la bdd
             $scope.timer=$interval(function(){ 
                $http.get("controller/classController.php/getMessages").success(function(data){
                $scope.listeReponseParticipants=data;
                })
                .error(function(){
                    console.log(data);
                }) 
                //On laisse le thread de tri faire son travail
                $http.get("controller/threadController.php/startRobotTri").success(function(){
                    console.log("entree");
                })
                .error(function(){
                   console.log('erreur lancer robot');         
            })  
            },2000);
        }
        else{ //Sinon on peut détruire le timer
        $scope.$on('$destroy', function () { $interval.cancel($scope.timer); });

        }
    
    });
        
       $scope.$watch('stop', function() {
        if ($scope.stop==false && angular.isDefined( $scope.timer)){
          $scope.$on('$destroy', function () { $interval.cancel($scope.timer); });
            $interval.cancel( $scope.timer);  
            $scope.timer=undefined;
        }
    
    });
        //Regarde si on active/desactive le thread de génération de sms
        $scope.$watch('robotDB', function() {
        if ($scope.robotDB==true){//lance le thread si true
               $scope.timerRobot=$interval(function(){ 
            $http.get("controller/threadController.php/startRobotDB").success(function(data){
                })
                .error(function(){
                   console.log('erreur lancer robot');         
            })    
                 
            },6000); 
        }
        else{ 
          $scope.$on('$destroy', function () { $interval.cancel($scope.timerRobot); });
            $interval.cancel( $scope.timerRobot);  
            $scope.timerRobot=undefined;

        }
    
    });
         //Fonction qui change les valeurs de start et stop si l'event est lancé 
        $scope.lancer=function(){ 
        $http.get("controller/classController.php/lancer").success(function(data){
            $scope.start=false;
            $scope.stop=true;                                                                  
        })
            .error(function() {
                console.log('erreur lors du lancement de l\'évènement');
            })
            $window.open('./view/rendu.html'); // Si l'évènement est lancé, on ouvre la page pour le vote
        };
    
        //Fonction qui change les valeurs de start et stop si l'event est stoppé 
        $scope.stopper=function(){
            $http.get("controller/classController.php/stopper").success(function(data){
                $scope.start=true;
                $scope.stop=false; 
                $scope.robotDB=false;
        })
            .error(function() {
                console.log('erreur lors de l\'arrêt de l\'évènement ');
            })
            $scope.getQuestionCourante();//La question courante se réinitialise si l'évènement est stoppé
        };
    
    //Fonction qui lance le robot de génération de sms
    $scope.lancerRobot=function(){
        if ($scope.robotDB==false){
            $scope.robotDB=true;
             $scope.resultMessage = "Simulation activée";
            $scope.result='alert alert-success';         
        }
        else{
            $scope.robotDB=false;
             $scope.resultMessage = "Simulation désactivée";
            $scope.result='alert alert-danger';    
        }
    };
    
    //Fonction qui stocke la question suivante et qui actualise l'affichage pour la question courante
    $scope.questionSuivante=function(){
        $http.post("controller/classController.php/setQuestion", {question:parseInt($scope.questionCourante)+1}).success(function(data){
                console.log(data);
            })
            .error(function(){
                console.log("erreur");
            })   
        $scope.getQuestionCourante();
    }


    });