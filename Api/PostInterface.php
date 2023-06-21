<?php

namespace Api;

interface PostInterface {

    /**
     * get post list
     *
     * @return array
     */
    public function getPosts();

    /**
     * get ID
     *
     * @param array $arr
     * @return int
     */
    public function getID($arr);

    /**
     * get title
     *
     * @param array $arr
     * @return string
     */
    public function getTitle($arr);

    /**
     * get content
     *
     * @param array $arr
     * @return string
     */
    public function getContent($arr);

    /**
     * get thumbnail image
     *
     * @param array $arr
     * @return string
     */
    public function getThumbnailImage($arr);

    /**
     * get url key
     *
     * @param array $arr
     * @return string
     */
    public function getUrlKey($arr);

    /**
     * get status
     *
     * @param array $arr
     * @return int
     */
    public function getStatus($arr);

    /**
     * get create at time
     *
     * @param array $arr
     * @return date
     */
    public function getCreateAt($arr);

    /**
     * get update at time
     *
     * @param array $arr
     * @return date
     */
    public function getUpdateAt($arr);
}