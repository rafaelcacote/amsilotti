<x-guest-layout>
    <!-- Título do Formulário -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Criar Nova Conta</h2>
        <p class="text-gray-600 text-sm">Preencha os dados abaixo para se cadastrar</p>
    </div>

    <!-- Alert para CPF Duplicado -->
    @if ($errors->has('cpf') && str_contains($errors->first('cpf'), 'cadastrado'))
        <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800">CPF já cadastrado</h3>
                    <p class="text-sm text-amber-700 mt-1">
                        Este CPF já existe em nossa base de dados. 
                        <a href="{{ route('login') }}" class="font-medium underline hover:text-amber-900">
                            Clique aqui para fazer login
                        </a>.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulário -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
        @csrf

        <!-- Nome -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
            <input id="name" 
                   name="name" 
                   type="text" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name" 
                   placeholder="Digite seu nome completo"
                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- E-mail -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="username" 
                   placeholder="Digite seu e-mail"
                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- CPF -->
        <div>
            <label for="cpf" class="block text-sm font-medium text-gray-700 mb-2">CPF</label>
            <input id="cpf" 
                   name="cpf" 
                   type="text" 
                   value="{{ old('cpf') }}" 
                   required 
                   maxlength="14" 
                   placeholder="000.000.000-00"
                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-mono text-center">
            <p class="text-xs text-gray-500 mt-1">Digite apenas os números do CPF</p>
            @error('cpf')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Senha -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
            <input id="password" 
                   name="password" 
                   type="password" 
                   required 
                   autocomplete="new-password" 
                   placeholder="Digite uma senha segura"
                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar Senha -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Senha</label>
            <input id="password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   required 
                   autocomplete="new-password" 
                   placeholder="Confirme sua senha"
                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            @error('password_confirmation')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botões -->
        <div style="padding-top: 20px;">
            <p style="margin-bottom: 15px;">
                <a href="{{ route('login') }}" style="color: #2563eb; text-decoration: underline; font-size: 14px;">
                    Já possui uma conta?
                </a>
            </p>
            
            <button type="submit" 
                    id="submitBtn"
                    style="
                        width: 100%;
                        background-color: #2563eb;
                        color: white;
                        padding: 12px 20px;
                        border: none;
                        border-radius: 8px;
                        font-size: 16px;
                        font-weight: 600;
                        cursor: pointer;
                        margin-top: 10px;
                        display: block;
                    "
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'">
                CRIAR CONTA
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');

            // Máscara de CPF
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                value = value.substring(0, 11);
                
                if (value.length > 3 && value.length <= 6) {
                    value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                } else if (value.length > 6 && value.length <= 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                } else if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                }
                
                e.target.value = value;
            });

            // Loading state no submit
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'CRIANDO...';
                submitBtn.style.backgroundColor = '#6b7280';
                
                // Remove máscara do CPF antes do envio
                const cleanCpf = cpfInput.value.replace(/\D/g, '');
                cpfInput.value = cleanCpf;
            });
        });
    </script>
</x-guest-layout>
