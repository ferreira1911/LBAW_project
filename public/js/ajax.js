document.addEventListener('DOMContentLoaded', () => {

    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : null;

    
    if (!csrfToken) {
        console.error("ERRO: Meta tag 'csrf-token' não encontrada no layout!");
    }

    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const usersTableBody = document.getElementById('usersTableBody');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const loadMoreContainer = document.getElementById('loadMoreContainer');

    if (!searchInput || !searchButton || !usersTableBody || !loadMoreBtn) {
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
        if (!append) usersTableBody.innerHTML = '';

        if (users.length === 0 && !append) {
            usersTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-search display-6 opacity-25 d-block mb-3"></i>
                        No users found.
                    </td>
                </tr>`;
            return;
        }

        users.forEach(user => {
            const row = document.createElement('tr');

            let avatarHtml = '';

            if (user.url) {
                avatarHtml = `
                    <img src="${baseUrl}/images/profile/${user.url}" 
                         alt="${user.name}" 
                         class="rounded-circle me-3 border" 
                         style="width: 40px; height: 40px; object-fit: cover;">
                `;
            } else {
                avatarHtml = `
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 40px; height: 40px;">
                        <i class="bi bi-person text-secondary"></i>
                    </div>
                `;
            }

            const roleBadge = user.is_admin 
                ? '<span class="badge bg-primary-subtle text-primary rounded-pill">Admin</span>' 
                : '<span class="badge bg-light text-secondary border rounded-pill">User</span>';

            let statusBadge = '';
            if (user.is_blocked) {
                statusBadge = '<span class="badge bg-danger-subtle text-danger rounded-pill"><i class="bi bi-x-circle me-1"></i>Blocked</span>';
            } else {
                statusBadge = '<span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-check-circle me-1"></i>Active</span>';
            }
            
            
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
                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-0" title="Block" onclick="return confirm('Are you sure you want to block this user?')">
                            <i class="bis bi-ban"></i>
                        </button>
                    </form>`;
            }

            
            
            const deleteBtnHtml = `
                <form action="${baseUrl}/users/${user.id}/delete" method="POST" class="d-inline">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-0" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                        <i class="bis bi-trash"></i>
                    </button>
                </form>`;
            

            row.innerHTML = `
                <td class="ps-4 fw-bold text-secondary">#${user.id}</td>

                <td>
                    <div class="d-flex align-items-center">
                        ${avatarHtml}
                        <div>
                            <a href= "${baseUrl}/users/${user.id}" class="fw-bold text-dark text-decoration-none">
                                ${user.name}
                            </a>
                            <div class="small text-muted">${user.email}</div>
                        </div>
                    </div>
                </td>

                <td>${roleBadge}</td>

                <td>${statusBadge}</td>

                <td class="text-end pe-4">
                    <div class="d-flex justify-content-end gap-1">
                        <a href="${baseUrl}/users/${user.id}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-eye"></i>
                        </a>
                        
                        <a href="${baseUrl}/users/${user.id}/edit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>

                        ${blockBtnHtml} 
                        ${deleteBtnHtml}
                    </div>
                </td>
            `;
            usersTableBody.appendChild(row);
        });
    }

    async function loadUsers(reset = true) {
        if (loadingSpinner) loadingSpinner.classList.remove('d-none');

        if (loadMoreContainer) loadMoreContainer.classList.add('d-none');

        if (reset) {
            currentPage = 1;
        }

        try {
            const data = await fetchUsers(currentPage, currentSearch);

            if (loadingSpinner) loadingSpinner.classList.add('d-none');

            renderUsers(data.data, !reset);

            if (loadMoreContainer) {
                if (data.current_page >= data.last_page) {
                    loadMoreContainer.classList.add('d-none');
                } else {
                    loadMoreContainer.classList.remove('d-none');
                }
            }
        } catch (error) {
            console.error("Error loading users:", error);
            if (loadingSpinner) loadingSpinner.classList.add('d-none');
        }
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