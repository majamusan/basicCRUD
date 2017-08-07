@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong> {{ $crud->name }} {{ $crud->surname }}</strong></div>
                    <div class="panel-body">

                        <a href="{{ url('/crud') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/crud/' . $crud->id . '/edit') }}" title="Edit Entry"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['crud', $crud->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Entry',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $crud->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $crud->name }} {{ $crud->surname }}</td></tr>
                                    <tr><th> Mobile </th><td> {{ $crud->mobile }} </td></tr>
                                    <tr><th> Email </th><td> {{ $crud->email }} </td></tr>
                                    <tr><th> ID Number  </th><td> {{ $crud->ID_Number }} </td></tr>
                                    <tr><th> Birth  </th><td> {{ $crud->birth }} </td></tr>
                                    <tr><th> Language </th><td> {{ $languageOptions[$crud->language]}} </td></tr>
                                    <tr><th> Interests </th><td> {{ $crud->interests}} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
