set source="C:\vagrant\www\htdocs\pro\wp-content\plugins\transitquote-pro"
set destination="C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3"
del "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3\*.*" /s /q

xcopy %source% %destination% /E /y
del "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3\*.git*" /s
"C:\Users\Transmissions HQ\7z.exe" a  "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3.zip" "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3\*"

xcopy "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3.zip" "C:\Users\Transmissions HQ\Dropbox\releases\pro\transitquote-pro.zip" 