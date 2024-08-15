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

    public function run(array $references = []): ResultCollection
    {
        $result = new ResultCollection;
        foreach ($references as $reference) {
            $result->add($this->execute($reference));
        }
        return $result;
    }

    private function execute(mixed $reference): ResultCollection
    {
        $value = [$reference];
        $handlers = $this->getHandlers();
        $bypass = [];
        foreach ($handlers as $rule) {
            if ($rule->field() !== null && is_array($reference)) {
                $value = [dot($rule->field(), $reference ?? [])];
            }

            $result = $this->runHandler($rule, $value, $bypass);
            if($result === null){
                continue;
            }

            $collection[$result->getStatus() ? "success" : "errors"][] = $result;
        }

        return new ResultCollection($collection['errors'] ?? [], $collection['success'] ?? []);
    }

    private function runHandler(Handler $rule, array $value, array &$bypass = []): ?Result
    {
        if(in_array($rule->field(), $bypass)) {
           return null;
        }

        try {
            $handler = $rule->handler();
            $status = $handler->handle(...$value);
        } catch (\Throwable) {
            $status = false;
        }

        if (method_exists($handler, 'break') && $handler->break()) {
            $bypass[] = $rule->field();
        }

        return new Result(
            $rule->name(),
            $status,
            $status ? null : $this->parseMessage($rule),
            $value,
            $status ? null : false,
            $rule->field()
        );
    }

    private function parseMessage(Handler $handler): ?string
    {
        return MessageParser::make($handler->message())->replace(
            $handler->field(),
            $handler->arguments()
        )->getMessage();
    }

    /**
     * @return array<Handler>
     */
    private function getHandlers(): array
    {
        return $this->handlers->getHandlers();
    }

}