<?php

declare(strict_types=1);

namespace Netgen\ContentBrowser\Ibexa\Tests\Item\ColumnProvider\ColumnValueProvider\Ibexa;

use Ibexa\Contracts\Core\Repository\SectionService;
use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo;
use Ibexa\Contracts\Core\Repository\Values\Content\Section as IbexaSection;
use Ibexa\Core\Repository\Repository;
use Ibexa\Core\Repository\Values\Content\Content;
use Ibexa\Core\Repository\Values\Content\Location;
use Ibexa\Core\Repository\Values\Content\VersionInfo;
use Netgen\ContentBrowser\Ibexa\Item\ColumnProvider\ColumnValueProvider\Ibexa\Section;
use Netgen\ContentBrowser\Ibexa\Item\Ibexa\Item;
use Netgen\ContentBrowser\Ibexa\Tests\Stubs\Item as StubItem;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

#[CoversClass(Section::class)]
final class SectionTest extends TestCase
{
    private Stub&Repository $repositoryStub;

    private Stub&SectionService $sectionServiceStub;

    private Section $provider;

    protected function setUp(): void
    {
        $this->repositoryStub = self::createStub(Repository::class);
        $this->sectionServiceStub = self::createStub(SectionService::class);

        $this->repositoryStub
            ->method('sudo')
            ->with(self::anything())
            ->willReturnCallback(
                fn (callable $callback) => $callback($this->repositoryStub),
            );

        $this->repositoryStub
            ->method('getSectionService')
            ->willReturn($this->sectionServiceStub);

        $this->provider = new Section(
            $this->repositoryStub,
        );
    }

    public function testGetValue(): void
    {
        $content = new Content(
            [
                'versionInfo' => new VersionInfo(
                    [
                        'contentInfo' => new ContentInfo(
                            [
                                'sectionId' => 42,
                            ],
                        ),
                    ],
                ),
            ],
        );

        $item = new Item(
            new Location(['content' => $content]),
            24,
        );

        $section = new IbexaSection(
            [
                'name' => 'Section name',
            ],
        );

        $this->sectionServiceStub
            ->method('loadSection')
            ->with(self::identicalTo(42))
            ->willReturn($section);

        self::assertSame(
            'Section name',
            $this->provider->getValue($item),
        );
    }

    public function testGetValueWithInvalidItem(): void
    {
        self::assertNull($this->provider->getValue(new StubItem(42)));
    }
}
