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
                
            },2000);
    
    });
    
 
     
  /*  $scope.$watch( shareQuestion.getProperty().success(), function(data) {
     shareQuestion.getProperty().success(function(data){
     $scope.question=data;
       console.log(data);
   });
  });*/
    
            
         /*   $http.get("../controller/classController.php/getQuestion").success(function(data){
            $scope.question=data;
            })
            .error(function(){
                console.log(data);
            }) */
 
});