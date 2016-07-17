<?php

namespace Netgen\Bundle\ContentBrowserBundle\Tests\Item\ColumnProvider\ColumnValueProvider\EzContent;

use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\Core\Repository\Values\Content\Location;
use Netgen\Bundle\ContentBrowserBundle\Item\ColumnProvider\ColumnValueProvider\EzContent\Visible;
use Netgen\Bundle\ContentBrowserBundle\Item\EzContent\Item;
use PHPUnit\Framework\TestCase;

class VisibleTest extends TestCase
{
    /**
     * @var \Netgen\Bundle\ContentBrowserBundle\Item\ColumnProvider\ColumnValueProvider\EzContent\Visible
     */
    protected $provider;

    public function setUp()
    {
        $this->provider = new Visible();
    }

    /**
     * @covers \Netgen\Bundle\ContentBrowserBundle\Item\ColumnProvider\ColumnValueProvider\EzContent\Visible::getValue
     */
    public function testGetValue()
    {
        $item = new Item(
            new Location(
                array(
                    'invisible' => true,
                )
            ),
            new ContentInfo(),
            'Name'
        );

        self::assertEquals(
            'No',
            $this->provider->getValue($item)
        );
    }
}
