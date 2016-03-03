<?php
namespace Training1\FreeGeoIp\Controller\Action;


use Magento\Framework\App\Action\AbstractAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Training1\FreeGeoIp\Model\FreeGeoIp;
use Training1\FreeGeoIp\Model\FreeGeoIpFactory;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_freeGeoIp;

    protected $_remoteAddress;

    public function __construct(
        Context $context,
        FreeGeoIpFactory $factory,
        RemoteAddress $remoteAddress
    ) {
        parent::__construct($context); // TODO: Change the autogenerated stub
        $this->_freeGeoIp = $factory->create();
        $this->_remoteAddress = $remoteAddress;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $data['remote_ip'] = $this->_remoteAddress->getRemoteAddress(true);
        $data['remote_url'] = 'http://freegeoip.net/json/';
        $response = $this->_freeGeoIp->sendRequest($data);
        $response = json_decode($response);
        var_dump($response);
        exit;
    }

}