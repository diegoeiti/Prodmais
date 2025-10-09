@echo off
REM Script de instalação para Windows

echo ========================================
echo   INSTALACAO PRODMAIS - WINDOWS
echo ========================================
echo.

REM Verificar se o PHP está disponível
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERRO: PHP nao encontrado no PATH
    echo Por favor, instale o PHP 8.2+ e adicione ao PATH
    pause
    exit /b 1
)

echo PHP encontrado. Executando instalacao...
echo.

REM Executar script de instalação PHP
php bin\install.php

echo.
echo Instalacao concluida!
echo.
echo Para iniciar o servidor de desenvolvimento:
echo php -S localhost:8000 -t public
echo.
pause