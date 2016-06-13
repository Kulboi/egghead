
var app =  angular.module("App-name",['ngRoute']); 



app.run(function($rootScope){
  $rootScope.BaseServer = 'http://localhost/project-root' ; //to absolute path to project folder
});

app.config( ['$routeProvider', function($routeProvider) {

    $routeProvider
        .when('/', {
            title: 'Welcome Page',
            templateUrl: 'models/page.php-or-page.html',
            controller : 'Required-Ctrl' 
        })

        .otherwise({
            redirectTo: '/'
        });
                
}]);
