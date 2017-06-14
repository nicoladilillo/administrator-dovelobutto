<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::orderBy('name')->get();
        return view('cities', ['cities' => $cities]);
    }

    public function create()
    {
      // Get the currently authenticated user's ID...
      $dump = Auth::id();
      $input = strtolower(Request::get('city'));

      $validate = City::where('name','=',$input)->count();

      if ( $validate != 0 ) {
        return redirect()->back()->withErrors(['City alredy exist']);
      }
      $city = new City;
      $city->name = $input;
      $city->dump_id = $dump;

      $city->save();

      return redirect()->back();
    }

    public function delete($id)
    {
      // Get the currently authenticated user's ID...
      $dump = Auth::id();

       City::where('id', $id)
            ->where('dump_id', $dump)
            ->delete();

      return redirect()->back();
    }
}
