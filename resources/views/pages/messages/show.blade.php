@extends('layouts.app')

@section('title', 'Chat with ' . $receiver->name)

@section('content')
<div class="bg-light py-4" style="height: calc(100vh - 70px);"> 
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-10 col-lg-8 h-100 d-flex flex-column">

                <div class="card border-0 shadow-sm rounded-top-4 rounded-bottom-0 z-1">
                    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center">
                        <button onclick="window.history.back()" class="btn btn-sm btn-light rounded-circle me-3">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <div class="d-flex align-items-center">
                            @if($receiver->url)
                                <img src="{{ $receiver->getProfileImage() }}" class="rounded-circle object-fit-cover border me-2" width="40" height="40">
                            @else
                                <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center border me-2" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill text-secondary"></i>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('users.show', $receiver) }}" class="text-decoration-none text-dark">
                                    <h6 class="fw-bold mb-0 hover-text-primary">{{ $receiver->name }}</h6>
                                </a>
                                <small class="text-muted">Online</small>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div id="chat-container" class="card-body bg-white border-start border-end overflow-auto flex-grow-1 p-4" style="background-color: #f8f9fa;">
                    @foreach($messages as $message)
                        @php
                            $isMe = $message->sender_id === Auth::id();
                        @endphp
                        <div class="d-flex mb-3 {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="p-3 rounded-4 shadow-sm {{ $isMe ? 'bg-primary text-white rounded-bottom-end-0' : 'bg-light text-dark border rounded-bottom-start-0' }}" 
                                 style="max-width: 75%;">
                                <div class="message-content text-break">{{ $message->content }}</div>
                                <div class="text-end mt-1">
                                    <small class="{{ $isMe ? 'text-white-50' : 'text-muted' }}" style="font-size: 0.7rem;">
                                        {{ $message->sent_date->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                
                <div class="card border-0 shadow-sm rounded-bottom-4 rounded-top-0">
                    <div class="card-body p-3">
                        <form id="chat-form" data-url="{{ route('messages.store') }}">
                            <div class="input-group">
                                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                                <input type="text" id="message-input" name="content" class="form-control border-0 bg-light rounded-start-pill ps-4 py-3 shadow-none" 
                                       placeholder="Type a message..." autocomplete="off" required>
                                <button type="submit" class="btn btn-primary rounded-end-pill px-4">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection