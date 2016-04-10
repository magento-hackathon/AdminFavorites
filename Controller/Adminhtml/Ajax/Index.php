<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml\Ajax;

use Magento\TestFramework\Inspection\Exception;

class Index extends \Magento\Backend\App\Action
{
    const MAX_NUMBER_ITEMS = 10;
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
        $url = $this->getUrlString();

        $userId = $this->getAdminUserId();

        /** @var \Hackathon\AdminFavorites\Model\Favorite $favorite */
        $favorite = $this->_favoriteFactory->create();
        
        $favorite->loadByUserIdAndUrl($userId, $url);
        
        $favorite->addData([
            'url' => $url,
            'user_id' => $userId,
            'label' => $this->getLabel(),
            'updated_at' => new \Zend_Db_Expr('NOW()'),
            'number_visits' => intval($favorite->getData('number_visits')) + 1,
        ]);
        
        $favorite->save();
        
        $output = $this->getOutputdata($favorite);
        
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw
            ->setContents(\Zend_Json::encode($output))
            ->setHeader('Content-Type', 'application/json');
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getUrlString()
    {
        $url = $this->getRequest()->getParam('url');
        if (!$url) {
            throw new Exception('URL not given!');
        }
        return $url;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getLabel()
    {
        $label = $this->getRequest()->getParam('label');
        if (!$label) {
            throw new Exception('Label not given!');
        }
        return $label;
    }

    /**
     * @return mixed
     */
    private function getAdminUserId()
    {
        return $this->_authSession->getUser()->getId();
    }

    /**
     * @param \Hackathon\AdminFavorites\Model\Favorite $currentFavorite
     * @return array
     */
    private function getOutputdata($currentFavorite)
    {
        $data = [
            'is_favorite' => intval($currentFavorite->getData('is_favorite')),
            'my_favorites' => [],
            'recently_viewed' => [],
            'mostly_viewed' => [],
        ];
        
        foreach($this->getMyFavoritesCollection($currentFavorite) as $favorite) {
            $data['my_favorites'][] = $this->getFavoriteDataForOutput($favorite);
        }
        
        foreach($this->getRecentlyViewedCollection($currentFavorite) as $favorite) {
            $data['recently_viewed'][] = $this->getFavoriteDataForOutput($favorite);
        }
        
        foreach($this->getMostlyViewedCollection($currentFavorite) as $favorite) {
            $data['mostly_viewed'][] = $this->getFavoriteDataForOutput($favorite);
        }
        
        return $data;
    }

    /**
     * @param \Hackathon\AdminFavorites\Model\Favorite $favorite
     * @return \Hackathon\AdminFavorites\Model\ResourceModel\Favorite\Collection
     */
    private function getMyFavoritesCollection($favorite)
    {
        return $favorite->getCollection()
            ->addFieldToFilter('user_id', $this->getAdminUserId())
            ->addFieldToFilter('is_favorite', 1)
            ->setPageSize(self::MAX_NUMBER_ITEMS);
    }

    /**
     * @param \Hackathon\AdminFavorites\Model\Favorite $favorite
     * @return \Hackathon\AdminFavorites\Model\ResourceModel\Favorite\Collection
     */
    private function getRecentlyViewedCollection($favorite)
    {
        return $favorite->getCollection()
            ->addFieldToFilter('user_id', $this->getAdminUserId())
            ->setOrder('updated_at', 'desc')
            ->setPageSize(self::MAX_NUMBER_ITEMS);
    }

    /**
     * @param \Hackathon\AdminFavorites\Model\Favorite $favorite
     * @return \Hackathon\AdminFavorites\Model\ResourceModel\Favorite\Collection
     */
    private function getMostlyViewedCollection($favorite)
    {
        return $favorite->getCollection()
            ->addFieldToFilter('user_id', $this->getAdminUserId())
            ->setOrder('number_visits', 'desc')
            ->setPageSize(self::MAX_NUMBER_ITEMS);
    }

    /**
     * @param \Hackathon\AdminFavorites\Model\Favorite $favorite
     * @return array
     */
    private function getFavoriteDataForOutput($favorite)
    {
        return [
            'url' => $this->getRouteUrl($favorite->getData('url')),
            'label' => $favorite->getData('label'),
        ];
    }

    /**
     * @param string $route
     * @return string
     * @throws \Exception
     */
    private function getRouteUrl($route) 
    {
        $routeParts = explode('/', $route);
        if (sizeof($routeParts) < 3) {
            throw new \Exception('Route must contain at least 2 slashes.');
        }
        $routePath = $routeParts[0] . '/' . $routeParts[1] . '/' . $routeParts[2];
        $routeParams = [];
        for ($i = 3; $i < sizeof($routeParts); $i += 2) {
            $routeParams[$routeParts[$i]] = $routeParts[$i + 1];
        }
        
        /** @var \Magento\Framework\UrlInterface $urlInterface */
        $urlInterface = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Backend\Model\UrlInterface');
        
        return $urlInterface->getUrl($routePath, $routeParams);
    }
}