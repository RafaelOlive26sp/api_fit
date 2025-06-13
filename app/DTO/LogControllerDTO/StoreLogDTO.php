<?php

namespace App\DTO\LogControllerDTO;

class StoreLogDTO
{
    public function __construct(
        public string $message,
        public ?string $stack = null,
        public ?string $context = null,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            message: $request['message'],
            stack: $request['stack'] ?? null,
            context: $request['context'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'stack' => $this->stack,
            'context' => $this->context,
        ];
    }
}
