document.addEventListener('DOMContentLoaded', () => {

    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : null;

    
    if (!csrfToken) {
        console.error("ERRO: Meta tag 'csrf-token' não encontrada no layout!");
    }

    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const usersContainer = document.getElementById('usersContainer');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    // Verifica se estamos na página correta
    if (!searchInput || !searchButton || !usersContainer || !loadMoreBtn) {
        return; 
    }

    let currentPage = 1;
    let currentSearch = searchInput.value;

    async function fetchUsers(page = 1, search = '') {
        
        const apiUrl = `${baseUrl}/users/api`; 
        
        const queryParams = new URLSearchParams({
            page: page,
            search: search
        });

        const response = await fetch(`${apiUrl}?${queryParams.toString()}`);
        const data = await response.json();
        return data;
    }

    function renderUsers(users, append = false) {
        if (!append) usersContainer.innerHTML = '';

        if (users.length === 0 && !append) {
            usersContainer.innerHTML = `<div class="col-12"><div class="text-center text-muted py-5 bg-white shadow-sm rounded-0">Nenhum utilizador encontrado.</div></div>`;
            return;
        }

        users.forEach(user => {
            const card = document.createElement('div');
            card.className = 'col';
            
            
            const adminBorderClass = user.is_admin ? 'border-primary border-3' : 'border-0';

            
            const adminBadge = user.is_admin 
                ? '<span class="badge bg-primary rounded-pill ms-2" style="font-size: 0.7em; vertical-align: middle;">Admin</span>' 
                : ''; 
            
            let blockBtnHtml = '';
            if (user.is_blocked) {
                blockBtnHtml = `
                    <form action="${baseUrl}/users/${user.id}/unblock" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button type="submit" class="btn btn-sm btn-outline-success rounded-0" title="Unblock">
                            <i class="bis bi-unlock"></i>
                        </button>
                    </form>`;
            } else {
                blockBtnHtml = `
                    <form action="${baseUrl}/users/${user.id}/block" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-0" title="Block" onclick="return confirm('Block this user?')">
                            <i class="bis bi-ban"></i>
                        </button>
                    </form>`;
            }

            
            
            deleteBtnHtml = `
                <form action="${baseUrl}/users/${user.id}/delete" method="POST" class="d-inline">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-0" title="Delete" onclick="return confirm('Delete this user?');">
                        <i class="bis bi-trash"></i>
                    </button>
                </form>`;
            

            card.innerHTML = `
                <div class="card shadow-sm ${adminBorderClass} rounded-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold m-0">
                                ${user.name}
                                ${adminBadge}
                            </h5>
                            ${user.is_blocked 
                                ? '<span class="badge bg-danger text-white rounded-0">Blocked</span>' 
                                : '<span class="badge bg-success text-white rounded-0">Active</span>'}
                        </div>
                        
                        <p class="card-text text-muted small mb-3">${user.email}</p>

                        <div class="mt-auto d-flex gap-2 pt-3 border-top">
                            <a href="${baseUrl}/users/${user.id}" class="btn btn-sm btn-outline-secondary rounded-0" title="View">
                                <i class="bis bi-eye"></i>
                            </a>
                            <a href="${baseUrl}/users/${user.id}/edit" class="btn btn-sm btn-outline-primary rounded-0" title="Edit">
                                <i class="bis bi-pencil"></i>
                            </a>
                            ${blockBtnHtml}
                            ${deleteBtnHtml}
                        </div>
                    </div>
                </div>
            `;
            usersContainer.appendChild(card);
        });
    }

    async function loadUsers(reset = true) {
        if (reset) {
            currentPage = 1;
        }

        const data = await fetchUsers(currentPage, currentSearch);
        renderUsers(data.data, !reset);

        loadMoreBtn.classList.toggle('d-none', data.current_page >= data.last_page);
    }

    searchButton.addEventListener('click', () => {
        currentSearch = searchInput.value.trim();
        loadUsers(true);
    });

    searchInput.addEventListener('keyup', e => {
        if (e.key === 'Enter') {
            currentSearch = searchInput.value.trim();
            loadUsers(true);
        }
    });

    loadMoreBtn.addEventListener('click', () => {
        currentPage++;
        loadUsers(false);
    });

    // Carregamento inicial
    loadUsers();
});


