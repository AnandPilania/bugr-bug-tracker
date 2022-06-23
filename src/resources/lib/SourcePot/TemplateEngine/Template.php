<?php

namespace SourcePot\TemplateEngine;

class Template
{
    private string $content;
    private string $compiledContent = '';

    public function __construct(
        private string $filename,
        private array $data = []
    ) {
        $this->content = file_get_contents($filename);
    }

    public function data(array $data = []): self
    {
        $this->data = $data;

        return $this;
    }

    public function compile(): self
    {
        $compiled = $this->content;
        // support simple variable replace only for now
        foreach($this->data as $key => $replace) {
            $search = '{{' . $key . '}}';
            $compiled = str_replace($search, $replace, $compiled);
        }

        $this->compiledContent = $compiled;

        return $this;
    }

    public function output(): string
    {
        if($this->compiledContent === '') {
            $this->compile();
        }

        return $this->compiledContent;
    }
}