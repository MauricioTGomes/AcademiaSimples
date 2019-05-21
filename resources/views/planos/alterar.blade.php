@extends('index')
@section('conteudo')

    {!! Form::model($pessoa,['route' => ['pessoas.update', $pessoa->id], 'metho'=>'POST','class'=>'form-pessoa','enctype'=>'multipart/form-data']) !!}

    @include('pessoa.campos_form')

    {!! Form::close() !!}

@endsection