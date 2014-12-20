'use strict';    

angular.module('feedbackApp').controller('gestionController', function($scope, $http) {
        $scope.title="Gestion évènement";
    
       // $http.get("./model/test.php/etatEvent").success(function(data){

              

	});

angular.module('feedbackApp').controller('buttonController', function($scope, $http,$interval){
        $http.get("./model/test.php/etatEvent").success(function(data){
         $scope.stop=angular.fromJson(data);
        console.log("stop session "+$scope.stop);
        $scope.start=!angular.fromJson(data);
        console.log("start session "+$scope.start);
    })
    .error(function() {
        console.log('erreur');
    })  

    if(angular.isDefined( $scope.timer)){
        $interval.cancel( $scope.timer);  
        $scope.timer=undefined;       
        
    }

    $scope.$watch('start', function() {
        console.log("start watch "+$scope.start);
        if ($scope.start==false){
            console.log("timer");
             $scope.timer=$interval(function(){ console.log("ok")},2000);
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
         
          /*  $scope.start=true;
            $scope.stop=false;*/
        $scope.lancer=function(){ 
        $http.get("./model/test.php/lancer").success(function(data){
            //$scope.timer=$interval(function(){ console.log("ok")},2000);
            //$http.get("./model/test.php/check",{timeout:$scope.stop});
            $scope.start=false;
            $scope.stop=true;
            console.log("lancer "+$scope.start);
                                                                                   
        })
            .error(function() {
                console.log('erreur');
            })

        };
  
        $scope.stopper=function(){
                        console.log("stop stopper");  
        $http.get("./model/test.php/stopper").success(function(data){
            $scope.start=true;
            $scope.stop=false; 
               /*$interval.cancel($scope.timer);  
            $scope.timer=undefined;*/
            console.log("stop "+$scope.stop);  
           console.log("lancer "+$scope.start);  
        
        })
            .error(function() {
                console.log('erreur');
            })
        };
    


    });