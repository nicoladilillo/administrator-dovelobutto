<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    public function index()
    {
      // Get the currently authenticated user's ID...
      $id = Auth::id();

      $products = DB::table('agreements')
              ->join('dumps', 'dumps.id', '=', 'agreements.id_dump')
              ->join('products', 'products.ID', '=', 'agreements.id_product')
              ->join('emails', 'emails.ID', '=', 'agreements.id_email')
              ->select('products.ID as id', 'products.name as name')
              ->where('id_dump','=',$id)
              ->whereNull('id_bin')
              ->groupBy('products.ID')
              ->groupBy('products.name')
              ->get();

      $bins = DB::table('bins')->get();

      return view('product', [
        'products' => $products,
        'bins' => $bins
      ]);
    }

    public function bin(Request $request, $product)
    {
      $bin = $request->input('bin');
      // Get the currently authenticated user's ID...
      $dump = Auth::id();

      DB::table('agreements')
            ->where('id_dump', $dump)
            ->where('id_product', $product)
            ->update([
              'id_status' => 1,
              'id_bin' => $bin
            ]);

      return redirect()->action('ProductController@index');
    }

    public function destroy($product)
    {
      // Get the currently authenticated user's ID...
      $dump = Auth::id();

      DB::table('agreements')
            ->where('id_dump', $dump)
            ->where('id_product', $product)
            ->delete();

      return redirect()->back();
    }

    public function all()
    {
      // Get the currently authenticated user's ID...
      $id = Auth::id();

      $products = DB::table('agreements')
              ->join('dumps', 'dumps.id', '=', 'agreements.id_dump')
              ->join('products', 'products.ID', '=', 'agreements.id_product')
              ->join('bins', 'bins.ID', '=', 'agreements.id_bin')
              ->select('products.ID as id', 'products.name as name', 'bins.name as bin')
              ->where('id_dump','=',$id)
              ->where('id_status','=',1)
              ->orderBy('products.name')
              ->groupBy('products.ID')
              ->groupBy('products.name')
              ->groupBy('bins.name')
              ->get();

      $bins = DB::table('bins')->get();

      return view('all', [
        'products' => $products,
        'bins' => $bins
      ]);
    }

    public function create(Request $request)
     {
       $bin = $request->input('bin');
       $new = strtolower($request->input('new'));
       // Get the currently authenticated user's ID...
       $id = Auth::id();

       $product = DB::table('products')
              ->where('name','=',$new)
              ->pluck('ID');

      if ( empty($product) ) {
        $product = DB::table('products')->insertGetId(
          ['name' => $new]
        );
      }

      DB::table('agreements')->insert(
        [
          'id_product' => $product[0],
          'id_status' => 1,
          'id_dump' => $id,
          'id_bin' => $bin
        ]
      );

      return redirect()->action('ProductController@all');
     }

}
