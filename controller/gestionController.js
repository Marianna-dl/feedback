'use strict';    

angular.module('feedbackApp').controller('gestionController', function($scope) {
        $scope.title="Gestion évènement";
       

	});

angular.module('feedbackApp').controller('buttonController', function($scope, $http,$q){
    
    $http.get("./model/test.php/etatEvent").success(function(data){
         $scope.stop=angular.fromJson(data);
        console.log("stop "+$scope.stop);
        $scope.start=!angular.fromJson(data);
        console.log("start "+$scope.start);
    })
    .error(function() {
        console.log('erreur');
    })
//$http.get("./model/test.php/check");
    
            $scope.start=false;
            $scope.stop=true;
        $scope.lancer=function(){ 
        $http.get("./model/test.php/lancer").success(function(data){
            $scope.start=false;
            $scope.stop=true;
            $http.get("./model/test.php/check",{timeout:$scope.stop});
            console.log("stop lancer "+$scope.stop);
                                                                                   
        })
            .error(function() {
                console.log('erreur');
            })

        };
  
        $scope.stopper=function(){

        $http.get("./model/test.php/stopper").success(function(data){
            $scope.start=true;
            $scope.stop=false; 
             console.log("stop stop "+$scope.stop);  
              
        })
            .error(function() {
                console.log('erreur');
            })
        };
    


    });