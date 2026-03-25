{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.custom-master')

@section('title', 'Iniciar sesión - EL CUMBE EIRL')

@section('content')
    <div class="container">
        <div class="flex justify-center authentication authentication-basic items-center h-full text-defaultsize text-defaulttextcolor">
            <div class="grid grid-cols-12">
                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-6 sm:col-span-8 col-span-12">
                    <div class="my-[2.5rem] flex justify-center">
                        <a href="{{url('/login')}}">
                            <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-36">
                        </a>
                    </div>
                    <div class="box">
                        <div class="box-body !p-[3rem]">
                            <p class="h5 font-semibold mb-2 text-center">Iniciar Sesión</p>
                            <p class="mb-4 text-[#8c9097] opacity-[0.7] font-normal text-center">Ingresa con tu número de DNI</p>
                            
                            @if (session('status'))
                                <div class="mb-4 text-sm text-success bg-success/10 border border-success/20 rounded-md px-3 py-2">
                                    {{ session('status') }}
                                </div>
                            @endif
                            
                            
                            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                                @csrf
                                
                                <div class="grid grid-cols-12">
                                    <div class="xl:col-span-12 col-span-12 mb-3">
                                        <label for="signin-username" class="form-label text-default">Usuario</label>
                                        <input 
                                            type="text" 
                                            id="username"
                                            name="username"
                                            maxlength="8"
                                            value="{{ old('username') }}"
                                            class="form-control form-control-lg w-full !rounded-md @error('username') !border-danger @enderror"
                                            placeholder="Usuario"
                                            required
                                            autofocus
                                            autocomplete="username"
                                            inputmode="numeric"
                                            >
                                        @error('username')
                                            <div class="mt-2 text-sm text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="xl:col-span-12 col-span-12 mb-3">
                                        <label for="signin-password" class="form-label text-default block">
                                            Contraseña
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="ltr:float-right rtl:float-left text-warning">
                                                    ¿Olvidaste tu contraseña?
                                                </a>
                                            @endif
                                        </label>
                                        <div class="input-group">
                                            <input 
                                                type="password" 
                                                id="password"
                                                name="password"
                                                class="form-control !border-s border-defaultborder form-control-lg !rounded-s-md @error('password') !border-danger @enderror"
                                                placeholder="Contraseña"
                                                required
                                                autocomplete="current-password"
                                                >
                                            <button 
                                                aria-label="Mostrar/Ocultar"
                                                class="ti-btn ti-btn-light !rounded-s-none !mb-0" type="button" 
                                                onclick="togglePassword('password', this)"
                                            >
                                            <i class="ri-eye-off-line align-middle"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="mt-2 text-sm text-danger">{{ $message }}</div>
                                        @enderror
                                        
                                        <div class="mt-2">
                                            <div class="form-check !ps-0">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="" 
                                                    id="remember_me"
                                                    name="remember"
                                                    {{ old('remember') ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label text-[#8c9097] font-normal" for="defaultCheck1">
                                                    ¿Recordar contraseña?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="xl:col-span-12 col-span-12 grid mt-2">
                                        <button
                                            type="submit"
                                            class="ti-btn ti-btn-dark !bg-dark  btn-wave !text-white !font-medium"
                                        >
                                        Ingresar
                                        </button>
                                    </div>
                                </div>
                            
                            </form>
                            
                            
                            
                            
                        </div>
                    </div>
                </div>
                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;

    const icon = btn.querySelector('i');
    const isPassword = input.type === 'password';

    input.type = isPassword ? 'text' : 'password';

    if (icon) {
        icon.classList.toggle('ri-eye-off-line', !isPassword);
        icon.classList.toggle('ri-eye-line', isPassword);
    }
}
</script>
@endpush
