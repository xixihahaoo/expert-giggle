<?php
namespace jpp\util;

/**
 * 时间工具类
 *
 * @package jpp\util
 */
class TimeUtil
{
    /**
     * 获取毫秒时间戳
     *
     * @return int
     */
    public static function microtime()
    {
        return bcmul(microtime(true), 1000, 0);
    }
}