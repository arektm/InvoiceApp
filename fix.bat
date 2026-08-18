REM call npx prettier --write "resources/js/pages/**/*" "resources/js/components/invoices/**/*" "resources/css/app.css"
call npm run format:pages
call vendor\bin\pint.bat
call vendor\bin\phpstan.bat