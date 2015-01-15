angular.module('renduApp').controller('renduController', function($scope, $http,$interval) {
            
        //On récupère la question courante à afficher lorsque la page s'ouvre
        $http.get("../controller/classController.php/getCurrentQuestion").success(function(data){
            $scope.numQuestion=data;
            //On récupère l'énoncé de la question
            $http.get("../controller/classController.php/getQuestion/"+parseInt($scope.numQuestion)).success(function(data){
                $scope.question=data[0].enonce;
            })
            .error(function(){
                console.log("Erreur: impossible de récupèrer l\'énoncé des questions");
            }) 
            //On récupère les réponses possibles de la question
            $http.get("../controller/classController.php/getRep/"+parseInt($scope.numQuestion)).success(function(data){
                $scope.listeReponses=data;
             //   console.log(data[0].description);
            })
            .error(function(){
                console.log("Erreur: impossible de récupèrer les réponses");
            }) 
         })
          .error(function(){
         console.log("Erreur: impossible de récupèrer la question courante");
        })    
        
    //Check les changements de la page parametres pour réactualiser la question et les réponses à afficher    
    $scope.$watch('numQuestion+question+listeReponses', function() {
             $scope.timer=$interval(function(){ 
                $http.get("../controller/classController.php/getCurrentQuestion").success(function(data){
                    $scope.numQuestion=data;
                    $http.get("../controller/classController.php/getQuestion/"+parseInt($scope.numQuestion)).success(function(data){
                        $scope.question=data[0].enonce;
                    })
                    .error(function(){
                        console.log("Erreur: impossible de récupèrer l\'énoncé des questions");
                    })  
                    $http.get("../controller/classController.php/getRep/"+parseInt($scope.numQuestion)).success(function(data){
                        $scope.listeReponses=data;
                        // console.log(data[0].description);
                    })
                    .error(function(){
                        console.log("Erreur: impossible de récupèrer les réponses");
                    }) 
                })
                .error(function(){
                    console.log("Erreur: impossible de récupèrer la question courante");
                })
            $http.get("../controller/classController.php/nbVotantQuestion/"+ $scope.numQuestion).success(function(data){
                $scope.nbVotantQ=data;
                })
                .error(function(){
                    console.log("Erreur: impossible de récupèrer le nombre de votants");
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