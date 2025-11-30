@extends('layouts.app')

@section('title', 'Gestão de Leilões')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
       
        @include('partials.admin-tabs')

        <div class="card border-0 shadow-sm rounded-bottom-4 rounded-top-0">
            <div class="card-body p-4">
                <h4 class="fw-bold text-secondary mb-4">Todos os Leilões (Admin)</h4>
                
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Dono</th>
                            <th>Estado</th>
                            <th>Preço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auctions as $auction)
                        <tr>
                            <td>#{{ $auction->id }}</td>
                            <td>
                                <a href="{{ route('auctions.show', $auction) }}" class="fw-bold text-decoration-none">
                                    {{ Str::limit($auction->title, 30) }}
                                </a>
                            </td>
                            <td>{{ $auction->owner->name }}</td>
                            <td>
                                <span class="badge rounded-pill 
                                    {{ $auction->status == 'Active' ? 'bg-success' : '' }}
                                    {{ $auction->status == 'Pending' ? 'bg-warning text-dark' : '' }}
                                    {{ $auction->status == 'Ended' ? 'bg-secondary' : '' }}
                                    {{ $auction->status == 'Cancelled' ? 'bg-danger' : '' }}">
                                    {{ $auction->status }}
                                </span>
                            </td>
                            <td>{{ number_format($auction->current_price, 2) }} €</td>
                            <td>
                                <a href="{{ route('auctions.edit', $auction) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $auctions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection