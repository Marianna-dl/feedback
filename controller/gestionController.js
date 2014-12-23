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
    })
    .error(function() {
        console.log('erreur');
    })  

    if(angular.isDefined( $scope.timer)){
        $interval.cancel( $scope.timer);  
        $scope.timer=undefined;          
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
         
        $scope.lancer=function(){ 
        $http.get("controller/classController.php/lancer").success(function(data){
            //$scope.timer=$interval(function(){ console.log("ok")},2000);
            //$http.get("./model/test.php/check",{timeout:$scope.stop});
            $scope.start=false;
            $scope.stop=true;                                                                  
        })
            .error(function() {
                console.log('erreur');
            })

        };
  
        $scope.stopper=function(){
           // $scope.stopperRobot();
            $http.get("controller/classController.php/stopper").success(function(data){
                $scope.start=true;
                $scope.stop=false; 
               /*$interval.cancel($scope.timer);  
            $scope.timer=undefined;*/
        })
            .error(function() {
                console.log('erreur');
            })
        };
    
 /*   $scope.lancerRobot=function(){
        console.log('ok');
            $http.post("controller/threadController.php/startRobotGenere",{etat:true}).success(function(data){
                console.log(data);
            })
            .error(function(){
                   console.log('erreur lancer robot');         
            })
    };
    
    $scope.stopperRobot=function(){
            $http.post("controller/threadController.php/startRobotGenere",{etat:false}).success(function(data){
                console.log(data);
            })
            .error(function(){
                   console.log('erreur stop robot');         
            })
    };*/
    


    });