@extends('index')
@section('conteudo')

    {!! Form::model($pacote,['route' => ['pacote.update', $pacote->id], 'metho'=>'POST','class'=>'form-pacote','enctype'=>'multipart/form-data']) !!}

    @include('pacote.campos_form')

    {!! Form::close() !!}

@endsection