   angular.module('feedbackApp').controller('parametresController', function($scope) {
        $scope.title="Paramètres";
	   
        //les variables
	    $scope.fontQuestion="";
        $scope.sizeQuestion="";
	    $scope.colorQuestion="";
	    $scope.fontAnswer="";
        $scope.sizeAnswer="";
	    $scope.colorGoodAnswer="";
	    $scope.colorBadAnswer="";
	    $scope.colorFirst="";
	    $scope.colorSecond="";

        /*$scope.sTest="color:"+$scope.couleurTexte+";"
		+"font-family:"+$scope.fontTest+";"
		+"font-size:"+$scope.sizeTest1+"px"+";"
		;*/
	});

    angular.module('feedbackApp').controller('imageController', function($scope, FileUploader) {
        $scope.uploader = new FileUploader();
    });