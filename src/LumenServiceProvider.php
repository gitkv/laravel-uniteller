<?php

namespace gitkv\Uniteller;


class LumenServiceProvider extends AbstractServiceProvider {

    public function register() {
        $this->app->configure('uniteller');
        parent::register();
    }
}
