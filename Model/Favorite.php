<?php
namespace Hackathon\AdminFavorites\Model;
class Favorite extends \Magento\Framework\Model\AbstractModel implements FavoriteInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'hackathon_admin_notification';

    protected function _construct()
    {
        $this->_init('Hackathon\AdminFavorites\Model\ResourceModel\Favorite');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}