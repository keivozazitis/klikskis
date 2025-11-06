<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klikšķis – Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/chat.css'])
</head>
<body>
    <div class="chat-container">
        <h2>Čats ar matched lietotājiem</h2>
        <div class="poga-back">
            <a href="{{ route('users.index') }}" class="back-to-users-btn">Atpakaļ uz lietotājiem</a>
        </div>
        @if(count($matchedUsers) === 0)
            <p>Tev nav neviena match lietotāja.</p>
        @else
            <div class="chat-sidebar">
                <ul>
                    @foreach($matchedUsers as $u)
                        <li data-id="{{ $u->id }}" class="matched-user">{{ $u->first_name }} {{ $u->last_name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="chat-main">
                <div class="chat-messages" id="chatMessages">
                    @if(!empty($messages))
                        @foreach($messages as $msg)
                            <p class="{{ $msg->sender_id == auth()->id() ? 'sent' : 'received' }}">
                                {{ $msg->message }}
                            </p>
                        @endforeach
                    @else
                        <p class="system">Nav ziņu</p>
                    @endif
                </div>
                <div class="chat-input">
                    <textarea id="messageInput" placeholder="Raksti ziņu..."></textarea>
                    <button id="sendBtn">Sūtīt</button>
                </div>
            </div>
        @endif
    </div>

    <script>
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let selectedUserId = null;

        document.querySelectorAll('.matched-user').forEach(el => {
            el.addEventListener('click', () => {
                selectedUserId = el.getAttribute('data-id');
                document.getElementById('chatMessages').innerHTML = '<p class="system">Čats ar ' + el.textContent + '</p>';
            });
        });

        document.getElementById('sendBtn')?.addEventListener('click', () => {
            const msg = document.getElementById('messageInput').value.trim();
            if(!selectedUserId || !msg) return;

            fetch('{{ route("chat.send") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: selectedUserId,
                    message: msg
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.error) return;

                const chatBox = document.getElementById('chatMessages');
                const p = document.createElement('p');
                p.classList.add('sent');
                p.textContent = data.message.message;
                chatBox.appendChild(p);
                document.getElementById('messageInput').value = '';
            });
        });
    </script>
</body>
</html>
