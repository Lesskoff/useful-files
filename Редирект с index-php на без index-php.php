# Редирект с index.php на без index.php

RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /index\.(php|html|htm)(.*)\ HTTP/
RewriteRule ^index.(php|html|htm)/?(.*)$ http://%{HTTP_HOST}/ [R=301]

RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ (.*)/index\.(php|html|htm)(.*)\ HTTP/
RewriteRule ^(.*)/index.php/?(.*)$ http://%{HTTP_HOST}/$1 [R=301,L]

# Редирект с индексной страницы php на саму папку, все страницы, за исключением админки Битрикса (можно добавить свои исключения)
RewriteCond %{REQUEST_URI} !^www.SITE.RU/bitrix/admin/
RewriteCond %{REQUEST_URI} !^SITE.RU/bitrix/admin/
RewriteCond %{REQUEST_URI} ^(.*)/index\.php$
RewriteRule ^(.*)index\.php$ http://%{HTTP_HOST}/$1 [R=301,L]

# Редирект с .html на без .html
RewriteRule (.+)\.html?$ http://www.SITE.RU/$1/ [R=301,L]