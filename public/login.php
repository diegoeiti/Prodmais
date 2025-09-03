<?php
session_start();
$error = '';
// Lista de administradores locais (adicione seu login institucional aqui)
$admins = [
    'matheus.lucindo', // Exemplo: login institucional
    'joao.almeida',    // Adicione outros logins conforme necessário
    'admin'            // Usuário padrão (pode remover se não quiser)
];
// Senhas dos administradores locais (login => senha)
$admin_passwords = [
    'matheus.lucindo' => 'Math/2006',
    'joao.almeida' => 'SENHA_JOAO',
    'admin' => 'senhaSegura'
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $ldap_ok = false;
    // Só tenta LDAP se a função existir
    if (function_exists('ldap_connect')) {
        $ldap_host = 'ldap://ldap.umc.br'; // Produção: configure conforme UMC
        $ldap_dn = "uid=$user,ou=users,dc=umc,dc=br";
        $ldap_conn = @ldap_connect($ldap_host);
        if ($ldap_conn) {
            ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            if (@ldap_bind($ldap_conn, $ldap_dn, $pass)) {
                $_SESSION['user'] = $user;
                header('Location: admin.php');
                exit;
            }
        }
    }
    // Login local sempre disponível para administradores cadastrados
    if (in_array($user, $admins) && isset($admin_passwords[$user]) && $pass === $admin_passwords[$user]) {
        $_SESSION['user'] = $user;
        header('Location: admin.php');
        exit;
    }
    $error = 'Usuário ou senha inválidos. Caso seja colaborador UMC, utilize seu login institucional.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Prodmais - UMC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #003366 60%, #fff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
        }
        .umc-logo {
            display: block;
            margin: 0 auto 18px auto;
            width: 120px;
        }
        .btn-umc {
            background: #003366;
            color: #fff;
            font-weight: 600;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .btn-umc:hover {
            background: #0055a5;
            color: #fff;
        }
        .umc-title {
            color: #003366;
            font-weight: 700;
            font-size: 1.3rem;
            text-align: center;
            margin-bottom: 8px;
        }
        .umc-subtitle {
            color: #555;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 18px;
        }
        .form-label {
            color: #003366;
            font-weight: 500;
        }
        .footer-umc {
            text-align: center;
            color: #ffffffff;
            font-size: 0.95rem;
            margin-top: 32px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Logo_umc1.png/1200px-Logo_umc1.png" alt="UMC" class="umc-logo">
        <div class="umc-title">Prodmais - UMC</div>
        <div class="umc-subtitle">Bem-vindo!<br>Faça login com seu usuário institucional UMC para acessar a área administrativa.<br><span style="font-size:0.95em;color:#0055a5;">Somente colaboradores autorizados.</span></div>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label for="user" class="form-label">Usuário institucional</label>
                <input type="text" class="form-control" id="user" name="user" required autofocus placeholder="Seu login UMC">
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Senha</label>
                <input type="password" class="form-control" id="pass" name="pass" required placeholder="Sua senha UMC">
            </div>
            <?php if (!empty($error)) echo "<div class='alert alert-danger text-center py-2 mb-3'>$error</div>"; ?>
            <div class="d-grid">
                <button type="submit" class="btn btn-umc btn-lg">Entrar</button>
            </div>
        </form>
        <div class="mt-3 text-center" style="font-size:0.95em;color:#555;">
            <span>Problemas de acesso? Contate o suporte TI da UMC.</span>
        </div>
    </div>
    <div class="footer-umc">
        Universidade de Mogi das Cruzes<br>
        <span style="font-size:0.9em;">© 2025 UMC. Todos os direitos reservados.</span>
    </div>
</body>
</html>
