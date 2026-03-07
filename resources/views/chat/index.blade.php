<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ChatApp — Gamboa</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #f0f4ff;
            --white: #ffffff;
            --sidebar-bg: #ffffff;
            --blue: #4a6cf7;
            --blue-dark: #3451d1;
            --blue-light: #eef2ff;
            --blue-mid: #c7d2fe;
            --text: #1e2340;
            --text2: #64748b;
            --muted: #94a3b8;
            --border: #e8edf5;
            --border2: #d1daf0;
            --online: #10b981;
            --sidebar-width: 300px;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            box-shadow: 2px 0 12px rgba(74,108,247,0.06);
        }

        .sidebar-header {
            padding: 18px 16px 14px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--white);
        }

        .app-logo { display: flex; align-items: center; gap: 10px; flex: 1; }
        .app-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #4a6cf7, #6366f1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
            box-shadow: 0 4px 12px rgba(74,108,247,0.3);
        }
        .app-logo-name {
            font-size: 17px; font-weight: 700; letter-spacing: -0.3px; color: var(--text);
        }
        .app-logo-name span { color: var(--blue); }

        .user-chip {
            display: flex; align-items: center; gap: 6px;
            background: var(--blue-light);
            border: 1px solid var(--blue-mid);
            border-radius: 20px;
            padding: 4px 10px 4px 6px;
        }
        .user-chip-avatar {
            width: 22px; height: 22px;
            background: linear-gradient(135deg, #4a6cf7, #6366f1);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; color: white;
        }
        .user-chip-name { font-size: 11px; font-weight: 600; color: var(--blue); max-width: 70px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .logout-btn {
            width: 30px; height: 30px;
            background: #fff0f0; border: 1px solid #fecaca;
            border-radius: 8px; color: #ef4444;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.2s; flex-shrink: 0;
        }
        .logout-btn:hover { background: #fee2e2; border-color: #ef4444; }

        .search-box { padding: 12px 14px; border-bottom: 1px solid var(--border); background: var(--white); }
        .search-wrapper { position: relative; }
        .search-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
        .search-input {
            width: 100%; background: var(--bg);
            border: 1.5px solid var(--border); border-radius: 10px;
            padding: 9px 14px 9px 34px;
            color: var(--text); font-size: 13px;
            font-family: 'Sora', sans-serif; outline: none; transition: all 0.2s;
        }
        .search-input:focus { border-color: var(--blue); background: white; box-shadow: 0 0 0 3px rgba(74,108,247,0.1); }
        .search-input::placeholder { color: var(--muted); }

        .section-label {
            padding: 12px 16px 4px;
            font-size: 10px; font-weight: 700;
            color: var(--muted); text-transform: uppercase; letter-spacing: 1.2px;
        }

        .contacts-list { flex: 1; overflow-y: auto; scrollbar-width: thin; scrollbar-color: var(--border) transparent; }
        .contacts-list::-webkit-scrollbar { width: 3px; }
        .contacts-list::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 2px; }

        .contact-item {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 16px; cursor: pointer;
            transition: all 0.15s; text-decoration: none; color: inherit;
            border-left: 3px solid transparent;
        }
        .contact-item:hover { background: var(--bg); }
        .contact-item.active {
            background: var(--blue-light);
            border-left-color: var(--blue);
        }

        .contact-avatar {
            width: 42px; height: 42px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700; color: white;
            flex-shrink: 0; position: relative;
        }
        .contact-avatar[data-color="0"] { background: linear-gradient(135deg,#f093fb,#f5576c); }
        .contact-avatar[data-color="1"] { background: linear-gradient(135deg,#4facfe,#00f2fe); }
        .contact-avatar[data-color="2"] { background: linear-gradient(135deg,#43e97b,#38f9d7); }
        .contact-avatar[data-color="3"] { background: linear-gradient(135deg,#fa709a,#fee140); }
        .contact-avatar[data-color="4"] { background: linear-gradient(135deg,#a18cd1,#fbc2eb); }
        .contact-avatar[data-color="5"] { background: linear-gradient(135deg,#4a6cf7,#6366f1); }
        .ai-avatar { background: linear-gradient(135deg,#4a6cf7,#6366f1) !important; }

        .online-dot {
            width: 10px; height: 10px; background: var(--online);
            border-radius: 50%; border: 2px solid white;
            position: absolute; bottom: 0; right: 0;
        }

        .contact-info { flex: 1; min-width: 0; }
        .contact-name { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text); }
        .contact-preview { font-size: 11px; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }

        .unread-badge {
            background: var(--blue); color: white;
            font-size: 10px; font-weight: 700;
            border-radius: 20px; padding: 2px 7px;
            min-width: 18px; text-align: center; display: none;
        }
        .unread-badge.show { display: block; }

        .ai-tag {
            background: var(--blue-light); border: 1px solid var(--blue-mid);
            color: var(--blue); font-size: 9px; font-weight: 700;
            border-radius: 6px; padding: 2px 7px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* ===== CHAT PANEL ===== */
        .chat-panel {
            flex: 1; display: flex; flex-direction: column;
            background: var(--bg); position: relative;
        }

        .empty-state {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            color: var(--muted); gap: 14px;
        }
        .empty-icon {
            width: 72px; height: 72px;
            background: white; border: 1.5px solid var(--border);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center; font-size: 32px;
            box-shadow: 0 4px 16px rgba(74,108,247,0.08);
        }
        .empty-state h3 { font-size: 17px; color: var(--text2); font-weight: 600; }
        .empty-state p { font-size: 13px; color: var(--muted); }

        .chat-header {
            padding: 13px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 12px;
            background: var(--white);
            box-shadow: 0 1px 8px rgba(74,108,247,0.06);
        }
        .chat-header-avatar {
            width: 38px; height: 38px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700; color: white;
        }
        .chat-header-info h3 { font-size: 15px; font-weight: 700; color: var(--text); }
        .chat-header-status { font-size: 11px; color: var(--online); display: flex; align-items: center; gap: 4px; margin-top: 1px; }
        .chat-header-status::before { content: ''; width: 6px; height: 6px; background: var(--online); border-radius: 50%; display: inline-block; }
        .ai-status { color: var(--blue); }
        .ai-status::before { background: var(--blue); }

        .messages-area {
            flex: 1; overflow-y: auto; padding: 20px 24px;
            display: flex; flex-direction: column; gap: 4px;
            scrollbar-width: thin; scrollbar-color: var(--border) transparent;
        }
        .messages-area::-webkit-scrollbar { width: 4px; }
        .messages-area::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 2px; }

        .message-group { display: flex; flex-direction: column; max-width: 62%; }
        .message-group.mine { align-self: flex-end; align-items: flex-end; }
        .message-group.theirs { align-self: flex-start; align-items: flex-start; }

        .message-bubble {
            padding: 10px 16px; border-radius: 18px;
            font-size: 14px; line-height: 1.6; max-width: 100%; word-break: break-word;
            animation: bubbleIn 0.2s cubic-bezier(0.34,1.56,0.64,1);
        }
        @keyframes bubbleIn {
            from { opacity: 0; transform: scale(0.92) translateY(6px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .message-group.mine .message-bubble {
            background: linear-gradient(135deg, #4a6cf7, #6366f1);
            border-bottom-right-radius: 4px; color: white;
            box-shadow: 0 4px 14px rgba(74,108,247,0.3);
        }
        .message-group.theirs .message-bubble {
            background: white; border: 1.5px solid var(--border);
            border-bottom-left-radius: 4px; color: var(--text);
            box-shadow: 0 2px 8px rgba(74,108,247,0.06);
        }
        .message-group.theirs.ai .message-bubble {
            background: var(--blue-light);
            border: 1.5px solid var(--blue-mid);
            border-bottom-left-radius: 4px;
            border-left: 3px solid var(--blue);
            color: var(--text);
        }

        .message-time { font-size: 10px; color: var(--muted); margin-top: 3px; padding: 0 4px; }

        .date-separator {
            text-align: center; margin: 12px 0;
            font-size: 11px; color: var(--muted);
            display: flex; align-items: center; gap: 10px;
        }
        .date-separator::before, .date-separator::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        /* Input area */
        .message-input-area {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            display: flex; align-items: flex-end; gap: 10px;
            background: var(--white);
            box-shadow: 0 -1px 8px rgba(74,108,247,0.04);
        }

        .message-textarea {
            flex: 1; background: var(--bg);
            border: 1.5px solid var(--border); border-radius: 14px;
            padding: 11px 16px; color: var(--text);
            font-size: 14px; font-family: 'Sora', sans-serif;
            outline: none; resize: none;
            max-height: 120px; min-height: 44px; line-height: 1.5;
            transition: border-color 0.2s;
        }
        .message-textarea:focus { border-color: var(--blue); background: white; box-shadow: 0 0 0 3px rgba(74,108,247,0.1); }
        .message-textarea::placeholder { color: var(--muted); }
        .message-textarea::-webkit-scrollbar { display: none; }

        .send-btn {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #4a6cf7, #6366f1);
            border: none; border-radius: 13px; color: white;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.2s; flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(74,108,247,0.35);
        }
        .send-btn:hover { transform: scale(1.06); box-shadow: 0 6px 20px rgba(74,108,247,0.45); }
        .send-btn:active { transform: scale(0.95); }

        .typing-indicator {
            display: none; align-items: center; gap: 5px;
            padding: 10px 16px;
            background: var(--blue-light);
            border: 1.5px solid var(--blue-mid);
            border-left: 3px solid var(--blue);
            border-radius: 18px; border-bottom-left-radius: 4px;
            width: fit-content;
        }
        .typing-indicator.show { display: flex; }
        .typing-dot {
            width: 6px; height: 6px; background: var(--blue);
            border-radius: 50%; animation: typingBounce 1.4s infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-6px); }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-header">
        <div class="app-logo">
            <div class="app-logo-icon">💬</div>
            <span class="app-logo-name">Chat<span>App</span></span>
        </div>
        <div class="user-chip">
            <div class="user-chip-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span class="user-chip-name">{{ Auth::user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Cerrar sesión">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                </svg>
            </button>
        </form>
    </div>

    <div class="search-box">
        <div class="search-wrapper">
            <svg class="search-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" class="search-input" placeholder="Buscar contacto..." id="searchInput">
        </div>
    </div>

    <div class="contacts-list">
        <div class="section-label">Asistente</div>

        <a href="{{ route('chat.ai.show') }}"
           class="contact-item {{ isset($isAiChat) && $isAiChat ? 'active' : '' }}">
            <div class="contact-avatar ai-avatar">🤖</div>
            <div class="contact-info">
                <div class="contact-name">Asistente IA</div>
                <div class="contact-preview">Cloudflare · Llama 3</div>
            </div>
            <span class="ai-tag">IA</span>
        </a>

        <div class="section-label">Contactos</div>

        @foreach($users as $user)
        @php $color = $user->id % 6; @endphp
        <a href="{{ route('chat.show', $user->id) }}"
           class="contact-item {{ isset($receiver) && !isset($isAiChat) && $receiver->id === $user->id ? 'active' : '' }}"
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
            <span class="unread-badge" id="badge-{{ $user->id }}"></span>
        </a>
        @endforeach
    </div>
</div>

<!-- PANEL DERECHO -->
<div class="chat-panel">

    @if(isset($isAiChat) && $isAiChat)
    <div class="chat-header">
        <div class="chat-header-avatar" style="background: linear-gradient(135deg,#4a6cf7,#6366f1);">🤖</div>
        <div class="chat-header-info">
            <h3>Asistente IA</h3>
            <div class="chat-header-status ai-status">Cloudflare AI · Llama 3</div>
        </div>
    </div>

    <div class="messages-area" id="messagesArea">
        <div class="message-group theirs ai">
            <div class="message-bubble">¡Hola! Soy tu asistente de inteligencia artificial. ¿En qué puedo ayudarte hoy? 😊</div>
            <span class="message-time">Ahora</span>
        </div>
        <div class="typing-indicator" id="typingIndicator">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
    </div>

    <div class="message-input-area">
        <textarea class="message-textarea" id="messageInput" placeholder="Pregúntale algo al asistente..." rows="1"></textarea>
        <button class="send-btn" id="sendBtn">
            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>

    @elseif(isset($receiver))
    @php
        $color = $receiver->id % 6;
        $gradients = [
            'linear-gradient(135deg,#f093fb,#f5576c)',
            'linear-gradient(135deg,#4facfe,#00f2fe)',
            'linear-gradient(135deg,#43e97b,#38f9d7)',
            'linear-gradient(135deg,#fa709a,#fee140)',
            'linear-gradient(135deg,#a18cd1,#fbc2eb)',
            'linear-gradient(135deg,#4a6cf7,#6366f1)',
        ];
    @endphp
    <div class="chat-header">
        <div class="chat-header-avatar" style="background: {{ $gradients[$color] }}">
            {{ strtoupper(substr($receiver->name, 0, 1)) }}
        </div>
        <div class="chat-header-info">
            <h3>{{ $receiver->name }}</h3>
            <div class="chat-header-status">En línea</div>
        </div>
    </div>

    <div class="messages-area" id="messagesArea">
        @foreach($messages as $msg)
        @php $isMine = $msg->sender_id === Auth::id(); @endphp
        <div class="message-group {{ $isMine ? 'mine' : 'theirs' }}">
            <div class="message-bubble">{{ $msg->content }}</div>
            <span class="message-time">{{ $msg->created_at->format('H:i') }}</span>
        </div>
        @endforeach
    </div>

    <div class="message-input-area">
        <textarea class="message-textarea" id="messageInput" placeholder="Escribe un mensaje..." rows="1"></textarea>
        <button class="send-btn" id="sendBtn">
            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>

    @else
    <div class="empty-state">
        <div class="empty-icon">💬</div>
        <h3>Selecciona una conversación</h3>
        <p>Elige un contacto o chatea con el Asistente IA</p>
    </div>
    @endif

</div>

<script>
const AUTH_ID   = {{ Auth::id() }};
const RECEIVER_ID = {{ isset($receiver) ? $receiver->id : 'null' }};
const IS_AI     = {{ isset($isAiChat) && $isAiChat ? 'true' : 'false' }};
const SEND_URL  = "{{ route('chat.send') }}";
const FETCH_URL = "{{ route('chat.fetch') }}";
const UNREAD_URL= "{{ route('chat.unread') }}";
const AI_URL    = "{{ route('chat.ai') }}";
const CSRF      = document.querySelector('meta[name="csrf-token"]').content;

let lastMessageId = {{ isset($messages) && !isset($isAiChat) && $messages->count() > 0 ? $messages->last()->id : 0 }};

const textarea = document.getElementById('messageInput');
if (textarea) {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            IS_AI ? sendToAI() : sendMessage();
        }
    });
}

document.getElementById('sendBtn')?.addEventListener('click', () => IS_AI ? sendToAI() : sendMessage());

async function sendMessage() {
    const input = document.getElementById('messageInput');
    const content = input.value.trim();
    if (!content || !RECEIVER_ID) return;
    input.value = ''; input.style.height = 'auto';
    appendMessage({ content, sender_id: AUTH_ID, created_at: new Date().toTimeString().slice(0,5) }, true, false);
    try {
        const res = await fetch(SEND_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ receiver_id: RECEIVER_ID, content })
        });
        const data = await res.json();
        lastMessageId = data.id;
    } catch(e) { console.error(e); }
}

async function sendToAI() {
    const input = document.getElementById('messageInput');
    const content = input.value.trim();
    if (!content) return;
    input.value = ''; input.style.height = 'auto';
    appendMessage({ content, created_at: new Date().toTimeString().slice(0,5) }, true, false);
    document.getElementById('typingIndicator')?.classList.add('show');
    scrollToBottom();
    try {
        const res = await fetch(AI_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ message: content })
        });
        const data = await res.json();
        document.getElementById('typingIndicator')?.classList.remove('show');
        appendMessage({ content: data.reply, created_at: new Date().toTimeString().slice(0,5) }, false, true);
    } catch(e) {
        document.getElementById('typingIndicator')?.classList.remove('show');
        appendMessage({ content: '⚠️ Error al conectar con el asistente.', created_at: new Date().toTimeString().slice(0,5) }, false, true);
    }
}

function appendMessage(msg, isMine, isAi) {
    const area = document.getElementById('messagesArea');
    if (!area) return;
    const group = document.createElement('div');
    group.className = `message-group ${isMine ? 'mine' : 'theirs'} ${isAi ? 'ai' : ''}`;
    group.innerHTML = `<div class="message-bubble">${escapeHtml(msg.content)}</div><span class="message-time">${msg.created_at}</span>`;
    const typing = document.getElementById('typingIndicator');
    if (typing) area.insertBefore(group, typing);
    else area.appendChild(group);
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

async function pollMessages() {
    if (!RECEIVER_ID || IS_AI) return;
    try {
        const res = await fetch(`${FETCH_URL}?with_user=${RECEIVER_ID}&last_id=${lastMessageId}`, { headers: { 'X-CSRF-TOKEN': CSRF } });
        const msgs = await res.json();
        msgs.forEach(msg => {
            if (msg.sender_id !== AUTH_ID) appendMessage(msg, false, false);
            if (msg.id > lastMessageId) lastMessageId = msg.id;
        });
    } catch(e) {}
}

async function pollUnread() {
    try {
        const res = await fetch(UNREAD_URL, { headers: { 'X-CSRF-TOKEN': CSRF } });
        const counts = await res.json();
        document.querySelectorAll('.unread-badge').forEach(badge => {
            const userId = badge.id.replace('badge-', '');
            const count = counts[userId] || 0;
            badge.textContent = count > 0 ? count : '';
            badge.classList.toggle('show', count > 0);
        });
    } catch(e) {}
}

document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.contact-item[data-name]').forEach(item => {
        item.style.display = item.dataset.name.toLowerCase().includes(q) ? '' : 'none';
    });
});

scrollToBottom();
if (!IS_AI) setInterval(pollMessages, 2000);
setInterval(pollUnread, 5000);
pollUnread();
</script>
</body>
</html>