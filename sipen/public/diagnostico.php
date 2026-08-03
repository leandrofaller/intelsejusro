<?php
// Script de Diagnóstico e Limpeza de Cache para o SIPEN

header('Content-Type: text/plain; charset=utf-8');

echo "=== DIAGNÓSTICO DO SERVIDOR ===\n\n";

// 1. Resetar o OPCache para forçar o PHP a ler os arquivos do disco
if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        echo "Sucesso: O OPCache do PHP foi limpo/resetado.\n";
    } else {
        echo "Aviso: Falha ao resetar o OPCache.\n";
    }
} else {
    echo "Info: OPCache não está ativo ou a função opcache_reset está desativada.\n";
}

// 2. Verificar o conteúdo do arquivo ProducaoController.php
$controllerPath = __DIR__ . '/../app/Http/Controllers/ProducaoController.php';

if (file_exists($controllerPath)) {
    $content = file_get_contents($controllerPath);
    echo "Arquivo ProducaoController.php encontrado.\n";
    
    // Procura por termos específicos do código novo
    if (strpos($content, 'base64_encode') !== false) {
        echo "Status do código: ATUALIZADO (Solução Base64 presente).\n";
    } elseif (strpos($content, 'tratarImagensHtml') !== false) {
        echo "Status do código: INTERMEDIÁRIO (Solução de caminhos relativos/absolutos).\n";
    } else {
        echo "Status do código: ANTIGO (Sem a função tratarImagensHtml).\n";
    }
    
    // Mostra as últimas 40 linhas do arquivo para validação visual do método tratarImagensHtml
    echo "\n=== FIM DO ARQUIVO ProducaoController.php ===\n";
    $lines = explode("\n", $content);
    $lastLines = array_slice($lines, -40);
    echo implode("\n", $lastLines);
    echo "\n============================================\n";
} else {
    echo "Erro: Arquivo ProducaoController.php não encontrado em: $controllerPath\n";
}
