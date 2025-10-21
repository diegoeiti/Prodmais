#!/bin/bash

# Verificar se há argumentos de porta fornecidos pelo Render
if [ -n "$PORT" ]; then
    LISTEN_PORT=$PORT
else
    LISTEN_PORT=80
fi

# Instalar dependências se não estiverem presentes
if [ ! -d "vendor" ]; then
    echo "Instalando dependências via Composer..."
    composer install --no-dev --optimize-autoloader
fi

# Criar diretórios necessários
mkdir -p data/uploads data/cache data/logs data/backups

# Criar arquivos .gitkeep se não existirem
touch data/uploads/.gitkeep
touch data/cache/.gitkeep
touch data/logs/.gitkeep
touch data/backups/.gitkeep

# Configurar permissões
chmod -R 755 data/
chmod -R 755 public/

echo "Iniciando servidor PHP na porta $LISTEN_PORT..."
echo "Sistema Prodmais UMC - Pronto para produção!"

# Iniciar servidor PHP
cd public && php -S 0.0.0.0:$LISTEN_PORT