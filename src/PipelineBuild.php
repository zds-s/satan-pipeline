<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 1:58
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan;

use SaTan\Contracts\Pipeline;
use SaTan\Contracts\Processor;
use SaTan\Processor\Stack;

class PipelineBuild implements Contracts\PipelineBuild
{
    /**
     * @var array 荷载数组
     */
    private array $stages = [];

    /**
     * @inheritDoc
     */
    public function add(callable $stage): Contracts\PipelineBuild
    {
        $this->stages[] = $stage;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(Processor $processor = null): Pipeline
    {
        return new \SaTan\Pipeline($processor, ...$this->stages);
    }

    /**
     * 返回一个stack荷载处理的pipeline
     * @param callable[] $stacks 栈堆数组
     * @param ?callable $exceptionHandler 异常处理闭包
     * @return Pipeline
     */
    public function buildStack(array $stacks, ?callable $exceptionHandler = null): Pipeline
    {
        $stack = new Stack();
        $stack->setStacks($stacks);
        $stack->setExceptionHandler($exceptionHandler);
        return $this->build($stack);
    }
}