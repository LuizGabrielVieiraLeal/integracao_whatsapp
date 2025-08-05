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
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">Autenticação por WhatsApp</h4>
                    <p>Para garantir a segurança da sua conta, é necessário confirmar a sua identidade.</p>
                    <p>Você receberá um código de verificação via WhatsApp. Por favor, siga os seguintes passos:</p>
                    <ul>
                        <li>Insira o número do WhatsApp que você deseja utilizar para a autenticação.</li>
                        <li>Você receberá um código de 6 dígitos no WhatsApp.</li>
                        <li>Digite o código de 6 dígitos no campo abaixo e clique em "Verificar".</li>
                    </ul>
                    <hr />
                    <p class="mb-0">Caso não receba o código, verifique se o número está correto, aguarde alguns
                        instantes e caso ainda não receba clique para reenviar.</p>
                </div>

                @if (session('status'))
                    <div class="alert {{ str_contains(session('status'), 'válido') ? 'alert-success' : 'alert-danger' }}"
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

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código de Verificação</label>
                        <input type="text" id="codigo" name="codigo" class="form-control" maxlength="6"
                            pattern="\d{6}" required autofocus value="{{ old('codigo') }}"
                            placeholder="Digite o código recebido">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Verificar</button>
                    <div class="text-center mt-3">
                        <a href="{{ route('reenviar.codigo') }}" class="text-decoration-none">Reenviar código via
                            WhatsApp
                            🔄</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
