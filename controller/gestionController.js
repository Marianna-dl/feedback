    angular.module('feedbackApp').controller('gestionController', function($scope) {
        $scope.title="Gestion évènement";
       

	});

angular.module('feedbackApp').controller('buttonController', function($scope, $http,$q){
    
  /*  $http.get("./model/test.php/etatEvent").success(function(data){
         $scope.stop=angular.fromJson(data);
        console.log("stop "+$scope.stop);
        $scope.start=!angular.fromJson(data);
        console.log("start "+$scope.start);
    })
    .error(function() {
        console.log('erreur');
    })
    

    
    $scope.lancer=function(){ 
        $http.get("./model/test.php/lancer").success(function(data){
            $scope.start=false;
            $scope.stop=data;
             var promiseX=$http.get("./model/test.php/check");
            promiseX.then(function(result) {
    $scope.a = result.data;
});
$q.all({
    x: promiseX
}).then(function(results) {
    $scope.z = results.x.data;
});
            console.log($scope.z);
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

    
   /*     $scope.lancerRobot=function(){
        $http.get("./model/test.php/robot").success(function(data){                                                                                                                  
        })
            .error(function() {
                console.log('erreur');
            })
        };*/
    
    var canceller = $q.defer();
 
$http.get("./model/test.php/check", { timeout: canceller.promise })
     .then(function(response){
        $scope.movie = response.data;
    });
 
$scope.stopper = function(){
    canceller.resolve("user cancelled");  
};


    });