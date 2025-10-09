#!/bin/bash

# Script de instalação para Linux/macOS

echo "========================================"
echo "   INSTALACAO PRODMAIS - LINUX/MACOS   "
echo "========================================"
echo

# Verificar se o PHP está disponível
if ! command -v php &> /dev/null; then
    echo "ERRO: PHP não encontrado"
    echo "Por favor, instale o PHP 8.2+ primeiro"
    exit 1
fi

echo "PHP encontrado. Executando instalação..."
echo

# Tornar executável e executar script de instalação PHP
chmod +x bin/install.php
php bin/install.php

echo
echo "Instalação concluída!"
echo
echo "Para iniciar o servidor de desenvolvimento:"
echo "php -S localhost:8000 -t public"
echo