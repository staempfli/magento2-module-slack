<?php
/**
 * @category  Staempfli
 * @package   Staempfli_Slack
 * @copyright Copyright © Stämpfli AG. All rights reserved.
 * @author    marcel.hauri@staempfli.com
 */

namespace Staempfli\Slack\Observer;

use League\HTMLToMarkdown\HtmlConverter;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Staempfli\ChatConnector\Api\Data\MessageInterface;
use Staempfli\ChatConnector\Api\MessageManagementInterface;
use Staempfli\Slack\Model\Config;

class Notify implements ObserverInterface
{
    /**
     * @var MessageInterface
     */
    private $message;
    /**
     * @var MessageManagementInterface
     */
    private $messageManagement;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var HtmlConverter
     */
    private $converter;

    /**
     * Notify constructor.
     * @param MessageInterface $message
     * @param MessageManagementInterface $messageManagement
     * @param Config $config
     * @param HtmlConverter $converter
     */
    public function __construct(
        MessageInterface $message,
        MessageManagementInterface $messageManagement,
        Config $config,
        HtmlConverter $converter
    ) {
        $this->message = $message;
        $this->messageManagement = $messageManagement;
        $this->config = $config;
        $this->converter = $converter;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = [];
        $data['text'] = strip_tags($observer->getMessage());

        if ($this->config->getMessageFormat() === 'mrkdwn') {
            $this->converter->getConfig()->setOption('bold_style', '*');
            $this->converter->getConfig()->setOption('italic_style', '_');
            $this->converter->getConfig()->setOption('strike_style', '~');
            $this->converter->getConfig()->setOption('code_style', "`");
            $data['text'] = $this->converter->convert(nl2br($observer->getMessage()));
            $data['mrkdwn'] = true;
            $data['mrkdwn_in'] = 'text';
        }

        $data['channel'] = $this->config->getChannel();
        $data['username'] = $this->config->getUsername();
        $data['icon_emoji'] = $this->config->getIcon();
        $message = $this->message
            ->setUrl($this->config->getUrl())
            ->setMessageData($data);
        $this->messageManagement->send($message);
    }
}
