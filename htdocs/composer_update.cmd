@ECHO OFF
IF EXIST vendor (
    composer update
) ELSE (
    composer install
)
PAUSE
