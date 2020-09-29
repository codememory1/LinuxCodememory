<?php

namespace System\Codememory\Components\HTMLView;

use Store;

class HTML 
{

    CONST COMPOENTS_HTML = [
        'div' => [
            'start' => '<div %attributes>',
            'end'   => '</div>'
        ],
        'span' => [
            'start' => '<span %attributes>',
            'end'   => '</span>'
        ],
        'mark' => [
            'start' => '<mark %attributes>',
            'end'   => '</mark>'
        ],
        'p' => [
            'start' => '<p %attributes>',
            'end'   => '</p>'
        ],
        'form' => [
            'start' => '<form %attributes>',
            'end'   => '</form>'
        ],
        'button' => [
            'start' => '<button %attributes>',
            'end'   => '</button>'
        ],
        'input' => [
            'start' => '<input %attributes>',
            'end'   => ''
        ],
        'section' => [
            'start' => '<section %attributes>',
            'end'   => '</section>'
        ],
        'select' => [
            'start' => '<select %attributes>',
            'end'   => '</select>'
        ],
        'option' => [
            'start' => '<option %attributes>',
            'end'   => '</option>'
        ],
        'u' => [
            'start' => '<u %attributes>',
            'end'   => '</u>'
        ],
        'br' => [
            'start' => '<br %attributes>',
            'end'   => ''
        ],
        'hr' => [
            'start' => '<hr %attributes>',
            'end'   => ''
        ],
        'h1' => [
            'start' => '<h1 %attributes>',
            'end'   => '</h1>'
        ],
        'h2' => [
            'start' => '<h2 %attributes>',
            'end'   => '</h2>'
        ],
        'h3' => [
            'start' => '<h3 %attributes>',
            'end'   => '</h3>'
        ],
        'h4' => [
            'start' => '<h4 %attributes>',
            'end'   => '</h4>'
        ],
        'h5' => [
            'start' => '<h5 %attributes>',
            'end'   => '</h5>'
        ],
        'h6' => [
            'start' => '<h6 %attributes>',
            'end'   => '</h6>'
        ]
    ];
        
    /**
     * result
     *
     * @var mixed
     */
    private $result;
    
    /**
     * elements
     *
     * @var array
     */
    private $elements = [];
        
    /**
     * getComponent
     *
     * @param  mixed $tagName
     * @return void
     */
    private function getComponent($tagName)
    {

        return self::COMPOENTS_HTML[$tagName];

    }
    
    /**
     * parse
     *
     * @return void
     */
    private function parse()
    {

        $result = null;

        foreach($this->elements as $key => $element)
        {
            $tag = $element['tag'];
            $content = $element['content'] ?? '';
            $this->result .= $this->attributes($tag).$content;

            if(isset($element['add'])) {
                foreach($element['add'] as $k => $addTag)
                {
                    $content = $addTag['content'] ?? '';
                    $this->result .= $this->attributes($addTag['tag']).$content;

                    if(isset($addTag['add'])) {
                        
                        $this->elements = $addTag['add'];
                        $this->parse();
                    }

                    $this->result .= $this->attributes($addTag['tag'], 'end');
                }
            }

            $this->result .= $this->attributes($tag, 'end');
            
        }
        
    }
    
    /**
     * view
     *
     * @param  mixed $tags
     * @return void
     */
    public function view(array $tags)
    {
        
        $this->elements = $tags;
        $this->parse();

        return $this->result;

    }
    
    /**
     * attributes
     *
     * @param  mixed $tag
     * @return void
     */
    private function attributes(string $tag, string $as = 'start')
    {

        preg_match('/(?<tag>\w+)(\[(.*)\])?/', $tag, $matchTag);
        preg_match_all('/(\[(?<attr>[^\]\[]+)\])/', $matchTag[2], $match);

        $attributes = [];

        foreach($match['attr'] as $attribute)
        {

            preg_match('/(?<attr>\w+)\=(?<value_attr>.*)/', $attribute, $matchAttr);

            $attributes[] = $matchAttr['attr'].'="'.$matchAttr['value_attr'].'"';

        }

        if($as === 'start') {
            return Store::replace(['%attributes' => implode(' ', $attributes)], $this->getComponent($matchTag['tag'])['start']);
        } else {
            return  $this->getComponent($matchTag['tag'])['end'];
        }

    }

    public function render()
    {



    }

}