<?php

namespace Zim32\TestTask\Service;

use Zim32\TestTask\Contract\BinCountryResolverInterface;

class DefaultBinCountryResolver implements BinCountryResolverInterface
{
    /**
     * @throws \Exception
     */
    public function getCountryCodeByBinNumber(string $bin): string|null
    {
        $context = [
            'http' => [
                'header' => [
                    'Accept-Version: 3',
                ],
            ]
        ];

        $response = @file_get_contents(sprintf('https://lookup.binlist.net/%s', $bin), false, stream_context_create($context));

        if (!$response) {
            throw new \Exception('Can not get detect country code: can not get response from binlist.net');
        }

        $response = json_decode($response, 1);
        $countryCode = $response['country']['alpha2'] ?? null;

        if (!$countryCode) {
            return null;
        }

        return strtoupper($countryCode);
    }
}
