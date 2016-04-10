define([
    "jquery",
    "jquery/ui",
    "domReady!"
], function ($) {
    'use strict';

    $(document).ready(function () {
        // ajax call to grab values above and send to the hackathon_admin_favorites/checkurl
        // returns json or 3 arrays  - favs, popular, recent
        $.ajax({
            type: "GET",
            url: getFavesUrl,
            data: getFavesData,
            success: function () {
            }
        }).done(function (result) {
            //updateFavoriteMegaMenu(result.items);
            //$('#hackathon_admin_favorites_heart').show();
        });
        // ajax call to toggle fav //no fav
        $('#hackathon_admin_favorites_heart').click(function (event) {
            event.stopPropagation();
            $.ajax({
                type: "POST",
                url: toggleFaveUrl,
                data: toggleFaveData,
                success: function () {
                }
            }).done(function () {
                //$('#hackathon_admin_favorites_heart').addClass(result.is_favorite);
                //updateFavoriteMegaMenu(result.items);
            });
        });
    });

    function updateFavoriteMegaMenu(items) {
        for (var i = 0; i < items.length; i++) {
            // add urls for each column
            // foreach input box, on change, update label
        }
    }
    //var favoritesMenu = $("#menu-hackathon-adminfavorites-favorites .submenu [role='menu']")
    //favoritesMenu.html("");
    //favoritesMenu.append('<li class="column">' +
    //    '<ul role="menu">' +
    //    '<li data-ui-id="menu-magento-reports-report-marketing" class="item-report-marketing  parent  level-1" role="menu-item"><strong class="submenu-group-title" role="presentation">' +
    //    '<span>Favorites</span>' +
    //    '</strong>' +
    //    '<div class="submenu">' +
    //    '<ul id="favorites-menu" role="menu">' +
    //    '</ul>' +
    //    '</div>' +
    //    '</li>' +
    //    '</ul>' +
    //    '</li>');
    //favoritesMenu.append('<li class="column">' +
    //    '<ul role="menu">' +
    //    '<li data-ui-id="menu-magento-reports-report-marketing" class="item-report-marketing  parent  level-1" role="menu-item"><strong class="submenu-group-title" role="presentation">' +
    //    '<span>Mostly Viewed</span>' +
    //    '</strong>' +
    //    '<div class="submenu">' +
    //    '<ul id="mostly-viewed-menu" role="menu">' +
    //    '</ul>' +
    //    '</div>' +
    //    '</li>' +
    //    '</ul>' +
    //    '</li>');
    //favoritesMenu.append('<li class="column">' +
    //    '<ul role="menu">' +
    //    '<li data-ui-id="menu-magento-reports-report-marketing" class="item-report-marketing  parent  level-1" role="menu-item"><strong class="submenu-group-title" role="presentation">' +
    //    '<span>Recently Viewed</span>' +
    //    '</strong>' +
    //    '<div class="submenu">' +
    //    '<ul id="recently-viewed-menu" role="menu">' +
    //    '</ul>' +
    //    '</div>' +
    //    '</li>' +
    //    '</ul>' +
    //    '</li>');
    //
    //var json = '{"is_favorite":0,"my_favorites":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"}],"recently_viewed":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/param\/1\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/13\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"}],"mostly_viewed":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/param\/1\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/13\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/","label":"Test"}]}';
    //var parsedJson = JSON.parse(json);
    //var populateFavorites = function(json){
    //    if(!typeof json == 'object'){
    //        var json = JSON.parse(json);
    //    }
    //    $.each(json, function(element, value){
    //        var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-report-shopcart-product level-2" role="menu-item">' +
    //            '<a href="'+value.url+'" class="">' +
    //            '<span>'+value.label+'</span>' +
    //            '</a>' +
    //            '</li>';
    //        $('#favorites-menu').append(element);
    //    });
    //}
    //var populateRecentlyViewed = function(json){
    //    if(!typeof json == 'object'){
    //        var json = JSON.parse(json);
    //    }
    //    $.each(json, function(element, value){
    //        var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-report-shopcart-product level-2" role="menu-item">' +
    //            '<a href="'+value.url+'" class="">' +
    //            '<span>'+value.label+'</span>' +
    //            '</a>' +
    //            '</li>';
    //
    //        $('#recently-viewed-menu').append(element);
    //    });
    //}
    //var populateMostlyViewed = function(json){
    //    if(!typeof json == 'object'){
    //        var json = JSON.parse(json);
    //    }
    //    $.each(json, function(element, value){
    //        var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-report-shopcart-product level-2" role="menu-item">' +
    //            '<a href="'+value.url+'" class="">' +
    //            '<span>'+value.label+'</span>' +
    //            '</a>' +
    //            '</li>';
    //
    //        $('#mostly-viewed-menu').append(element);
    //    });
    //}
    //populateFavorites(parsedJson.my_favorites);
    //populateMostlyViewed(parsedJson.mostly_viewed);
    //populateRecentlyViewed(parsedJson.recently_viewed);
});