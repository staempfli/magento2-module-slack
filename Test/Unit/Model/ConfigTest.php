<?php
/**
 * @category  Staempfli
 * @package   Staempfli_Slack
 * @copyright Copyright © Stämpfli AG. All rights reserved.
 * @author    marcel.hauri@staempfli.com
 */
namespace Staempfli\Slack\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $objectManagerHelper;
    private $scopeConfigInterface;
    private $config;

    protected function setUp()
    {
        $this->scopeConfigInterface = $this->getMockBuilder('Magento\Framework\App\Config\ScopeConfigInterface')
            ->getMockForAbstractClass();
        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->config = $this->objectManagerHelper->getObject(
            'Staempfli\Slack\Model\Config',
            [
                'scopeConfig' => $this->scopeConfigInterface,
            ]
        );
    }

    public function testGetMessageFormat()
    {
        $this->assertSame('mrkdwn', $this->config->getMessageFormat(), 'Message Format should be \'mrkdwn\' by default');
    }
}
