<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ChatApp — Gamboa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-primary: #0e1621;
            --bg-secondary: #17212b;
            --bg-tertiary: #232e3c;
            --bg-hover: #2b5278;
            --accent: #2b9af3;
            --accent-dark: #1a7ad4;
            --text-primary: #ffffff;
            --text-secondary: #8899a6;
            --text-muted: #6c7e8e;
            --bubble-out: #2b5278;
            --bubble-in: #182533;
            --border: #1e2c3a;
            --online: #4dca5a;
            --sidebar-width: 340px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-secondary);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-header {
            padding: 16px 16px 12px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
            color: var(--accent);
            flex: 1;
            letter-spacing: -0.5px;
        }

        .user-avatar-header {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2b9af3, #1a6ec7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
        }

        .logout-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 6px;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        .logout-btn:hover { background: var(--bg-tertiary); color: var(--text-primary); }

        .search-box {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
        }

        .search-input {
            width: 100%;
            background: var(--bg-tertiary);
            border: none;
            border-radius: 20px;
            padding: 8px 16px 8px 38px;
            color: var(--text-primary);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            position: relative;
        }
        .search-input::placeholder { color: var(--text-muted); }

        .search-wrapper {
            position: relative;
        }
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .contacts-list {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--bg-tertiary) transparent;
        }

        .contacts-list::-webkit-scrollbar { width: 4px; }
        .contacts-list::-webkit-scrollbar-track { background: transparent; }
        .contacts-list::-webkit-scrollbar-thumb { background: var(--bg-tertiary); border-radius: 2px; }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            cursor: pointer;
            transition: background 0.15s;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            text-decoration: none;
            color: inherit;
        }
        .contact-item:hover { background: var(--bg-tertiary); }
        .contact-item.active { background: var(--bg-hover); }

        .contact-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3a8fd6, #1e5fa0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 600;
            flex-shrink: 0;
            position: relative;
        }

        .avatar-colors {
            --c0: linear-gradient(135deg,#f093fb,#f5576c);
            --c1: linear-gradient(135deg,#4facfe,#00f2fe);
            --c2: linear-gradient(135deg,#43e97b,#38f9d7);
            --c3: linear-gradient(135deg,#fa709a,#fee140);
            --c4: linear-gradient(135deg,#a18cd1,#fbc2eb);
            --c5: linear-gradient(135deg,#ffecd2,#fcb69f);
        }

        .contact-avatar[data-color="0"] { background: var(--c0); }
        .contact-avatar[data-color="1"] { background: var(--c1); }
        .contact-avatar[data-color="2"] { background: var(--c2); }
        .contact-avatar[data-color="3"] { background: var(--c3); }
        .contact-avatar[data-color="4"] { background: var(--c4); }
        .contact-avatar[data-color="5"] { background: var(--c5); }

        .online-dot {
            width: 12px;
            height: 12px;
            background: var(--online);
            border-radius: 50%;
            border: 2px solid var(--bg-secondary);
            position: absolute;
            bottom: 1px;
            right: 1px;
        }

        .contact-info { flex: 1; min-width: 0; }
        .contact-name {
            font-size: 15px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .contact-preview {
            font-size: 13px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }

        .unread-badge {
            background: var(--accent);
            color: white;
            font-size: 11px;
            font-weight: 600;
            border-radius: 10px;
            padding: 2px 7px;
            min-width: 20px;
            text-align: center;
            display: none;
        }
        .unread-badge.show { display: block; }

        /* ===== CHAT PANEL ===== */
        .chat-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-primary);
            position: relative;
        }

        /* Estado vacío */
        .empty-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            gap: 16px;
        }
        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-tertiary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
        }
        .empty-state h3 { font-size: 20px; color: var(--text-secondary); font-weight: 500; }
        .empty-state p { font-size: 14px; }

        /* Header del chat */
        .chat-header {
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--bg-secondary);
        }

        .chat-header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 600;
        }

        .chat-header-info h3 { font-size: 16px; font-weight: 600; }
        .chat-header-info span { font-size: 13px; color: var(--online); }

        /* Mensajes */
        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            scrollbar-width: thin;
            scrollbar-color: var(--bg-tertiary) transparent;
        }

        .messages-area::-webkit-scrollbar { width: 4px; }
        .messages-area::-webkit-scrollbar-thumb { background: var(--bg-tertiary); border-radius: 2px; }

        .message-group {
            display: flex;
            flex-direction: column;
            max-width: 65%;
        }
        .message-group.mine { align-self: flex-end; align-items: flex-end; }
        .message-group.theirs { align-self: flex-start; align-items: flex-start; }

        .message-bubble {
            padding: 8px 14px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.5;
            max-width: 100%;
            word-break: break-word;
            position: relative;
            animation: bubbleIn 0.2s ease;
        }

        @keyframes bubbleIn {
            from { opacity: 0; transform: scale(0.95) translateY(4px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .message-group.mine .message-bubble {
            background: var(--bubble-out);
            border-bottom-right-radius: 4px;
            color: #e8f4ff;
        }
        .message-group.theirs .message-bubble {
            background: var(--bubble-in);
            border-bottom-left-radius: 4px;
            color: var(--text-primary);
        }

        .message-time {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
            padding: 0 4px;
        }

        .date-divider {
            text-align: center;
            margin: 16px 0 8px;
        }
        .date-divider span {
            background: var(--bg-tertiary);
            color: var(--text-muted);
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 12px;
        }

        /* Input de mensaje */
        .message-input-area {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: flex-end;
            gap: 10px;
            background: var(--bg-secondary);
        }

        .message-textarea {
            flex: 1;
            background: var(--bg-tertiary);
            border: none;
            border-radius: 20px;
            padding: 10px 18px;
            color: var(--text-primary);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            resize: none;
            max-height: 120px;
            min-height: 42px;
            line-height: 1.5;
            scrollbar-width: none;
        }
        .message-textarea::placeholder { color: var(--text-muted); }
        .message-textarea::-webkit-scrollbar { display: none; }

        .send-btn {
            width: 42px;
            height: 42px;
            background: var(--accent);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .send-btn:hover { background: var(--accent-dark); transform: scale(1.05); }
        .send-btn:active { transform: scale(0.95); }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: absolute; z-index: 10; height: 100%; }
            .sidebar.hidden { display: none; }
        }

        .typing-indicator {
            display: none;
            align-items: center;
            gap: 4px;
            padding: 8px 14px;
            background: var(--bubble-in);
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            width: fit-content;
        }
        .typing-indicator.show { display: flex; }
        .typing-dot {
            width: 7px; height: 7px;
            background: var(--text-muted);
            border-radius: 50%;
            animation: typingBounce 1.4s infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typingBounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-6px); }
        }
    </style>
