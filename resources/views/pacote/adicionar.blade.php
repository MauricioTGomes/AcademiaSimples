@extends('index')
@section('conteudo')

    {!! Form::open(['route'=>'pacote.gravar','class'=>'form-pacote','enctype'=>'multipart/form-data', 'method'=>'POST']) !!}

    @include('pacote.campos_form')

    {!! Form::close() !!}

@endsection