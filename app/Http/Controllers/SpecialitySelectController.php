<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speciality;

class SpecialitySelectController extends Controller
{
    public function specialitySelect(Request $request)
    {
          $query = $request->get('query');
          $filterResult = Speciality::where('name', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    }
}
