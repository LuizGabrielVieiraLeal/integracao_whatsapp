<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Verificação WhatsApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

    <div class="pt-5 mt-5 pb-5 mb-5">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-sm p-4" style="min-width: 320px; max-width: 400px; width: 100%;">
                <!-- Alerta informativo -->
                <div class="alert" role="alert">
                    <h4 class="alert-heading mb-4">Autenticação por WhatsApp</h4>
                    <p>Para garantir a segurança da sua conta, é necessário confirmar a sua identidade.</p>
                    <p>Você receberá um código de verificação via WhatsApp. Por favor, siga os seguintes passos:</p>
                    <ul>
                        <li>Você receberá um código de 6 dígitos no WhatsApp.</li>
                        <li>Digite o código de 6 dígitos no campo abaixo e clique em "Verificar".</li>
                    </ul>
                    <p class="mb-0">Caso não receba o código, em alguns instantes você poderá solicitar o reenvio
                        novamente.</p>
                </div>

                <hr class="mb-4" />

                @if (session('status'))
                    <div class="alert {{ str_contains(session('status'), 'válido') || str_contains(session('status'), 'Novo código enviado') ? 'alert-success' : 'alert-danger' }}"
                        role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verificar.codigo') }}">
                    @csrf

                    <div class="mt-3 mb-3">
                        <label for="codigo" class="form-label"><strong>Código de Verificação:</strong></label>
                        <input type="text" id="codigo" name="codigo" class="form-control" maxlength="6"
                            pattern="\d{6}" required autofocus value="{{ old('codigo') }}"
                            placeholder="Digite o código recebido">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 m-1">Verificar</button>

                    <div class="text-center mt-3">
                        <a href="{{ route('reenviar.codigo') }}" id="reenviar-link"
                            class="text-decoration-none disabled text-muted" aria-disabled="true"
                            onclick="return false;">
                            Reenviar código via WhatsApp 🔄 <span id="contador">(30s)</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let tempoRestante = 60;
        const contador = document.getElementById('contador');
        const link = document.getElementById('reenviar-link');

        const intervalo = setInterval(() => {
            tempoRestante--;
            contador.textContent = `(${tempoRestante}s)`;

            if (tempoRestante <= 0) {
                clearInterval(intervalo);
                link.classList.remove('disabled', 'text-muted');
                link.removeAttribute('aria-disabled');
                link.setAttribute('onclick', '');
                contador.remove(); // remove o contador
                link.textContent = 'Reenviar código via WhatsApp 🔄';
            }
        }, 1000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
