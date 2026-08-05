$content = Get-Content 'C:\Program Files\PostgreSQL\15\data\postgresql.conf' -Raw
$content = $content -replace '(^#wal_level\s*=.*$)', 'wal_level = minimal'
Set-Content 'C:\Program Files\PostgreSQL\15\data\postgresql.conf' -Value $content