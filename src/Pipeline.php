<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/4
 * @createTime: 23:54
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan;

use SaTan\Contracts\Processor;
use SaTan\Processor\FingersCrossed;
use SaTan\Contracts\Pipeline as PipelineInterface;

/**
 * 管道
 */
class Pipeline implements PipelineInterface
{
    /**
     * @var callable[]
     */
    private array $stages = [];

    /**
     * @var Processor
     */
    private Processor $processor;

    /**
     * 创建一个实例
     * @param Processor|null $processor 处理器实例
     * @param callable ...$stages 载荷
     */
    public function __construct(Processor $processor = null, callable ...$stages)
    {
        $this->processor = $processor ?? new FingersCrossed();
        $this->stages = $stages;
    }

    /**
     * @inheritDoc
     */
    public function pipe(callable $operation): PipelineInterface
    {
        $pipeline = clone $this;
        $pipeline->stages[] = $operation;

        return $pipeline;
    }

    /**
     * @inheritDoc
     */
    public function process($payload)
    {
        return $this->processor->process($payload, ...$this->stages);
    }

    public function __invoke($payload)
    {
        return $this->process($payload);
    }
}