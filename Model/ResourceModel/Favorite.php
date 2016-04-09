<?php
namespace Hackathon\AdminFavorites\Model\ResourceModel;
class Favorite extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('admin_favorites','favorites_id');
    }
}