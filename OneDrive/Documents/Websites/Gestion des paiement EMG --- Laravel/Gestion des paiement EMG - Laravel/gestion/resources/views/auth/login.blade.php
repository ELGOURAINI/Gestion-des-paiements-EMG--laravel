<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-5/assets/css/login-5.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Authentification</title>
</head>
<body>
    <!-- Session Status -->
    <br><br>
    <section class="p-3 p-md-4 p-xl-4">
        <div class="container">
          <div class="card border-light-subtle shadow-sm">
            <div class="row g-0">
              <div class="col-12 col-md-6 loginhalf ">
                <div class="d-flex align-items-center justify-content-center h-100">
                  <div class="col-10 col-xl-8 py-3 align-items-center justify-content-center">
                    <h1 class="whiteText">Authentification</h1>
                    <hr class="border-primary-subtle mb-4">
                    <h2 class="h1 mb-4 whiteText">We make digital products that drive you to stand out.</h2>
                    <p class="lead m-0 whiteText">We write words, take photos, make videos, and interact with artificial intelligence.</p><br><br><br>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="card-body p-3 p-md-4 p-xl-5">
                  <div class="row logologin">
                    <div class="col-12">
                      <div class="mb-5 logologin">
                        <img class="img-fluid rounded mb-4 " loading="lazy" src="/assets/images/logo_02.png" width="245" height="80" alt="BootstrapBrain Logo">
                      </div>
                    </div>
                  </div>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row gy-3 gy-md-4 overflow-hidden">
                      <div class="col-12">
                        <label for="email" :value="__('Email')" class="form-label">Email <span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control" name="email" placeholder="name@example.com" :value="old('email')" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                      <div class="col-12">
                        <label for="password" :value="__('Password')" for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" required autofocus autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                      </div>
                      <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label for="remember_me" class="form-check-label">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">Remember me </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-pass">{{ __('Forgot your password?') }}</a>
                    @endif
                  </div>
                      <div class="col-12">
                      <div class="text-center">
                        <button type="submit" class="btn bsb-btn-xl btn-primary">{{ __('Log in') }}</button>
                    </div>
                      </div>
            </div>
    </form>
    </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</body>
</html>
