<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 0:31
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Processor;

/**
 * 检测载荷处理器
 */
class Incorruptible implements \SaTan\Contracts\Processor
{
    /**
     * 检测载荷
     * @var null|callable
     */
    protected $check;

    /**
     * 初始化载荷
     * @var null|callable
     */
    protected $stage = null;

    /**
     * 生成一个实例
     * @param callable $check 检测载荷
     * @param callable|null $stage 初始化载荷
     */
    public function __construct(callable $check, ?callable $stage = null)
    {
        $this->check = $check;
        $this->stage = $stage;
    }

    /**
     * @inheritDoc
     */
    public function process($payload, callable ...$stages)
    {
        //获取检测载荷
        $check = $this->check;
        return array_reduce(
            $stages,
            function ($initStage, $stage) use ($payload, $check) {
                //检测初始化载荷是否存在
                if (is_callable($initStage, true)) {
                    $payload_result = $stage($initStage($payload));
                } else {
                    $payload_result = $stage($payload);
                }

                return $check($payload_result) !== true ? $payload : $payload_result;
            },
            $this->stage
        );
    }
}