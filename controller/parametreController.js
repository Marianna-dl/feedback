   angular.module('feedbackApp').controller('parametresController', function($scope) {
        $scope.title="Paramètres";

        //Body BG+Text
        $scope.couleurBody="#FF983D";
        $scope.sizeBody="2em";

        $scope.styleBody="color:"+$scope.couleurBody+";"
                          +"font-size:"+$scope.sizeBody+";"
                          ;

	});


    angular.module('feedbackApp').controller('imageController', function($scope, FileUploader) {
        $scope.uploader = new FileUploader();
    });