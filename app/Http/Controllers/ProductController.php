<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\SendMail;

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
              ->where('id_status','=',2)
              ->whereNull('id_bin')
              ->groupBy('products.ID')
              ->groupBy('products.name')
              ->get();

      return view('product', ['products' => $products]);
    }

    //Accept product
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

      $user = DB::table('agreements')
          ->join('emails','agreements.id_email','=','emails.ID')
          ->join('dumps', 'dumps.id', '=', 'agreements.id_dump')
          ->join('products', 'products.ID', '=', 'agreements.id_product')
          ->join('bins','bins.ID','=','agreements.id_bin')
          ->select('emails.email as user', 'dumps.name as dump', 'products.name as product', 'bins.name as bin')
          ->where('id_dump', $dump)
          ->where('id_product', $product)
          ->get();

      foreach ($user as $user) {
        $data = [
          'product' => $user->product,
          'dump' => $user->dump,
          'bin' => $user->bin
        ];
        Mail::send('emails.view', $data, function($message) use ($user)
        {
          $message->to($user->user)->subject('Abbiamo indirizzato il rifiuto da te segnalato');
        });
      }

      return redirect()->action('ProductController@index');
    }

    public function destroy($product)
    {
      // Get the currently authenticated user's ID...
      $dump = Auth::id();
      echo "ciao";

      DB::table('agreements')
            ->where('id_dump', $dump)
            ->where('id_product', $product)
            ->update(['id_status' => 3]);

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

      return view('all', ['products' => $products,]);
    }

    public function create(Request $request)
    {
       $bin = $request->input('bin');
       $new = strtolower($request->input('new'));
       // Get the currently authenticated user's ID...
       $id = Auth::id();

       $validate = DB::table('products')
              ->where('name','=',$new)
              ->count();

      if ( $validate == 0 ) {
        $product = DB::table('products')->insertGetId(
          ['name' => $new]
        );
      }
      else  {
        $product = DB::table('products')
                  ->where('name','=',$new)
                  ->pluck('ID');

        $product = $product[0];

        //You can't put a products in two differt bins
        $validate = DB::table('agreements')
                    ->where('id_product','=',$product)
                    ->where('id_status','=',1)
                    ->where('id_dump','=',$id)
                    ->count();

        if ( $validate != 0 ) {
          return redirect()->back()->withErrors(['Product alredy exist! Try to delete it before and then change the bin']);
        }
      }

      DB::table('agreements')->insert(
        [
          'id_product' => $product,
          'id_status' => 1,
          'id_dump' => $id,
          'id_bin' => $bin
        ]
      );

      return redirect()->action('ProductController@all');
     }

}
