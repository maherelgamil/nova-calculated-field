<?php

namespace Maherelgamil\NovaCalculatedField;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaCalculatedField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-calculated-field';

    /**
     * The field the slug should be generated from.
     *
     * @param string $from
     * @return string
     */
    public $from;

    /**
     * The function to call when input is detected
     * @var \Closure
     */
    public $calculateFunction;

    /***
     * ListenerField constructor.
     * @param $name
     * @param null $attribute
     * @param callable|null $resolveCallback
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

//        $this->calculateFunction = function ($values, Request $request) {
//            return collect($values)->values()->sum();
//        };
    }

    /**
     * The field the slug should be generated from.
     *
     * @param string $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /***
     * The callback we want to call when the field has some input
     *
     * @param callable $calculateFunction
     * @return $this
     */
    public function calculateWith(callable $calculateFunction) {
        $this->calculateFunction = $calculateFunction;

        return $this;
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $request = app(NovaRequest::class);

        if ($request->isUpdateOrUpdateAttachedRequest()) {
            $this->readonly();
        }

        return array_merge([
            'updating' => $request->isUpdateOrUpdateAttachedRequest(),
            'from' => Str::lower($this->from),
        ], parent::jsonSerialize());
    }
}
