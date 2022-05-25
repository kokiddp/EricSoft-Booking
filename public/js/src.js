require('angular');
var moment = require('moment');
require('moment/locale/it');
var _ = require('lodash');

(function( $ ) {
	'use strict';

	/**
	 * On DOM ready:
	 */
	$(function() {	
        console.log('EricSoft Booking by Gabriele Coquillard');
        moment.locale('it');
	});

	/**
	 * Angular spapp:
	 */
    var app = angular.module('veb',[]);
    
    app.config(['$compileProvider', function($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
        $compileProvider.commentDirectivesEnabled(false);
        $compileProvider.cssClassDirectivesEnabled(false);
    }]);

    app.controller('vebController',[
        "$scope",
        "$window",
        function($scope,$window) {

            $scope.internal = {
                minNights: parseInt(veb_options.minNights),
                maxRooms: parseInt(veb_options.maxRooms),
                maxPeople: parseInt(veb_options.maxPeople),
                defaultAdults: parseInt(veb_options.defaultAdults),
                minAdultsFirstRoom: parseInt(veb_options.minAdultsFirstRoom),
                minAdultsOtherRooms: parseInt(veb_options.minAdultsOtherRooms),
                minArrivalDate: moment(new Date()).startOf('day').toDate(),
                url: veb_options.url,
                queryString: '',
            }
            $scope.internal.minDepartDate = moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate();
            $scope.internal.arrival = moment($scope.internal.minArrivalDate).startOf('day');
            $scope.internal.depart = moment($scope.internal.minDepartDate).startOf('day');

            $scope.form = {
                arrivalDate: moment(new Date()).startOf('day').toDate(),
                departDate: moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate(),
                rooms: [{
                    id: 0,
                    adulti: parseInt(veb_options.defaultAdults),
                    ragazzi: 0,
                    bambini: 0,
                    neonati: 0,
                    minAdulti: parseInt(veb_options.minAdultsFirstRoom),
                    maxAdulti: parseInt(veb_options.maxPeople),
                    minRagazzi: 0,
                    maxRagazzi: parseInt(veb_options.maxPeople),
                    minBambini: 0,
                    maxBambini: parseInt(veb_options.maxPeople),
                    minNeonati: 0,
                    maxNeonati: parseInt(veb_options.maxPeople),
                }],
            }

            $scope.submit = {
                idh: veb_options.idh,
                cur: 'EUR',
                lang: 'it',
                pax: '',
            }

            $scope.$watch("form.rooms", function(){
                
            }, true);

            $scope.$watch("form.arrivalDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
                $scope.internal.minDepartDate = moment($scope.internal.arrival.toDate()).add(parseInt($scope.internal.minNights), 'd').toDate();
            }, true);

            $scope.$watch("form.departDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
            }, true);

            $scope.addRoom = function(){
                $scope.form.rooms.push({
                    id: _.last($scope.form.rooms).id+1,
                    adulti: parseInt(veb_options.defaultAdults),
                    ragazzi: 0,
                    bambini: 0,
                    neonati: 0,
                    minAdulti: parseInt(veb_options.minAdultsOtherRooms),
                    maxAdulti: parseInt(veb_options.maxPeople),
                    minRagazzi: 0,
                    maxRagazzi: parseInt(veb_options.maxPeople),
                    minBambini: 0,
                    maxBambini: parseInt(veb_options.maxPeople),
                    minNeonati: 0,
                    maxNeonati: parseInt(veb_options.maxPeople),
                });
            }

            $scope.removeRoom = function(){
                $scope.form.rooms.splice(-1,1);
            }

            $scope.submitForm = function(){
                $scope.submit.arrival = $scope.internal.arrival.format('YYYY-MM-DD');
                $scope.submit.departure = $scope.internal.depart.format('YYYY-MM-DD');

                $scope.submit.pax = '';
                _.forEach($scope.form.rooms, function(room){
                    $scope.submit.pax += room.adulti + '_' + room.ragazzi + '_'+ room.bambini + '_' + room.neonati + '%7C';
                });
                $scope.submit.pax = $scope.submit.pax.substring(0, $scope.submit.pax.length-3);

                $scope.internal.queryString = _.reduce($scope.submit, function(result, value, key) { return (!_.isNull(value) && !_.isUndefined(value)) ? (result += key + '=' + value + '&') : result; }, '').slice(0, -1);
                $window.open($scope.internal.url+'?'+$scope.internal.queryString);
            }
        
    }]);
    
    app.filter('range', function() {
        return function(input, min, max) {
            min = parseInt(min);
            max = parseInt(max);
            for (var i=min; i<=max; i++)
                input.push(i);
            return input;
        };
    });

})( jQuery );