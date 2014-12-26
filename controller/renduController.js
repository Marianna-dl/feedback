angular.module('renduApp').controller('renduController', function($scope, $http,shareQuestion) {
            

 /*  $scope.test=function(){
       shareQuestion.getProperty().success(function(data){
     $scope.question=data;
       console.log(data);
   });
   }
    $scope.$watch('test()', function(data) {
     shareQuestion.getProperty().success(function(data){
     $scope.question=data;
       console.log(data);
   });
  });
    */
            
            $http.get("../controller/classController.php/getQuestion").success(function(data){
            $scope.question=data;
            })
            .error(function(){
                console.log(data);
            }) 
 
});