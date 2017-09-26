<?php

namespace Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProvider\EzLocation;

use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProviderInterface;
use Netgen\ContentBrowser\Item\EzLocation\EzLocationInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

class Modified implements ColumnValueProviderInterface
{
    /**
     * @var string
     */
    private $dateFormat;

    /**
     * Constructor.
     *
     * @param string $dateFormat
     */
    public function __construct($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    public function getValue(ItemInterface $item)
    {
        if (!$item instanceof EzLocationInterface) {
            return null;
        }

        return $item->getLocation()->contentInfo->modificationDate->format(
            $this->dateFormat
        );
    }
}
