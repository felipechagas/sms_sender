<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
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

    }

    /**
     * Create one new restaurant
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Obtains and show one restaurant
     * @return Illuminate\Http\Response
     */
    public function show($restaurant)
    {

    }

    /**
     * Update an existing restaurant
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $restaurant)
    {

    }

    /**
     * Remove an existing restaurant
     * @return Illuminate\Http\Response
     */
    public function destroy($restaurant)
    {

    }
}
