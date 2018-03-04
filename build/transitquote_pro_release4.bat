set source="C:\xampp\htdocs\pro\wp-content\plugins\transitquote-pro"
set destination="C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-1"
del "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-1\*.*" /s /q
xcopy %source% %destination% /E /y
del "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-1\*.git*" /s
"C:\Users\Transmissions HQ\7z.exe" a  "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-1.zip" "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-1\*"