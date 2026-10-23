@extends('errors.layout')

@section('title', 'Too Many Requests')
@section('code', '429')
@section('message', 'Too many requests')
@section('description', "You've made too many requests in a short time. Please wait a moment and try again.")
