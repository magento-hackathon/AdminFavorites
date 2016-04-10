<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml\Ajax;

use Magento\TestFramework\Inspection\Exception;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Hackathon\AdminFavorites\Model\FavoriteFactory
     */
    protected $_favoriteFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_authSession;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

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
     * say admin text
     */
    public function execute()
    {
        $url = $this->getRequest()->getParam('url');
        if (!$url) {
            throw new Exception('URL not given!');
        }

        $label = $this->getRequest()->getParam('label');
        if (!$label) {
            throw new Exception('Label not given!');
        }

        $userId = $this->_authSession->getUser()->getId();

        /** @var \Hackathon\AdminFavorites\Model\Favorite $favorite */
        $favorite = $this->_favoriteFactory->create();
        
        $favorite->addData([
            'url' => $url,
            'user_id' => $userId,
            'label' => $label,
            'updated_at' => new \Zend_Db_Expr('NOW()'),
            'number_visits' => intval($favorite->getData('number_visits')) + 1,
        ]);
        
        $favorite->save();
        
        $output = [
            'is_favorite' => intval($favorite->getData('is_favorite')),
        ];
        
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw
            ->setContents(\Zend_Json::encode($output))
            ->setHeader('Content-Type', 'application/json');
    }
}