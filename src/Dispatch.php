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
        foreach ($handlers as $rule) {
            if ($rule->field() !== null && is_array($reference)) {
                $value = [dot($rule->field(), $reference ?? [])];
            }

            try {
                $handler = $rule->handler();
                $status = $handler->handle(...$value);
            } catch (\Throwable) {
                $status = false;
            }

            $result = new Result(
                $rule->name(),
                $status,
                $status ? null : $this->parseMessage($rule),
                $value,
                $status ? null : false,
                $rule->field()
            );

            $collection[ $status ? "success" : "errors"][] = $result;

            if(method_exists($handler, 'break') && $handler->break()){
                break;
            }
        }

        return new ResultCollection($collection['errors'] ?? [], $collection['success'] ?? []);
    }

    private function parseMessage(Handler $handler): ?string
    {
        return MessageParser::make($handler->message())->replace(
            $handler->field(),
            $handler->arguments()
        )->getMessage();
    }

    /**
     * @param array<Handler> $handlers
     * @param class-string $instance
     * @param string|null $field
     */
    private function hasInstanceOf(string $instance, array $handlers, ?string $field = null): bool
    {
        $handler = array_filter(
            $handlers,
            fn(Handler $handler) => $handler->getHandlerName() === $instance
            && ($field === null ? true : $handler->field() === $field)
        );

        return !empty($handler);
    }

    /**
     * @return array<Handler>
     */
    private function getHandlers(): array
    {
        return $this->handlers->getHandlers();
    }

}