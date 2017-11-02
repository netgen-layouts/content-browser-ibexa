<?php

namespace Netgen\ContentBrowser\Item\EzPublish;

use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Location;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\ContentBrowser\Item\LocationInterface;

final class Item implements ItemInterface, LocationInterface, EzPublishInterface
{
    /**
     * @var \eZ\Publish\API\Repository\Values\Content\Location
     */
    private $location;

    /**
     * @var \eZ\Publish\API\Repository\Values\Content\Content
     */
    private $content;

    /**
     * @var int|string
     */
    private $value;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $selectable;

    /**
     * Constructor.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location
     * @param \eZ\Publish\API\Repository\Values\Content\Content $content
     * @param int|string $value
     * @param string $name
     * @param bool $selectable
     */
    public function __construct(Location $location, Content $content, $value, $name, $selectable = true)
    {
        $this->location = $location;
        $this->content = $content;
        $this->value = $value;
        $this->name = $name;
        $this->selectable = $selectable;
    }

    public function getLocationId()
    {
        return $this->location->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParentId()
    {
        $parentId = (int) $this->location->parentLocationId;

        return $parentId !== 1 ? $parentId : null;
    }

    public function isVisible()
    {
        return !$this->location->invisible;
    }

    public function isSelectable()
    {
        return $this->selectable;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getContent()
    {
        return $this->content;
    }
}