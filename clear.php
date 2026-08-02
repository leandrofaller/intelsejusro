<?php
echo "<h1>Limpador de Cache do Laravel - SIPEN</h1>";

function limparPasta($dir) {
    if (!is_dir($dir)) {
        echo "Diretório não encontrado: $dir<br>";
        return;
    }
    $files = array_diff(scandir($dir), array('.', '..', '.gitignore'));
    $count = 0;
    foreach ($files as $file) {
        $path = "$dir/$file";
        if (is_dir($path)) {
            limparPasta($path);
            @rmdir($path);
        } else {
            if (@unlink($path)) {
                $count++;
            }
        }
    }
    echo "Removidos $count arquivos de cache em: $dir<br>";
}

// 1. Limpar cache de views do SIPEN
echo "Limpando views do SIPEN...<br>";
limparPasta(__DIR__ . '/sipen/storage/framework/views');

// 2. Limpar cache de views do SIPEN Admin
echo "Limpando views do SIPEN Admin...<br>";
limparPasta(__DIR__ . '/sipen-admin/storage/framework/views');

echo "<br><b>Limpeza concluída com sucesso!</b>";
?>
