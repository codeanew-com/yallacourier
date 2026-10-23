@extends('errors.layout')

@section('title', 'Server Error')
@section('code', '500')
@section('message', 'Something went wrong')
@section('description', "We hit an unexpected error on our end. It's already been logged — please try again shortly, or reach out if it keeps happening.")
@section('whatsapp', 'yes')
