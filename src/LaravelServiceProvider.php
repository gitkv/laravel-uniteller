<?php

namespace gitkv\Uniteller;


class LaravelServiceProvider extends AbstractServiceProvider {

    public function boot() {
        parent::boot();
        $this->publishes([__DIR__ . '/../config/' => config_path() . '/']);
    }
}