</head>
<body class="avatar-colors">

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span class="logo">💬 ChatApp</span>
        <span style="font-size:13px;color:var(--text-muted);">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Cerrar sesión">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                </svg>
            </button>
        </form>
    </div>

    <div class="search-box">
        <div class="search-wrapper">
            <svg class="search-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" class="search-input" placeholder="Buscar contacto..." id="searchInput">
        </div>
    </div>

    <div class="contacts-list" id="contactsList">
        @foreach($users as $user)
        @php $color = $user->id % 6; @endphp
        <a href="{{ route('chat.show', $user->id) }}"
           class="contact-item {{ isset($receiver) && $receiver->id === $user->id ? 'active' : '' }}"
           data-user-id="{{ $user->id }}"
           data-name="{{ $user->name }}">
            <div class="contact-avatar" data-color="{{ $color }}">
                {{ strtoupper(substr($user->name, 0, 1)) }}
                <div class="online-dot"></div>
            </div>
            <div class="contact-info">
                <div class="contact-name">{{ $user->name }}</div>
                <div class="contact-preview">{{ $user->email }}</div>
            </div>
            <span class="unread-badge" id="badge-{{ $user->id }}">0</span>
        </a>
        @endforeach
    </div>
</div>

<!-- PANEL DERECHO -->
<div class="chat-panel">

    @if(isset($receiver))
    {{-- HEADER DEL CHAT --}}
    @php $color = $receiver->id % 6; $gradients = ['linear-gradient(135deg,#f093fb,#f5576c)','linear-gradient(135deg,#4facfe,#00f2fe)','linear-gradient(135deg,#43e97b,#38f9d7)','linear-gradient(135deg,#fa709a,#fee140)','linear-gradient(135deg,#a18cd1,#fbc2eb)','linear-gradient(135deg,#ffecd2,#fcb69f)']; @endphp
    <div class="chat-header">
        <div class="chat-header-avatar" style="background: {{ $gradients[$color] }}">
            {{ strtoupper(substr($receiver->name, 0, 1)) }}
        </div>
        <div class="chat-header-info">
            <h3>{{ $receiver->name }}</h3>
            <span>en línea</span>
        </div>
    </div>

    {{-- MENSAJES --}}
    <div class="messages-area" id="messagesArea">
        @foreach($messages as $msg)
        @php $isMine = $msg->sender_id === Auth::id(); @endphp
        <div class="message-group {{ $isMine ? 'mine' : 'theirs' }}">
            <div class="message-bubble">{{ $msg->content }}</div>
            <span class="message-time">{{ $msg->created_at->format('H:i') }}</span>
        </div>
        @endforeach

        <div class="message-group theirs" id="typingIndicatorWrapper" style="display:none;">
            <div class="typing-indicator show">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>
    </div>

    {{-- INPUT --}}
    <div class="message-input-area">
        <textarea class="message-textarea"
                  id="messageInput"
                  placeholder="Escribe un mensaje..."
                  rows="1"></textarea>
        <button class="send-btn" id="sendBtn">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>

    @else
    {{-- ESTADO VACÍO --}}
    <div class="empty-state">
        <div class="empty-icon">💬</div>
        <h3>Selecciona un contacto</h3>
        <p>Elige una conversación de la lista para comenzar a chatear</p>
    </div>
    @endif
