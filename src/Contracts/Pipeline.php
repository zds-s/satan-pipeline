<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 1:05
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Contracts;

/**
 * 管道接口
 */
interface Pipeline
{
    /**
     * 创建一个带有附加的新管道
     *
     * @return static
     */
    public function pipe(callable $operation): Pipeline;

    /**
     * 处理payload
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload);
}