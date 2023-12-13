<?php

namespace App\Support;

use PhpDom\DomNode;
use PhpDom\TextNode;

class Dom 
{
    public static function addTab($ref, $key, $view, $before = null)
    {
        if (! $ref) {
            return;
        }
        
        $label = $ref->querySelector('tpl[slot="tabs"]');
        if (!$label) {
            return;
        }
        
        $active = !$ref->querySelectorAll('li')->count();
        $push = DomNode::new('li', ['class' => 'nav-item'])
        ->appendChild(DomNode::new('button', [
            'class' => 'nav-link' . ($active ? ' active' : ''),
            'id' => $key . '-tab',
            'data-bs-toggle' => 'tab',
            'data-bs-target' => '#' . $key,
            'type' => 'button',
            'aria-controls' => $key
        ])
        ->appendChild(new TextNode("{t '$key'}")));
        
        if ($before) {
            $before = $ref->querySelector('#' . $before . '-tab');
        }
        
        if (!$before) {
            $push->appendTo($label);
        } else {
            $push->insertBefore($before);
        }
        
        DomNode::new('tpl', ['include' => $view, 'slot' => $key])
        ->appendTo($ref);
    }
}