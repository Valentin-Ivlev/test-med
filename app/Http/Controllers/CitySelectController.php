<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CitySelectController extends Controller
{
    public function index()
    {
        return view('form');
    }
 
    public function citySelect(Request $request)
    {
          $query = $request->get('query');
          $filterResult = City::where('name', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    }
}
