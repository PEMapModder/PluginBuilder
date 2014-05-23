@echo off
TITLE PocketMine-MP Plugin Builder
cd /d %~dp0
if exist bin\php\php.exe (
	set PHP_BINARY=bin\php\php.exe
) else (
	set PHP_BINARY=php
)

set START_FILE=Main.php

if exist bin\mintty.exe (
	start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o CursorType=0 -o CursorBlinks=1 -h error -t "PocketMine-MP PLugin Builder" -i bin/pocketmine.ico -w max %PHP_BINARY% %START_FILE% --enable-ansi %*
) else (
	%PHP_BINARY% %START_FILE% %*
)
