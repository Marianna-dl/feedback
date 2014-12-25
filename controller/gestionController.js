'use strict';    

angular.module('feedbackApp').controller('gestionController', function($scope, $http, $interval) {
        $scope.title="Gestion évènement";      
    
        $http.get("controller/classController.php/getMessages").success(function(data){
            $scope.listeReponseParticipants=data;
            })
            .error(function(){
                console.log(data);
            })                    
        $http.get("controller/classController.php/etatEvent").success(function(data){
         $scope.stop=angular.fromJson(data);
        $scope.start=!angular.fromJson(data);
        $scope.robotDB=angular.fromJson(data);
    })
    .error(function() {
        console.log('erreur');
    })  
        
    if ($scope.robotDB==false){
        $scope.resultMessage = "Simulation activée";
        $scope.result='alert alert-success';         
    }
    else{
        $scope.resultMessage = "Simulation désactivée";
        $scope.result='alert alert-danger';    
    }      
        
    
        
        

    if(angular.isDefined( $scope.timer) && angular.isDefined( $scope.timerRobot)){
        $interval.cancel( $scope.timer);  
        $scope.timer=undefined;     
            $interval.cancel( $scope.timerRobot);  
        $scope.timerRobot=undefined;       
    }

    $scope.$watch('start', function() {
        if ($scope.start==false){
             $scope.timer=$interval(function(){ 
                $http.get("controller/classController.php/getMessages").success(function(data){
                $scope.listeReponseParticipants=data;
                })
                .error(function(){
                    console.log(data);
                })                                          
            },2000);
        }
        else{ 
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
    
        $scope.$watch('robotDB', function() {
        if ($scope.robotDB==true){
               $scope.timerRobot=$interval(function(){ 
                            console.log('interval');
            $http.get("controller/threadController.php/startRobotDB").success(function(data){
                })
                .error(function(){
                   console.log('erreur lancer robot');         
            })    
                 
            },6000); 
        }
        else{ 
            console.log("else "+ $scope.robotDB);
          $scope.$on('$destroy', function () { $interval.cancel($scope.timerRobot); });
            $interval.cancel( $scope.timerRobot);  
            $scope.timerRobot=undefined;

        }
    
    });
    
    
    
         
        $scope.lancer=function(){ 
        $http.get("controller/classController.php/lancer").success(function(data){
            $scope.start=false;
            $scope.stop=true;                                                                  
        })
            .error(function() {
                console.log('erreur');
            })

        };
  
        $scope.stopper=function(){
            $http.get("controller/classController.php/stopper").success(function(data){
                $scope.start=true;
                $scope.stop=false; 
        })
            .error(function() {
                console.log('erreur');
            })
        };
    
    
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
    


    });