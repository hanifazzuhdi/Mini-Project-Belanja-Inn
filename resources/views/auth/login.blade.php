<!doctype html>
<html lang="en">

    <head>
        <title>Login Admin</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: linear-gradient(180deg,#4e73df 10%,#224abe 100%);
        }

        .container {
            position: relative;
            padding: 50px 45px 30px;
            box-sizing: border-box;
            border-radius: 10px;
            background-color: white;
        }

        .container h2 {
            line-height: 1em;
            margin-bottom: 45px;
            padding-left: 10px;
            border-left: 5px solid red;
        }

        .container .content {
            position: relative;
            top: 0;
            left: 0;
            width: 240px;
            height: 45px;
            margin-bottom: 25px;
        }

        .container .content:nth-child(2) {
            margin-bottom: 15px;
        }

        .container form label {
            font-size: 13px;
        }

        .container .content:last-child {
            margin-top: 15px;
            margin-bottom: 0px;
        }

        .container .content input {
            position: absolute;
            top: 0;
            left: 0;
            box-sizing: border-box;
            width: 100%;
            padding: 9px;
            background-color: transparent;
            display: inline-block;
            border-radius: 4px;
            outline: none;
            border: 1px solid black;
        }

        .container .content span {
            position: absolute;
            top: 1px;
            left: 1px;
            padding: 9px;
            font-size: 14px;
            display: inline-block;
            transition: 0.5s;
            pointer-events: none;
        }

        .container .content input:focus~span,
        .container .content input:valid~span {
            font-size: 12px;
            transform: translateX(-10px) translateY(-29px);
        }

        .container .content button {
            position: relative;
            border-radius: 4px;
            width: 90px;
            height: 32px;
            cursor: pointer;
            background-color: #4e73df;
            outline: none;
            border: 1px solid #2686e0;
        }

        .container .content button:hover {
            background-color: lightblue;
        }

        .container a {
            color: #2686e0;
            font-size: 13px;
            text-decoration: none;
            transition: 0.5s;
        }

        .container a:hover {
            color: lightblue;
        }
   </style>

</head>

    <body>

        <div class="container">
            <h2>Login </h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="content">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" required name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span>Email</span>
                </div>

                <div class=" content">
                    <input type="password" required name="password" class="password" id="password" autocomplete="current-password">
                    <span>Password</span>
                </div>

                <input type="checkbox" name="remember" id="remember">
                <label for="">Remember Me</label>

                <div class="content">
                    <button type="submit" name="submit">Masuk</button>
                </div>
            </form>

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>

    </body>

    </html>
