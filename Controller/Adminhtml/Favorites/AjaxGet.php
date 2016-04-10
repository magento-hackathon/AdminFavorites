<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml\Favorites;

class AjaxGet extends \Hackathon\AdminFavorites\Controller\Adminhtml\AjaxAbstract
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
     */
    public function execute()
    {
        /** @var \Hackathon\AdminFavorites\Model\Favorite $favorite */
        $favorite = $this->_favoriteFactory->create();

        $favorites = $favorite->getCollection();

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw
            ->setContents(\Zend_Json::encode($favorites))
            ->setHeader('Content-Type', 'application/json');
    }
}