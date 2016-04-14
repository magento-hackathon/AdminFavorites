define([
    "jquery",
    "jquery/ui",
    "domReady!"
], function ($) {
    'use strict';

    var attachActionsToFavs = function() {
        $('.delete_fav_item').unbind('click');
        $('.delete_fav_item').click(function (event) {
            event.stopPropagation();
            var mydata = $(this).data();
            var favorites_id = mydata.value;
            //var json1 = JSON.stringify(mydata);
            console.log('remove ' + favorites_id);
            $.ajax({
                type: "POST",
                url: removeFavoriteUrlItem,
                data: {id       :favorites_id
                      ,form_key : window.FORM_KEY
                },
                success: function (response) {
                    console.log('remove success : ' + JSON.stringify(response));
                    populateFavoritesMenu(response);
                }
            }).done(function () {
                console.log('remove done');
            });
        });

        $('.edit_fav').click(function (event) {
            event.stopPropagation();
            var mydata = $(this).data();
            var favorites_id = mydata.value;
            console.log('edit label for ' + favorites_id);
        });
    };

    var populateFavorites = function(json){
        if(!typeof json == 'object'){
            var json = JSON.parse(json);
        }
        $('#favorites-menu').html('');
        $.each(json, function(element, value){
            var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-favorites-link item-report-shopcart-product level-2" role="menu-item">' +
                '<div class="favorites-item">'+
                '<div class="delete_fav-wrapper"><div class="delete_fav_item" data-value="' + value.id + '" title="Remove Favorite" ></div></div> ' +
                '<div class="edit_fav-wrapper"><div   class="edit_fav"   data-value="' + value.id + '" title="Edit Label" ></div></div> ' +
                '<a href="'+value.url+'" title="Navigate to ' + value.label + '" class="item-favorites-link">' + value.label + '</a>' +
                '</div>' +
                '</li>';
            $('#favorites-menu').append(element);
        });
        attachActionsToFavs();
    };
    var populateRecentlyViewed = function(json){
        if(!typeof json == 'object'){
            var json = JSON.parse(json);
        }
        $('#recently-viewed-menu').html('');
        $.each(json, function(element, value){
            var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-favorites-link item-report-shopcart-product level-2" role="menu-item">' +
                '<a href="'+value.url+'" class="item-favorites-link">' +
                '<div class="favorites-item">'+value.label+'</div>' +
                '</a>' +
                '</li>';

            $('#recently-viewed-menu').append(element);
        });
    };
    var populateMostlyViewed = function(json){
        if(!typeof json == 'object'){
            var json = JSON.parse(json);
        }
        $('#mostly-viewed-menu').html('');
        $.each(json, function(element, value){
            var element = '<li data-ui-id="menu-magento-reports-report-shopcart-product" class="item-favorites-link item-report-shopcart-product level-2" role="menu-item">' +
                '<a href="'+value.url+'" class="item-favorites-link">' +
                '<div class="favorites-item">'+value.label+'</div>' +
                '</a>' +
                '</li>';

            $('#mostly-viewed-menu').append(element);
        });
    };
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
    };
    var showActionButton = function(json){
        if(typeof json == "object") {
            if(json.is_favorite == '1') {
                $("#adminfavorites_remove").removeClass('hidden');
                $("#adminfavorites_add").addClass('hidden');
            } else {
                $("#adminfavorites_add").removeClass('hidden');
                $("#adminfavorites_remove").addClass('hidden');
            }
        }
    };
    var viewPage = function(){
        var requestUrl = $('#favorites-wrapper-id').attr('data-increment-page-viewed-url');
        //console.log(requestUrl);
        var requestData = {
            form_key: window.FORM_KEY,
            url: currentPageKey,
            label: document.title
        }
        //console.log(requestData);
        $.ajax({
            url: requestUrl,
            type: 'POST',
            dataType: 'json',
            data: requestData,
            showLoader: false
        }).done(function(response) {
            showActionButton(response);
            populateFavoritesMenu(response);
            //console.log(response);
        });

    };
    viewPage();

    var showFavoriteDetails = function (favoriteEntry) {
        var favorite = favoriteEntry.find('.notifications-entry-description');
        favorite.addClass('_show');
    };

    // Update favorite
    $('#adminfavorites_add').click(function (event) {
        event.stopPropagation();
        $('#adminfavorites_add span').html('Adding...');
        $.ajax({
            type: "POST",
            url: addFavoriteUrl,
            data: {'url':currentPageKey, 'label':document.title},
            success: function (response) {
                $('#adminfavorites_add span').html('Add');
                showActionButton(response);
                populateFavoritesMenu(response);
            }
        }).done(function () {
            //$('#hackathon_admin_favorites_heart').addClass(result.is_favorite);
            //updateFavoriteMegaMenu(result.items);
        });
    });

    $('#adminfavorites_remove').click(function (event) {
        event.stopPropagation();
        $('#adminfavorites_remove span').html('Removing...');
        $.ajax({
            type: "POST",
            url: removeFavoriteUrl,
            data: {'url':currentPageKey},
            success: function (response) {
                $('#adminfavorites_remove span').html('Remove');
                showActionButton(response);
                populateFavoritesMenu(response);
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