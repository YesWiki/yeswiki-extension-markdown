<?php
if (isset($this->config['use_md']) and $this->config['use_md'] === true) {
    $this->AddCSSFile('tools/markdown/libs/vendor/SimpleMDE/simplemde.min.css');
    $this->AddJavascriptFile('tools/markdown/libs/vendor/SimpleMDE/simplemde.min.js');
    $this->AddJavascriptFile('tools/markdown/libs/yw-markdown.js');
}
