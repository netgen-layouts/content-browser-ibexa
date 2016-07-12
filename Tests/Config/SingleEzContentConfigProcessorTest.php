<?php

namespace Netgen\Bundle\ContentBrowserBundle\Tests\Config;

use Netgen\Bundle\ContentBrowserBundle\Config\Configuration;
use Netgen\Bundle\ContentBrowserBundle\Config\SingleEzContentConfigProcessor;
use PHPUnit\Framework\TestCase;

class SingleEzContentConfigProcessorTest extends TestCase
{
    /**
     * @var \Netgen\Bundle\ContentBrowserBundle\Config\SingleEzContentConfigProcessor
     */
    protected $configProcessor;

    public function setUp()
    {
        $this->configProcessor = new SingleEzContentConfigProcessor();
    }

    /**
     * @covers \Netgen\Bundle\ContentBrowserBundle\Config\SingleEzContentConfigProcessor::supports
     */
    public function testSupports()
    {
        self::assertTrue(
            $this->configProcessor->supports(
                'ezcontent-single'
            )
        );
    }

    /**
     * @covers \Netgen\Bundle\ContentBrowserBundle\Config\SingleEzContentConfigProcessor::supports
     */
    public function testSupportsReturnsFalse()
    {
        self::assertFalse(
            $this->configProcessor->supports(
                'some-config'
            )
        );
    }

    /**
     * @covers \Netgen\Bundle\ContentBrowserBundle\Config\SingleEzContentConfigProcessor::getValueType
     */
    public function testGetValueType()
    {
        self::assertEquals('ezcontent', $this->configProcessor->getValueType());
    }

    /**
     * @covers \Netgen\Bundle\ContentBrowserBundle\Config\SingleEzContentConfigProcessor::processConfig
     */
    public function testLoadConfig()
    {
        $config = new Configuration('ezcontent', array('max_selected' => 0));
        $this->configProcessor->processConfig(
            'ezcontent-single',
            $config
        );

        self::assertEquals(1, $config->getMaxSelected());
    }
}
