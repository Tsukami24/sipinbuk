<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --navy: #0B132B;
            --primary: #2D6A4F;
            --accent: #74C69D;
            --card: #F8F9FA;
        }

        body {
            background-color: var(--navy);
        }

        .background-radial-gradient {
            background:
                radial-gradient(800px circle at 0% 0%,
                    rgba(116, 198, 157, 0.25),
                    transparent 60%),
                radial-gradient(800px circle at 100% 100%,
                    rgba(45, 106, 79, 0.35),
                    transparent 60%),
                var(--navy);
        }

        .bg-glass {
            background-color: var(--card);
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .compact-card {
            max-width: 380px;
        }

        .form-otp {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .form-otp input {
            width: 48px;
            height: 56px;
            text-align: center;
            font-size: 1.25rem;
            font-weight: 600;
            border-radius: 10px;
            border: 1.5px solid #ced4da;
            transition: all .2s;
        }

        .form-otp input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.15rem rgba(116, 198, 157, 0.45);
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 0.55rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            --bs-btn-bg: #2D6A4F;
            --bs-btn-border-color: #2D6A4F;
            --bs-btn-hover-bg: #1B4332;
            --bs-btn-hover-border-color: #1B4332;
            --bs-btn-active-bg: #1B4332;
            --bs-btn-active-border-color: #1B4332;

            --bs-btn-focus-shadow-rgb: 0, 0, 0;
        }

        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary:focus-visible,
        .btn-primary:active:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .btn-primary:focus-visible {
            box-shadow: 0 0 0 0.15rem rgba(116, 198, 157, 0.45) !important;
        }

        .btn-primary:hover {
            background-color: #1B4332;
        }

        .btn:focus,
        .btn:active {
            box-shadow: none;
        }

        .text-accent {
            color: var(--accent);
        }
    </style>
</head>

<body>
    <section class="background-radial-gradient vh-100 d-flex align-items-center">
        <div class="container d-flex justify-content-center">
            <div class="card bg-glass compact-card w-100">
                <div class="card-body p-4 text-center">

                    <h5 class="fw-bold mb-1">Verifikasi OTP</h5>
                    <p class="text-muted small mb-4">
                        Masukkan kode OTP yang dikirim ke email kamu
                    </p>

                    @error('otp')
                        <div class="alert alert-danger py-2 small">
                            {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('auth.verify-otp') }}">
                        @csrf

                        <div class="form-otp mb-4">
                            <input type="text" maxlength="1" inputmode="numeric">
                            <input type="text" maxlength="1" inputmode="numeric">
                            <input type="text" maxlength="1" inputmode="numeric">
                            <input type="text" maxlength="1" inputmode="numeric">
                            <input type="text" maxlength="1" inputmode="numeric">
                            <input type="text" maxlength="1" inputmode="numeric">
                        </div>

                        <input type="hidden" name="otp" id="otp">

                        <button class="btn btn-primary w-100">
                            Verifikasi
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <script>
        const inputs = document.querySelectorAll('.form-otp input');
        const otpHidden = document.getElementById('otp');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                input.value = input.value.replace(/\D/g, '');

                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                updateOtp();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        function updateOtp() {
            otpHidden.value = Array.from(inputs).map(i => i.value).join('');
        }
    </script>
</body>

</html>
