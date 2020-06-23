<?php

namespace Botble\Media\Repositories\Caches;

use Botble\Media\Repositories\Interfaces\MediaFolderInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class MediaFolderCacheDecorator extends CacheAbstractDecorator implements MediaFolderInterface
{

    /**
     * {@inheritdoc}
     */
    public function getFolderByParentId($folderId, array $params = [], $withTrash = false)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createSlug($name, $parentId)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createName($name, $parentId)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getBreadcrumbs($parentId, $breadcrumbs = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getTrashed($parentId, array $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteFolder($folderId, $force = false)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllChildFolders($parentId, $child = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getFullPath($folderId, $path = '')
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function restoreFolder($folderId)
    {
        $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function emptyTrash()
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
