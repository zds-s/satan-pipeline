<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/5
 * @createTime: 1:11
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Processor;

use Exception;
use SaTan\Contracts\Processor;
use Throwable;

/**
 * 栈堆调用
 */
class Stack implements Processor
{
    /**
     * @var array 栈堆
     */
    protected array $stacks = [];

    /**
     * 设置异常处理器
     * @var null|callable|mixed|array
     */
    protected $exceptionHandler = null;

    /**
     * 设置异常处理器
     * @param callable|null $exceptionHandler
     * @return Stack
     */
    public function setExceptionHandler(?callable $exceptionHandler): self
    {
        $this->exceptionHandler = $exceptionHandler;
        return $this;
    }

    /**
     * 设置栈堆
     * @param array|string $stacks
     * @return self
     */
    public function setStacks($stacks): self
    {
        $this->stacks = is_array($stacks) ? $stacks : func_get_args();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function process($payload, callable ...$stages)
    {
        $pipeline =
            array_reduce(
                $stages,
                function ($init, $stage) {
                    return array_reduce(
                        array_reverse($this->stacks),
                        $this->carry(),
                        function ($passable) use ($stage) {
                            try {
                                return $stage($passable);
                            } catch (Throwable | Exception $e) {
                                return $this->handleException($passable, $e);
                            }
                        }
                    );
                }
            );
        return is_callable($pipeline) ? $pipeline($payload) : false;
    }

    /**
     * 处理栈堆
     * @return callable
     */
    protected function carry(): callable
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                try {
                    return $pipe($passable, $stack);
                } catch (Throwable | Exception $e) {
                    return $this->handleException($passable, $e);
                }
            };
        };
    }

    /**
     * 异常处理
     * @param $passable
     * @param Throwable $e
     * @return mixed
     * @throws Throwable
     */
    protected function handleException($passable, Throwable $e)
    {
        if ($this->exceptionHandler) {
            return call_user_func($this->exceptionHandler, $passable, $e);
        }
        throw $e;
    }
}