(function(){
  var app = angular.module('userApi', []);

  app.factory('jData', ['$http', '$q',function($http,$q){
    var dataP = null;

    function loadData(page){
      var defer = $q.defer();
      $http.get('./includes/data/'+page+'.json').success(function(data){
        dataP = data;
        defer.resolve();
      });
      return defer.promise;
    }


    return {
      getData: function(){ return dataP; },
      loadData: loadData
    };

  }]);

})();
