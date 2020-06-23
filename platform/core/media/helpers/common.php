<?php

use Illuminate\Support\Str;

if (!function_exists('is_image')) {
    /**
     * Is the mime type an image
     *
     * @param $mimeType
     * @return bool
     */
    function is_image($mimeType)
    {
        return Str::startsWith($mimeType, 'image/');
    }
}

if (!function_exists('get_image_url')) {
    /**
     * @param $url
     * @param $size
     * @param bool $relativePath
     * @param null $default
     * @return string
     */
    function get_image_url($url, $size = null, $relativePath = false, $default = null)
    {
        if (empty($url)) {
            return $default;
        }

        if ($url == config('core.media.media.default-img')) {
            return url($url);
        }

        if ($size && array_key_exists($size, RvMedia::getSizes())) {
            $url = str_replace(
                File::name($url) . '.' . File::extension($url),
                File::name($url) . '-' . RvMedia::getSize($size) . '.' . File::extension($url),
                $url
            );
        }

        if ($relativePath) {
            return $url;
        }

        if ($url == '__image__') {
            return RvMedia::url($default);
        }

        return RvMedia::url($url);
    }
}

if (!function_exists('get_object_image')) {
    /**
     * @param $image
     * @param null $size
     * @param bool $relativePath
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function get_object_image($image, $size = null, $relativePath = false)
    {
        if (!empty($image)) {
            if (empty($size) || $image == '__value__') {
                if ($relativePath) {
                    return $image;
                }

                return RvMedia::url($image);
            }
            return get_image_url($image, $size, $relativePath);
        }

        return get_image_url(config('core.media.media.default-img'), null, $relativePath);
    }
}

if (!function_exists('rv_media_handle_upload')) {
    /**
     * @param $fileUpload
     * @param int $folderId
     * @param string $path
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function rv_media_handle_upload($fileUpload, $folderId = 0, $path = '')
    {
        return RvMedia::handleUpload($fileUpload, $folderId, $path);
    }
}

