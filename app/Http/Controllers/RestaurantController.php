<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    use ApiResponser;

    /**
     * Create a new RestaurantController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of restaurants
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::all();

        return $this->successResponse($restaurants);
    }

    /**
     * Create one new restaurant
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'delivery_time' => 'required|max:5',
        ];

        $this->validate($request, $rules);

        $restaurant = Restaurant::create($request->all());

        return $this->successResponse($restaurant, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one restaurant
     * @return Illuminate\Http\Response
     */
    public function show($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);

        return $this->successResponse($restaurant);
    }

    /**
     * Update an existing restaurant
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $restaurant)
    {
        $rules = [
            'name' => 'max:255',
            'delivery_time' => 'max:5',
        ];

        $this->validate($request, $rules);

        $restaurant = Restaurant::findOrFail($restaurant);

        $restaurant->fill($request->all());

        if ($restaurant->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restaurant->save();

        return $this->successResponse($restaurant);
    }

    /**
     * Remove an existing restaurant
     * @return Illuminate\Http\Response
     */
    public function destroy($restaurant)
    {
        $restaurant = Restaurant::findOrFail($restaurant);

        $restaurant->delete();

        return $this->successResponse($restaurant);
    }
}
