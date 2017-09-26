<?php

namespace Netgen\ContentBrowser\Tests\Item\ColumnProvider\ColumnValueProvider\EzLocation;

use eZ\Publish\Core\Repository\Values\Content\Content;
use eZ\Publish\Core\Repository\Values\Content\Location;
use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzLocation\Visible;
use Netgen\ContentBrowser\Item\EzLocation\Item;
use Netgen\ContentBrowser\Tests\Stubs\Item as StubItem;
use PHPUnit\Framework\TestCase;

class VisibleTest extends TestCase
{
    /**
     * @var \Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzLocation\Visible
     */
    private $provider;

    public function setUp()
    {
        $this->provider = new Visible();
    }

    /**
     * @covers \Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzLocation\Visible::getValue
     */
    public function testGetValue()
    {
        $item = new Item(
            new Location(
                array(
                    'invisible' => true,
                )
            ),
            new Content(),
            'Name'
        );

        $this->assertEquals(
            'No',
            $this->provider->getValue($item)
        );
    }

    /**
     * @covers \Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzLocation\Visible::getValue
     */
    public function testGetValueWithInvalidItem()
    {
        $this->assertNull($this->provider->getValue(new StubItem()));
    }
}
