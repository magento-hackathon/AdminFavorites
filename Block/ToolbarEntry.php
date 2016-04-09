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

    public function isCurrentPageFavorite() {
        return false;
    }
}
