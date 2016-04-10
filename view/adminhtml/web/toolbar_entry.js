define([
    "jquery",
    "jquery/ui",
    "domReady!"
], function ($) {
    'use strict';

    var json = '{"is_favorite":1,"my_favorites":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"}],"recently_viewed":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/param\/1\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/13\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"}],"mostly_viewed":[{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/param\/1\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/12\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/13\/","label":"Test"},{"url":"http:\/\/adminfavorites.local\/admin_jz5czk\/test\/abc\/14\/","label":"Test"}]}';
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
    var populateFavoritesMenu = function(json){
        if(typeof json == "object") {
            if(json.my_favorites) {
                populateFavorites(json.my_favorites);
            }
            if(json.mostly_viewed) {
                populateMostlyViewed(json.mostly_viewed);
            }
            if(json.recently_viewed) {
                populateRecentlyViewed(json.recently_viewed);
            }
        }
    }
    var viewPage = function(){
        var requestUrl = $('#favorites-wrapper-id').attr('data-increment-page-viewed-url');
        console.log(requestUrl);
        var requestData = {
            form_key: window.FORM_KEY,
            url: currentPageKey,
            label: document.title
        }
        console.log(requestData);
        $.ajax({
            url: requestUrl,
            type: 'POST',
            dataType: 'json',
            data: requestData,
            showLoader: false
        }).done(function(response) {
            populateFavoritesMenu(response);
            console.log(response);
        });

    }
    viewPage();

    var showFavoriteDetails = function (favoriteEntry) {
        var favorite = favoriteEntry.find('.notifications-entry-description');
        favorite.addClass('_show');
    };

    // Update favorite
    $('#adminfavorites_add').click(function (event) {
        event.stopPropagation();
        $.ajax({
            type: "POST",
            url: addFavoriteUrl,
            data: {'url':currentPageKey, 'label':currentPageKey},
            success: function () {
            }
        }).done(function () {
            //$('#hackathon_admin_favorites_heart').addClass(result.is_favorite);
            //updateFavoriteMegaMenu(result.items);
        });
    });
    $('#adminfavorites_remove').click(function (event) {
        event.stopPropagation();
        $.ajax({
            type: "POST",
            url: removeFavoriteUrl,
            data: {'url':currentPageKey},
            success: function () {
            }
        }).done(function () {
            //$('#hackathon_admin_favorites_heart').addClass(result.is_favorite);
            //updateFavoriteMegaMenu(result.items);
        });
    });


    $('.favorites-wrapper .admin__action-dropdown-menu .notifications-entry').on('click.showNotification', function (event) {
        // hide notification dropdown
        $('.favorites-wrapper .notifications-icon').trigger('click.dropdown');

        showFavoriteDetails($(this));
        event.stopPropagation();
    });

});