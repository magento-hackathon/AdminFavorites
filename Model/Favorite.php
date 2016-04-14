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

    /**
     * Load object data
     *
     * @param integer $userId
     * @param string $url
     * @return $this
     */
    public function loadByUserIdAndUrl($userId, $url)
    {
        $this->_getResource()->loadByUserIdAndUrl($this, $userId, $url);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        return $this;
    }

    public function loadByUserIdAndId($userId, $id)
    {
        $this->_getResource()->loadByUserIdAndId($this, $userId, $id);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        return $this;
    }
}