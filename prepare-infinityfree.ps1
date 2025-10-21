# Script PowerShell para preparar Prodmais UMC para InfinityFree
# Execute: .\prepare-infinityfree.ps1

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  PREPARAR PRODMAIS PARA INFINITYFREE   " -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Criar config.php se não existir
Write-Host "[1/6] Verificando config.php..." -ForegroundColor Yellow
if (-not (Test-Path "config\config.php")) {
    Write-Host "→ Copiando config.example.php para config.php" -ForegroundColor Gray
    Copy-Item "config\config.example.php" "config\config.php"
    Write-Host "✅ config.php criado" -ForegroundColor Green
} else {
    Write-Host "✅ config.php já existe" -ForegroundColor Green
}

# 2. Instalar dependências
Write-Host ""
Write-Host "[2/6] Instalando dependências do Composer..." -ForegroundColor Yellow
if (Test-Path "composer.json") {
    composer install --no-dev --optimize-autoloader
    Write-Host "✅ Dependências instaladas" -ForegroundColor Green
} else {
    Write-Host "❌ composer.json não encontrado!" -ForegroundColor Red
    exit 1
}

# 3. Criar diretórios necessários
Write-Host ""
Write-Host "[3/6] Criando diretórios..." -ForegroundColor Yellow
$dirs = @("data\uploads", "data\cache", "data\logs", "data\backups", "data\lattes_xml")
foreach ($dir in $dirs) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
    }
    New-Item -ItemType File -Path "$dir\.gitkeep" -Force | Out-Null
}
Write-Host "✅ Diretórios criados" -ForegroundColor Green

# 4. Criar .htaccess principal se não existir
Write-Host ""
Write-Host "[4/6] Verificando .htaccess..." -ForegroundColor Yellow
if (-not (Test-Path ".htaccess")) {
    $htaccess = @"
# Prodmais UMC - InfinityFree Configuration

# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Direcionar tudo para public/
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ /public/$1 [L]

# PHP Settings
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value memory_limit 256M
php_value max_execution_time 300

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>

# Disable directory listing
Options -Indexes

# Protect sensitive files
<FilesMatch "^(composer\.(json|lock)|\.git.*|\.env|config\.php)$">
    Order allow,deny
    Deny from all
</FilesMatch>
"@
    $htaccess | Out-File -FilePath ".htaccess" -Encoding ASCII
    Write-Host "✅ .htaccess criado" -ForegroundColor Green
} else {
    Write-Host "✅ .htaccess já existe" -ForegroundColor Green
}

# 5. Criar .htaccess em public/ se não existir
Write-Host ""
Write-Host "[5/6] Verificando public/.htaccess..." -ForegroundColor Yellow
if (-not (Test-Path "public\.htaccess")) {
    $publicHtaccess = @"
# public/.htaccess
RewriteEngine On

# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Remove index.php from URL
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]

# Security
<Files "*.php">
    Order Deny,Allow
    Allow from all
</Files>

# Allow static files
<FilesMatch "\.(css|js|png|jpg|gif|ico|svg|woff|woff2|ttf)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>
"@
    $publicHtaccess | Out-File -FilePath "public\.htaccess" -Encoding ASCII
    Write-Host "✅ public/.htaccess criado" -ForegroundColor Green
} else {
    Write-Host "✅ public/.htaccess já existe" -ForegroundColor Green
}

# 6. Compactar para upload fácil
Write-Host ""
Write-Host "[6/6] Criando pacote para upload..." -ForegroundColor Yellow

# Arquivos a excluir
$exclude = @(
    ".git",
    ".history",
    "*.md",
    "docker-compose.yml",
    "Dockerfile",
    ".dockerignore",
    "render.yaml",
    "nixpacks.toml",
    "*.sh",
    "*.bat",
    "prepare-infinityfree.ps1"
)

Write-Host "→ Criando prodmais-infinityfree.zip..." -ForegroundColor Gray

# Criar lista de arquivos para incluir
$files = Get-ChildItem -Recurse -File | Where-Object {
    $file = $_
    $shouldExclude = $false
    
    foreach ($pattern in $exclude) {
        if ($file.FullName -like "*$pattern*") {
            $shouldExclude = $true
            break
        }
    }
    
    -not $shouldExclude
}

# Criar ZIP
Compress-Archive -Path $files.FullName -DestinationPath "prodmais-infinityfree.zip" -Force

Write-Host "✅ Pacote criado: prodmais-infinityfree.zip" -ForegroundColor Green

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  PREPARACAO CONCLUIDA!                  " -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Pacote criado: prodmais-infinityfree.zip" -ForegroundColor White
Write-Host ""
Write-Host "Proximos passos:" -ForegroundColor Yellow
Write-Host "1. Acesse https://www.infinityfree.net" -ForegroundColor White
Write-Host "2. Crie sua conta de hospedagem" -ForegroundColor White
Write-Host "3. Faca upload via FTP ou File Manager" -ForegroundColor White
Write-Host "4. Extraia o ZIP em htdocs/" -ForegroundColor White
Write-Host "5. Configure permissoes (755 para data/)" -ForegroundColor White
Write-Host ""
Write-Host "Veja DEPLOY_INFINITYFREE.md para guia completo" -ForegroundColor Cyan
Write-Host ""
