angular.module('Admin', ['ngRoute'])

.controller('MainController', ['$scope', '$rootScope', '$location', '$http', '$interval', ($scope, $rootScope, $location, $http, $interval) => {
    $scope.data = [];
    $scope.num = 0;

    $scope.getData = (num = 0) => {
        $scope.num = num;
        $http
            .post("api/getdata/" + num, {})
            .then(
                (response) => {
                     $scope.data = response.data;
                }
            );
    }

    $scope.select = (time) => {
        $location.path('time/' + encodeURIComponent(time));
    }

    $scope.getTitle = (s) => {
        return s == 'close' ? 'Подтвержден' : s == 'multi' ? 'Дубль' : s == "wait" ? "'Ожидание'" : 'Свободное время';
    };
    
    $scope.getData();
}])
.controller('SetTimeController', ['$scope', '$rootScope', '$location', '$http', '$interval', '$routeParams', ($scope, $rootScope, $location, $http, $interval, $routeParams) => {
    $scope.data = [];
    $scope.num = 0;

    $scope.getData = (num = 0) => {
        $scope.num = num;
        $http
            .post("api/getdata/" + num, {})
            .then(
                (response) => {
                     $scope.data = response.data;
                }
            );
    }

    $scope.select = (time) => {
        $http
            .post("api/settime", {id: $routeParams['id'], time: time.fullTime})
            .then(
                (response) => {
                     $location.path('/');
                }
            );
    }

    $scope.getTitle = (s) => {
        return s == 'close' ? 'Подтвержден' : s == 'multi' ? 'Дубль' : s == "wait" ? "'Ожидание'" : 'Свободное время';
    };
    
    $scope.getData();
}])
.controller('NewController', ['$scope', '$rootScope', '$location', '$http', '$interval', ($scope, $rootScope, $location, $http, $interval) => {
    $scope.data = [];
    $scope.num = 0;

    $scope.getData = () => {
        $http
            .post("api/getnew", {})
            .then(
                (response) => {
                    //alert(response.data);
                     $scope.data = response.data;
                }
            );
    }

    $scope.remove = (id) => {
        $http
            .post("api/remove/" + id, {})
            .then(
                (response) => {
                    $scope.getData();
                }
            );
    }

    $scope.accept = (id) => {
        $http
            .post("api/accept/" + id, {})
            .then(
                (response) => {
                    $scope.getData();
                }
            );
    }

    $scope.setTime = (id) => {
        $location.path('settime/' + id);
    }
    
    $scope.getData();
}])
.controller('TimeController', ['$scope', '$rootScope', '$location', '$http', '$interval', '$routeParams', ($scope, $rootScope, $location, $http, $interval, $routeParams) => {
    $scope.data = [];

    $scope.time = decodeURIComponent($routeParams['time']);

    $scope.getData = () => {
        $http
            .post("api/get/" + $routeParams['time'], {})
            .then(
                (response) => {
                   // alert(response.data);
                     $scope.data = response.data;
                }
            );
    }

    $scope.remove = (id) => {
        $http
            .post("api/remove/" + id, {})
            .then(
                (response) => {
                    $scope.getData();
                }
            );
    }

    $scope.add = (time) => {
        $location.path('addnew/' + encodeURIComponent(time));
    }

    $scope.accept = (id) => {
        $http
            .post("api/accept/" + id, {})
            .then(
                (response) => {
                    $scope.getData();
                }
            );
    }

    $scope.setTime = (id) => {
        $location.path('settime/' + id);
    }
    
    $scope.getData();
}])
.controller('AddNewController', ['$scope', '$rootScope', '$location', '$http', '$interval', '$routeParams', ($scope, $rootScope, $location, $http, $interval, $routeParams) => {
    $scope.time = decodeURIComponent($routeParams['time']);
    $scope.data = {name: '', phone: '', time: $scope.time, status: 'wait'};

    $scope.add = () => {
        if($scope.data.name && $scope.data.phone)
            $http
                .post("api/addnew", {data: $scope.data})
                .then(
                    (response) => {
                        $location.path('time/' + $routeParams['time']);
                    }
                );
        else{
            alert('Введите имя и телефон');
        }
    }
}])

.config(($locationProvider) => {
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: true
    });
})
.config(function($routeProvider) {
    $routeProvider
        .when('/table/', {
            controller: 'MainController',
            templateUrl: 'tpl/main.tpl',
            resolve: {
              
                fnc: ($http, $rootScope) => {
                    $rootScope.activePage = "main";
                    $rootScope.title = "Таблица";
                }
            }
        })   
        .when('/new/', {
            controller: 'NewController',
            templateUrl: 'tpl/orders.tpl',
            resolve: {
              
                fnc: ($http, $rootScope) => {
                    $rootScope.activePage = "new";
                    $rootScope.title = "Таблица";
                }
            }
        })   
        .when('/time/:time', {
            controller: 'TimeController',
            templateUrl: 'tpl/time.tpl',
            resolve: {
              
                fnc: ($http, $rootScope) => {
                    $rootScope.activePage = "get";
                    $rootScope.title = "Таблица";
                }
            }
        })   
        .when('/settime/:id', {
            controller: 'SetTimeController',
            templateUrl: 'tpl/settime.tpl',
            resolve: {
              
                fnc: ($http, $rootScope) => {
                    $rootScope.activePage = "get";
                    $rootScope.title = "Таблица";
                }
            }
        })   
        .when('/addnew/:time', {
            controller: 'AddNewController',
            templateUrl: 'tpl/addnew.tpl',
            resolve: {
              
                fnc: ($http, $rootScope) => {
                    $rootScope.activePage = "addnew";
                    $rootScope.title = "Добавить";
                }
            }
        })   
        .otherwise({ redirectTo: '/table/' });
});

