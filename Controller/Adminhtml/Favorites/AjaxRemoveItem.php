<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml\Favorites;

class AjaxRemoveitem extends \Hackathon\AdminFavorites\Controller\Adminhtml\AjaxAbstract
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Hackathon\AdminFavorites\Model\FavoriteFactory $favoriteFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Hackathon\AdminFavorites\Model\FavoriteFactory $favoriteFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    ) {
        parent::__construct($context);
        $this->_favoriteFactory = $favoriteFactory;
        $this->_authSession = $authSession;
        $this->resultRawFactory = $resultRawFactory;
    }
    /**
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $id = $this->getFavoriteId();

        $userId = $this->getAdminUserId();

        /** @var \Hackathon\AdminFavorites\Model\Favorite $favorite */
        $favorite = $this->_favoriteFactory->create();

        $favorite->loadByUserIdAndId($userId, $id);

        $favorite->addData([
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