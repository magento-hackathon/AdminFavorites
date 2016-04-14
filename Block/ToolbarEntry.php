<?php

// @codingStandardsIgnoreFile

namespace Hackathon\AdminFavorites\Block;

/**
 * Toolbar entry to allow favoriting/un-favoriting of the current page.
 *
 * @author      Magento 2016 Hackathon Team
 */
class ToolbarEntry extends \Magento\Backend\Block\Template
{
    public function allowToFavorite() {
        return true;
    }

    public function getCurrentPageKey() {
        return $this->getRequest()->getRouteName() .'/'. $this->getRequest()->getControllerName() .'/'. $this->getRequest()->getActionName();
    }

    public function getGetFavoritesUrl() {
        return $this->_urlBuilder->getUrl('adminfavorites/favorites/ajaxGet');
    }

    public function getAddFavoriteUrl() {
        return $this->_urlBuilder->getUrl('adminfavorites/favorites/ajaxAdd');
    }

    public function getRemoveFavoriteUrl() {
        return $this->_urlBuilder->getUrl('adminfavorites/favorites/ajaxRemove');
    }

    public function getRemoveFavoriteUrlItem() {
        return $this->_urlBuilder->getUrl('adminfavorites/favorites/ajaxRemoveitem');
    }

    public function getIncrementUrl() {
        return $this->_urlBuilder->getUrl('adminfavorites/favorites/ajaxIncrement');
    }


}
