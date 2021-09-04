<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 0:05
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Contracts;

/**
 * 处理荷载接口
 */
interface Processor
{
    /**
     * 处理荷载
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload, callable ...$stages);
}