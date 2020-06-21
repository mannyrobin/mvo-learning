<?php

namespace HipCTA\CTA;

class CTA
{
    protected $post_id;
    protected $container;
    
    public function __construct( $container, $post_id = '' )
    {
        $this->post_id = $post_id;
        $this->container = $container;
    }
    
    public function set_id( $id )
    {
        $this->post_id = $id;
    }
    
    public function get_id()
    {
        return $this->post_id;
    }
    
    public function get_container()
    {
        return $this->container;
    }
}
