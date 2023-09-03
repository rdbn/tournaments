<?php

declare(strict_types=1);

namespace App\Service\Tournament;

class SlugService
{
    public const SLUG_REG_EXP = '/[^A-Za-z0-9-]+/';

    public static function createSlug(string $tournamentName): string
    {
        return preg_replace(self::SLUG_REG_EXP, '-', $tournamentName);
    }
}