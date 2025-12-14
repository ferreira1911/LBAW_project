<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="list-group list-group-flush">
        @forelse ($conversations as $message)
            @php
                // Determine who the "other" person is
                $otherUser = ($message->sender_id === Auth::id()) ? $message->receiver : $message->sender;
            @endphp

            <a href="{{ route('messages.show', $otherUser) }}" class="list-group-item list-group-item-action p-4 d-flex align-items-center">
                {{-- Avatar --}}
                <div class="flex-shrink-0 me-3 position-relative">
                    @if($otherUser->url)
                        <img src="{{ $otherUser->getProfileImage() }}" class="rounded-circle object-fit-cover border" width="50" height="50">
                    @else
                        <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-fill text-secondary fs-4"></i>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex justify-content-between align-items-baseline mb-1">
                        <h6 class="fw-bold text-dark mb-0">{{ $otherUser->name }}</h6>
                        <small class="text-muted">{{ $message->sent_date->diffForHumans() }}</small>
                    </div>
                    <p class="text-secondary small mb-0 text-truncate">
                        @if($message->sender_id === Auth::id())
                            <span class="text-muted fst-italic">You:</span>
                        @endif
                        {{ $message->content }}
                    </p>
                </div>
                
                {{-- Chevron --}}
                <div class="ms-3 text-muted">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </a>
        @empty
            <div class="text-center py-5">
                <div class="mb-3 text-muted opacity-25">
                    <i class="bi bi-chat-dots-fill display-1"></i>
                </div>
                <h5 class="fw-bold text-secondary">No messages yet</h5>
                <p class="text-muted">Start a conversation from an auction page or user profile.</p>
            </div>
        @endforelse
    </div>
</div>