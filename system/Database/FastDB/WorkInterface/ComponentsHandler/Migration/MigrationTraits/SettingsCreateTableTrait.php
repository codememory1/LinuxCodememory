<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationTraits;

trait SettingsCreateTableTrait
{
    
    /**
     * type
     *
     * @var string
     */
    private $type = 'int';
    
    /**
     * length
     *
     * @var undefined
     */
    private $length = null;
    
    /**
     * default
     *
     * @var string
     */
    private $default = 'null';
    
    /**
     * itsDefault
     *
     * @var undefined
     */
    private $itsDefault = null;
    
    /**
     * charset
     *
     * @var string
     */
    private $charset = 'UTF-8';
    
    /**
     * column
     *
     * @param  mixed $column
     * @param  mixed $settings
     * @return void
     */
    public function column(string $column, callable $settings)
    {

        call_user_func_array($settings, [$this]);

        $this->columnsTable[] = [
            'name-column'   => $column,
            'type'          => $this->type,
            'length'        => $this->length,
            'default'       => $this->default,
            'other-default' => $this->itsDefault,
            'charset'       => $this->charset
        ];

        return $this;

    }
    
    /**
     * type
     *
     * @param  mixed $type
     * @return void
     */
    public function type(string $type)
    {

        $this->type = $type;

        return $this;

    }
    
    /**
     * length
     *
     * @param  mixed $length
     * @return void
     */
    public function length(int $length)
    {

        $this->length = $length;

        return $this;

    }
    
    /**
     * defaultValue
     *
     * @param  mixed $default
     * @return void
     */
    public function defaultValue(string $default)
    {

        $this->default = $default;

        return $this;

    }
    
    /**
     * itsDefaultValue
     *
     * @param  mixed $default
     * @return void
     */
    public function itsDefaultValue(string $default)
    {

        $this->itsDefault = $default;

        return $this;

    }
    
    /**
     * charset
     *
     * @param  mixed $charset
     * @return void
     */
    public function charset(string $charset)
    {

        $this->setArgument('charset', strtoupper($charset));
        $this->charset = strtoupper($charset);

        return $this;

    }
    
    /**
     * enableDataLife
     *
     * @return void
     */
    public function enableDataLife()
    {

        $this->columnsTable['add-column-life'] = 'on';

        return $this;

    }
    
    /**
     * disableDataLife
     *
     * @return void
     */
    public function disableDataLife()
    {

        $this->columnsTable['add-column-life'] = 'off';

        return $this;

    }

}