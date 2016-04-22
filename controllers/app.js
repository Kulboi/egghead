
  var app =  angular.module("App-name",['ngRoute'],['other-packsges-required-by-app']); 



app.run(function($rootScope,$any-other-injection){
  $rootScope.BaseServer = 'http://localhost/project-root' ; //to absolute path to project folder
});