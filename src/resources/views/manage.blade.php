<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Manage Users</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .btn-primary {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #0056b3;
            }

            .btn-chat {
                background-color: #28a745;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-chat:hover {
                background-color: #218838;
            }

            .btn-chat:disabled {
                background-color: #6c757d;
                cursor: not-allowed;
            }

            .input-field {
                padding: 10px;
                border: 2px solid #ccc;
                border-radius: 4px;
                width: 100%;
                box-sizing: border-box;
                margin-top: 6px;
                margin-bottom: 16px;
                resize: vertical;
            }

            .input-field:focus {
                border-color: #007bff;
                outline: none;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
                text-align: left;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            tr:hover {
                background-color: #f1f1f1;
            }

            .flex-container {
                display: flex;
                align-items: center;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
                justify-content: center;
                align-items: center;
            }

            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 500px;
                border-radius: 8px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                animation-name: animatetop;
                animation-duration: 0.4s;
            }

            .modal-close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .modal-close:hover,
            .modal-close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .logged-in-user {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 14px;
                color: #1b1b18;
            }
        </style>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] p-6 lg:p-8">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden mx-auto relative">
        <nav class="flex items-center justify-center gap-4">
            <a
                href="{{ url('/manage') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
            >
                Manage
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Logout
                </button>
            </form>
        </nav>
        <div class="logged-in-user">
            Logged as: {{ auth()->user()->email }}
        </div>
        </header>
        <div class="w-full lg:max-w-4xl max-w-[335px] mx-auto">
            <div class="text-center">
                <h3 class="text-l lg:text-l font-bold mb-4">Manage Users</h3>
            </div>

            <div class="w-full">
                <form method="POST" action="{{ route('updateUsers') }}">
                    @csrf
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2">Name</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">Role</th>
                                <th class="py-2">Actions</th>
                                <th class="py-2">Chat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2">
                                        <input type="text" name="users[{{ $user->id }}][name]" value="{{ $user->name }}" class="input-field">
                                    </td>
                                    <td class="py-2">
                                        <input type="email" name="users[{{ $user->id }}][email]" value="{{ $user->email }}" class="input-field">
                                    </td>
                                    <td class="py-2">
                                        <select name="users[{{ $user->id }}][role]" class="input-field">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </td>
                                    <td class="py-2 text-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </td>
                                    <td class="py-2 text-center">
                                        <button type="button" class="btn btn-chat" onclick="openChat({{ $user->id }})" {{ $user->id === auth()->user()->id ? 'disabled' : '' }}>Chat</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <!-- Chat Modal -->
        <div id="chatModal" class="modal" onclick="closeModal(event, 'chatModal')">
            <div class="modal-content" onclick="event.stopPropagation()">
                <span class="modal-close" onclick="document.getElementById('chatModal').style.display='none'">&times;</span>
                <h2 class="modal-header text-2xl font-bold mb-4" style="background-color: #f1f1f1; padding: 15px; border-radius: 5px; text-align: center;">Chat</h2>
                <div id="chatContent" class="mb-4">
                    <!-- Chat content will be dynamically loaded here -->
                </div>
                <div class="flex-container">
                    <input type="text" id="chatInput" class="input-field" placeholder="Type your message...">
                    <button type="button" class="btn btn-primary" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>

        <script>
            function openChat(userId) {
                // Replace with the actual URL to load the chat content with the selected user
                const chatContent = document.getElementById('chatContent');
                chatContent.innerHTML = `<p>Loading chat with user ${userId}...</p>`;
                document.getElementById('chatModal').style.display = 'flex';

                // Simulate loading chat content
                setTimeout(() => {
                    chatContent.innerHTML = `<p>Chat with user ${userId} loaded.</p>`;
                }, 1000);
            }

            function closeModal(event, modalId) {
                if (event.target.id === modalId) {
                    document.getElementById(modalId).style.display = 'none';
                }
            }

            function sendMessage() {
                const chatInput = document.getElementById('chatInput');
                const message = chatInput.value;
                if (message.trim() !== '') {
                    // Replace with the actual logic to send the message
                    alert(`Message sent: ${message}`);
                    chatInput.value = '';
                }
            }
        </script>
    </body>
</html>
