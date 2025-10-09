@echo off
echo ===== INICIANDO ELASTICSEARCH PARA PRODMAIS UMC =====
echo.
echo Verificando se o Elasticsearch ja esta rodando...
netstat -an | findstr :9200 >nul
if %errorlevel% == 0 (
    echo Elasticsearch ja esta rodando na porta 9200!
    echo Acesse: http://localhost:9200
    pause
    exit
)

echo.
echo Iniciando Elasticsearch...
echo Caminho: C:\Users\mathe\Downloads\elasticsearch-9.1.2\bin
echo.

cd "C:\Users\mathe\Downloads\elasticsearch-9.1.2\bin"

if not exist elasticsearch.bat (
    echo ERRO: arquivo elasticsearch.bat nao encontrado!
    echo Verifique se o caminho esta correto.
    pause
    exit
)

echo Iniciando servidor Elasticsearch...
echo.
echo IMPORTANTE: 
echo - Deixe esta janela aberta
echo - Elasticsearch rodara na porta 9200
echo - Para parar, feche esta janela ou pressione Ctrl+C
echo.
pause

elasticsearch.bat