function markAsRead(id) {
    const url = `${baseUrl}/notifications/${id}/mark-read`;
    const notificationElement = document.getElementById(`notification-${id}`);
    
    const color = notificationElement.getAttribute('data-color');

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            notificationElement.classList.remove('bg-white', 'shadow-sm', 'border-start', 'border-4', `border-${color}`);
            
            notificationElement.classList.add('bg-light', 'text-muted');

            const badge = notificationElement.querySelector('.badge');
            if (badge) badge.remove();

            const btn = notificationElement.querySelector('button');
            if (btn) btn.parentElement.remove();
        }
    })
    .catch(err => console.error(err));
}

function markAllRead() {
    const url = `${baseUrl}/notifications/mark-all-read`;

    if(!confirm('Are you sure you want to mark all notifications as read?')) return;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success || data.message) {
            window.location.reload(); 
        }
    })
    .catch(err => console.error(err));
}


document.addEventListener('DOMContentLoaded', () => {
    
    const followButtons = document.querySelectorAll('.follow-btn');
    console.log(followButtons);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF Token not found: Follow button will not work.');
        return;
    }

    followButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();

            
            const url = this.dataset.url;
            const isFollowing = this.dataset.following === 'true';
            
            
            toggleButtonState(this, !isFollowing);

            try {
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', 
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({})
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                
                const data = await response.json();
                
                const newState = data.following !== undefined ? data.following : !isFollowing;
                this.dataset.following = newState.toString();
                
                
                toggleButtonState(this, newState);

            } catch (error) {
                console.error('Follow action failed:', error);
                
                toggleButtonState(this, isFollowing);
                alert('Something went wrong. Please try again.');
            }
        });
    });

   function toggleButtonState(button, following) {
    const icon = button.querySelector('i');
    const text = button.querySelector('.btn-text');

    if (!icon || !text) {
        console.error("Follow button structure is missing <i> or .btn-text");
        return;
    }

    if (following) {
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-outline-danger');

        icon.classList.remove('bi-heart');
        icon.classList.add('bi-heart-fill');

        text.textContent = 'Unfollow';
    } else {
        button.classList.remove('btn-outline-danger');
        button.classList.add('btn-outline-secondary');

        icon.classList.remove('bi-heart-fill');
        icon.classList.add('bi-heart');

        text.textContent = 'Follow';
    }
}
});


document.addEventListener('DOMContentLoaded', () => {
    const chatContainer = document.getElementById('chat-container');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    

    scrollToBottom();

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const msgText = messageInput.value.trim();
        
        const receiverInput = chatForm.querySelector('input[name="receiver_id"]');
        const receiverId = receiverInput ? receiverInput.value : null;

        if (!msgText) return; // Não enviar vazios

        messageInput.value = '';

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const url = chatForm.dataset.url;

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Importante para JSON
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    content: msgText,
                    receiver_id: receiverId
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error("ERRO DO SERVIDOR:", errorData);
                throw new Error(errorData.message || 'Erro ao enviar');
            }

            const data = await response.json();

            if (data.message) {
                 appendMessage(data.message.content, true);
            }

        } catch (error) {
            console.error(error);
            alert('Erro: ' + error.message);
            messageInput.value = msgText;
        }
    });
    // Helper: Append Message HTML
    function appendMessage(text, isMe) {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        const alignment = isMe ? 'justify-content-end' : 'justify-content-start';
        const bgClass = isMe ? 'bg-primary text-white rounded-bottom-end-0' : 'bg-light text-dark border rounded-bottom-start-0';
        const textMuted = isMe ? 'text-white-50' : 'text-muted';

        const html = `
            <div class="d-flex mb-3 ${alignment} animate-fade-in">
                <div class="p-3 rounded-4 shadow-sm ${bgClass}" style="max-width: 75%;">
                    <div class="message-content text-break">${escapeHtml(text)}</div>
                    <div class="text-end mt-1">
                        <small class="${textMuted}" style="font-size: 0.7rem;">${time}</small>
                    </div>
                </div>
            </div>
        `;

        chatContainer.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Security: Basic HTML escape to prevent XSS in the optimistic update
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
});