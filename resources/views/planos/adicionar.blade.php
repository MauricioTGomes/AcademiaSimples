@extends('index')
@section('conteudo')

    {!! Form::open(['route'=>'pacotesCliente.gravar','class'=>'form-pacotesCliente','enctype'=>'multipart/form-data']) !!}

    @include('planos.campos_form')

    {!! Form::close() !!}

@endsection