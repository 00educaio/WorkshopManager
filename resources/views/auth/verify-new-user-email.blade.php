<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        /* Seu CSS totalmente customizado aqui */
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn { background-color: #000; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; }
        h1 { color: #333; }
    </style>
</head>
<body>

    <div class="card">
        <h1>Olá, {{ $user->name }}! 👋</h1>
        
        <p>Obrigado por se cadastrar. Para começar, precisamos apenas que você clique no botão abaixo para verificar que este email é realmente seu.</p>
        
        <br>

        <div style="text-align: center;">
            <!-- AQUI ESTÁ A MÁGICA: A variável $url vem do Provider -->
            <a href="{{ $url }}" class="btn">Confirmar meu Email</a>
        </div>

        <br>
        
        <p style="font-size: 12px; color: #777;">
            Se você não criou uma conta, nenhuma ação é necessária.
        </p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        
        <p style="font-size: 10px; color: #999;">
            Se o botão não funcionar, copie e cole este link no navegador: <br>
            {{ $url }}
        </p>
    </div>

</body>
</html>