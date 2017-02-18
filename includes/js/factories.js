(function(){
  var app = angular.module('userApi', []);

  app.factory('jData', ['$http',function($http){
    var dataRepository = {
      data: null,
      pData: function(){
        return $http.get('./includes/data/home.json');
      }
    };

/*    $http.get('./includes/data/home.json').success(function(response){
      console.log(response);
      dataRepository.data = response;
      console.log(dataRepository.data);
    });*/

    return dataRepository;

  }]);

})();
