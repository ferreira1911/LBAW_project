document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const usersContainer = document.getElementById('usersContainer');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    // Verifica se estamos na página correta (se os elementos existem)
    if (!searchInput || !searchButton || !usersContainer || !loadMoreBtn) {
        // Não faz nada se não estiver na página de utilizadores
        return; 
    }

    let currentPage = 1;
    let currentSearch = searchInput.value; // Pega o valor inicial

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
            
        
            card.innerHTML = `
                <div class="card shadow-sm border-0 rounded-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">${user.name}</h5>
                        <p class="card-text text-muted mb-1">${user.email}</p>
                        <div class="mt-3 d-flex gap-2">
                            <a href="${baseUrl}/user/${user.id}" class="btn btn-sm btn-outline-secondary rounded-0">Ver Perfil</a>
                            <a href="${baseUrl}/user/${user.id}/edit" class="btn btn-sm btn-outline-primary rounded-0">Editar</a>
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