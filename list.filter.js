//Angular to trust html so it can be displayed on a page
(function () {
    "use strict";
    var myApp = angular.module("iowaList");
    myApp.filter("trustHtml", function($sce) {
        return function(html) {
            return $sce.trustAsHtml(html);
        };
    });
} )();
