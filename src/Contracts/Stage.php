<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 0:44
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Contracts;

/**
 * 载荷接口
 * 实现了这个契约的类都可以当做载荷传入
 */
interface Stage
{
    /**
     * 把当前类当做方法来处理载荷
     * @param mixed $payload 载荷
     * @return mixed
     */
    public function __invoke($payload);
}