   angular.module('feedbackApp').controller('parametresController', function($scope) {
        $scope.title="Paramètres";
        //Cadre Couleur+Text
        $scope.couleurCadre="#4DFFE7";
        $scope.sizeCadre="3em";

        //BG général
        $scope.couleurBG="#2E89FF";

        //Body BG+Text
        $scope.couleurBody="#FF983D";
        $scope.sizeBody="2em";


        $scope.styleCadre="color:"+$scope.couleurCadre+";"
                          +"font-size:"+$scope.sizeCadre+";"
                          ;

        $scope.styleBG="color:"+$scope.couleurBG+";"
                          ;

        $scope.styleBody="color:"+$scope.couleurBody+";"
                          +"font-size:"+$scope.sizeBody+";"
                          ;

	});


    angular.module('feedbackApp').controller('imageController', function($scope, FileUploader) {
        $scope.uploader = new FileUploader();
    });