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
	});

angular.module('feedbackApp').controller('imageController', function($scope, FileUploader) {
        $scope.uploader = new FileUploader();
    });

angular.module('feedbackApp').controller('paramRenduController', function($scope,$http) {

	   /* $scope.colorFirst="";
	    $scope.colorSecond="";*/
});
