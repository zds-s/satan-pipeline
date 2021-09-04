<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 0:03
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Processor;

use SaTan\Contracts\Processor;

/**
 * 处理载荷-1
 * @link https://github.com/thephpleague/pipeline/blob/master/src/FingersCrossedProcessor.php
 */
class FingersCrossed implements Processor
{
    /**
     * 初始化的一个载荷
     * @var callable|null
     */
    protected $stage = null;

    /**
     * 初始化一个载荷
     * @param callable|null $stage 载荷
     */
    public function __construct(?callable $stage = null)
    {
        $this->stage = $stage;
    }

    /**
     * @inheritDoc
     */
    public function process($payload, callable ...$stages)
    {
        return array_reduce(
            $stages,
            function ($initStage, $stage) use ($payload) {
                if (is_callable($initStage, true)) {
                    return $stage($initStage($payload));
                } else {
                    return $stage($payload);
                }
            },
            $this->stage
        );
    }

}