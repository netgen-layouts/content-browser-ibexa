<?php

declare(strict_types=1);

namespace Netgen\ContentBrowser\Ibexa\Item\ColumnProvider\ColumnValueProvider\Ibexa;

use Ibexa\Contracts\Core\Repository\Repository;
use Netgen\ContentBrowser\Ibexa\Item\Ibexa\IbexaInterface;
use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProviderInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

final class Section implements ColumnValueProviderInterface
{
    public function __construct(private Repository $repository) {}

    public function getValue(ItemInterface $item): ?string
    {
        if (!$item instanceof IbexaInterface) {
            return null;
        }

        return $this->repository->sudo(
            fn (): string => $this->repository
                ->getSectionService()
                ->loadSection(
                    $item->getContent()->contentInfo->sectionId,
                )->name,
        );
    }
}
