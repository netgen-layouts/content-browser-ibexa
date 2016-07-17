<?php

namespace Netgen\Bundle\ContentBrowserBundle\Tests\Item\ColumnProvider\ColumnValueProvider\EzLocation;

use eZ\Publish\API\Repository\SectionService;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\Core\Repository\Repository;
use eZ\Publish\Core\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\Section as EzSection;
use Netgen\Bundle\ContentBrowserBundle\Item\ColumnProvider\ColumnValueProvider\EzLocation\Section;
use Netgen\Bundle\ContentBrowserBundle\Item\EzLocation\Item;
use PHPUnit\Framework\TestCase;

class SectionTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $sectionServiceMock;

    /**
     * @var \Netgen\Bundle\ContentBrowserBundle\Item\ColumnProvider\ColumnValueProvider\EzLocation\Section
     */
    protected $provider;

    public function setUp()
    {
        $this->sectionServiceMock = $this->createMock(SectionService::class);

        $this->repositoryMock = $this->getMockBuilder(Repository::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getSectionService'))
            ->getMock();

        $this->repositoryMock
            ->expects($this->any())
            ->method('getSectionService')
            ->will($this->returnValue($this->sectionServiceMock));

        $this->provider = new Section(
            $this->repositoryMock
        );
    }

    /**
     * @covers \Netgen\Bundle\ContentBrowserBundle\Item\ColumnProvider\ColumnValueProvider\EzLocation\Section::__construct
     * @covers \Netgen\Bundle\ContentBrowserBundle\Item\ColumnProvider\ColumnValueProvider\EzLocation\Section::getValue
     */
    public function testGetValue()
    {
        $item = new Item(
            new Location(
                array(
                    'contentInfo' => new ContentInfo(
                        array(
                            'sectionId' => 42,
                        )
                    ),
                )
            ),
            'Name'
        );

        $section = new EzSection(
            array(
                'name' => 'Section name',
            )
        );

        $this->sectionServiceMock
            ->expects($this->once())
            ->method('loadSection')
            ->with($this->equalTo(42))
            ->will($this->returnValue($section));

        self::assertEquals(
            'Section name',
            $this->provider->getValue($item)
        );
    }
}
