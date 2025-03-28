<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
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

        .btn-hover-blue {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-hover-blue:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        <nav class="flex items-center justify-center gap-4">
            <button
                onclick="document.getElementById('loginModal').style.display='flex'"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal btn-hover-blue">
                Log in
            </button>

            @if (Route::has('register'))
            <button
                onclick="document.getElementById('registerModal').style.display='flex'"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal btn-hover-blue">
                Register
            </button>
            @endif
        </nav>

        <div class="datetime text-right mt-4">
            {{ now()->format('l, F j, Y') }}<br>
            <span id="live-time"></span>
            <script>
                function updateTime() {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    document.getElementById('live-time').textContent = `${hours}:${minutes}:${seconds}`;
                }
                setInterval(updateTime, 1000);
                updateTime();
            </script>
        </div>
    </header>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <div class="text-center">
            <h1 class="text-3xl lg:text-4xl font-bold mb-4">Welcome to your Laravel Breeze Starter Kit</h1>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal" onclick="closeModal(event, 'loginModal')">
        <div class="modal-content" onclick="event.stopPropagation()">
            <h2 class="modal-header text-3xl font-bold mb-4" style="background-color: #f1f1f1; padding: 15px; border-radius: 5px; text-align: center;">Log in</h2>
            @if ($errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
            <script>
                document.getElementById('loginModal').style.display = 'flex';
            </script>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="input-field" value="{{ old('email') }}" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="input-field" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="button" onclick="document.getElementById('loginModal').style.display='none'" class="btn btn-cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="modal" onclick="closeModal(event, 'registerModal')">
        <div class="modal-content" onclick="event.stopPropagation()">
            <h2 class="justify-center modal-header text-3xl font-bold mb-4" style="background-color: #f1f1f1; padding: 15px; border-radius: 5px; text-align: center;">Register</h2>
            @if ($errors->any() && !$errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first() }}</div>
            <script>
                document.getElementById('registerModal').style.display = 'flex';
            </script>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="input-field" value="{{ old('name') }}" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="input-field" value="{{ old('email') }}" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="input-field" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="input-field" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button type="button" onclick="document.getElementById('registerModal').style.display='none'" class="btn btn-cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function closeModal(event, modalId) {
            if (event.target.id === modalId) {
                document.getElementById(modalId).style.display = 'none';
            }
        }
    </script>
</body>

</html>