</div>

<script>
const AUTH_ID = {{ Auth::id() }};
const RECEIVER_ID = {{ isset($receiver) ? $receiver->id : 'null' }};
const SEND_URL = "{{ route('chat.send') }}";
const FETCH_URL = "{{ route('chat.fetch') }}";
const UNREAD_URL = "{{ route('chat.unread') }}";
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

let lastMessageId = {{ isset($messages) && $messages->count() > 0 ? $messages->last()->id : 0 }};

// Auto-resize textarea
const textarea = document.getElementById('messageInput');
if (textarea) {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Enter para enviar, Shift+Enter para nueva línea
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
}

// Botón enviar
const sendBtn = document.getElementById('sendBtn');
if (sendBtn) sendBtn.addEventListener('click', sendMessage);

async function sendMessage() {
    const input = document.getElementById('messageInput');
    const content = input.value.trim();
    if (!content || !RECEIVER_ID) return;

    input.value = '';
    input.style.height = 'auto';

    // Mostrar burbuja inmediatamente (optimistic UI)
    appendMessage({ content, sender_id: AUTH_ID, created_at: new Date().toTimeString().slice(0,5) }, true);

    try {
        const res = await fetch(SEND_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ receiver_id: RECEIVER_ID, content })
        });
        const data = await res.json();
        lastMessageId = data.id;
    } catch(e) {
        console.error('Error enviando mensaje', e);
    }
}

function appendMessage(msg, isMine) {
    const area = document.getElementById('messagesArea');
    if (!area) return;

    const group = document.createElement('div');
    group.className = `message-group ${isMine ? 'mine' : 'theirs'}`;
    group.innerHTML = `
        <div class="message-bubble">${escapeHtml(msg.content)}</div>
        <span class="message-time">${msg.created_at}</span>
    `;

    // Insertar antes del indicador de typing
    const typing = document.getElementById('typingIndicatorWrapper');
    area.insertBefore(group, typing);
    scrollToBottom();
}

function escapeHtml(text) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(text));
    return d.innerHTML;
}

function scrollToBottom() {
    const area = document.getElementById('messagesArea');
    if (area) area.scrollTop = area.scrollHeight;
}

// Polling de nuevos mensajes cada 2 segundos
async function pollMessages() {
    if (!RECEIVER_ID) return;
    try {
        const res = await fetch(`${FETCH_URL}?with_user=${RECEIVER_ID}&last_id=${lastMessageId}`, {
            headers: { 'X-CSRF-TOKEN': CSRF }
        });
        const msgs = await res.json();
        msgs.forEach(msg => {
            if (msg.sender_id !== AUTH_ID) {
                appendMessage(msg, false);
                lastMessageId = msg.id;
            } else if (msg.id > lastMessageId) {
                lastMessageId = msg.id;
            }
        });
    } catch(e) {}
}

// Polling de mensajes no leídos para badges
async function pollUnread() {
    try {
        const res = await fetch(UNREAD_URL, { headers: { 'X-CSRF-TOKEN': CSRF } });
        const counts = await res.json();
        document.querySelectorAll('.unread-badge').forEach(badge => {
            const userId = badge.id.replace('badge-', '');
            const count = counts[userId] || 0;
            badge.textContent = count;
            badge.classList.toggle('show', count > 0);
        });
    } catch(e) {}
}

// Búsqueda de contactos
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.contact-item').forEach(item => {
        const name = item.dataset.name.toLowerCase();
        item.style.display = name.includes(q) ? '' : 'none';
    });
});

// Scroll inicial al fondo
scrollToBottom();

// Iniciar polling
if (RECEIVER_ID) {
    setInterval(pollMessages, 2000);
}
setInterval(pollUnread, 5000);
pollUnread();
</script>
</body>
</html>
