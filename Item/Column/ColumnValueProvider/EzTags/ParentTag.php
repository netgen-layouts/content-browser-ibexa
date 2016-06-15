<?php

namespace Netgen\Bundle\ContentBrowserBundle\Item\Column\ColumnValueProvider\EzTags;

use eZ\Publish\Core\Helper\TranslationHelper;
use Netgen\Bundle\ContentBrowserBundle\Item\Column\ColumnValueProviderInterface;
use Netgen\TagsBundle\API\Repository\TagsService;

class ParentTag implements ColumnValueProviderInterface
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
     * Provides the column value.
     *
     * @param \Netgen\TagsBundle\API\Repository\Values\Tags\Tag $valueObject
     *
     * @return mixed
     */
    public function getValue($valueObject)
    {
        if ($valueObject->id > 0) {
            return $this->tagsService->sudo(
                function (TagsService $tagsService) use ($valueObject) {
                    if (empty($valueObject->parentTagId)) {
                        return '(No parent)';
                    }

                    return $this->translationHelper->getTranslatedByMethod(
                        $tagsService->loadTag($valueObject->parentTagId),
                        'getKeyword'
                    );
                }
            );
        }

        return '';
    }
}