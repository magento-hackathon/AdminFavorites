<?php
namespace Hackathon\AdminFavorites\Model\ResourceModel;
class Favorite extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('admin_favorites', 'favorites_id');
    }

    /**
     * Load an object
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param int $userId
     * @param string $url
     * @return $this
     */
    public function loadByUserIdAndUrl(\Magento\Framework\Model\AbstractModel $object, $userId, $url)
    {
        $connection = $this->getConnection();
        if ($connection) {
            $select = $this->_getLoadByUserIdAndUrlSelect($userId, $url, $object);
            $data = $connection->fetchRow($select);

            if ($data) {
                $object->setData($data);
            }
        }

        $this->unserializeFields($object);
        $this->_afterLoad($object);

        return $this;
    }

    /**
     * Retrieve select object for load object data
     *
     * @param int $userId
     * @param string $url
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Framework\DB\Select
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getLoadByUserIdAndUrlSelect($userId, $url, $object)
    {
        $userIdField = $this->getConnection()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), 'user_id'));
        $urlField = $this->getConnection()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), 'url'));
        $select = $this->getConnection()->select()
            ->from($this->getMainTable())
            ->where($userIdField . '=?', $userId)
            ->where($urlField . '=?', $url);
        return $select;
    }

}