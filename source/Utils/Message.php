<?php

namespace Source\Utils;

class Message
{
    private string $text;
    private string $type;

    public function __toString(): string
    {
        return $this->render();
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function info(string $message): Message
    {
        $this->type = CONF_MESSAGE_INFO;
        $this->text = $this->filter($message);
        return $this;
    }

    public function success(string $message): Message
    {
        $this->type = CONF_MESSAGE_SUCCESS;
        $this->text = $this->filter($message);
        return $this;
    }

    public function warning(string $message): Message
    {
        $this->type = CONF_MESSAGE_WARNING;
        $this->text = $this->filter($message);
        return $this;
    }

    public function error(string $message): Message
    {
        $this->type = CONF_MESSAGE_ERROR;
        $this->text = $this->filter($message);
        return $this;
    }

    public function render(): string
    {
        return "<div class='" . CONF_MESSAGE_CLASS ." {$this->getType()}'>{$this->getText()}</div>";
    }

    public function json(): string
    {
        return json_encode(['error' => $this->getText()], JSON_UNESCAPED_UNICODE);
    }

    public function flash(): void
    {
        (new Session())->set("flash", $this);
    }

    public function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
    }

}