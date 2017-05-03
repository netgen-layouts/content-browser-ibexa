<?php

namespace Netgen\ContentBrowser\Tests\Item\ColumnProvider\ColumnValueProvider\EzContent;

use eZ\Publish\Core\Repository\Values\Content\Content;
use eZ\Publish\Core\Repository\Values\Content\Location;
use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzContent\Priority;
use Netgen\ContentBrowser\Item\EzContent\Item;
use PHPUnit\Framework\TestCase;

class PriorityTest extends TestCase
{
    /**
     * @var \Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzContent\Priority
     */
    protected $provider;

    public function setUp()
    {
        $this->provider = new Priority();
    }

    /**
     * @covers \Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzContent\Priority::getValue
     */
    public function testGetValue()
    {
        $item = new Item(
            new Location(
                array(
                    'priority' => 5,
                )
            ),
            new Content(),
            'Name'
        );

        $this->assertEquals(
            5,
            $this->provider->getValue($item)
        );
    }
}