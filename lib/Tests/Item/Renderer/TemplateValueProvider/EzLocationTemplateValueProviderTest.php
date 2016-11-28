<?php

namespace Netgen\ContentBrowser\Tests\Item\Renderer\TemplateValueProvider;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\Core\Repository\Values\Content\Content;
use Netgen\ContentBrowser\Item\Renderer\TemplateValueProvider\EzLocationTemplateValueProvider;
use Netgen\ContentBrowser\Item\EzLocation\Item;
use eZ\Publish\Core\Repository\Repository;
use eZ\Publish\Core\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use PHPUnit\Framework\TestCase;
use DateTimeZone;
use DateTime;

class EzLocationTemplateValueProviderTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $contentServiceMock;

    /**
     * @var \Netgen\ContentBrowser\Item\Renderer\TemplateValueProvider\EzLocationTemplateValueProvider
     */
    protected $valueProvider;

    public function setUp()
    {
        $this->contentServiceMock = $this->createMock(ContentService::class);
        $this->repositoryMock = $this->createPartialMock(Repository::class, array('sudo', 'getContentService'));

        $this->repositoryMock
            ->expects($this->any())
            ->method('sudo')
            ->with($this->anything())
            ->will($this->returnCallback(function ($callback) {
                return $callback($this->repositoryMock);
            }));

        $this->repositoryMock
            ->expects($this->any())
            ->method('getContentService')
            ->will($this->returnValue($this->contentServiceMock));

        $this->valueProvider = new EzLocationTemplateValueProvider(
            $this->repositoryMock
        );
    }

    /**
     * @covers \Netgen\ContentBrowser\Item\Renderer\TemplateValueProvider\EzLocationTemplateValueProvider::__construct
     * @covers \Netgen\ContentBrowser\Item\Renderer\TemplateValueProvider\EzLocationTemplateValueProvider::getValues
     * @covers \Netgen\ContentBrowser\Item\Renderer\TemplateValueProvider\EzLocationTemplateValueProvider::getContentInfo
     */
    public function testGetValues()
    {
        $item = $this->getItem();

        $this->contentServiceMock
            ->expects($this->once())
            ->method('loadContentByContentInfo')
            ->with($item->getLocation()->contentInfo)
            ->will($this->returnValue(new Content()));

        $this->assertEquals(
            array(
                'content' => new Content(),
                'location' => $item->getLocation(),
            ),
            $this->valueProvider->getValues($item)
        );
    }

    /**
     * @return \Netgen\ContentBrowser\Item\ItemInterface
     */
    protected function getItem()
    {
        $modificationDate = new DateTime();
        $modificationDate->setTimestamp(0);
        $modificationDate->setTimezone(new DateTimeZone('UTC'));

        $publishedDate = new DateTime();
        $publishedDate->setTimestamp(10);
        $publishedDate->setTimezone(new DateTimeZone('UTC'));

        $location = new Location(
            array(
                'id' => 42,
                'parentLocationId' => 24,
                'invisible' => false,
                'priority' => 3,
                'contentInfo' => new ContentInfo(
                    array(
                        'id' => 84,
                        'contentTypeId' => 85,
                        'ownerId' => 14,
                        'sectionId' => 2,
                        'modificationDate' => $modificationDate,
                        'publishedDate' => $publishedDate,
                    )
                ),
            )
        );

        return new Item($location, 'name');
    }
}