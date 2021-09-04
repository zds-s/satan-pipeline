<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 1:54
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Contracts;

interface PipelineBuild
{
    /**
     *
     * 添加一个阶段。
     * @param callable $stage
     * @return self
     */
    public function add(callable $stage): self;

    /**
     * 构建一个新的 Pipeline 对象。
     */
    public function build(Processor $processor = null): Pipeline;
}