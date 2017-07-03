@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Handle New Product</div>

                <div class="panel-body">

                  @include('error')

                  @if( count($products) == 0 )
                    <p>There are not product...</p>
                  @endif

                  <div class="container">
                  @foreach ($products as $product)
                    <div class="row justify-content-center">

                      <div class="col-sm-6">
                        <form class="form-inline" role="form" method="post" action="{{ route('bin.update', $product->id) }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-group">
                            <label for="product" class="text-capitalize col-sm-2 control-label">{{ $product->name }}</label>
                          </div>

                          <div class="form-group">
                              @include('bin')
                          </div>


                        <div class="row">
                            <div class="col-sm-2">
                              <button type="submit" class="btn btn-success btn-md">
                                add
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                              </button>
                            </div>
                          </form>

                          <div class="col-sm-2">
                            {{  Form::open([ 'method'  => 'delete', 'route' => [ 'bin.destroy', $product->id ], 'class' => 'form-inline' ])  }}
                            <button type="submit" class="btn btn-danger btn-md">
                              delete
                              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                            {{ Form::close() }}
                          </div>
                        </div>
                      </div>

                  </div>
                  @endforeach
                  </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
