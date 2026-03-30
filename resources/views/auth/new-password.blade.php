<form method="POST" action="{{ route('auth.new-password.submit') }}">
    @csrf

    <input type="password" name="password" class="form-control" placeholder="Password Baru">
    <input type="password" name="password_confirmation" class="form-control mt-2" placeholder="Konfirmasi Password">

    <button class="btn btn-primary w-100 mt-3">
        Reset Password
    </button>
</form>
