<?php (defined('BASEPATH')) or exit('No direct script access allowed');

if (! function_exists('lazyload')) {

    function lazyload($params = array())
    {
        $options = array(
            'src'       => FALSE,
            'view'      => FALSE,
            'slick'     => FALSE,
            'itemprop'  => FALSE,
            'tag'       => 'div'
        );
        $params = array_merge($options, $params);
        if (!$params['src'])
            return '';

        $UA =& load_class('User_agent', 'libraries');

        $view = $params['view'];
        $tag = $params['tag'];
        $src = $params['src'];
        $slick = $params['slick'];
        $itemprop = $params['itemprop'];
        unset($params['src'], $params['view'], $params['tag'], $params['slick'], $params['itemprop']);

        $container = '<'.$tag;

        if ($UA->is_robot()){
            $img = '<img src="'.$src.'"'.(isset($params['alt']) ? ' alt="'.$params['alt'].'"' : '').($itemprop ? ' itemprop="'.$itemprop.'"' : '').' />';
            $view = $img . $view;
        } else {
            if (!$slick){
                $params['data-src'] = $src;
                if (isset($params['alt']))
                    $params['data-alt'] = $params['alt'];
            }else{
                $img = '<div class="lazyload-slick"><img data-lazy="'.$src.'"'.(isset($params['alt']) ? ' alt="'.$params['alt'].'"' : '').' /><div class="loader"></div></div>';
                $view = $img . $view;
            }
        }
        unset($params['alt']);

        foreach ($params as $key => $value) {
            $container .= " " . $key . "='" . $value . "'";
        }

        $container .= '>'.($view ? $view : '');
        if ($itemprop && !$UA->is_robot()){
            $container .= '<meta itemprop="'.$itemprop.'" content="'.$src.'" />';
        }
        $container .= '</'.$tag.'>';

        return $container;
    }
}