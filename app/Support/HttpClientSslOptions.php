<?php

namespace App\Support;

final class HttpClientSslOptions
{
    /**
     * Guzzle options for Laravel Http client (verify CA bundle or disable check).
     *
     * @return array<string, mixed>
     */
    public static function guzzleVerifyOptions(bool $verifySsl, ?string $cacert): array
    {
        if (! $verifySsl) {
            return ['verify' => false];
        }

        if (! is_string($cacert) || $cacert === '') {
            return [];
        }

        $path = self::resolveCertificatePath($cacert);

        return $path !== null ? ['verify' => $path] : [];
    }

    private static function resolveCertificatePath(string $path): ?string
    {
        if (! self::isAbsoluteFilesystemPath($path)) {
            $path = base_path($path);
        }

        return is_readable($path) ? $path : null;
    }

    private static function isAbsoluteFilesystemPath(string $path): bool
    {
        if ($path === '') {
            return false;
        }

        if (str_starts_with($path, '/') || str_starts_with($path, '\\')) {
            return true;
        }

        return (bool) preg_match('#^[A-Za-z]:[/\\\\]#', $path);
    }
}
