@extends('pages.layout')
@section('title', 'Bem-vindo(a)')
@section('content')


    <h1 class="alert alert-info">Lorem ipsum dolor sit amet.</h1>
    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Lorem ipsum, dolor sit amet consectetur adipisicing
        elit.</h2>
    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi rerum non amet recusandae, ipsam dicta iure
        voluptatibus eius ullam vero vel inventore in iusto, sequi repudiandae fugiat dolorum aspernatur harum.
    </p>
    <div>

        {{-- nao estou logado --}}
        
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-info">Entrar</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Cadastre-se</a>
        @endguest

        {{-- estou logado --}}

        @auth
            <a href="{{ route('home') }}" class="btn btn-outline-primary">Home</a>
        @endauth

    </div>

@endsection
