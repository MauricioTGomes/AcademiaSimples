@extends('index')
@section('conteudo')

    {!! Form::open(['route'=>'pessoas.gravar','class'=>'form-pessoa','enctype'=>'multipart/form-data']) !!}

    @include('pessoa.campos_form')

    {!! Form::close() !!}

@endsection