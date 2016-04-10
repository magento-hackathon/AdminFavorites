<?php
namespace Hackathon\AdminFavorites\Model\ResourceModel\Favorite;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Hackathon\AdminFavorites\Model\Favorite', 'Hackathon\AdminFavorites\Model\ResourceModel\Favorite');
    }
}