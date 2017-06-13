@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">All Product</div>

                <div class="panel-body">

                  {{  Form::open([ 'method'  => 'post', 'route' => [ 'product.create' ] ])  }}
                    {{ Form::text('new') }}
                    @include('bin', $bins)
                    {{ Form::submit('Add', ['class' => 'btn btn-primary']) }}
                  {{ Form::close() }}

                  @foreach ($products as $product)

                    {{ $product->name }}
                    {{ $product->bin }}

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
