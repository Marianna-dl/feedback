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

        $scope.attribut = ['font-family', 'font-size', 'color'];
      	$scope.valueQuestion = [$scope.fontQuestion, $scope.sizeQuestion, $scope.colorQuestion];
	    $scope.valueGoodAnswer = [$scope.fontAnswer, $scope.sizeAnswer, $scope.colorGoodAnswer];
	    $scope.valueBadAnswer = [$scope.fontAnswer, $scope.sizeAnswer, $scope.colorBadAnswer];
	   
	   	$scope.styleQuestion = function(attribut,valueQuestion) {
          return { attribut: valueQuestion };
      	}
		$scope.styleGoodAnswer = function(attribut,valueGoodAnswer) {
          return { attribut: valueGoodAnswer };
      	}
		$scope.styleBadAnswer = function(attribut,valueBadAnswer) {
          return { attribut: valueBadAnswer };
      	}
	   
	   $scope.styleTest = function() {
          return { 	"font-family": $scope.fontQuestion
				 	//"font-size": $scope.sizeQuestion"px";
				  	//"color": $scope.colorQuestion
				 };
      }
	});

    angular.module('feedbackApp').controller('imageController', function($scope, FileUploader) {
        $scope.uploader = new FileUploader();
    });