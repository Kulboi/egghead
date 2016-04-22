
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
