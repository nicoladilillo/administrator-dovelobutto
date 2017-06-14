@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a href="{{ route('product') }}">Handle New Product</a><br>
                    <a href="{{ route('product.all') }}">All Product</a><br>
                    <a href="{{ route('city') }}">All City</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
