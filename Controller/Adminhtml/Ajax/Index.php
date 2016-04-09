<?php
namespace Hackathon\AdminFavorites\Controller\Adminhtml\Ajax;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
    }

    /**
     * say admin text
     */
    public function execute()
    {
        $output = [
            'is_favorite' => 1,
        ];
        
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw
            ->setContents(\Zend_Json::encode($output))
            ->setHeader('Content-Type', 'application/json');
    }
}