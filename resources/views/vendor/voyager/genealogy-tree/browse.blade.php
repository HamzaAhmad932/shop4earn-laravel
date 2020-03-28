@extends('voyager::master')

@section('page_title', 'Genealogy Tree')
@section('css')
<style>
    body{
        background: none !important;
    }
    .app-container{
        background: none !important;
    }
</style>
@stop

@section('content')
    <div class="page-content browse container-fluid" id="app">
        <genealogy-tree></genealogy-tree>
    </div>
@stop
@section('javascript')

@stop
