@extends('layouts.app')

@section('title', 'Gerir Utilizadores')

@section('content')
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark mb-0">Gestão de Utilizadores</h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group input-group-lg shadow-sm rounded-0 overflow-hidden">
                <span class="input-group-text bg-white border-0 ps-4">
                    <i class="fas fa-search text-muted"></i>
                </span>
                {{-- ID para o JavaScript --}}
                <input type="text" id="searchInput" class="form-control border-0 ps-3 py-3" 
                       placeholder="Pesquisar por nome ou email..." 
                       aria-label="Pesquisar utilizadores">
                {{-- ID para o JavaScript --}}
                <button id="searchButton" class="btn btn-primary px-4 fw-bold rounded-0" type="button">
                    PESQUISAR
                </button>
            </div>
        </div>
    </div>


    <div id="usersContainer" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        
    </div>

    {{-- Botão "Carregar Mais" --}}
    <div class="text-center mt-5">
        {{-- ID para o JavaScript --}}
        <button id="loadMoreBtn" class="btn btn-outline-primary btn-lg px-5 rounded-0 d-none">
            Carregar Mais
        </button>
    </div>

</div>
@endsection