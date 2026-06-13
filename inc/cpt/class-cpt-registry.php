<?php
// @package PMPortfolio\CPT

namespace PMPortfolio\CPT;

defined('ABSPATH') || exit;

class CPT_Registry
{

    public function register(): void
    {
        add_action('init', [$this, 'register_all']);
    }

    /**
     * Instacia e registra cada CPT
     */

    public function register_all(): void
    {
        (new Portfolio())->register();
        (new Service())->register();
    }
}
