angular.module('share',[]).service('shareQuestion',function ($http) {
        var question="1";
 
       return {
            getProperty: function () {
            return $http({
                url:"../controller/classController.php/getQuestion",
                method:'GET'
            })

            }
           /* setProperty: function(value) {
                  $rootScope.property=value;
            
            }*/
        }
});