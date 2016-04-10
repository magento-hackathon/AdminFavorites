<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml\Favorites;

class AjaxGet extends \Magento\Backend\App\Action
{
    /**
     *
     */
    public function execute()
    {
//        if (!$this->getRequest()->getPostValue()) {
//            return;
//        }

        $result = array('item1'=>'value1', 'item2'=>'value2');
        $this->getResponse()->representJson($this->jsonHelper->jsonEncode($result));
    }
}