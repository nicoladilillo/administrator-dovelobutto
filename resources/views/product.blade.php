@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Handle New Product</div>

                <div class="panel-body">

                  @include('error')

                  @foreach ($products as $product)

                    <form class="form-vertical" role="form" method="post" action="{{ route('bin.update', $product->id) }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group">
                        <label class="col-sm-2 control-label">{{ $product->name }}</label>
                        <div class="col-sm-10">
                          @include('bin')
                        </div>
                      </div>
                    {{ Form::submit('Click Me!') }}
                    </form>

                    {{  Form::open([ 'method'  => 'delete', 'route' => [ 'bin.destroy', $product->id ] ])  }}
                      {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    {{ Form::close() }}

                  @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
