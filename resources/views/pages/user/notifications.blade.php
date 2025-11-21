@extends('layouts.app')

@section('title', 'Notificações')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 150px);">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                {{-- Cabeçalho --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-dark m-0">
                        Notificações 
                        {{-- Contador opcional de não lidas --}}
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger rounded-pill fs-6 ms-2">{{ $unreadCount }}</span>
                        @endif
                    </h2>
                    
                </div>

                {{-- Lista de Notificações --}}
                <div class="notifications-list">
                    @forelse ($notifications as $notification)
                        {{-- Inclui o Partial que criámos --}}
                        @include('partials.notification', ['notification' => $notification])
                    @empty
                        {{-- Estado Vazio (Empty State) --}}
                        <div class="text-center py-5">
                            <div class="mb-4 text-muted opacity-25">
                                
                                <i class="far fa-bell-slash fa-4x"></i>
                            </div>
                            <h4 class="fw-bold text-secondary">Tudo limpo!</h4>
                            <p class="text-muted mb-4">Não tens notificações novas de momento.</p>
                            
                            <a href="{{ route('auctions.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                                Explorar Leilões
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Paginação --}}
                @if($notifications->hasPages())
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $notifications->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection