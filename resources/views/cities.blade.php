@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">All Cities</div>

                <div class="panel-body">

                  @include('error')

                  <div class="container-fluid">
                  {{  Form::open([ 'method'  => 'post', 'route' => [ 'city.create' ], 'class' => 'form-inline' ]) }}
                    <div class="form-group">
                      {{ Form::label('city', 'City', ['class' => 'sr-only']) }}
                      {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'add city'] ) }}
                    </div>
                    {{ Form::submit('Add', ['class' => 'btn btn-primary']) }}
                  {{ Form::close() }}
                  </div>

                  <div class="row">
                    @if( count($cities) == 0 )
                      <p>...Add some cities</p>
                    @endif
                  @foreach ($cities as $city)
                    <div class=".col-md-6">
                      {{  Form::open([ 'method'  => 'delete', 'route' => [ 'city.delete', $city->id ], 'class' => 'form-horizontal' ])  }}
                        <div class="form-group">
                          {{ Form::label('city', $city->name, ['class' => 'text-capitalize col-sm-2 control-label'] ) }}
                          <div class="col-sm-10">
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                          </div>
                        </div>
                      {{ Form::close() }}
                    </div>
                  @endforeach
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
