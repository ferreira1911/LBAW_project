@extends('layouts.app')

@section('title', 'Criar Novo Utilizador')

@section('content')
<div class="bg-light py-5">
    <div class="container py-4">
        
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Gestão de Utilizadores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Criar Novo</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-0">
                    <div class="card-body p-4 p-md-5">
                        
                        <h2 class="fw-bold text-dark mb-4">Criar Novo Utilizador</h2>

                        <form method="POST" action="{{ route('user.store') }}">
                            @csrf

                            
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nome Completo</label>
                                <input type="text" class="form-control rounded-0" id="name" name="name" 
                                       value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control rounded-0" id="email" name="email" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input type="password" class="form-control rounded-0" id="password" name="password" required>
                                    @error('password')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold">Confirmar Password</label>
                                    <input type="password" class="form-control rounded-0" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>

                            
                            <div class="mb-4 border-top pt-4">
                                <h5 class="fw-bold">Permissões</h5>
                                <div class="form-check form-switch fs-5">
                                    
                                    <input class="form-check-input rounded-0" type="checkbox" role="switch" 
                                           id="is_admin" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_admin">
                                        Tornar este utilizador um Administrador?
                                    </label>
                                </div>
                                <p class="text-muted small mt-2">
                                    Administradores têm permissão para gerir utilizadores, moderar relatórios e aceder a todas as áreas restritas.
                                </p>
                            </div>

                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg rounded-0 px-5">Criar Utilizador</button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-0 px-4">Cancelar</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection