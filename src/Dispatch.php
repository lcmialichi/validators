<?php

namespace Validators;

use Validators\Handler;
use Validators\MessageParser;
use Validators\Collection\ResultCollection;
use Validators\Collection\HandlerCollection;


class Dispatch
{
    public function __construct(private HandlerCollection $handlers)
    {
    }

    public static function createDispatch(HandlerCollection $handlers): self
    {
        return new self($handlers);
    }

    public function run(mixed $references = null)
    {
        $collection = [];
        foreach ($this->handlers->getHandlers() as $rule) {
            if ($rule->field() !== null) {
                $references = [dot($rule->field(), $references)];
            }

            $status = $rule->handler()->handle(...$references);
            $result = new Result(
                $rule->name(),
                $status,
                $status ? null :$this->parseMessage($rule),
                $status ? null : $rule->arguments()
            );

            $statusName = $status ? "success" : "errors";
            $collection[$statusName][] = $result;
        }

        return new ResultCollection($collection['success'] ?? [], $collection['errors'] ?? []);
    }

    private function parseMessage(Handler $handler): ?string
    {
        return MessageParser::make($handler->message())->replace(
            $handler->field(),
            $handler->arguments()
        )->getMessage();
    }

}