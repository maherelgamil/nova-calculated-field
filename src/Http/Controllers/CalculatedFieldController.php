<?php

namespace Maherelgamil\NovaCalculatedField\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;

class CalculatedFieldController extends Controller
{
    public function calculate($resource, $field, NovaRequest $request)
    {
        $field = $request->newResource()
            ->availableFields($request)
            ->where('attribute', '=', $field)
            ->first();

        if (empty($field)) {
            abort(404, "Unable to find the field required to calculate this value");
        }

        $calculatedValue = call_user_func(
            $field->calculateFunction,
            $request->get('value'),
            $request
        );

        return response()->json([
            'value' => $calculatedValue
        ]);
    }
}
