#!/bin/bash

# Script para preparar Prodmais UMC para InfinityFree
# Execute este script antes de fazer upload via FTP

echo "========================================="
echo "  PREPARAR PRODMAIS PARA INFINITYFREE   "
echo "========================================="
echo ""

# 1. Criar config.php se não existir
echo "[1/6] Verificando config.php..."
if [ ! -f "config/config.php" ]; then
    echo "→ Copiando config.example.php para config.php"
    cp config/config.example.php config/config.php
    echo "✅ config.php criado"
else
    echo "✅ config.php já existe"
fi

# 2. Instalar dependências
echo ""
echo "[2/6] Instalando dependências do Composer..."
if [ -f "composer.json" ]; then
    composer install --no-dev --optimize-autoloader
    echo "✅ Dependências instaladas"
else
    echo "❌ composer.json não encontrado!"
    exit 1
fi

# 3. Criar diretórios necessários
echo ""
echo "[3/6] Criando diretórios..."
mkdir -p data/uploads data/cache data/logs data/backups data/lattes_xml
touch data/uploads/.gitkeep
touch data/cache/.gitkeep
touch data/logs/.gitkeep
touch data/backups/.gitkeep
touch data/lattes_xml/.gitkeep
echo "✅ Diretórios criados"

# 4. Configurar permissões
echo ""
echo "[4/6] Configurando permissões..."
chmod -R 755 data/
chmod -R 755 public/
chmod 644 config/config.php
echo "✅ Permissões configuradas"

# 5. Criar .htaccess principal se não existir
echo ""
echo "[5/6] Verificando .htaccess..."
if [ ! -f ".htaccess" ]; then
    cat > .htaccess << 'EOF'
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
EOF
    echo "✅ .htaccess criado"
else
    echo "✅ .htaccess já existe"
fi

# 6. Compactar para upload fácil
echo ""
echo "[6/6] Criando pacote para upload..."

# Excluir arquivos desnecessários
EXCLUDE_DIRS=(
    ".git"
    ".history"
    "node_modules"
    "*.md"
    "DEPLOY_*.md"
    "README.md"
    "CHANGELOG.md"
    "TROUBLESHOOTING.md"
    ".gitignore"
    ".gitattributes"
    "docker-compose.yml"
    "Dockerfile"
    ".dockerignore"
    "render.yaml"
    "nixpacks.toml"
    "start.sh"
    "install.sh"
    "install.bat"
)

# Criar ZIP otimizado
echo "→ Criando prodmais-infinityfree.zip..."
zip -r prodmais-infinityfree.zip . \
    -x ".git/*" \
    -x ".history/*" \
    -x "*.md" \
    -x "docker-compose.yml" \
    -x "Dockerfile" \
    -x ".dockerignore" \
    -x "render.yaml" \
    -x "nixpacks.toml" \
    -x "*.sh" \
    -x "*.bat"

echo "✅ Pacote criado: prodmais-infinityfree.zip"

echo ""
echo "========================================="
echo "  ✅ PREPARAÇÃO CONCLUÍDA!              "
echo "========================================="
echo ""
echo "📦 Arquivo criado: prodmais-infinityfree.zip"
echo ""
echo "Próximos passos:"
echo "1. Acesse https://www.infinityfree.net"
echo "2. Crie sua conta de hospedagem"
echo "3. Faça upload via FTP ou File Manager"
echo "4. Extraia o ZIP em htdocs/"
echo "5. Configure permissões (755 para data/)"
echo ""
echo "📖 Veja DEPLOY_INFINITYFREE.md para guia completo"
echo ""
