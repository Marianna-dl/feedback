angular.module('renduApp').controller('renduController', function($scope, $http,$interval) {
            
        $http.get("../controller/classController.php/getCurrentQuestion").success(function(data){
            $scope.numQuestion=data;
            $http.get("../controller/classController.php/getQuestion/"+parseInt($scope.numQuestion)).success(function(data){
                $scope.question=data[0].enonce;
            })
            .error(function(){
                console.log(data);
            }) 
            $http.get("../controller/classController.php/getRep/"+parseInt($scope.numQuestion)).success(function(data){
                $scope.listeReponses=data;
             //   console.log(data[0].description);
            })
            .error(function(){
                console.log(data);
            }) 
         })
          .error(function(){
         console.log(data);
        })    
        
    $scope.$watch('numQuestion+question+listeReponses', function() {
             $scope.timer=$interval(function(){ 
                $http.get("../controller/classController.php/getCurrentQuestion").success(function(data){
                    $scope.numQuestion=data;
                $http.get("../controller/classController.php/getQuestion/"+parseInt($scope.numQuestion)).success(function(data){
                    $scope.question=data[0].enonce;
                })
                .error(function(){
                    console.log(data);
                })  
                $http.get("../controller/classController.php/getRep/"+parseInt($scope.numQuestion)).success(function(data){
                    $scope.listeReponses=data;
                   // console.log(data[0].description);
                })
                .error(function(){
                    console.log(data);
                }) 
                })
                .error(function(){
                    console.log(data);
                })
            $http.get("../controller/classController.php/nbVotantQuestion/"+ $scope.numQuestion).success(function(data){
                $scope.nbVotantQ=data;
                })
                .error(function(){
                    console.log("erreur");
                }) 
                
            },2000);
    
    });
    
    
           /* $http.get("../controller/classController.php/statsAnswer/"+ $scope.numQuestion+).success(function(data){
                $scope.nbVotantQ=data;
                })
                .error(function(){
                    console.log("erreur");
                }) */
                
 
 
});