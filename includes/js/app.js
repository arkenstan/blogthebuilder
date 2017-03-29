(function(){


  var app = angular.module('btbApp', ['ngRoute', "chart.js", 'structural-directives', 'textAngular'])
  .controller("chartCtrl", function($scope) {

    $scope.labels = ["January", "February", "March", "April", "May", "June", "July"];
    $scope.series = ['Series A', 'Series B'];
    $scope.data = [
        [65, 59, 20, 81, 56, 55, 40],
        [28, 48, 40, 19, 86, 27, 90]
    ];
    $scope.datasetOverride = [{
        yAxisID: 'y-axis-1'
    }, {
        yAxisID: 'y-axis-2'
    }];
    $scope.options = {
        scales: {
            yAxes: [{
                id: 'y-axis-1',
                type: 'linear',
                display: true,
                position: 'left'
            }, {
                id: 'y-axis-2',
                type: 'linear',
                display: true,
                position: 'right'
            }]
        }
    };
    this.callFunction = function(){
      $scope.data = [
          [Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1)],
          [Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1)]
      ];
    };
});


  app.controller('mainCtrl', function(){

    this.sidebarTogg = false;

    this.toggleSidebar = function(){
      if(this.sidebarTogg === true){
        this.sidebarTogg = false;
      } else {
        this.sidebarTogg = true;
      }
    };

  });

  app.controller('sidebarCtrl', function(){
    this.tab = 1;

    this.setTab = function(val){
      this.tab = val;
    };

    this.isSet = function(check){
      return this.tab === check;
    };

  });

  app.controller('wysiwygeditor', function($scope){
/*		$scope.hidePost = function()
		{
			if($scope.showEditor == true)
				return true;
		}
		$scope.textValue = "Sample Text for binding";
<<<<<<< HEAD

=======
*/		
>>>>>>> 937f3457261d851d0ea745ea03e8d5643c4d1e7a
		$scope.orightml = '<h2>Try me!</h2><p>textAngular is a super cool WYSIWYG Text Editor directive for AngularJS</p><p><b>Features:</b></p><ol><li>Automatic Seamless Two-Way-Binding</li><li>Super Easy <b>Theming</b> Options</li><li style="color: green;">Simple Editor Instance Creation</li><li>Safely Parses Html for Custom Toolbar Icons</li><li class="text-danger">Doesn&apos;t Use an iFrame</li><li>Works with Firefox, Chrome, and IE8+</li></ol><p><b>Code at GitHub:</b> <a href="https://github.com/fraywing/textAngular">Here</a> </p>';
		$scope.htmlcontent = $scope.orightml;
		$scope.disabled = false;

		$scope.head={selected:null};
	});

  app.controller('privacyCtrl', function($scope)
  {
    $scope.notifyVal = false;
    $scope.notifyFunc = function()
    {
      if(document.getElementById("notify").checked == true)
        return $scope.notifyVal = true;
      else
        return $scope.notifyVal = false;
    };
  });


})();
