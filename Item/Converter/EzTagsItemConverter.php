<?php

namespace Netgen\Bundle\ContentBrowserBundle\Item\Converter;

use eZ\Publish\Core\Helper\TranslationHelper;
use DateTime;
use Netgen\TagsBundle\API\Repository\TagsService;
use Netgen\TagsBundle\API\Repository\Values\Tags\Tag;

class EzTagsItemConverter implements ConverterInterface
{
    /**
     * @var \Netgen\TagsBundle\API\Repository\TagsService
     */
    protected $tagsService;

    /**
     * @var \eZ\Publish\Core\Helper\TranslationHelper
     */
    protected $translationHelper;

    /**
     * Constructor.
     *
     * @param \Netgen\TagsBundle\API\Repository\TagsService $tagsService
     * @param \eZ\Publish\Core\Helper\TranslationHelper $translationHelper
     */
    public function __construct(TagsService $tagsService, TranslationHelper $translationHelper)
    {
        $this->tagsService = $tagsService;
        $this->translationHelper = $translationHelper;
    }

    /**
     * Returns the ID of the value object.
     *
     * @param mixed $valueObject
     *
     * @return int|string
     */
    public function getId($valueObject)
    {
        return $valueObject->id;
    }

    /**
     * Returns the parent ID of the value object.
     *
     * @param mixed $valueObject
     *
     * @return int|string
     */
    public function getParentId($valueObject)
    {
        return $valueObject->parentTagId;
    }

    /**
     * Returns the value of the value object.
     *
     * @param mixed $valueObject
     *
     * @return int|string
     */
    public function getValue($valueObject)
    {
        return $valueObject->id;
    }

    /**
     * Returns the name of the value object.
     *
     * @param mixed $valueObject
     *
     * @return string
     */
    public function getName($valueObject)
    {
        return $this->translationHelper->getTranslatedByMethod(
            $valueObject,
            'getKeyword'
        );
    }

    /**
     * Returns the selectable flag of the value object.
     *
     * @param mixed $valueObject
     *
     * @return bool
     */
    public function getIsSelectable($valueObject)
    {
        return $valueObject->id > 0 ? true : false;
    }

    /**
     * Returns the template variables of the value object.
     *
     * @param mixed $valueObject
     *
     * @return array
     */
    public function getTemplateVariables($valueObject)
    {
        return array(
            'tag' => $valueObject->id > 0 ? $valueObject : null,
        );
    }

    /**
     * Returns the columns of the value object.
     *
     * @param mixed $valueObject
     *
     * @return array
     */
    public function getColumns($valueObject)
    {
        $parentTag = null;
        if ($valueObject->parentTagId > 0) {
            $parentTag = $this->tagsService->loadTag($valueObject->parentTagId);
        }

        if ($valueObject->id > 0) {
            return array(
                'tag_id' => $valueObject->id,
                'parent_tag_id' => $valueObject->parentTagId,
                'parent_tag' => $parentTag instanceof Tag ?
                    $this->translationHelper->getTranslatedByMethod($parentTag, 'getKeyword') :
                    '(No parent)',
                'modified' => $valueObject->modificationDate->format(Datetime::ISO8601),
            );
        }

        return array();
    }
}
