define([
    "jquery",
    "jquery/ui",
    "domReady!"
], function ($) {
    'use strict';

    var json = '{"is_favorite":0,"my_favorites":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"}],"recently_viewed":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/param\/1\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/13\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"}],"mostly_viewed":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/param\/1\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/13\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/","label":"Test"}]}';
    var parsedJson = JSON.parse(json);
    var populateFavorites = function(json){
        if(!typeof json == 'object'){
            var json = JSON.parse(json);
        }
        $.each(json, function(element, value){
            var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-report-shopcart-product level-2" role="menu-item">' +
                '<a href="'+value.url+'" class="">' +
                '<span>'+value.label+'</span>' +
                '</a>' +
                '</li>';
            $('#favorites-menu').append(element);
        });
    }
    var populateRecentlyViewed = function(json){
        if(!typeof json == 'object'){
            var json = JSON.parse(json);
        }
        $.each(json, function(element, value){
            var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-report-shopcart-product level-2" role="menu-item">' +
                '<a href="'+value.url+'" class="">' +
                '<span>'+value.label+'</span>' +
                '</a>' +
                '</li>';

            $('#recently-viewed-menu').append(element);
        });
    }
    var populateMostlyViewed = function(json){
        if(!typeof json == 'object'){
            var json = JSON.parse(json);
        }
        $.each(json, function(element, value){
            var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-report-shopcart-product level-2" role="menu-item">' +
                '<a href="'+value.url+'" class="">' +
                '<span>'+value.label+'</span>' +
                '</a>' +
                '</li>';

            $('#mostly-viewed-menu').append(element);
        });
    }
    populateFavorites(parsedJson.my_favorites);
    populateMostlyViewed(parsedJson.mostly_viewed);
    populateRecentlyViewed(parsedJson.recently_viewed);

    var showFavoriteDetails = function (favoriteEntry) {
        var favorite = favoriteEntry.find('.notifications-entry-description');
        favorite.addClass('_show');
    };


    $('.favorites-wrapper .admin__action-dropdown-menu .notifications-entry').on('click.showNotification', function (event) {
        // hide notification dropdown
        $('.favorites-wrapper .notifications-icon').trigger('click.dropdown');

        showFavoriteDetails($(this));
        event.stopPropagation();
    });

});