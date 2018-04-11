<?php
/**
 * @category  Staempfli
 * @package   Staempfli_Slack
 * @copyright Copyright © Stämpfli AG. All rights reserved.
 * @author    marcel.hauri@staempfli.com
 */
namespace Staempfli\Slack\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const MESSAGE_FORMAT = 'mrkdwn';
    const XML_PATH_SLACK_URL = 'chatconnector/slack/url';
    const XML_PATH_SLACK_CHANNEL = 'chatconnector/slack/channel';
    const XML_PATH_SLACK_USERNAME = 'chatconnector/slack/username';
    const XML_PATH_SLACK_ICON = 'chatconnector/slack/icon';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        $url = $this->scopeConfig->getValue(self::XML_PATH_SLACK_URL, ScopeInterface::SCOPE_STORE);
        $url = rtrim($url, '/');
        return $url;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        $channel = $this->scopeConfig->getValue(self::XML_PATH_SLACK_CHANNEL, ScopeInterface::SCOPE_STORE);
        return sprintf('#%s', ltrim($channel, '#'));
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SLACK_USERNAME, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        $icon = trim($this->scopeConfig->getValue(self::XML_PATH_SLACK_ICON, ScopeInterface::SCOPE_STORE), ':');
        return sprintf(':%s:', $icon);
    }

    /**
     * @return string
     */
    public function getMessageFormat()
    {
        return self::MESSAGE_FORMAT;
    }
}
