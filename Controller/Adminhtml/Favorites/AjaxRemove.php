<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml\Favorites;

class AjaxRemove extends \Hackathon\AdminFavorites\Controller\Adminhtml\AjaxAbstract
{
    /**
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $url = $this->getUrlString();

        $userId = $this->getAdminUserId();

        /** @var \Hackathon\AdminFavorites\Model\Favorite $favorite */
        $favorite = $this->_favoriteFactory->create();

        $favorite->loadByUserIdAndUrl($userId, $url);

        $favorite->addData([
            'url' => $url,
            'user_id' => $userId,
            'label' => $this->getLabel(),
            'is_favorite' => '0',
            'updated_at' => new \Zend_Db_Expr('NOW()')
        ]);

        $favorite->save();

        $output = $this->getOutputdata($favorite);

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw
            ->setContents(\Zend_Json::encode($output))
            ->setHeader('Content-Type', 'application/json');
    }
}