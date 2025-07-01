<?php

namespace Tests\Arch;

// see: https://github.com/pestphp/pest/blob/3.x/src/ArchPresets/Php.php
arch()->preset()
    ->php();

// see: https://github.com/pestphp/pest/blob/3.x/src/ArchPresets/Security.php
arch()->preset()
    ->security()
    ->ignoring('parse_str');
