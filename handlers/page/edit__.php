<?php
if (isset($this->config['use_md']) and $this->config['use_md'] === true) {
    $plugin_output_new = preg_replace(
        '/id=\"body\"/',
        'id="SimpleMDE" data-page="'.$this->getPageTag().'"',
        $plugin_output_new
    );
}
