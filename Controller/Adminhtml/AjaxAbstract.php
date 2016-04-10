<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml;

abstract class AjaxAbstract extends \Magento\Backend\App\Action
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
     * @return mixed
     * @throws Exception
     */
    protected function getUrlString()
    {
        $url = $this->getRequest()->getParam('url');
        if (!$url) {
            throw new \Magento\Framework\Exception\LocalizedException(__('URL not given!'));
        }
        return $url;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getLabel()
    {
        $label = $this->getRequest()->getParam('label');
        if (!$label) {
            throw new \Magento\Framework\LocalizedException(__('Label not given!'));
        }
        return $label;
    }

    /**
     * @return mixed
     */
    protected function getAdminUserId()
    {
        return $this->_authSession->getUser()->getId();
    }

    /**
     * @param \Hackathon\AdminFavorites\Model\Favorite $currentFavorite
     * @return array
     */
    protected function getOutputdata($currentFavorite)
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
     * This should be in a helper. I'd move it but I have no idea how right now.
     *
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