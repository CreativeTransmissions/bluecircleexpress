set source="C:\vagrant\www\pro\public_html\wp-content\plugins\transitquote-pro"
set destination="C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3-0\"
del "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3-0\*.*" /s /q

xcopy %source% %destination% /E /y
del "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3-0\*.git*" /s
"C:\Users\Transmissions HQ\7z.exe" a  "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3-0.zip" "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3-0\*"

xcopy "C:\Users\Transmissions HQ\Documents\Code\releases\transitquote-pro-v4-3-0.zip" "C:\Users\Transmissions HQ\Dropbox\releases\pro\transitquote-pro.zip" 